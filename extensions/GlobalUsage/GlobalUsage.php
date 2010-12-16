<?php
/*
 Copyright (c) 2008 - 2009 Bryan Tong Minh

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


$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Global Usage',
	'author' => 'Bryan Tong Minh',
	'description' => 'Special page to view global file usage',
	'descriptionmsg' => 'globalusage-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:GlobalUsage',
	'version' => '2.0',
);

$wgExtensionMessagesFiles['GlobalUsage'] = $dir . 'GlobalUsage.i18n.php';
$wgAutoloadClasses['GlobalUsage'] = $dir . 'GlobalUsage_body.php';
$wgAutoloadClasses['GlobalUsageHooks'] = $dir . 'GlobalUsageHooks.php';
$wgAutoloadClasses['SpecialGlobalUsage'] = $dir . 'SpecialGlobalUsage.php';
$wgAutoloadClasses['GlobalUsageQuery'] = $dir . 'GlobalUsageQuery.php';
$wgAutoloadClasses['ApiQueryGlobalUsage'] = $dir . 'ApiQueryGlobalUsage.php';
$wgExtensionMessageFiles['GlobalUsage'] = $dir . 'GlobalUsage.i18n.php';
$wgExtensionAliasesFiles['GlobalUsage'] = $dir . 'GlobalUsage.alias.php';
$wgSpecialPages['GlobalUsage'] = 'SpecialGlobalUsage';
$wgAPIPropModules['globalusage'] = 'ApiQueryGlobalUsage';

/* Things that can cause link updates:
 * - Local LinksUpdate
 * - Local article deletion (remove from table)
 * - Local article move (update page title)
 * - Local file upload/deletion/move (toggle is_local flag)
 */
$wgHooks['LinksUpdateComplete'][] = 'GlobalUsageHooks::onLinksUpdateComplete';
$wgHooks['ArticleDeleteComplete'][] = 'GlobalUsageHooks::onArticleDeleteComplete';
$wgHooks['FileDeleteComplete'][] = 'GlobalUsageHooks::onFileDeleteComplete';
$wgHooks['FileUndeleteComplete'][] = 'GlobalUsageHooks::onFileUndeleteComplete';
$wgHooks['UploadComplete'][] = 'GlobalUsageHooks::onUploadComplete';
$wgHooks['TitleMoveComplete'][] = 'GlobalUsageHooks::onTitleMoveComplete';
$wgHooks['ImagePageAfterImageLinks'][] = 'SpecialGlobalUsage::onImagePageAfterImageLinks';
$wgHooks['ImagePageShowTOC'][] = 'SpecialGlobalUsage::onImagePageShowTOC';
$wgHooks['ParserTestTables'][] = 'GlobalUsageHooks::onParserTestTables';

// If set to false, the local database contains the globalimagelinks table
// Else set to something understandable to LBFactory
$wgGlobalUsageDatabase = false;
