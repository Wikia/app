#!/usr/bin/env python
#
# Better run this with twistd -r epoll -y poolcounter.py -u nobody -g nogroup
#

from twisted.internet import reactor, protocol
from twisted.protocols import basic, policies
from twisted.application import internet, service

import time

port=7531

class Error:
	badcomm = (1, "Bad command or not enough arguments")
	nokey = (2, "%s No such key acquired by current connection")
	haveit = (3, "%s Already acquired")
	
	def __init__(self,error,params=[]):
		self.errno=error[0]
		self.message=error[1]
		self.params=params
		pass
		
	def msg(self):
		return "ERROR %03d %s\n" % (self.errno, self.message % self.params)


class CounterDatabase(dict):
	"""Counter database organizes counter objects by their name,
	and provides basis for on-demand creation and destruction of counters
	
	It maps:
		1:1 with CounterFactory
		1:n with Counter (linked both sides)
	"""
	def acquireCounter(self, name, client,options={}):
		"""Acquires (and if needed) creates a counter 
		for a client, as well as increments counts"""
		
		if name not in self:
			counter = Counter(name, self)
		else:
			counter = self[name]
			
		if client in counter: 
			raise Error(Error.haveit, name)
		
		counter.acquire(client)
		return counter
		
	def releaseCounter(self, name, client, options={}):
		"""Releases, and if necessary, destroys counter object"""
		try: 
			counter = self[name]
			counter[client]
		except KeyError:
			raise Error(Error.nokey, name)

		# Counter manages it's own membership inside the database
		counter.release(client)


class Counter(dict):
	"""Counter object tracks and counts 
	clients that have acquired it"""
	# count is size of dictionary
	count = property(fget=len)
	age = property(fget = lambda self: int(time.time() - self.init_time))
	
	def __hash__(self):
		"""Make this object usable as key in other dictionaries, 
		after losing such property by inheriting (dict)"""
		return id(self);
	
	def __init__(self, name, db):
		"""Register object in supplied database"""
		self.database = db
		self.name = name
		self.database[name] = self
		self.init_time = time.time()

	def acquire(self, client):
		"""Register both client inside counter, and counter at client"""
		self[client] = True
		client.counts[self] = True
	
	def release(self, client):
		del self[client]
		del client.counts[self]
		
		if len(self) == 0:
			del self.database[self.name]


class CounterClient(basic.LineReceiver,policies.TimeoutMixin):
	"""Counter protocol, basic functions and connection tracking"""
	def __init__(self):
		"""Initialize counter objects held by a client"""
		self.counts = {}
		
	def error(self, error, parts=[]):
		"""Write an error, based either on exception message or custom error tuple"""
		if isinstance(error,Error):
			self.transport.write(error.msg())
		else:
			self.transport.write("ERROR %03d %s\n" % (error[0], error[1] % parts) )
	
	def connectionMade(self):
		"""When connection is established, add it to factory 
		public list of connections, and set timeouts"""
		self.factory.conns[self] = True
		self.setTimeout(300)
		
	def lineReceived(self,line):
		"""Process the request line, and invoke necessary actions"""
		
		request = line.split()
		
		self.resetTimeout()
		self.factory.stats_requests += 1
		
		# Development, debugging and introspection functions
		if (len(request)<=1):
			if len(request) == 0: 
				pass
			elif request[0] == "quit":
				self.transport.loseConnection()
			# Show counts acquired by connections
			elif request[0] == "conns":
				self.transport.write( str([(k, [c.name for c in k.counts]) 
					for k in self.factory.conns])+"\n")
			# Show counter values
			elif request[0] == "counts":
				self.transport.write(str([(k,v.count) for k,v in 
					self.factory.database.items()])+ "\n")
			# Just die :) 
			elif request[0] == "die":
				reactor.stop()
			# Basic statistics
			elif request[0] == "stats":
				self.transport.write("Counters: %d\nConnections: %d\nRequests: %d\n" % 
					(len(self.factory.database), len(self.factory.conns), self.factory.stats_requests))
			else:
				self.error(Error.badcomm)
			return

		# From here on verbs need nouns and more
		# This is where real work starts
		# First we save options provided
		options = dict([len(y.split(":", 2)) > 1 and y.split(":", 2) or (y, True) 
			for y in request[2:]])

		verb = request[0]
		key = request[1]

		# Acquire can specify:
		# XXX - notification thresholds
		# XXX - ???
		# XXX - Profit!!!
		
		if verb == "acquire":
			# Parse the options, format is: a:x b c:y ...
			try: 
				counter = self.factory.database.acquireCounter(key, self, options)
			except Error, e:
				self.error(e) 
				return
			self.transport.write("ACK %s count:%d age:%d\n" % (key, counter.count, counter.age) )
		# Release can specify options:
		# XXX - abandoned (don't notify)
		elif verb == "release":
			try:
				self.factory.database.releaseCounter(key, self, options)
			except Error, e:
				self.error(e)
				return
			self.transport.write("RELEASED %s\n" % key)
		# Noop counter fetch
		elif verb == "count":
			if key in self.factory.database:
				counter=self.factory.database[key]
				count=counter.count
				age=counter.age
			else:
				count=0
				age=0
			self.transport.write("COUNT %s count:%d age:%d\n" % (key, count) )
		else:
			self.error(Error.badcomm)
			return
			
	def connectionLost(self, reason):
		"""Abandon counters and deregister connection on lost connection in case:
			* Disconnected
			* "quit" command received
			* Timeout hit
		"""
		for counter in self.counts.copy(): 
			counter.release(self)
		del self.factory.conns[self]


class CounterFactory(protocol.ServerFactory):
	"""Counter instance object, owns database and bunch of clients"""
	protocol = CounterClient
	
	def __init__(self):
		self.database = CounterDatabase()
		self.stats_requests = 0
		self.conns = {}

# Linux reactor
try:
	from twisted.internet import epollreactor
	epollreactor.install()
except: pass

factory = CounterFactory()
application = service.Application("poolcounter")
counterservice = internet.TCPServer(port, factory)
counterservice.setServiceParent(application)

# If invoked directly and ot via twistd...
if __name__=="__main__":
	reactor.listenTCP(port, factory)
	reactor.run()

