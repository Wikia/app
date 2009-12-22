#!/usr/bin/perl -w

package main;

use strict;
use warnings;

use CGI::Fast;
use Data::Dumper;

my $debug       = $ENV{ "DEBUG" }    || 1;
my $test        = $ENV{ "TEST" }     || 0;

# these params should be defined if form is posted:
#
#	"source"
#	"class"
#	"hash"
#	"suffix"
#	"directory"

while( my $req = new CGI::Fast ) {

	#
	# check if have all params
	#
	print $req->header( "text/plain" );
	my $params = $req->Vars;

	#
	# write defined variables
	#
	for my $key ( keys %$params ) {
		print $key, " = ", $params->{ $key };
	}
}
