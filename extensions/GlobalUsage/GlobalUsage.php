<?php
/*
 Copyright (c) 2008 Bryan Tong Minh

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
if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/GlobalUsage/GlobalUsage.php" );
EOT;
	exit( 1 );
}

// Defines
define('GUIW_LOCAL', 0);
define('GUIW_SERVER', 1);

if (isset($_SERVER) && array_key_exists( 'REQUEST_METHOD', $_SERVER ) ) {
	$dir = dirname(__FILE__) . '/';

	$wgExtensionCredits['specialpage'][] = array(
		'name' => 'Global Usage',
		'author' => 'Bryan Tong Minh',
		'description' => 'Special page to view global file usage',
		'descriptionmsg' => 'globalusage-desc',
		'url' => 'http://www.mediawiki.org/wiki/Extension:GlobalUsage',
		'version' => '1.0',
	);

	$wgExtensionMessagesFiles['GlobalUsage'] = $dir . 'GlobalUsage.i18n.php';
	$wgAutoloadClasses['GlobalUsage'] = $dir . 'GlobalUsage_body.php';
	$wgExtensionMessageFiles['GlobalUsage'] = $dir . 'GlobalUsage.i18n.php';
	$wgSpecialPages['GlobalUsage'] = 'GlobalUsage';

	$wgHooks['LinksUpdate'][] = array( 'GlobalUsage', 'updateLinks' );
	$wgHooks['ArticleDeleteComplete'][] = array( 'GlobalUsage', 'articleDeleted' );
	$wgHooks['FileDeleteComplete'][] = array( 'GlobalUsage', 'fileDeleted' );
	$wgHooks['FileUndeleteComplete'][] = array( 'GlobalUsage', 'fileUndeleted' );
	$wgHooks['UploadComplete'][] = array( 'GlobalUsage', 'imageUploaded' );
	$wgHooks['SpecialMovepageAfterMove'][] = array( 'GlobalUsage', 'articleMoved' );
}

// If set to false, the local database contains the globalimagelinks table
// Else set to something understandable to LBFactory
$wgguMasterDatabase = false;
