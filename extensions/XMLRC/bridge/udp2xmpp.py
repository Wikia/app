#!/usr/bin/python

##############################################################################
# UDP to XMPP relay server for XMLRC
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

import sys, os, os.path, traceback, random, time
import ConfigParser, optparse
import select, socket, urllib
import xmpp, xmpp.simplexml # using the xmpppy library <http://xmpppy.sourceforge.net/>, GPL

from xml.parsers.expat import ExpatError

LOG_MUTE = 0
LOG_QUIET = 10
LOG_VERBOSE = 20
LOG_DEBUG = 30
LOG_TRACE = 40

################################################################################
class WikiInfo(object):
    def __init__( self, config ):
	self.config = config

    def get_wikis( self ):
	return self.config.sections()

    def get_wiki_property( self, wiki, prop ):
	if not self.config.has_section( wiki ): 
	    return None

	if not self.config.has_option( wiki, prop ): 
	    return None

	return self.config.get( wiki, prop )

    def get_wiki_url( self, wiki, prop, suffix ):
	u = self.get_wiki_property( wiki, prop )
	if u is None:
	    u = self.get_wiki_base_url( wiki )
	    if not u is None:
		u = u + suffix

	return u

    def get_wiki_base_url( self, wiki ):
	return self.get_wiki_property( wiki, 'base-url' )

    def get_wiki_page_url( self, wiki ):
	return self.get_wiki_url( wiki, 'page-url', 'index.php/$1' )

    def get_wiki_script_url( self, wiki ):
	return self.get_wiki_url( wiki, 'script-url', 'index.php' )

    def get_wiki_api_url( self, wiki ):
	return self.get_wiki_url( wiki, 'api-url', 'api.php' )

    def get_wiki_channel_type( self, wiki ):
	return self.get_wiki_property( wiki, 'channel-type' )

    def get_wiki_channel_spec( self, wiki ):
	return self.get_wiki_property( wiki, 'channel' )

