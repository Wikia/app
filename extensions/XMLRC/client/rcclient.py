#!/usr/bin/python

##############################################################################
# XMPP client for XMLRC
# 
# 
#  Copyright (c) 2010, Wikimedia Deutschland; Author: Daniel Kinzler
#  All rights reserved.
# 
#    This program is free software: you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation, either version 3 of the License, or
#    (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with this program.  If not, see <http://www.gnu.org/licenses/>.
##############################################################################

import sys, os, os.path, traceback, datetime, re
import ConfigParser, optparse
import select, xmpp # using the xmpppy library <http://xmpppy.sourceforge.net/>, GPL


LOG_MUTE = 0
LOG_QUIET = 10
LOG_VERBOSE = 20
LOG_DEBUG = 30

##################################################################################
class RecentChange(object):
    """ Represents a RecentChanges-Record. Properties of a change can be accessed
	using item syntax (e.g. rc['revid']) or attribute syntax (e.g. rc.revid). 
	Well known attributes are converted to the appropriate type automatically. 
	Nested tags become available as DOM nodes by their tag name, better
	support for these is pending.
    """

    flags = set( ( 'anon', 'bot', 'minor', 'redirect', 'patrolled' ) )
    numerics = set( ( 'rcid', 'pageid', 'revid', 'old_revid', 'newlen', 'oldlen', 'ns', ) )
    times = set( ( 'timestamp', ) )

    def __init__(self, dom):
	""" create a RecentChange object from a DOM node """

	self.dom = dom

    def get_property(self, prop):
	""" get an RC property, as represented by an attribute in the <rc> tag, 
	    or a tag nested in the <rc> tag. Nested tags can be accessed by their
	    tag name, but only one instance of each tag name is supports.
            Well known attributes are converted to the appropriate type automatically. 
	"""

	a = self.dom.getAttr(prop)

	if type(prop) == unicode:
	    prop = prop.encode("ascii")

	if prop in RecentChange.flags:
	    if a is None or a is False:
		return False
	    else:
		return True
	elif a is None:
	    a = self.dom.getTag(prop)
	    # TODO: wrap for conversion. known tags: <tags>, <param>, <block>
	elif prop in RecentChange.numerics:
	    if a == "": 
		a = None
	    else: 
		a = int( a )
	elif prop in RecentChange.times:
	    if a == "": 
		a = None
	    else: 
		# Using ISO 8601: 2010-10-12T08:57:03Z
		# XXX: python apparently does not support time zone offsets (%z) when parsing the date time??
		# a = datetime.datetime.strptime( a, '%Y-%m-%dT%H:%M:%S%z' ) 

		a = re.sub( r'[A-Z]+$|[-+][0-9]+$', r'', a ) # strip time zone
		a = datetime.datetime.strptime( a, '%Y-%m-%dT%H:%M:%S' ) # naive time. This sucks, but MW should use UTC anyway
	else:
	    pass

        return a

    def __getitem__(self, prop):
	""" delegates to get_property( prop ) """
        return self.get_property(prop)

    def __getattr__(self, prop):
	""" delegates to get_property( prop ) """
        return self.get_property(prop)

class RCHandler(object):
    """ Base class for RC hanlders. Instances compatible with this class
	can be registered with RCClient.add_handler(). Their process(rc)
	method will then be called for every change record received. """

    def process(self, rc):
	""" called for each RC message received by RCClient.
	    This implementation raises an Exception, please override it with 
	    something meaningful.
	""" 

	raise Exception( "please override process(self, rc)" )

class RCEcho(RCHandler):
    """ Implementation of RCHandler that will print the RecentChanges-
	record to the shell. """

    props = ( 'rcid', 'timestamp', 'type', 'ns', 'title', 'pageid', 'revid', 'old_revid', 
	      'user', 'oldlen', 'newlen', 'comment', 'logid', 'logtype', 'logaction',
	      'anon', 'bot', 'minor', 'redirect', 'patrolled' )

    def process(self, rc):
	""" called for each RC message received by RCClient.
	    This implementation outputs the values for a set of well known RC properties.
	    
	    Arguments:
	    rc -- an instance of RecentChange that describes the change
	""" 

	print "-----------------------------------------------"
	for p in RCEcho.props:
	    self.print_prop(rc, p)
	print "-----------------------------------------------"

    def print_prop(self, rc, prop):
	""" Retrieves and prints a single property from an RecentChange instance.
	    
	    Arguments:
	    rc -- an instance of RecentChange that describes the change
	    prop -- name of the property to print
	""" 

	v = rc[prop]
	if v is None: v = ''

	print "%s: %s" % (prop, v)

class XMLEcho(RCHandler):
    """ Implementation of RCHandler that will print the XML representation
	of the RecentChanges-record to the shell. """

    def process(self, rc):
	""" Dumps the XML <rc> element that describes the event.
	    
	    Arguments:
	    rc -- an instance of RecentChange that describes the change
	""" 

	print rc.dom.__str__(1)

##################################################################################

