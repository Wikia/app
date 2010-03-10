#!/usr/bin/perl -l

#
# check which apaches are running 404handler and generate configuration for
# lighttpd
#

use common::sense;
use IO::Socket::INET;

my @lists = qw/
127.0.0.1:39393
/;


print "fastcgi.server = (\n\t\"/404handler.fcgi\" => (";
for my $server ( @lists ) {
	#
	# check if server is available
	#
	my $socket = IO::Socket::INET->new(
		PeerAddr => $server,
		Timeout => 5,
		Proto => 'tcp' );

	if( $socket ) {
		my( $host, $port ) = split( ":", $server );
		print "\t\t(\n\t\t\t\"host\" => \"$host\",";
		print "\t\t\t\"port\" => $port,";
		print "\t\t\t\"check-local\" => \"disable\",";
		print "\t\t\t\"broken-scriptfilename\" => \"disable\",";
		print "\t\t\t\"allow-x-send-file\" => \"enable\"";
		print "\t\t),";
	}
}
print "\t)\n)"
