#!/usr/bin/perl -w

use strict;
use URI;
use FCGI;
use Sys::Syslog qw(:standard :macros);
use Image::Magick;
use Image::LibRSVG;
use File::LibMagic;
use IO::File;
use File::Basename;
use File::Path;

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
my $maxwidth = 3000;

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
	#my $request_uri = "/s/silenthill/de/images/thumb/8/85/Heather_%28Konzept4%29.jpg/420px-Heather_%28Konzept4%29.jpg"; # test url
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
					eval { mkpath( $thumbdir, 1 ) };
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
					else {
						syslog( LOG_INFO, "SVG conversion from $original to $thumbnail failed" ) if $syslog;
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
						if( $mimetype =~ m!image/gif! ) {
							$image->Coalesce();
						}
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
						else {
							syslog( LOG_INFO, "ImageMagick thumbnailer from $original to $thumbnail failed" ) if $syslog;
						}
						undef $image;
					}
				}
			}
			else {
				syslog( LOG_INFO, "$thumbnail original file $original does not exists" ) if $syslog;
			}
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