class Relay(object):
    def __init__( self, wiki_info, console_encoding = 'utf-8' ):
	self.console_encoding = console_encoding
	self.channels = {}
	self.loglevel = LOG_VERBOSE
	self.wiki_info = wiki_info;

    def append_exec_info(self, message, error_type = None, error_value = None, trbk = None):
	if trbk and not error_type:
	    message = message + "\n" + "  ".join( traceback.format_tb( trbk ) )
	elif error_type:
	    message = message + " * " + "  ".join( traceback.format_exception( error_type, error_value, trbk ) ) 

	return message

    def warn(self, message, error_type = None, error_value = None, trbk = None):
	if self.loglevel >= LOG_QUIET:
	    message = self.append_exec_info( message, error_type, error_value, trbk )
	    sys.stderr.write( "WARNING: %s\n" % ( message.encode( self.console_encoding ) ) )

    def info(self, message, error_type = None, error_value = None, trbk = None):
	if self.loglevel >= LOG_VERBOSE:
	    message = self.append_exec_info( message, error_type, error_value, trbk )
	    sys.stderr.write( "INFO: %s\n" % ( message.encode( self.console_encoding ) ) )

    def debug(self, message):
	if self.loglevel >= LOG_DEBUG:
	    sys.stderr.write( "DEBUG: %s\n" % ( message.encode( self.console_encoding ) ) )

    def trace(self, message):
	if self.loglevel >= LOG_TRACE:
	    sys.stderr.write( "TRACE: %s\n" % ( message.encode( self.console_encoding ) ) )

    def get_all_channels(self):
	return self.channels.values()

    def get_channel( self, name ):
	return self.channels.get( name )

    def add_channel( self, name, channel ):
	self.channels[ name ] = channel
	self.debug("added channel " + name)

    def create_channels( self, names, factories ):
	for wiki in names:
	    t = self.wiki_info.get_wiki_channel_type( wiki )
	    x = self.wiki_info.get_wiki_channel_spec( wiki )

	    f = factories[ t ]
	    channel = f( x )

	    self.add_channel( wiki, channel )

	self.join_channels()

    def join_channels( self ):
	for name, channel in self.channels.items():
	    channel.join() #FIXME: error detection / recovery!

    def broadcast_message( self, message, xml = None ):
        targets = self.get_all_channels()

	for t in targets:
	    t.send_message( message, xml = xml )

    def process_command(self, line):
	args = line.split()
	command = args[0][1:]
	args = args[1:]

	self.debug( "processing command: %s" % command )

        if ( command == 'quit' ):
    	    self.online = False
        #elif ( command.startswith( '/' ) ):
    	#    self.broadcast_message( line[1:] )
        elif ( command == 'send' ):
    	    self.broadcast_message( ' '.join(args) )
        elif ( command == 'trace' ):
    	    self.loglevel = LOG_TRACE
        elif ( command == 'debug' ):
    	    self.loglevel = LOG_DEBUG
        elif ( command == 'verbose' ):
    	    self.loglevel = LOG_VERBOSE
        elif ( command == 'quiet' ):
    	    self.loglevel = LOG_QUIET
	else:
	    self.warn( "unknwon command: %s" % command )

    def get_rc_text( self, rc ):
	rc_id = rc.getAttr( 'rcid' )
	rc_type = rc.getAttr( 'type' )
	rc_wikiid = rc.getAttr( 'wikiid' )

	if rc_id is None or rc_type is None or rc_wikiid is None:
	    return False

	rc_title = rc.getAttr( 'title' )
	rc_user = rc.getAttr( 'user' )
	rc_comment = rc.getAttr( 'comment' )
	rc_timestamp = rc.getAttr( 'timestamp' )

	rc_logtype = rc.getAttr( 'logtype' )
	rc_logaction = rc.getAttr( 'logaction' )

	rc_oldlen = rc.getAttr( 'oldlen' )
	rc_newlen = rc.getAttr( 'newlen' )
	rc_revid = rc.getAttr( 'revid' )
	rc_old_revid = rc.getAttr( 'old_revid' )

	rc_anon = rc.getAttr( 'anon' ) is not None
	rc_bot = rc.getAttr( 'bot' ) is not None
	rc_minor = rc.getAttr( 'minor' ) is not None

	if not rc_oldlen is None: rc_oldlen = int( rc_oldlen )
	if not rc_newlen is None: rc_newlen = int( rc_newlen )
	if not rc_revid is None: rc_revid = int( rc_revid )
	if not rc_old_revid is None: rc_old_revid = int( rc_old_revid )
	if not rc_id is None: rc_id = int( rc_id )

	if rc_comment is None: rc_comment = ''

	target = None
	target_params = {}

	if rc_type == 'log':
	    target = "Special:Log/" + rc_logtype;
	    target_params['page'] = rc_title
	else:
	    target = rc_title;

	    if rc_revid is not None:
		if rc_type != 'new':
		    target_params['diff'] = rc_revid
		    target_params['rcid'] = rc_id

		    if rc_old_revid is not None:
			target_params['oldid'] = rc_old_revid
		else:
		    target_params['oldid'] = rc_revid

	url = self.get_wiki_url( rc_wikiid, target, **target_params );
	if not url: url = ''

	if rc_oldlen is not None and rc_newlen is not None and rc_type != 'log':
		d = ( rc_newlen - rc_oldlen )
		if d >= 0:
			szdiff = '(+%d)' % d
		else: 
			szdiff = '(%d)' % d
	else:
		szdiff = ''

	flag = ''

	if rc_type == 'log':
		targetText = rc_title
		flag = rc_logaction
	else:
		flag = ''
		
		if rc_type == 'new':
		    flag += 'N';

		if rc_minor:
		    flag += 'M';

		if rc_bot:
		    flag += 'B';

		if rc_anon:
		    flag += 'A';

		# TODO: flag as ! for patrolling events, once we can receive them

	if target is None or rc_user is None:
	    return False

	fullString = "[[%s]] %s %s * %s * %s %s" % ( target, flag, url, rc_user, szdiff, rc_comment );

	return fullString;

    def get_wiki_url( self, wikiid, pagename, **params ):
	if type(pagename) == unicode:
	    pagename = pagename.encode('utf-8')

	if len(params) > 0 or pagename is None:
	    u = self.wiki_info.get_wiki_script_url( wikiid )
	    if not u: return False

	    if not pagename is None:
		params[ 'title' ] = pagename

	    for k, v in params.items():
		if type(v) == unicode:
		    params[k] = v.encode('utf-8')

	    return u + "?" + urllib.urlencode( params )
	else:
	    u = self.wiki_info.get_wiki_page_url( wikiid )
	    if not u: return False

	    return u.replace( '$1', urllib.quote( pagename ) )

    def relay_rc_message( self, rc ):
	w = rc.getAttr('wikiid')
	
	if not w:
	    self.warn( "missing attribute wikiid, can't determin channel. discarding message.")
	    return False

	t = self.get_channel( w )
	
	if not t:
	    self.warn( "no channel found for %s, discarding message " % w )
	    return False

	else:
	    m = self.get_rc_text( rc )

	    if m is None or m == False:
		self.warn( "insufficient information in RC packet (rcid: %s), discarding message" % rc.getAttr('rcid') )
	    else:
		self.debug( "relying RC message: %s" % m )
		return t.send_message( m, rc )

    def check_connections( self, connection_sockets, broken, context, exec_info = (), test = True ):
	remove = set()
	c = 0

	for sock, conn in connection_sockets.items():
	    if ( not test and not conn.is_connected() ) or ( test and not conn.test_connection() ):
		if test: 
		    self.warn( "test_connection for connection %s returned false (%s)" % (repr(conn), context), *exec_info );
		else: 
		    self.warn( "is_connected for connection %s failed (%s)" % (repr(conn), context), *exec_info ); 

		broken.add(conn)
		remove.add(sock)
		c += 1

	for sock in remove:
	    del connection_sockets[ sock ]

	return c

    def select_connections( self, connection_sockets, broken, timeout = 1 ):
	waiting = set()

	self.check_connections( connection_sockets, broken, "prior to socket-select", test = False )

	try:
	    (in_socks , out_socks, err_socks) = select.select(connection_sockets.keys(),[],connection_sockets.keys(),1)

	    for sock in err_socks:
		conn = connection_sockets[ sock ]
		self.warn("exception in socket %s, connection %s" % (repr(sock), repr(conn)));

		broken.add( conn )
		del connection_sockets[ sock ]

	    for sock in in_socks:
		conn = connection_sockets[ sock ]
		waiting.add( conn )

	except socket.error, e:
	    found = self.check_connections( connection_sockets, broken, "after exception", test = True, exec_info = sys.exc_info() )

	    if found == 0:
		    self.warn("exception ocurred, but all connections seem valid!", error_type, error_value, trbk);

	except IOError, e:
	    found = self.check_connections( connection_sockets, broken, "after exception", test = True, exec_info = sys.exc_info() )

	    if found == 0:
		    self.warn("exception ocurred, but all connections seem valid!", error_type, error_value, trbk);

	return waiting

    def service_loop( self, *connections ):
	self.online = 1

	connection_sockets = {}
	for conn in connections:
	    connection_sockets[ conn.get_socket() ] = conn

	broken = set()
	last_tick = 0

	try:
	    while self.online:
		waiting = self.select_connections( connection_sockets, broken, timeout = 1 )

		if broken:
		    self.debug( "currently broken: %s" % repr(broken) )

		for conn in broken:
		    if conn.reconnect_backoff():
			self.debug( "skipping attempt to reconnected for %s!" % repr(conn) )
			continue

		    try:
			conn.reconnect()

			connection_sockets[ conn.get_socket() ] = conn
			self.info( "reconnected %s!" % repr(conn) )

		    except Exception, e:
			error_type, error_value, trbk = sys.exc_info()
			self.warn( "Error during reconnect for connection %s!" % repr(conn), error_type, error_value, trbk )

		if len(broken) >0:
		    broken -= set( connection_sockets.values() )

		for conn in waiting:
		    try:
			conn.process()
		    except Exception, e:
			error_type, error_value, trbk = sys.exc_info()
			
			if not conn.test_connection():
			    self.warn("test_connection for connection %s failed after exception in process()" % repr(conn), error_type, error_value, trbk);
			    broken.add(conn)
			    del connection_sockets[ conn.get_socket() ]
			else:
			    self.info("connection %s seems to be valid after exception in process()" % repr(conn), error_type, error_value, trbk);

		t = int( time.time() )
		if t != last_tick:
		    for conn in connections:
			conn.tick()

		last_tick = t

	except KeyboardInterrupt:
	    self.online= 0

	self.info("service loop terminated, disconnecting")

	for conn in connections:
	    conn.close()

	self.info("done.")

