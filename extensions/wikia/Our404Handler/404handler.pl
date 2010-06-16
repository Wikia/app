#!/usr/bin/perl -w

package main;

#
# Image::Magick version
#

use strict;
use URI;
use FCGI;
use FCGI::ProcManager;
use Image::Magick;
use Image::LibRSVG;
use File::LibMagic;
use IO::File;
use File::Basename;
use File::Path;
use File::Copy;
use XML::Simple;
use Data::Types qw(:all);
use Math::Round qw(round);
use Getopt::Long;
use Cwd;

#
# constant
#
use constant FFMPEG   => "/usr/bin/ffmpeg";
use constant OGGTHUMB => "/usr/bin/oggThumb";


sub real404 {
	my $request_uri  = shift;
	print "Status: 404\r\n";
	print "Cache-control: max-age=30\r\n";
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
# go trough tests and show results
#
sub testResults {
	my( $basepath, $tests ) = @_;
	for my $test ( @$tests ) {
		print $basepath.$test."\n";
	}
}

#
# scaleHeight function compatible with MediaWiki
#
sub scaleHeight {
	my( $srcWidth, $srcHeight, $dstWidth, $test ) = @_;
	my $dstHeight;
	if( $srcWidth == 0  )  {
		$dstHeight = 0;
	}
	else {
		$dstHeight = round( $srcHeight * $dstWidth /  $srcWidth );
	}
	print qq/$srcWidth x $srcHeight -> $dstWidth x $dstHeight\n/ if( $test );
	return $dstHeight;
}


#
# video thumbnail, by default oggThumb will be used.
# as for now $seek is ignored
#
sub videoThumbnail {
	my ( $original, $thumbnail, $seek ) = @_;

	my $useFfmpeg = 0;

	if( $useFfmpeg ) {
		#
		# use ffmpeg
		#
		my @cmd = ();
		push @cmd, qw(-ss 1);
		push @cmd, "-an";
		push @cmd, qw(-vframes 1);
		push @cmd, "-y";
		push @cmd, "-i", $original;
		push @cmd, qw(-f mjpeg);
		push @cmd, $thumbnail;

		open( CMD, "-|", FFMPEG, @cmd );
		close( CMD );

		unless( -f $thumbnail ) {
			#
			# get first stream
			#
			unshift @cmd, qw(-map 0:1);
			open( CMD, "-|", FFMPEG, @cmd );
			close( CMD );
		}
	}
	else {
		#
		# use oggThumb, but first change current working directory to /tmp
		#
		my $pwd = getcwd();
		chdir( "/tmp" );

		my @cmd = ();
		push @cmd, qw(-o jpg);
		push @cmd, qw(-t 0);
		push @cmd, $original;
		open( CMD, "-|", OGGTHUMB, @cmd );
		my @result = <CMD>;
		close( CMD );

		#
		# check result for thumbnail name, in future version it will
		# be parametrized
		#
		my $out = join "", @result;
		my ( $file ) = $out =~ m/writing (.+)/;
		move( $file, $thumbnail );
		chdir( $pwd );
	}
}

#
# do not make zombies
#

my @tests = qw(
	/c/carnivores/images/thumb/5/59/Padlock.svg/120px-Padlock.svg.png
	/y/yugioh/images/thumb/a/ae/Flag_of_the_United_Kingdom.svg/700px-Flag_of_the_United_Kingdom.svg.png
	/a/answers/images/thumb/8/84/Play_fight_of_polar_bears_edit_1.avi.OGG/mid-Play_fight_of_polar_bears_edit_1.avi.OGG.jpg
	/g/gw/images/thumb/archive/7/78/20090811221502!Nicholas_the_Traveler_location_20090810_2.PNG/120px-Nicholas_the_Traveler_location_20090810_2.PNG
	/m/meerundmehr/images/thumb/1/17/Mr._Icognito.svg/150px-Mr._Icognito.svg.png
	/c/central/images/thumb/e/e9/CP_c17i4°.svg/250px-CP_c17i4°.svg.png
	/c/central/images/thumb/b/bf/Wiki_wide.png/155px-Wiki_wide.png
	/c/central/images/thumb/8/8c/The_Smurfs_Animated_Gif.gif/200px-The_Smurfs_Animated_Gif.gif
	/h/half-life/en/images/thumb/1/1d/Zombie_Assassin.jpg/100px-Zombie_Assassin.jpg
	/h/half-life/en/images/thumb/a/a5/Gene_worm_model.jpg/260px-Gene_worm_model.jpg
	/h/half-life/en/images/thumb/a/a5/Gene_worm_model.jpg/250px-Gene_worm_model.jpg
	/h/half-life/en/images/thumb/b/b1/Alyx_hanging_trailer.jpg/250px-Alyx_hanging_trailer.jpg
	/h/half-life/en/images/thumb/d/d6/Black_Mesa_logo.svg/240px-Black_Mesa_logo.svg.png
	/h/half-life/en/images/thumb/d/d6/Black_Mesa_logo.svg/250px-Black_Mesa_logo.svg.png
	/m/memoryalpha/en/images/thumb/8/88/2390s_Starfleet.svg/300px-2390s_Starfleet.svg.png
	/h/half-life/en/images/thumb/d/d6/Black_Mesa_logo.svg/250px-Black_Mesa_logo.svg.png
	/de/images/thumb/3/35/Information_icon.svg/120px-Information_icon.svg.png
);
my @done = ();

#
# initialization
#
# configurable via environmet variables
#
my $maxrequests = $ENV{ "REQUESTS" } || 1000;
my $basepath    = $ENV{ "IMGPATH"  } || "/images";
my $clients     = $ENV{ "CHILDREN" } || 4;
my $listen      = $ENV{ "SOCKET"   } || "0.0.0.0:39393";
my $debug       = $ENV{ "DEBUG"    } || 1;
my $test        = $ENV{ "TEST"     } || 0;
my $pidfile     = $ENV{ "PIDFILE"  } || "/var/run/404handler.pid";

#
# fastcgi request
#
my %env;
my( $socket, $request, $manager, $request_uri, $referer, $test_uri );

unless( $test ) {
	$socket     = FCGI::OpenSocket( $listen, 100 ) or die "failed to open FastCGI socket; $!";
	$request    = FCGI::Request( \*STDIN, \*STDOUT, \*STDERR, \%env, $socket, ( &FCGI::FAIL_ACCEPT_ON_INTR ) );
	$manager    = FCGI::ProcManager->new({ n_processes => $clients });

	$manager->pm_write_pid_file( $pidfile );
	$manager->pm_manage();

}
else {
	$request    = FCGI::Request();
}

my $flm         = new File::LibMagic;
my $maxwidth    = 3000;

#
# if thumbnail was really generated
#
my $transformed = 0;
my $mimetype    = "text/plain";
my $imgtype     = undef;

while( $request->Accept() >= 0 || $test ) {
	$manager->pm_pre_dispatch() unless $test;

	$request_uri = "";
	$referer     = "";

	if( $test ) {
		$request_uri = pop @tests || last;
		push @done, $request_uri;
	}

	#
	# get last part of uri, remove first slash if exists
	#
	$request_uri = $env{"REQUEST_URI"} if $env{"REQUEST_URI"};
	$referer     = $env{"HTTP_REFERER"} if $env{"HTTP_REFERER"};

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

	#
	# remove varnish/apache marker
	#
	$thumbnail =~ s/__thumbnail_gen//;

	my @parts = split( "/", $path );
	my $last = pop @parts;


	#
	# if last part of $request_uri is \d+px-\. it is probably thumbnail
	#
	my( $width ) = $last =~ /^(\d+)px\-.+\w$/;

	#
	# but ogghandler thumbnails can have seek=\d+ or mid
	#
	( $width ) = $last =~ /^seek=(\d+)\-.+\w$/ unless $width;
	( $width ) = $last =~ /^(mid)\-.+\w$/ unless $width;

	if( $width ) {
		$width = $maxwidth if $width =~ /^\d+$/ && $width > $maxwidth;
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
			print STDERR "$origname not found in $last\n" if $debug;
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
				( $imgtype ) = $mimetype =~ m![^/+]/(\w+)!;
				print STDERR "$original $thumbnail $mimetype $imgtype $request_uri $referer\n" if $debug;

				#
				# create folder for thumbnail if doesn't exists
				#
				my $thumbdir = dirname( $thumbnail );
				unless( -d $thumbdir ) {
					eval { mkpath( $thumbdir, { mode => 0775 } ) };
					if( $@ ) {
						print STDERR "Creating of $thumbdir folder failed\n" if $debug;
					}
					else {
						print STDERR "Folder $thumbdir created\n" if $debug;
					}
				}

				#
				# read original file, thumbnail it, store on disc
				# file2 has old mimetype database, it thinks that svg file is just
				# xml file
				#
				# some svg are completely broken so we check extension file as well
				#
				my ( $filext ) = $original =~ /\.(\w+)$/;
				$filext = lc( $filext );
				if( $mimetype =~ m!^image/svg\+xml! || $mimetype =~ m!text/xml! || $filext eq "svg" ) {
					#
					# read width & height of SVG file
					#
					my $xmlp = XMLin( $original );
					my $origw = $xmlp->{ 'width' };
					my $origh = $xmlp->{ 'height' };
					$origw = to_float( $origw ) unless is_float( $origw );
					$origh = to_float( $origh ) unless is_float( $origh );
					my $height = scaleHeight( $origw, $origh, $width, $test );

					#
					# RSVG thumbnailer
					#
					my $rsvg = new Image::LibRSVG;

					#
					# there is stupid bug (typo) in Image::LibRSVG so we have to
					# define hash with dimension and dimesion
					#

					my $args = { "dimension" => [$width, $height], "dimesion" => [$width, $height] };
					$rsvg->loadImage( $original, 0, $args );
					$transformed = 1;

					if( $transformed ) {
						print "HTTP/1.1 200 OK\r\n";
						print "Cache-control: max-age=30\r\n";
						print "Content-type: $mimetype\r\n\r\n";
						print $rsvg->getImageBitmap() unless $test;
						print STDERR "File $thumbnail created\n" if $debug;
					}
					else {
						print STDERR "SVG conversion from $original to $thumbnail failed\n";
					}
					undef $rsvg;
					undef $xmlp;
				}
				elsif( $mimetype =~ m!application/ogg! ) {
					#
					# check what frame we should get...
					#
					my $seek = ( $width eq "mid" ) ? 1 : $width;

					videoThumbnail( $original, $thumbnail, $seek );

					$transformed = 1;
					if( -f $thumbnail ) {
						chmod 0664, $thumbnail;
						$mimetype = $flm->checktype_filename( $thumbnail );
						print "HTTP/1.1 200 OK\r\n";
						print "X-LIGHTTPD-send-file: $thumbnail\r\n";
						print "Cache-control: max-age=30\r\n";
						print "Content-type: $mimetype\r\n\r\n";
						print STDERR "File $thumbnail created\n" if $debug;
					}
					else {
						print STDERR "Thumbnailer from $original to $thumbnail failed\n" if $debug;
						#
						# serve original file
						#
						print "HTTP/1.1 200 OK\r\n";
						print "X-LIGHTTPD-send-file: $original\r\n";
						print "Cache-control: max-age=30\r\n";
						print "Content-type: $mimetype\r\n\r\n";
					}
				}
				else {
					#
					# for other else use Image::Magick
					#
					my $image = new Image::Magick;
					$image->Read( $original );

					#
					# use only first frame in animated gifs
					#
					$image = $image->[ 0 ] if $image->[ 0 ]->Get('magick') eq 'GIF';
					my $origw  = $image->Get( 'width' );
					my $origh  = $image->Get( 'height' );
					if( $origw && $origh ) {
						my $height = scaleHeight( $origw, $origh, $width, $test );
						$image->Resize( "geometry" => "${width}x${height}!", "blur" => 0.9 );
						$transformed = 1;
						if( $transformed ) { #-f $thumbnail
							#
							# serve file if is ready to serve
							#
							print "HTTP/1.1 200 OK\r\n";
							print "Cache-control: max-age=30\r\n";
							print "Content-type: $mimetype\r\n\r\n";
							print $image->ImageToBlob() unless $test;
							print STDERR "File $thumbnail served\n" if $debug;
						}
						else {
							print STDERR "Thumbnailer from $original to $thumbnail failed\n" if $debug;
							#
							# serve original file
							#
							print "HTTP/1.1 200 OK\r\n";
							print "X-LIGHTTPD-send-file: $original\r\n";
							print "Cache-control: max-age=30\r\n";
							print "Content-type: $mimetype\r\n\r\n";
						}
						undef $image;
					}
				}
			}
			else {
				print STDERR "$thumbnail original file $original does not exists\n" if $debug > 1;
			}
		}
	}

	if( ! $transformed ) {
		real404( $request_uri )
	}

	$transformed = 0;
	$manager->pm_post_dispatch() unless $test;
}

$manager->pm_remove_pid_file() unless $test;

#
# if test display results
#
testResults( $basepath, \@done ) if $test;
