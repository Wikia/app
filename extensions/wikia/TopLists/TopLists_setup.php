<?php
/**
 * Setup file for TopLists extension
 * @package MediaWiki
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is part of MediaWiki, it is not a valid entry point.\n";
	exit( 1 );
}

//info
global $wgExtensionCredits;

$wgExtensionCredits['other'][] = array(
	"name" => "TopLists",
	"description" => "Top Lists",
	"descriptionmsg" => "toplists-desc",
	"url" => "http://help.wikia.com/wiki/Help:Top_lists",
	"author" => array(
		'Federico "Lox" Lucignano <federico@wikia-inc.com>'
	)
);

//constants/variables
define('TOPLISTS_SAVE_AUTODETECT', 0);
define('TOPLISTS_SAVE_CREATE', 1);
define('TOPLISTS_SAVE_UPDATE', 2);

$dir = dirname(__FILE__);

//namespaces
global $wgNamespacesWithSubpages, $wgExtensionNamespacesFiles;

define( 'NS_TOPLIST', 700 );

$wgNamespacesWithSubpages[ NS_TOPLIST ] = true;

$wgExtensionNamespacesFiles[ 'TopLists' ] = "{$dir}/TopLists.namespaces.php";

wfLoadExtensionNamespaces( 'TopLists', array( NS_TOPLIST ) );

//messages
global $wgExtensionMessagesFiles;

$wgExtensionMessagesFiles[ 'TopLists' ] = "{$dir}/TopLists.i18n.php";

//rights
global $wgAvailableRights, $wgGroupPermissions;

$wgAvailableRights[] = 'toplists-create-edit-list';

$wgGroupPermissions[ '*' ][ 'toplists-create-edit-list' ] = false;
$wgGroupPermissions[ 'user' ][ 'toplists-create-edit-list' ] = true;
$wgGroupPermissions[ 'bot' ][ 'toplists-create-edit-list' ] = true;

//special pages
global $wgSpecialPages;

$wgSpecialPages['CreateTopList'] = 'SpecialCreateTopList';
$wgSpecialPages['EditTopList'] = 'SpecialEditTopList';
//$wgSpecialPages['TopLists'] = 'SpecialTopLists';

$wgSpecialPageGroups['CreateTopList'] = 'wikia';
$wgSpecialPageGroups['EditTopList'] = 'wikia';
//$wgSpecialPageGroups['TopLists'] = 'wikia';

//aliases
/*global $wgExtensionAliasesFiles;

$wgExtensionAliasesFiles[ 'TopLists' ] = "{$dir}/TopLists.alias.php";*/

//classes
global $wgAutoloadClasses;

$wgAutoloadClasses[ 'TopListHelper' ] = "{$dir}/TopListHelper.class.php";
$wgAutoloadClasses[ 'TopListParser' ] = "{$dir}/TopListParser.class.php";
$wgAutoloadClasses[ 'TopListBase' ] = "{$dir}/TopListBase.class.php";
$wgAutoloadClasses[ 'TopList' ] = "{$dir}/TopList.class.php";
$wgAutoloadClasses[ 'TopListItem' ] = "{$dir}/TopListItem.class.php";
$wgAutoloadClasses[ 'WikiaPhotoGalleryUpload' ] = "{$dir}/../WikiaPhotoGallery/WikiaPhotoGalleryUpload.class.php";

$wgAutoloadClasses[ 'SpecialCreateTopList' ] = "{$dir}/specials/SpecialCreateTopList.class.php";
$wgAutoloadClasses[ 'SpecialEditTopList' ] = "{$dir}/specials/SpecialEditTopList.class.php";
//$wgAutoloadClasses[ 'SpecialTopList' ] = "{$dir}/specials/SpecialTopLists.class.php";

//ajax exports
global $wgAjaxExportList;

$wgAjaxExportList[] = 'TopListHelper::renderImageBrowser';
$wgAjaxExportList[] = 'TopListHelper::uploadImage';
$wgAjaxExportList[] = 'TopListHelper::voteItem';

//hooks
global $wgHooks;

$wgHooks['ArticleFromTitle'][] = 'TopListHelper::onArticleFromTitle';
$wgHooks['AlternateEdit'][] = 'TopListHelper::onAlternateEdit';
//$wgHooks['UnwatchArticleComplete'][] = 'TopListHelper::onUnwatchArticleComplete';

//parser functions, tags and attributes
define( 'TOPLIST_TAG', 'toplist' );
define( 'TOPLIST_ATTRIBUTE_RELATED', 'related');
define( 'TOPLIST_ATTRIBUTE_PICTURE', 'picture');

$wgHooks['ParserFirstCallInit'][] = "TopListParser::onParserFirstCallInit";

//init extension
/*global $wgExtensionFunctions;

$wgExtensionFunctions[] = 'TopListHelper::setup';*/