################################################################################
class Connection(object):
    def __init__( self, relay ):
	self.relay = relay

    def warn(self, message):
	self.relay.warn( message )

    def info(self, message):
	self.relay.info( message )

    def debug(self, message):
	self.relay.debug( message )

    def trace(self, message):
	self.relay.trace( message )

    def tick(self):
	pass

class XmppCallback (object):
    def __init__( self, stanza = None, stanza_name = None, 
		  stanza_type = None, stanza_id = None, stanza_child_namespace = '', stanza_status = None, 
		  timeout = 10, permanent = False, match_condition = None, protocol_generator = None,
		  on_match = None, on_timeout = None, on_error = None, 
		  description = None
		):

	if stanza is None and stanza_name is None:
	    raise Exception("must provide at least stanza or stanza_name")

	if stanza and stanza_name is None:
	    stanza_name = stanza.getName()

	if stanza and (stanza_type is None or stanza_type==''):
	    t = stanza.getAttr("type")

	    if t == "get":
		stanza_type = "result"

	if stanza and (stanza_id is None or stanza_id==''):
	    stanza_id = stanza.getAttr("id")

	self.stanza_types = None
	self.stanza_name = stanza_name
	self.stanza_type = stanza_type
	self.stanza_id = stanza_id
	self.stanza_status = stanza_status
	self.stanza_child_namespace = stanza_child_namespace

	if self.stanza_type and type(self.stanza_type) in set((set, tuple, list)):
	    self.stanza_types = set(self.stanza_type)
	    self.stanza_type = None
	elif self.stanza_type and self.stanza_type.find('|'):
	    self.stanza_types = set(self.stanza_type.split('|'))
	    self.stanza_type = None

	self.timeout = timeout
	self.permanent = permanent
	self.protocol_generator = protocol_generator

	self.connection = None
	self.status = "pending"

	if description is None:
	    self.description = "<%s type=%s id=%s ns=%s>" % ( stanza_name, stanza_type, stanza_id, stanza_child_namespace )
	else:
	    self.description = description

	if on_timeout:
	    if type(on_timeout) == unicode or type(on_timeout) == str:
		msg = on_timeout

		on_timeout = lambda cb: self.connection.warn(msg),

	    self.on_timeout = on_timeout

	if on_error:
	    if type(on_error) == unicode or type(on_error) == str:
		msg = on_error
		if msg.find("%") < 0:
		    msg += " (%s)"

		on_error = lambda cb, stanza: self.connection.warn(msg % stanza.getError()),

	    self.on_error = on_error

	if on_match:
	    if type(on_match) == unicode or type(on_match) == str:
		msg = on_match

		on_match = lambda cb, stanza: self.connection.info(msg),

	    self.on_match = on_match

	if match_condition:
	    self.match_condition = match_condition
	else:
	    self.match_condition = None

    def __str__(self):
	return self.description

    def configure_for_response(self, stanza):
	# match on id
	sid = stanza.getAttr('id')
	if not self.stanza_id and sid:
	    self.stanza_id = sid
	
	# match on corresponding type
	t = stanza.getAttr('type')
	if not self.stanza_type and t:
	    if t == 'get':
		self.stanza_type = 'result'

	# match on stanza name (this is probably pointless, since it's always set anyway)
	if not self.stanza_name:
	    self.stanza_name = stanza.getName()

    def on_match(self, stanza):
	pass

    def on_timeout(self, dummy):
	self.connection.warn("callback timed out: %s" % (self.description))

    def on_error(self, dummy, stanza):
	self.connection.warn("callback got error: %s -> %s" % (self.description, stanza.__str__()))

    def handle_tick(self):
	if self.timeout is None or self.permanent:
	    return # callback is permanent

	self.timeout -= 1
	if self.timeout <= 0:
	    try:
		self.status = "timeout"
		self.on_timeout(self)
	    finally:
		self.unregister()

    def handle_stanza(self, conn, stanza):
	if self.matches_stanza( stanza ):
	    connection = self.connection #save across unregistr

	    try:
		if stanza.getError() or stanza.getAttr("type") == "error":
		    self.status = "error"
		    self.on_error( self, stanza )
		else:
		    self.status = "matched"
		    self.on_match( self, stanza )
	    finally:
		if not self.permanent:
		    self.unregister()

	    if self.protocol_generator:
		connection.run_protocol( self.protocol_generator )

    def matches_stanza(self, stanza):
	# NOTE: stanza_name and stanza_child_namespace are already checked by the dispatcher!
	#       stanza_type could also be matched by the dispatcher, but that's not quite flexible enough

	if self.stanza_id is not None:
	    if self.stanza_id != stanza.getAttr( 'id' ):
		return False

	t = stanza.getAttr( 'type' )

	if t != "error": #always pass type="error". filter other types
	    if self.stanza_type is not None and self.stanza_type != '':
		if self.stanza_type != t:
		    return False

	    if self.stanza_types is not None:
		if t not in self.stanza_types:
		    return False

	if self.stanza_status is not None:
	    if self.stanza_status not in self.connection.get_status_codes(stanza):
		return False

	if self.match_condition and not self.match_condition(self, stanza):
	    return False

	return True

    def attach(self, connection):
	if self.connection is not None:
	    raise Exception('callback is already attached!')

	self.connection = connection

    def detach(self, connection):
	if self.connection is None:
	    return

	if connection != self.connection:
	    raise Exception("trying to detach from the wrong connection object!")

	self.connection = None

    def unregister(self):
	if not self.connection:
	    return

	self.connection.remove_callback(self)

	self.connection = None

