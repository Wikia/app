#!/usr/bin/perl -w

use strict;
use URI;
use FCGI;
use Sys::Syslog qw(:standard :macros);
use Image::Magick;
use Image::LibRSVG;
use File::LibMagic;
use IO::File;

#
# debug
#
use Data::Dumper;
my $syslog = 1;

#
# initialization
#
my $request = FCGI::Request();
my $basepath = "/images";
my $flm = new File::LibMagic;

#
# if thumbnail was really generated
#
my $transformed = 0;
my $mimetype = "text/plain";

openlog "404handler", "ndelay", LOG_LOCAL0 if $syslog;
while( $request->Accept() >= 0 ) {
	my $env = $request->GetEnvironment();
	my $redirect_to = "";
	#my $request_uri = "http://images.wikia.com/central/images/thumb/b/bf/Wiki_wide.png/50px-Wiki_wide.png"; # test url
	my $request_uri = "";
	my $referer = "";

	#
	# we basicly redirecting REQUEST_URI to another url
	#
	$request_uri = $env->{"REQUEST_URI"} if $env->{"REQUEST_URI"};
	$referer = $env->{"HTTP_REFERER"} if $env->{"HTTP_REFERER"};

	#
	# get last part of uri, remove first slash if exists
	#
	my $uri = URI->new( $request_uri );
	my $path  = $uri->path;
	$path =~ s/^\///;

	#
	# if path has single letter on beginning it's already new directory layout
	#
	if( $path !~ m!^\w/! ) {
		$path = substr( $path, 0, 1 ) . '/' . $path;
	}
	my $thumbnail = $basepath . '/' . $path;

	my @parts = split( "/", $path );
	my $last = pop @parts;


	#
	# if last part of $request_uri is \d+px-\. we redirecting this to special
	# page. otherwise we sending 404 error
	#
	syslog( LOG_INFO, qq{$thumbnail REQUEST_URI=$request_uri HTTP_REFERER=$referer} ) if $syslog;
	my ( $width ) = $last =~ /^(\d+)px\-/;
	if( $width ) {
		#
		# guess rest of image, last three parts would be image name and two
		# subdirectories
		#
		my $orig = join( "/", splice( @parts, -3, 3 ) );

		#
		# now, last part is thumbnails folder, we skip that too
		#
		pop @parts;

		my $original = $basepath . '/' . join( "/", @parts ) . '/' . $orig;

		#
		# then find proper thumbnailer for file, first check if this is svg
		# thumbnail request. mimetype will be used later in header
		#
		if( -f $original ) {
			$mimetype = $flm->checktype_filename( $original );
			syslog( LOG_INFO, qq{$thumbnail $mimetype} ) if $syslog;
			#
			# read original file, thumbnail it, store on disc
			#

			if( $mimetype =~ /^image\/svg\+xml/ ) {
				#
				# RSVG thumbnailer
				#
				my $rsvg = new Image::LibRSVG;
				$rsvg->convertAtMaxSize( $original, $thumbnail, $width, $width );

				if( -f $thumbnail ) {
					$mimetype = $flm->checktype_filename( $thumbnail );
					$transformed = 1;
					print "HTTP/1.1 200 OK\r\n";
					print "X-Thumb-Path: $thumbnail\r\n";
					print "Content-type: $mimetype\r\n\r\n";
					my $fh = new IO::File $thumbnail, O_RDONLY;
					if( defined $fh ) {
						binmode $fh;
						print <$fh>;
						undef $fh;
					}
					syslog( LOG_INFO, "$thumbnail created" ) if $syslog;
				}
				undef $rsvg;
			}
			else {
				#
				# for other else use Image::Magick
				#
				my $image = new Image::Magick;
				$image->Read( $original );
				my $origw  = $image->Get( 'width' );
				my $origh  = $image->Get( 'height' );
				if( $origw && $origh ) {
					my $height = $width * $origh / $origw;
					$image->Resize( "geometry" => "${width}x${height}>", "blur" => 0.9 );
					$image->Write( "filename" => $thumbnail );

					if( -f $thumbnail ) {
						#
						# serve file if is ready to serve
						#
						$transformed = 1;
						print "HTTP/1.1 200 OK\r\n";
						print "X-Thumb-Path: $thumbnail\r\n";
						print "Content-type: $mimetype\r\n\r\n";
						my $fh = new IO::File $thumbnail, O_RDONLY;
						if( defined $fh ) {
							binmode $fh;
							print <$fh>;
							undef $fh;
						}
						syslog( LOG_INFO, "$thumbnail created" ) if $syslog;
					}
					undef $image;
				}
			}
		}
		else {
			syslog( LOG_INFO, "Cannot read original file $original" ) if $syslog;
		}
	}
	if( ! $transformed ) {
		print "Status: 404\r\n";
		print "Connection: close\r\n";
		print "Content-Type: text/html; charset=utf-8\r\n\r\n";
		print qq{
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title>Error 404: Page not found</title></head>
<body style="font-family: sans-serif; font-size: 10pt;">
<h1 style="font-size: large;">Error 404: Page not found</h1>
<hr style="border-top: 1px solid black;" />
	Please move along people, nothing to see here. Especially, there is no <strong>$request_uri</strong> file. But still, you can
	go for example to our <a href="http://www.wikia.com/">Main Page</a>.
</body>
</html>
		};
	}

	$request->Finish();
	$transformed = 0;
}
closelog if $syslog;
