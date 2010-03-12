#!/usr/bin/perl -l

#
# check which apaches are running 404handler and generate configuration for
# lighttpd
#

use common::sense;
use IO::Socket::INET;

#eloy@ap-s1:~$ for i in `seq 1 10`; do grep ap-s$i /etc/hosts; done
#10.8.2.12       ap-s1   ap1
#10.8.2.180      ap-s2
#10.8.2.111      ap-s3
#10.8.2.113      ap-s4
#10.8.2.161      ap-s5
#10.8.2.160      ap-s6
#10.8.2.162      ap-s7
#10.8.2.163      ap-s8
#10.8.2.164      ap-s9

my @lists = qw/
10.8.2.180:39393
10.8.2.111:39393
10.8.2.113:39393
10.8.2.161:39393
10.8.2.160:39393
10.8.2.162:39393
10.8.2.163:39393
10.8.2.164:39393
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