class XmppConnection (Connection):
    def __init__( self, relay, message_encoding = 'utf-8', backoff_factor = 5, backoff_max_tock = 6, xmpp_debug = [], connection_security = None ):
        super( XmppConnection, self ).__init__( relay )
	self.message_encoding = message_encoding
	self.jid = None

	if connection_security == '0' or connection_security == 0 or connection_security == 'off':
	    self.connection_security = 0
	elif connection_security == '1' or connection_security == 1 or connection_security == 'on':
	    self.connection_security = 1
	else:
	    self.connection_security = None

	self.id_counter = 0
	self.xmpp_debug = xmpp_debug

	self.backoff_tick = 0
	self.backoff_tock = 0
	self.backoff_factor = backoff_factor 
	self.backoff_max_tock = backoff_max_tock

	self.connect_info = None

	self.callbacks = []

    def add_callback(self, callback):
	self.jabber.RegisterHandler( callback.stanza_name, callback.handle_stanza, typ = '', ns = callback.stanza_child_namespace ) #NOTE: leave type match to callback
	self.callbacks.append( callback )
	callback.attach( self )
	self.debug( "registered callback for %s: %s" % (callback.stanza_name, callback) )

    def remove_callback(self, callback):
	self.jabber.UnregisterHandler( callback.stanza_name, callback.handle_stanza, typ = callback.stanza_type, ns = callback.stanza_child_namespace )
	self.callbacks.remove( callback )
	callback.detach( self )
	self.debug( "unregistered callback for %s: %s" % (callback.stanza_name, callback) )

    def tick(self):
	for c in self.callbacks:
	    c.handle_tick()

    def process( self ):
	self.jabber.Process(1)

    def close( self ):
	# self.jabber.disconnect() #wha??
	# XXX: leave chat rooms, etc?

	sock = self.get_socket()
	if sock: sock.close()

	self.debug("closed xmpp socket")

    def make_jabber_channel( self, jid ):
	return JabberChannel( self, jid )

    def make_muc_channel( self, room_jid, room_nick = None ):
	if type(room_jid) != object:
	    room_jid = xmpp.protocol.JID( room_jid )

	if not room_nick:
	    room_nick = room_jid.getResource()

	if not room_nick:
	    room_nick = self.jid.getNode()

	return MucChannel( self, room_jid, room_nick )

    def log_server_error(self, stanza):
	error = stanza.getTag('error')

	if error:
	    name = None

	    for node in error.kids:
		if node and node.getNamespace(): 
		    name = node.getName()
		    break
	    
	    if name:
		self.warn( 'SERVER ERROR: %s: %s ' % ( error['type'], name ) )
	    else:
		self.warn( 'SERVER ERROR: %s' % error.__str__() )

	    return True
	else:
	    return False
	    

    def process_other_stanza(self, conn, stanza):
	self.trace("<< received <%s>: %s" % (stanza.getName(), stanza.__str__()) )  
	self.log_server_error( stanza )

    def process_message(self, conn, message):
        if self.log_server_error( message ):
	    return
	elif message.getBody():
	    if message.getFrom().getResource() != self.jid.getNode(): #FIXME: this inly works if no different nick was specified when joining the channel
		self.debug("discarding %s message from <%s>: %s" % (message.getType(), message.getFrom(), message.getBody().strip() ))

    def process_presence(self, conn, presence):
	self.trace("<< received presence: %s" % presence)  

	if self.log_server_error( presence ):
	    return

	x = presence.getTag('x')
	if not x:
	    return

	ns = x.getNamespace()

	if ns == 'http://jabber.org/protocol/muc#user':
	    self.process_presence_muc_user( conn, x )

    def process_presence_muc_user(self, conn, x):
	self.debug( 'muc presence: %s' % x.__str__() ) #FIXME: better info!

    def guess_local_resource(self):
	resource = "%s-%d" % ( socket.gethostname(), os.getpid() ) 
	
	return resource;

    def connect( self, jid, password, port = 5222, host = None ):

	self.connect_info = { 'jid': jid, 'password': password, 'port': port, 'host': host }

	if type( jid ) != object:
	    jid = xmpp.protocol.JID( jid )

	if jid.getResource() is None:
	    jid = xmpp.protocol.JID( host= jid.getDomain(), node= jid.getNode(), resource = self.guess_local_resource() )

	if host is None:
	    host = jid.getDomain()

	self.jabber = xmpp.Client( host, port = port, debug = self.xmpp_debug )
        conn= self.jabber.connect( secure = self.connection_security )

        if not conn:
            self.warn( 'could not connect to %s:%s!' % (host, port) )
            return False

        self.debug( 'connected with %s' % conn )

        auth= self.jabber.auth( jid.getNode(), password, resource= jid.getResource() )

        if not auth:
            self.warn( 'could not authenticate as %s!' % jid )
            return False

        self.debug('authenticated using %s as %s' % ( auth, jid ) )

        self.jabber.RegisterHandler( 'message', self.process_message )
        self.jabber.RegisterHandler( 'presence', self.process_presence )
        self.jabber.RegisterHandler( 'iq', self.process_other_stanza )

	self.jid = jid;
        self.info( 'connected as %s to %s' % ( jid, host ) )

	self.ping()
	self.on_connect()

        return conn

    def on_connect( self ):
        self.jabber.sendInitPresence(self)

	self.backoff_tick = 0
	self.backoff_tock = 0

        self.roster = self.jabber.getRoster()

	self.relay.join_channels() #FIXME: this re-joins *all* channels. not just the ones for this connection!

    def get_socket( self ):
	try:
	    return self.jabber.Connection._sock
	except AttributeError:
	    pass

	return None

    def is_connected( self ):
	return self.jabber.isConnected()

    def test_connection( self ):
	if not self.is_connected():
	    return False

	ok = True

	try:
	    ok = self.get_socket().fileno() >= 0
	except:
	    ok = False

	if not ok: return False

	try:
	    self.ping() #XXX: would be nice to *wait* for a response here...
	except:
	    ok = False

	self.jabber.connected = None #XXX: ugly
	return ok

    def get_status_codes(self, node):
	codes = set()

	if not node:
	    return codes

	if node.getName() != "x" and node.getName() != "item":
	    node = node.T.x

	if not node:
	    return codes

	if node.getName() == "x":
	    node = node.T.item

	for s in node.getTags("status"):
	    codes.add( s.code )

	return codes

    def make_id( self, name ):
	self.id_counter += 1
	r = random.randint(1000000, 9999999)

	the_id = "%s-%d-%d" % (name, self.id_counter, r)
	return the_id

    def future_send( self, stanza, callback = None, **args ):
	future = {}
	future.update(args)

	future['callback'] = callback
	future['stanza'] = stanza

	return future

    def send( self, stanza, callback = None, **args ):
	if stanza.getName() == "iq":
	    # auto-assign id for iq
	    if stanza.getAttr("type") == "get" and stanza.getAttr("id") is None:
		stanza.setAttr( "id", self.make_id("iq") )

	if not callback and 'on_match' in args:
	    callback = args['on_match']
	    del args['on_match']

	if callback and callable(callback):
	    # if callback is a plain callable, wrap in a XmppCallback
	    callback = XmppCallback(stanza, on_match = callback, **args)
	elif callback:
	    # otherwise auto-match stanza
	    callback.configure_for_response(stanza)
	elif args:
	    raise Exception("no callback, but callback arguments: %s" % repr(args))

	self.jabber.send(stanza)
	self.trace('>> stanza sent: %s' % stanza.__str__() )
	self.trace('...callback: %s' % repr(callback) )

	if callback:
	    self.add_callback(callback)  # NOTE: can't miss anything, this is single threaded!
	    return callback
	else:
	    return True

    def run_protocol( self, protocol_generator ):
	if callable(protocol_generator):
	    protocol_generator = protocol_generator(self) # factory passed, instantiate generator

	try:
	    n = protocol_generator.next()

	    if callable(n):
		self.debug("run protocol: callable %s" % repr(n))

		return n(self, protocol_generator)
	    else:
		n['protocol_generator'] = protocol_generator #pass the generator itself to the next incaranation!

		self.debug("run protocol: dict %s" % repr(n))
		return self.send(**n)
	except StopIteration:
	    self.debug("run protocol: done.")

	return False


    def ping( self ):
	ping = xmpp.Iq( typ='get', to= self.jid.getDomain(), frm= self.jid )
	ping.addChild( name= "ping", namespace = "urn:xmpp:ping" )

	self.send( ping, lambda cb, stanza: self.debug('response received to ping!'), description= "expect pong" )
	self.debug('ping sent: %s' % ping.__str__() )

    def reconnect_backoff( self ):
	self.debug( "reconnect_backoff: tick = %d, tock = %d" % (self.backoff_tick, self.backoff_tock) )

	if self.backoff_tick <= 0:
	    self.backoff_tock = min( self.backoff_tock + 1, self.backoff_max_tock )
	    self.backoff_tick = self.backoff_tock * self.backoff_factor
	    return False
	else: 
	    self.backoff_tick -= 1
	    return True

    def reconnect( self ):
	try:
	    if self.jabber:
		self.close()
	except:
	    pass

	if self.connect_info:
	    self.connect( **self.connect_info )