class RCClient(object):
    """ XMPP client listeneing for RecentChanges-messages, and passing them
	to any instances of RCHandler that have been registered using 
	RCClient.add_handler(). """

    def __init__( self, console_encoding = 'utf-8' ):
	""" Creates a new RCClient.
	    
	    Arguments:
	    console_encoding -- encoding to use for the console, default is utf-8
	""" 

	self.console_encoding = console_encoding
	self.handlers = []
	self.loglevel = LOG_VERBOSE

	self.xmpp = None
	self.jid = None

        self.room = None
        self.nick = None

	self.echo_stanzas = False

    def warn(self, message):
	""" Prints a warning to the console if self.loglevel >= LOG_QUIET """
	if self.loglevel >= LOG_QUIET:
	    sys.stderr.write( "WARNING: %s\n" % ( message.encode( self.console_encoding ) ) )

    def info(self, message):
	""" Prints a message to the console if self.loglevel >= LOG_VERBOSE """
	if self.loglevel >= LOG_VERBOSE:
	    sys.stderr.write( "INFO: %s\n" % ( message.encode( self.console_encoding ) ) )

    def debug(self, message):
	""" Prints a debug message to the console if self.loglevel >= LOG_DEBUG """
	if self.loglevel >= LOG_DEBUG:
	    sys.stderr.write( "DEBUG: %s\n" % ( message.encode( self.console_encoding ) ) )

    def service_loop( self ):
	""" Application main loop for processing incomming XMPP messages. 
	    Call only after connect() was successful.
	""" 

	sockets = ( self.xmpp.Connection._sock, )

	self.online = 1

	try:
	    while self.online:
		(in_socks , out_socks, err_socks) = select.select(sockets, [], sockets, 1)

		for sock in in_socks:
		    try:
			self.xmpp.Process(1)

			if not self.xmpp.isConnected(): 
			    self.warn("connection lost, reconnecting...")
			    
			    if self.xmpp.reconnectAndReauth():
				sockets = ( self.xmpp.Connection._sock, )
				self.info("re-connect successful.")
				self.on_connect()

		    except Exception, e:
			error_type, error_value, trbk = sys.exc_info()
			self.warn( "Error while processing! %s" % "  ".join( traceback.format_exception( error_type, error_value, trbk ) ) )
			# TODO: detect when we should kill the loop because a connection failed

		for sock in err_socks:
			raise Exception( "Error in socket: %s" % repr(sock) )
	except KeyboardInterrupt:
		pass

	self.info("service loop terminated, disconnecting")

	for sock in sockets:
	    sock.close()

	# TODO: how to leave chat room cleanly ?

	self.info("done.")

    def process_message(self, con, message):
	""" XMPP message handler, gets called automatically by the xmpppy framework. 
	    Will analyze the message and look for <rc> tags attached to it.
	    If such a tag is found, an instance of RecentChange is created for convenient access
	    to the recent changes properties, and it is passed to self.dispatch_rc().
	""" 

	if self.echo_stanzas:
	    print message.__str__(1)

        if (message.getError()):
            self.warn("received %s error from <%s>: %s" % (message.getType(), message.getError(), message.getFrom() ))
	elif message.getBody():
	    rc_dom = message.T.rc
	    if rc_dom:
		self.debug("RC %s message from <%s>: %s" % (message.getType(), message.getFrom(), message.getBody().strip() ))
		rc = RecentChange( rc_dom )
		self.dispatch_rc( rc )
	    else:
		self.info("plain %s message from <%s>: %s" % (message.getType(), message.getFrom(), message.getBody().strip() ))

    def dispatch_rc(self, rc):
	""" Dispatch an instance of RecentChange to all handlers registered using add_handler().
    
	    Arguments:
	    rc -- an instance of RecentChange that represents the event
	""" 

	for h in self.handlers:
	    if callable( h ):
		h( rc )
	    else:
		h.process( rc )

    def add_handler(self, handler):
	""" Adds a handler. The handler must either be callable or an instance of (a subclass of) RCHandler.
	    The handler will be called by dispatch_rc() for each RecentChange-instance to be dispatched, until
	    remove_handler() has been called on this handler at least as often as add_handler() had been called for it.
	""" 

	if not callable( handler ) and not isinstance( handler, RCHandler ):
	    raise TypeError( "handler must be callable or an instance of RCHandler" )

	self.handlers.append( handler )

    def remove_handler(self, handler):
	""" Adds a handler that had previously been registered using add_handler(). After remove_handler() has been called
	    at least as many times as add_handler() had been called for the same handler, the handler will no longer be 
	    called by dispatch_rc().
	""" 

	self.handlers.remove( handler )

    def guess_local_resource(self):
	""" Internal method for creating a resource ID for use when logging into an XMPP server.
	    The automatic resource name is composed of the local hostname and the program's PID.
	""" 

	resource = "%s-%d" % ( socket.gethostname(), os.getpid() ) 
	
	return resource;

    def connect( self, jid, password ):
	""" Connects this RCClient to an XMPP server using the given jid and password 
	    for authentication. If the jid does nopt contain a resource id, one will
	    be generated automatically using guess_local_resource()
	""" 

	if type( jid ) != object:
	    jid = xmpp.protocol.JID( jid )

	if jid.getResource() is None:
	    jid = xmpp.protocol.JID( host= jid.getHost(), node= jid.getNode(), resource = self.guess_local_resource() )

	self.xmpp = xmpp.Client(jid.getDomain(),debug=[])
        con= self.xmpp.connect()

        if not con:
            self.warn( 'could not connect to %s!' % jid.getDomain() )
            return False

        self.debug( 'connected with %s' % con )

        auth= self.xmpp.auth( jid.getNode(), password, resource= jid.getResource() )

        if not auth:
            self.warn( 'could not authenticate as %s!' % jid )
            return False

        self.debug('authenticated using %s as %s' % ( auth, jid ) )

        self.xmpp.RegisterHandler( 'message', self.process_message )

	self.jid = jid;
        self.info( 'connected as %s' % ( jid ) )

	self.on_connect()

        return con

    def on_connect( self ):
	""" Hook called after a successfull run of connect(). This implementation sends 
	    an initial presence notification to the server and retrieves the roster.
	    If a chat room is known to this client, it will be joined (this is useful for
	    re-connecting after an interruption).
	""" 

        self.xmpp.sendInitPresence(self)
        self.roster = self.xmpp.getRoster()

	if self.room:
		self.join( self.room )

    def join(self, room, nick = None):
	""" Joins a MUC room. Only works after a successful connect().

	    Arguments:
	    room -- the JID of the room to join
	    nick -- the nickname to join the room with. If not given, the node name from the jid passed to connect() will be used.
	""" 

	if not nick:
	    nick = self.jid.getNode()

	if type( room ) != object:
	    room = xmpp.protocol.JID( room )

	# use our own desired nickname as resource part of the room's JID
	gjid = room.getStripped() + "/" + nick; 

	#create presence stanza
	join = xmpp.Presence( to= gjid )

	#announce full MUC support
	join.addChild( name = 'x', namespace = 'http://jabber.org/protocol/muc' ) 

	self.xmpp.send( join )

	self.info( 'joined room %s' % room.getStripped() )

	self.room = room
	self.nick = nick

	return True

