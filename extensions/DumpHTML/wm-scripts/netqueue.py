#!/usr/bin/python
# vim: set ts=4 sw=4 :
import SocketServer, sys, signal, os, threading, Queue

class QueueServer(SocketServer.ThreadingMixIn, SocketServer.TCPServer): 
	queue = Queue.Queue(0)
	allow_reuse_address = True

	def enqueue(self, value):
		self.queue.put(value)

	def dequeue(self):
		try:
			value = self.queue.get_nowait()
		except Queue.Empty:
			value = None
		return value

	def blockingDequeue(self, file):
		value = self.queue.get()
		#if file.closed:
			# File doesn't want it, requeue it
		#	self.queue.put(value)
		#	value = None
		return value;
	
	def clearQueue(self):
		self.queue = Queue.Queue(0)


class QueueRequestHandler(SocketServer.StreamRequestHandler):
	def handle(self):
		try:
			for line in self.rfile:
				cmd = line.strip()
				if cmd[:4] == "enq ":
					self.server.enqueue(cmd[4:])
					self.wfile.write("ok\n")
				elif cmd == "deq":
					value = self.server.dequeue()
					if value is None:
						self.wfile.write("empty\n")
					else:
						self.wfile.write("data " + value + "\n")
				elif cmd == "bdeq":
					value = self.server.blockingDequeue(self.wfile)
					if value is None:
						self.wfile.write("empty\n")
					else:
						self.wfile.write("data " + value + "\n")
				elif cmd == "size":
					self.wfile.write("size " + str(self.server.queue.qsize()) + "\n")
				elif cmd == "clear":
					self.server.clearQueue()
					self.wfile.write("ok\n")
				else:
					self.wfile.write("invalid command\n")
		except:
			sys.stdout.write("netqueue: Error processing socket " + self.request.getpeername() + "\n")


if __name__ == '__main__':
	server = QueueServer(('127.0.0.1', 8200), QueueRequestHandler)
	try:
		server.serve_forever()
	except KeyboardInterrupt:
		print "Caught KeyboardInterrupt"
		os.kill(os.getpid(), signal.SIGKILL)
		sys.exit(0)