class CommandConnection (Connection):
    def __init__( self, relay, socket ):
        super( CommandConnection, self ).__init__( relay )
	self.socket = socket
	self.connected = None

    def close( self ):
	if self.socket != sys.stdin:
	    self.socket.close()
	    self.debug("closed command socket")
	else:
	    self.debug("not closing stdin")

    def process(self):
	msg = self.socket.readline().strip()

	if (msg.startswith('/')):
	    self.process_command( msg )
	#else:
	#    self.relay.broadcast_message( msg )

    def process_command(self, command):
        self.relay.process_command( command )

    def is_connected( self ):
	if self.connected is None:
	    self.connected = self.test_connection()

	return self.connected

    def get_socket( self ):
	return self.socket

    def test_connection( self ):
	try:
	    self.socket.fileno()
	    self.connected = True
	except:
	    self.connected = False

	return self.connected

    def reconnect_backoff( self ):
	return False

    def reconnect( self ):
	raise IOException("can't reconnect command socket!")


class UdpConnection (Connection):
    def __init__( self, relay, buffer_size = 8192 ):
        super( UdpConnection, self ).__init__( relay )
	self.buffer_size = buffer_size
	self.socket = None
	self.address = None
	self.connected = None

    def close( self ):
	self.socket.close()
	self.debug("closed UDP socket")

    def process(self):
	packet = self.socket.recvfrom( self.buffer_size )

	body = packet[0]
	addr = packet[1] #TODO: optionally filter...

	self.trace( "<< received packet from %s:%s" % addr )
	self.process_rc_packet( body )

    def process_rc_packet(self, data):
	try:
	    dom = xmpp.simplexml.XML2Node( data )

	    if dom.getName() != "rc":
		self.warn( "expected <rc> element, found <%s>; sklipping unknown XML" % dom.getName() )
		return False

	except ExpatError, e:
	    self.warn( "failed to parse RC XML: " + e.args[0] + "; data: " + data[:128].strip() )
	    return False
	
	#TODO: optionally filter...
	self.relay.relay_rc_message( dom )

    def connect( self, port, interface = '0.0.0.0' ):
	self.socket = socket.socket( socket.AF_INET, socket.SOCK_DGRAM )
	self.socket.setsockopt( socket.SOL_SOCKET, socket.SO_REUSEADDR, 1 )
	self.socket.setblocking( 0 )

	self.debug( "binding to UDP %s:%d" % (interface, port) )
	self.socket.bind( (interface, port) )

	if not self.socket.fileno():
	    self.warn( "failed to bind to UDP %s:%d" % (interface, port) )
	    return False

	self.address = (interface, port)

	self.info( "listening to UDP %s:%d" % (interface, port) )
	self.connected = True

	return True

    def get_socket( self ):
	return self.socket

    def is_connected( self ):
	return self.connected

    def test_connection( self ):
	try:
	    self.socket.fileno()
	    #TODO: try more stuff!
	    return True
	except:
	    pass

	self.connected = False
	return False

    def reconnect_backoff( self ):
	return False

    def reconnect( self ):
	try:
	    if self.socket:
		self.close()
	except:
	    pass

	if self.address:
	    return self.connect( self.address[1], self.address[0] ) 
	else:
	    return None

