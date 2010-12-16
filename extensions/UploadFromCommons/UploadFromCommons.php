<?php
/*
 Copyright (c) 2009 Bryan Tong Minh

 Permission is hereby granted, free of charge, to any person
 obtaining a copy of this software and associated documentation
 files (the "Software"), to deal in the Software without
 restriction, including without limitation the rights to use,
 copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the
 Software is furnished to do so, subject to the following
 conditions:

 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 OTHER DEALINGS IN THE SOFTWARE.
*/

// Alert the user that this is not a valid entry point to MediaWiki if they try to access the extension file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/UploadFromCommons/UploadFromCommons.php" );
EOT;
	exit( 1 );
}


$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'UploadFromCommons',
	'author' => 'Bryan Tong Minh',
	'description' => 'Quickly upload an image from Commons',
	'descriptionmsg' => 'uploadfromcommons',
	'url' => 'http://www.mediawiki.org/wiki/Extension:UploadFromCommons',
	'version' => '1.0',
);

$wgExtensionMessagesFiles['UploadFromCommons'] = $dir . 'UploadFromCommons.i18n.php';
$wgAutoloadClasses['UploadFromCommons'] = $dir . 'UploadFromCommons_body.php';

$wgAutoloadClasses['SpecialGlobalUsage'] = $dir . 'SpecialGlobalUsage.php';

$wgHooks['UploadCreateFromRequest'][] = 'UploadFromCommons::onCreateFromRequest';
$wgHooks['UploadFormSourceDescriptors'][] = 'UploadFromCommons::onUploadFormSourceDescriptors';
