#!/usr/bin/perl -w

use strict;
use URI;
use URI::Escape;
use FCGI;
use Sys::Syslog qw(:standard :macros);
use Image::Magick;
use Image::LibRSVG;
use File::LibMagic;

#
# debug
#
use Data::Dumper;

my $request = FCGI::Request();
my $syslog = 1;
my $basepath = "/images";
my $flm = File::LibMagic->new();

openlog "404handler", "ndelay", LOG_LOCAL0 if $syslog;
while( $request->Accept() >= 0 ) {
    my $env = $request->GetEnvironment();
    my $redirect_to = "";
    # my $request_uri = "http://images.wikia.com/central/images/thumb/b/bf/Wiki_wide.png/50px-Wiki_wide.png"; # test url
	my $request_uri = "http://images.wikia.com/firefly/images/thumb/e/e0/Bsag-logo.svg/120px-Bsag-logo.svg.png"; # test url
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
	my $thumbnail = $basepath . '/' . substr( $path, 0, 1 ) . '/' . $path;

    my @parts = split( "/", $path );
    my $last = pop @parts;

    #
    # if last part of $request_uri is \d+px-\. we redirecting this to special
    # page. otherwise we sending 404 error
    #
    if( $last =~ /^\d+px\-/ ) {
        syslog( LOG_INFO, qq{302 $request_uri $referer} ) if $syslog;

		#
		# guess rest of image, last three parts would be image name and two
		# subdirectories
		#
		my $orig = join( "/", splice( @parts, -3, 3 ) );

		#
		# now, last part is thumbnails folder, we skip that too
		#
		pop @parts;

		my $original = $basepath . '/' . substr( join( "/", @parts ), 0, 1 )
			. '/' .  join( "/", @parts ) . '/' . $orig;

		#
		# then find proper thumbnailer for file, first check if this is svg
		# thumbnail request. mimetype will be used later in header
		#
		my $mimetype = $flm->checktype_filename( $original );
		if( $mimetype =~ /^image\/svg\+xml/ ) {
			#
			# RSVG thumbnailer
			#
		}
		else {
			#
			# for other else use Image::Magick
			#
		}

		#
		# read original file, thumbnail it, store on disc
		#
		print Dumper( $thumbnail );
		print Dumper( $original );


		#
		# serve file if is ready to serve
		#
        print "HTTP/1.1 302 Moved Temporarily\r\n";
        print "Location: $redirect_to\r\n";
        print "Content-type: $mimetype\r\n\r\n";
    }
    else {
        syslog( LOG_INFO, qq{404 $request_uri $referer} ) if $syslog;
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
}
closelog if $syslog;