##################################################################################

class Channel(object):
    def __init__( self, connection ):
	self.connection = connection

    def join(self):
	pass

class JabberChannel (Channel):
    def __init__( self, connection, jid ):
	super( JabberChannel, self ).__init__( connection )

	if type( jid ) != object:
	    jid = xmpp.protocol.JID( jid )

	self.connection = connection
        self.jid = jid
	self.message_type = 'chat'

    def compose_message( self, message, xml = None, mtype = None ):
	if type( message ) == unicode:
	    message = message.encode( self.connection.message_encoding )

	if type( message ) == str:
	    if mtype is None:
		mtype = self.message_type

	    message = xmpp.protocol.Message( self.jid, body= message, typ= mtype )

	    if xml:
		message.addChild( node = xml )
	else:
	    if xml:
		raise Exception("Message already composed, can't attach XML!")

	    if mtype is not None and mtype != message.getType():
		raise Exception("Message already composed with incompatible type! ( %s != %s )" % (mtype, message.getType()) )

	return message

    def send_message( self, message, xml = None, mtype = None ):
	if not self.connection.is_connected():
	    self.connection.warn( "not connected XMPP server, discarding message %s" % message )
	    return False

	message = self.compose_message( message, mtype = mtype, xml = xml )

        return self.connection.send( message )

