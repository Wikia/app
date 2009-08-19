#!/usr/bin/perl -w

#
# Imager version
#

use strict;
use URI;
use FCGI;
use Sys::Syslog qw(:standard :macros);
use Imager;
use Image::LibRSVG;
use File::LibMagic;
use IO::File;
use File::Basename;
use File::Path;
use XML::Simple;

#
# debug
#
use Data::Dumper;
my $syslog      = 2;

sub real404 {
	my $request_uri  = shift;
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

#
# initialization
#
my $request     = FCGI::Request();
my $basepath    = "/images";
my $flm         = new File::LibMagic;
my $maxwidth    = 3000;

#
# how many requests we should handle
#
my $maxrequests  = 1000;
my $cntrequest   = 0;


#
# if thumbnail was really generated
#
my $transformed = 0;
my $mimetype = "text/plain";
umask( 022 );

openlog "404handler", "ndelay", LOG_LOCAL0 if $syslog;
while( $request->Accept() >= 0 ) {
	my $env = $request->GetEnvironment();
	my $redirect_to = "";
	my $request_uri = "";
	my $referer = "";

=pod examples
	$request_uri = "/c/central/images/thumb/b/bf/Wiki_wide.png/155px-Wiki_wide.png";
	$request_uri = "/s/silenthill/de/images/thumb/8/85/Heather_%28Konzept4%29.jpg/420px-Heather_%28Konzept4%29.jpg";
	$request_uri = "/g/gw/images/thumb/archive/7/78/20090811221502!Nicholas_the_Traveler_location_20090810_2.PNG/120px-Nicholas_the_Traveler_location_20090810_2.PNG";
	$request_uri = "/m/meerundmehr/images/thumb/1/17/Mr._Icognito.svg/150px-Mr._Icognito.svg.png";
=cut

	$request_uri = "/c/central/images/thumb/8/8c/The_Smurfs_Animated_Gif.gif/200px-The_Smurfs_Animated_Gif.gif";

	#
	# get last part of uri, remove first slash if exists
	#
	$request_uri = $env->{"REQUEST_URI"} if $env->{"REQUEST_URI"};
	$referer = $env->{"HTTP_REFERER"} if $env->{"HTTP_REFERER"};
	my $uri = URI->new( $request_uri );
	my $path  = $uri->path;
	$path =~ s/^\///;
	$path =~ s/%([0-9A-Fa-f]{2})/chr(hex($1))/eg;

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
	# if last part of $request_uri is \d+px-\. it is probably thumbnail
	#
	my ( $width ) = $last =~ /^(\d+)px\-.+\w$/;
	if( $width ) {
		$width = $maxwidth if ( $width > $maxwidth );
		#
		# guess rest of image, last three parts would be image name and two
		# subdirectories
		#
		# there could be two kinds: current image and archive image,
		# archive image has '/archive/' part additionaly
		#
		my $original = join( "/", splice( @parts, -3, 3 ) );

		#
		# we match thumbnail path against this name because we don't want to
		# create false positives (it's not perfect though )
		#
		my $origname = pop @{ [ split( "/" , $original ) ] };
		if( index( $last, $original ) != -1 ) {
			syslog( LOG_INFO, "$origname not found in $last" ) if $syslog;
		}
		else {
			#
			# now, last part is thumbnails folder, we skip that too
			#
			pop @parts;

			#
			# if thumbnail is for archived image add /archive/ part
			#
			if( index( $thumbnail, "/archive/" ) != -1 ) {
				$parts[ -1 ] = "archive";
			}

			#
			# merge with rest of path
			#
			$original = $basepath . '/' . join( "/", @parts ) . '/' . $original;
			#
			# then find proper thumbnailer for file, first check if this is svg
			# thumbnail request. mimetype will be used later in header
			#
			if( -f $original ) {
				$mimetype = $flm->checktype_filename( $original );
				syslog( LOG_INFO, qq{$thumbnail $mimetype REQUEST_URI=$request_uri HTTP_REFERER=$referer} ) if $syslog;

				#
				# create folder for thumbnail if doesn't exists
				#
				my $thumbdir = dirname( $thumbnail );
				unless( -d $thumbdir ) {
					eval { mkpath( $thumbdir ) };
					if( $@ ) {
						syslog( LOG_INFO, "Creating of $thumbdir folder failed" ) if $syslog;
					}
					else {
						syslog( LOG_INFO, "Folder $thumbdir created" ) if $syslog;
					}
				}

				#
				# read original file, thumbnail it, store on disc
				# file2 has old mimetype database, it thinks that svg file is just
				# xml file
				#
				if( $mimetype =~ m!^image/svg\+xml! || $mimetype =~ m!text/xml! ) {
					#
					# read width & height of SVG file
					#
					my $xmlp = XMLin( $original );
					my $origw = $xmlp->{'width'};
					my $origh = $xmlp->{'height'};
					my $height = $width;
					if( $origw && $origh ) {
						$height = $width * $origh / $origw;
					}
					#
					# RSVG thumbnailer
					#
					my $rsvg = new Image::LibRSVG;
					$rsvg->convertAtMaxSize( $original, $thumbnail, $width, $height );

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
						syslog( LOG_INFO, "File $thumbnail created" ) if $syslog;
					}
					else {
						syslog( LOG_INFO, "SVG conversion from $original to $thumbnail failed" ) if $syslog;
					}
					undef $rsvg;
					undef $xmlp;
				}
				else {
					#
					# for other else use Image::Magick
					#
					my $image = new Imager;
					$image->read( file => $original );
					my $origw  = $image->getwidth;
					my $origh  = $image->getheight;
					print "Here! $origw $origh\n";
					if( $origw && $origh ) {
						print "Here!";
						my $height = $width * $origh / $origw;
						my $thumb = $image->scale( xpixels => $width, ypixels => $height );
						if( $mimetype =~ m!image/gif! ) {
#							$image->Coalesce();
						}
						$thumb->write( file => $thumbnail );

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
							syslog( LOG_INFO, "File $thumbnail created" ) if $syslog;
						}
						else {
							syslog( LOG_INFO, "ImageMagick thumbnailer from $original to $thumbnail failed" ) if $syslog;
						}
						undef $image;
					}
				}
			}
			else {
				syslog( LOG_INFO, "$thumbnail original file $original does not exists" ) if $syslog > 1;
			}
		}
	}
	if( ! $transformed ) {
		real404( $request_uri )
	}

	$request->Finish();
	$transformed = 0;
	$cntrequest++;

	syslog( LOG_INFO, "request no $cntrequest" ) if $syslog;

	#
	# prevent memory leaks
	#
	if( $cntrequest >= $maxrequests ) {
		$request->LastCall();
		last;
	}
}
closelog if $syslog;
