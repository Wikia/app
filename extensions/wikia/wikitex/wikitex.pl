#!/usr/bin/perl -w

package main;

use strict;
use URI;
use FCGI;
use FCGI::ProcManager;

#
# initialization
#
# configurable via environmet variables
#
my $maxrequests = $ENV{ "REQUESTS" } || 1000;
my $clients     = $ENV{ "CHILDREN" } || 10;
my $listen      = $ENV{ "SOCKET" }   || "127.0.0.1:39396";
my $debug       = $ENV{ "DEBUG" }    || 1;
my $test        = $ENV{ "TEST" }     || 0;

#
# fastcgi request
#
my %env;
my( $socket, $request, $manager, $request_uri, $referer, $test_uri );

unless( $test ) {
	$socket     = FCGI::OpenSocket( $listen, 100 ) or die "failed to open FastCGI socket; $!";
	$request    = FCGI::Request( \*STDIN, \*STDOUT, \*STDOUT, \%env, $socket, ( &FCGI::FAIL_ACCEPT_ON_INTR ) );
	$manager    = FCGI::ProcManager->new({ n_processes => $clients });
}
else {
	$request    = FCGI::Request();
}

$manager->pm_manage() unless $test;
while( $request->Accept() >= 0 || $test ) {
	$manager->pm_pre_dispatch() unless $test;

	$manager->pm_post_dispatch() unless $test;
}
