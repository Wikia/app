<?php
/**
 * Internationalisation file for img_auth script
 * This information is only needed if running in version prior to 1.16, otherwise messages are already included in core messages
 *
 * @file
 * @ingroup Extensions
*/

$messages = array();

/** English
 * @author Jack D. Pond
 */
$messages['en'] = array(
#img_auth script messages
'img-auth-desc' 		  => 'Image authorisation script',
'img-auth-accessdenied'   => "Access Denied",
'img-auth-nopathinfo'     => "Missing PATH_INFO.  Your server is not set up to pass this information - may be CGI-based and can't support img_auth. See `Image Authorization` on MediaWiki.",
'img-auth-notindir' 	  => "Requested path not in upload directory.",
'img-auth-badtitle' 	  => "Unable to construct a valid Title from `$1`.",
'img-auth-nologinnWL'     => "Not logged in and `$1` not in whitelist.",
'img-auth-nofile' 	      => "`$1` does not exist.",
'img-auth-isdir' 		  => "`$1` is a directory.",
'img-auth-streaming' 	  => "Streaming `$1`.",
'img-auth-public'		  => "The function of img_auth.php is to output files from a private wiki. This wiki is configured as a public wiki. For optimal security, img_auth.php is disabled for this case.",
'img-auth-noread'		  => "User does not have access to read `$1`.",
);

/** Message documentation (Message documentation)
 * @author Jack D. Pond
 */
$messages['qqq'] = array(
'img-auth-desc' 		  => '[[Image Authorization]] script, see http://www.mediawiki.org/wiki/Manual:Image_Authorization',
'img-auth-accessdenied'   => "[[Image Authorization]] Access Denied",
'img-auth-nopathinfo'     => "[[Image Authorization]] Missing PATH_INFO - see english description",
'img-auth-notindir' 	  => "[[Image Authorization]] when the specified path is not in upload directory.",
'img-auth-badtitle' 	  => "[[Image Authorization]] bad title, parameter `$1` is the invalid title",
'img-auth-nologinnWL'     => "[[Image Authorization]] logged in and file not whitelisted. Parameter `$1` is the file not in whitelist.",
'img-auth-nofile' 	      => "[[Image Authorization]] non existent file, parameter `$1` is the file that does not exist.",
'img-auth-isdir' 		  => "[[Image Authorization]] trying to access a directory instead of a file, parameter`$1` is the directory.",
'img-auth-streaming' 	  => "[[Image Authorization]] is now streaming file specified by parameter `$1`.",
'img-auth-public'		  => "[[Image Authorization]] an error message when the admin has configured the wiki to be a public wiki, but is using img_auth script - normally this is a configuration error, except when special restriction extensions are used",
'img-auth-noread'		  => "[[Image Authorization]] User does not have access to read file, parameter `$1` is the file",
);