##################################################################################

if __name__ == '__main__':

    # -- CONFIG & COMMAND LINE ----------------------------------------------------------------------

    # find the location of this script
    bindir=  os.path.dirname( os.path.realpath( sys.argv[0] ) )
    extdir=  os.path.dirname( bindir )

    # set up command line options........
    option_parser = optparse.OptionParser()
    option_parser.set_usage( "usage: %prog [options] [room]" )
    option_parser.add_option("--config", dest="config_file", 
				help="read config from FILE", metavar="FILE")

    option_parser.add_option("--quiet", action="store_const", dest="loglevel", const=LOG_QUIET, default=LOG_VERBOSE, 
				help="suppress informational messages, only print warnings and errors")

    option_parser.add_option("--debug", action="store_const", dest="loglevel", const=LOG_DEBUG, 
				help="print debug messages")

    option_parser.add_option("--nick", dest="nick", metavar="NICKNAME", default=None,
				help="use NICKNAME in the MUC room")

    option_parser.add_option("--xml", action="store_true", dest="xml",
				help="echo XML <rc> tags, not interpreted RC info")

    option_parser.add_option("--stanzas", action="store_true", dest="stanzas",
				help="echo raw XMPP stanzas only")

    (options, args) = option_parser.parse_args()

    # find config file........
    if options.config_file:
	cfg = options.config_file #take it from --config
    else:
        cfg = extdir + "/../../rcclient.ini" #installation root

	if not os.path.exists( cfg ):
		cfg = extdir + "/../../phase3/rcclient.ini" #installation root in dev environment

	if not os.path.exists( cfg ):
		cfg = bindir + "/rcclient.ini" #extension dir

    # define config defaults........
    config = ConfigParser.SafeConfigParser()

    config.add_section( 'XMPP' )
    config.set( 'XMPP', 'room', '' )
    config.set( 'XMPP', 'nick', '' )

    # read config file........
    if not config.read( cfg ):
	sys.stderr.write( "failed to read config from %s\n" % cfg )
	sys.exit(2)

    jid = config.get( 'XMPP', 'jid' )
    password = config.get( 'XMPP', 'password' )

    if len(args) >= 1:
	room = args[0]
    else:
	room = config.get( 'XMPP', 'room' )

    if options.nick is None:
	nick = config.get( 'XMPP', 'nick' )
    else:
	nick = options.nick

    if room == '': room = None
    if nick == '': nick = None

    # -- DO STUFF -----------------------------------------------------------------------------------

    # create rc client instance
    client = RCClient( )
    client.loglevel = options.loglevel

    # add an echo handler that prints the RC info to the shell
    if options.stanzas:
	client.echo_stanzas = True
    elif options.xml:
	client.add_handler( XMLEcho() ) 
    else:
	client.add_handler( RCEcho() ) 

    # connect................
    if not client.connect( jid, password ):
	sys.exit(1)

    if room:
	client.join( room, nick )

    # run listener loop................
    client.service_loop( )

    print "done."
    