class MucChannel (JabberChannel):
    def __init__( self, connection, room_jid, room_nick ):
	if type( room_jid ) != object:
	    room_jid = xmpp.protocol.JID( room_jid )

	super( MucChannel, self ).__init__( connection, room_jid.getStripped() )

        self.nick = room_nick
	self.message_type = 'groupchat'

	self.room_identity = None
	self.presence = None
	self.status = None
	self.is_new_room = None
	self.presence_type = None

    def part_protocol(self, connection ):
	# use our own desired nickname as resource part of the group's JID
	jid = self.jid.getStripped() + "/" + self.nick; 

	#create presence stanza
	part = xmpp.Presence( to= jid, typ = "unavailable" )

	send = self.connection.future_send( part, 
	    match_condition = lambda cb, stanza: self.is_my_presence(stanza),
	    on_match = lambda cb, stanza: None, #already handled by permanent handler for set_my_presence
	    on_error = "FAILED TO LEAVE ROOM %s! " % jid,
	    on_timeout = "TIMEOUT WHILE LEAVING ROOM %s! " % jid,
	    description = "final presence for %s (part)" % jid,
	    )
	self.connection.info( 'leaving room %s' % self.jid.getStripped() )
	yield send

    def join_protocol(self, connection, create = True, register = True ):
	# use our own desired nickname as resource part of the group's JID
	jid = self.jid.getStripped() + "/" + self.nick; 

	#create presence stanza
	join = xmpp.Presence( to= jid )
	join.addChild( name = 'x', namespace = 'http://jabber.org/protocol/muc' )  #announce full MUC support

	send = self.connection.future_send( join, 
	    match_condition = lambda cb, stanza: self.is_my_presence(stanza),
	    on_match = lambda cb, stanza: self.set_my_presence(stanza, callback = cb),
	    on_error = "PRESENCE ERROR %s! " % jid,
	    permanent = True,
	    description = "room presence for %s" % jid
	    )
	self.connection.debug( 'joining room %s' % self.jid.getStripped() )
	yield send

	#create disco query
	disco = xmpp.Iq( to= self.jid, typ="get" )
	disco.addChild( name="query", namespace = "http://jabber.org/protocol/disco#info" )

	send = self.connection.future_send( disco, 
	    on_match = lambda cb, stanza: self.set_room_info(stanza), 
	    on_error = "FAILED TO GET ROOM IDENTITY FOR %s! " % jid,
	    on_timeout = "TIMEOUT WHILE GETTING ROOM IDENTITY FOR %s!" % jid,
	    description = "room info for %s" % jid
	    )
	yield send
	
	if not self.is_new_room:
	    return
	elif not create and not register:
	    self.connection.warn("ROMM %s DID NOT EXIST! creation/registeration is not enabled." % jid)
	    self.part()
	    return

	#TODO: configure/register!

    def join(self):
	self.connection.run_protocol( self.join_protocol )

    def part(self):
	self.connection.run_protocol( self.part_protocol )

    def create_room(self):
	# use our own desired nickname as resource part of the group's JID
	jid = self.jid.getStripped() + "/" + self.nick; 

	#create presence stanza
	join = xmpp.Presence( to= jid )
	join.addChild( name = 'x', namespace = 'http://jabber.org/protocol/muc' )  #announce full MUC support

    def set_room_info( self, iq ):
	self.connection.debug("ROOM IDENITY: " + iq.T.query.T.identity.__str__())
	self.room_identity = iq.T.query.T.identity

    def set_my_presence( self, presence, callback = None ):
	self.connection.debug("MY PRESENCE: %s" + presence.__str__() )

	self.presence_type = presence.getAttr("type")
	if self.presence_type is None: 
	    self.presence_type = "subscribed"

	if self.presence_type != "unavailable" and self.presence is None:
	    self.connection.info("joined room " + presence.getFrom().__str__() )

	self.presence = presence
	self.status = self.connection.get_status_codes(presence)
	self.is_new_room = ( self.is_new_room or "201" in self.status )

	if self.presence_type == "unavailable":
	    self.connection.info("left room " + presence.getFrom().__str__() )
	    self.status = None
	    self.room_identity = None
	    self.is_new_room = None
	    self.presence = None

	    if callback:
		self.connection.remove_callback(callback)

    def is_my_presence( self, presence ):
	if presence.T.x and presence.T.x.getNamespace() == "http://jabber.org/protocol/muc#user":
	      if presence.T.x.T.item: 
		  jid = presence.T.x.T.item.getAttr("jid")
		  me = self.connection.jid.getStripped()

		  if jid.startswith( me ):
		      return True
	else:
	      self.connection.debug("not my presence: %s" + presence.__str__() )
	      return False


##################################################################################

