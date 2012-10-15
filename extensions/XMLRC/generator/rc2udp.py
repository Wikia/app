#!/usr/bin/python

##############################################################################
# UDP generator for testing the UDP-to-XMPP bridge and XMPP client
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

import sys, os, os.path, traceback, time
import ConfigParser, optparse
import socket, urllib
import xmpp.simplexml # could use a different XML lib, but since udp2xmpp and rcclient use this, just stick with it

from xml.parsers.expat import ExpatError

LOG_MUTE = 0
LOG_QUIET = 10
LOG_VERBOSE = 20
LOG_DEBUG = 30

MAX_RC_XML_SIZE = 4 * 1024 # largest size a <rc> tag may have.

##################################################################################

class RCPoller(object):
    """ RCPoller polls recent changes from a MediaWiki web API,
	and passes them to a handler. """

    def __init__( self, api_url, interval = 10, console_encoding = 'utf-8', 
		  rclimit = 500, rcprops = 'user|comment|flags|timestamp|title|ids|sizes|redirect|loginfo|tags' ):

	self.console_encoding = console_encoding
	self.api_url = api_url

	self.handlers = []
	self.loglevel = LOG_VERBOSE

	self.console_encoding = console_encoding
	self.interval = interval

	self.rcprops = rcprops
	self.rclimit = rclimit

	self.wikiid = None

    def warn(self, message):
	if self.loglevel >= LOG_QUIET:
	    sys.stderr.write( "WARNING: %s\n" % ( message.encode( self.console_encoding ) ) )

    def info(self, message):
	if self.loglevel >= LOG_VERBOSE:
	    sys.stderr.write( "INFO: %s\n" % ( message.encode( self.console_encoding ) ) )

    def debug(self, message):
	if self.loglevel >= LOG_DEBUG:
	    sys.stderr.write( "DEBUG: %s\n" % ( message.encode( self.console_encoding ) ) )

    def poll_loop( self ):
	self.online = 1

	limit = 1 #NOTE: on the first call, only fetch one RC
	last_id = 0
	last_timestamp = False

	if not self.wikiid:
	    self.wikiid = self.fetch_wiki_id()
	    self.info( "wikiid is %s" % self.wikiid )

	try:
	    while self.online:
		self.debug( "fetching RCs since %s (from #%d)" % (last_timestamp, last_id) )

		try:
		    rcs = self.fetch_recent_changes( last_id, last_timestamp, limit )

		    if len(rcs) > 0:
			limit = self.rclimit

		except Exception, e:
		    error_type, error_value, trbk = sys.exc_info()
		    self.warn( "Failed to fetch changes: %s" % "  ".join( traceback.format_exception( error_type, error_value, trbk ) ) )
		    continue

		for rc in rcs:
			self.debug( "dispatching RC #%s (%s)" % (rc['rcid'], rc['timestamp']) )

			rc.setAttr( 'wikiid', self.wikiid )

			self.dispatch_rc( rc )

			last_id = int( rc['rcid'] )
			last_timestamp = rc['timestamp']

		self.debug( "sleeping for %d sec" % self.interval )
		time.sleep( self.interval )
		

	except KeyboardInterrupt:
		pass

	self.info("service loop terminated, disconnecting")

	# XXX: close handlers?
 
	self.info("done.")

    def fetch_recent_changes(self, last_id, last_timestamp, limit = None ):
	if limit is None:
	    limit = self.rclimit

	u = self.api_url + "?format=xml&action=query&list=recentchanges&rcdir=older"
	u += "&rcprop=%s&rclimit=%d" % ( self.rcprops, limit )

	if last_timestamp:
	    u += "rcstart=%s" % ( last_timestamp, )

	x = urllib.urlopen( u )
	xml = x.read( self.rclimit * MAX_RC_XML_SIZE )

	try:
	    dom = xmpp.simplexml.XML2Node( xml )
	    if dom is None:
		raise IOError( "Failed to parse changes. data: %s" % xml[:128] )

	    rcs = dom.T.query.T.recentchanges.getTags( 'rc' )

	    rcs.reverse() # oldest first!

	    #skip redundant RC entries
	    i = 0
	    while i < len(rcs) and int( rcs[i]['rcid'] ) <= last_id:
		i += 1

	    rcs = rcs[i:]

	    return rcs

	except ExpatError, e:
	    error_type, error_value, trbk = sys.exc_info()
	    raise IOError( "Failed to parse site info: <%s> %s; data: %s" % ( error_type, error_value, xml[:128] ) )

    def fetch_wiki_id( self ):
	u = self.api_url + "?format=xml&action=query&meta=siteinfo&siprop=general"

	x = urllib.urlopen( u )
	xml = x.read( MAX_RC_XML_SIZE )

	try:
	    dom = xmpp.simplexml.XML2Node( xml )
	    if dom is None:
		raise IOError( "Failed to parse site info. data: %s" % xml[:128] )

	    info = dom.T.query.T.general

	    return info['wikiid']

	except ExpatError, e:
	    error_type, error_value, trbk = sys.exc_info()
	    raise IOError( "Failed to parse site info: <%s> %s; data: %s" % ( error_type, error_value, xml[:128] ) )
	
    def dispatch_rc(self, rc):
	for h in self.handlers:
	    try:
		h( rc )
	    except Exception, e:
		error_type, error_value, trbk = sys.exc_info()
		self.warn( "Error in handler: %s" % "  ".join( traceback.format_exception( error_type, error_value, trbk ) ) )

    def add_handler(self, handler):
	self.handlers.append( handler )

    def remove_handler(self, handler):
	self.handlers.remove( handler )

