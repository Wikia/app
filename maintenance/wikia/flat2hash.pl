#!/usr/bin/perl -w

use strict;
use Digest::MD5 qw(md5_hex);
use File::Path;
use File::Copy qw(cp);

die "missing argument\n$0 image\n" unless $ARGV[0];
my $file = $ARGV[0];
my $hash = md5_hex( $file );

my $dir = substr($hash, 0, 1) ."/".substr($hash, 0, 2);
unless( -d $dir ) {
    mkpath($dir, 1);
}
cp( $file, $dir );