if __name__ == '__main__':

    # find the location of this script
    bindir=  os.path.dirname( os.path.realpath( sys.argv[0] ) )
    extdir=  os.path.dirname( bindir )

    # set up command line options........
    option_parser = optparse.OptionParser()
    option_parser.add_option("--config", dest="config_file", 
				help="read config from FILE", metavar="FILE")

    option_parser.add_option("--wiki-info", dest="wiki_info_file", 
				help="read wiki info from FILE", metavar="FILE")

    option_parser.add_option("--xmpp-security", dest="xmpp_security", 
				help="SSL/TSL security. 'on', 'off' or 'auto'.")

    option_parser.add_option("--quiet", action="store_const", dest="loglevel", const=LOG_QUIET, default=LOG_VERBOSE, 
				help="suppress informational messages, only print warnings and errors")

    option_parser.add_option("--debug", action="store_const", dest="loglevel", const=LOG_DEBUG, 
				help="print debug messages")

    option_parser.add_option("--trace", action="store_const", dest="loglevel", const=LOG_TRACE, 
				help="print debug trace messages")

    option_parser.add_option("--xmpp-debug", action="store_true", dest="xmpp_debug", 
				help="""enable debugging in the xmpppy library. Flags are set in the [XMPP] section configuration, using the key 'debug-flags'. Flags are separated by pipe characters.""")

    (options, args) = option_parser.parse_args()

    # find config file........
    if options.config_file:
	cfg = options.config_file #take it from --config
    else:
        cfg = extdir + "/../../udp2xmpp.ini" #installation root

	if not os.path.exists( cfg ):
		cfg = extdir + "/../../phase3/udp2xmpp.ini" #installation root in dev environment

	if not os.path.exists( cfg ):
		cfg = bindir + "/udp2xmpp.ini" #extension dir

    # define config defaults........
    config = ConfigParser.SafeConfigParser()

    config.add_section( 'UDP' )
    config.set( 'UDP', 'buffer-size', '8192' )
    config.set( 'UDP', 'port', '4455' )
    config.set( 'UDP', 'interface', '0.0.0.0' )

    config.add_section( 'XMPP' )
    config.set( 'XMPP', 'message-encoding', 'utf-8' )
    config.set( 'XMPP', 'debug-flags', 'client|component|got' )
    config.set( 'XMPP', 'security', 'auto' )
    config.set( 'XMPP', 'port', '5222' )
    config.set( 'XMPP', 'host', '' )

    # read config file........
    if not config.read( cfg ):
	sys.stderr.write( "failed to read config from %s\n" % cfg )
	sys.exit(2)


    # find wiki info file........
    wikis = None

    if options.wiki_info_file:
	w = options.wiki_info_file #take it from --wiki-info

    elif config.has_option( 'udp2xmpp', 'wiki-info-section' ):
	# if the config specifies a wiki-info section, there's only one wiki
	# with the wiki id equal to that section name. The wiki's properties
	# are then take from that section in the config file, no extra wiki 
	# info file is needed.

	wikiid = config.get( 'udp2xmpp', 'wiki-info-section' ) 
	info = config.options( wikiid )

	wikis = ConfigParser.SafeConfigParser()
	wikis.add_section( wikiid )

	for k in info:
	    v = config.get( wikiid, k )
	    wikis.set( wikiid, k, v )

    elif config.has_option( 'udp2xmpp', 'wiki-info-file' ):
	w = config.get( 'udp2xmpp', 'wiki-info-file' ) # config file says where to find the wiki info file

	if not os.path.isabs( w ):
	    w = os.path.dirname( cfg ) + os.sep + w

    else:
        w = extdir + "/../../udp2xmpp-wikis.ini" #installation root

	if not os.path.exists( cfg ):
		w = extdir + "/../../phase3/udp2xmpp-wikis.ini" #installation root in dev environment

	if not os.path.exists( cfg ):
		w = bindir + "/udp2xmpp-wikis.ini" #extension dir

    # load wiki info file, if no wiki info is yet known
    if not wikis:
	wikis = ConfigParser.SafeConfigParser()
	if not wikis.read( w ):
	    sys.stderr.write( "failed to read wiki info from %s\n" % w )
	    sys.exit(2)

    # create wiki info wrapper and relay instance
    wiki_info = WikiInfo( wikis )
    relay = Relay( wiki_info )

    relay.loglevel = options.loglevel

    xmpp_port = config.getint( 'XMPP', 'port' )
    xmpp_host = config.get( 'XMPP', 'host' )

    if xmpp_host == '':
	xmpp_host = None

    xmpp_debug = []
    if options.xmpp_debug:
	xmpp_debug = config.get( 'XMPP', 'debug-flags' ).split("|")

    if options.xmpp_security:
	connection_security = options.xmpp_security
    else: 
	connection_security = config.get( 'XMPP', 'security' )

    # create connections............
    commands_con = CommandConnection( relay, sys.stdin )
    udp_con = UdpConnection( relay, buffer_size = config.getint( 'UDP', 'buffer-size' ) )    
    xmpp_con = XmppConnection( relay, message_encoding = config.get( 'XMPP', 'message-encoding' ), xmpp_debug = xmpp_debug, connection_security = connection_security )

    # -- DO STUFF -----------------------------------------------------------------------------------

    # connect................
    if not xmpp_con.connect( jid = config.get( 'XMPP', 'jid' ), password = config.get( 'XMPP', 'password' ), port = xmpp_port, host = xmpp_host ):
	sys.exit(1)

    if not udp_con.connect( port = config.getint( 'UDP', 'port' ), interface = config.get( 'UDP', 'interface' ) ):
	sys.exit(1)

    # create channels................
    # note: Need to be connected to do this. Some channels need to be joined.
    relay.create_channels( wiki_info.get_wikis(), {
			      'jabber': xmpp_con.make_jabber_channel,
			      'muc': xmpp_con.make_muc_channel,
			  } )
    
    # run relay loop................
    relay.service_loop( commands_con, udp_con, xmpp_con )

    print "done."