class UDPSender(object):
    def __init__(self, host, port):
	self.address = ( host, port )
	self.socket = None

    def connect( self ):
	self.sock = socket.socket( socket.AF_INET, socket.SOCK_DGRAM )
	self.sock.setsockopt( socket.SOL_SOCKET, socket.SO_REUSEADDR, 1 )
	self.sock.setblocking( 1 )

	return True

    def send( self, data ):
	if type(data) == unicode:
	    data = data.encode('utf-8')

	if type(data) != str:
	    data = data.__str__()
	    data = data.encode('utf-8')

	self.sock.sendto( data, 0, self.address )

    def close( self ):
	self.socket.close()

    def __call__(self, data ):
	self.send( data )

##################################################################################

if __name__ == '__main__':

    # -- CONFIG & COMMAND LINE ----------------------------------------------------------------------

    # find the location of this script
    bindir=  os.path.dirname( os.path.realpath( sys.argv[0] ) )
    extdir=  os.path.dirname( bindir )

    # set up command line options........
    option_parser = optparse.OptionParser()
    option_parser.set_usage( "usage: %prog [options] <api-url> <target-host> [port]" )

    option_parser.add_option("--config", dest="config_file", 
				help="read config from FILE", metavar="FILE")

    option_parser.add_option("--quiet", action="store_const", dest="loglevel", const=LOG_QUIET, default=LOG_VERBOSE, 
				help="suppress informational messages, only print warnings and errors")

    option_parser.add_option("--debug", action="store_const", dest="loglevel", const=LOG_DEBUG, 
				help="print debug messages")

    (options, args) = option_parser.parse_args()

    # find config file........
    if options.config_file:
	cfg = options.config_file #take it from --config
    else:
        cfg = extdir + "/../../rc2udp.ini" #installation root

	if not os.path.exists( cfg ):
		cfg = extdir + "/../../phase3/rc2udp.ini" #installation root in dev environment

	if not os.path.exists( cfg ):
		cfg = bindir + "/rc2udp.ini" #extension dir

    # define config defaults........
    config = ConfigParser.SafeConfigParser()

    config.add_section( 'rc2udp' )
    config.set( 'rc2udp', 'port', '4455' )
    config.set( 'rc2udp', 'poll-interval', '10' )
    config.set( 'rc2udp', 'rclimit', '500' )
    config.set( 'rc2udp', 'rcprops', 'user|comment|flags|timestamp|title|ids|sizes|redirect|loginfo|tags' )

    # read config file........
    if not config.read( cfg ):
	sys.stderr.write( "failed to read config from %s\n" % cfg )
	sys.exit(2)

    api = args[0]
    host = args[1]

    if len(args) >= 3:
	port = int( args[2] )
    else:
	port = config.getint( 'rc2udp', 'port' )

    # -- DO STUFF -----------------------------------------------------------------------------------

    # tell python to send a meaningful UAS string
    class URLopener(urllib.FancyURLopener):
        version = "rc2udp.py (+http://www.mediawiki.org/wiki/Extension:XMLRC) " + urllib.FancyURLopener.version

    urllib._urlopener = URLopener()

    print "HTTP User-Agent: " + urllib._urlopener.version

    # create poller
    poller = RCPoller( api, interval = config.getint( 'rc2udp', 'poll-interval' ), 
		  rclimit = config.getint( 'rc2udp', 'rclimit' ), 
		  rcprops = config.get( 'rc2udp', 'rcprops' ) )

    poller.loglevel = options.loglevel

    # add an echo handler that prints the RC info to the shell
    sender = UDPSender( host, port )
    sender.connect()

    poller.add_handler( sender ) 

    # run listener loop................
    poller.poll_loop( )

    print "done."
    