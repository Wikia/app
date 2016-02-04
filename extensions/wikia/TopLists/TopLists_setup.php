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
	"name" => "Top 10 lists",
	"description" => "Top 10 lists",
	"descriptionmsg" => "toplists-desc",
	"url" => "http://community.wikia.com/wiki/Help:Top_lists",
	"author" => array(
		'Federico "Lox" Lucignano <federico@wikia-inc.com>',
		'Adrian Wieczorek <adi@wikia-inc.com>'
	)
);

//constants/variables
define( 'TOPLISTS_SAVE_AUTODETECT', 0 );
define( 'TOPLISTS_SAVE_CREATE', 1 );
define( 'TOPLISTS_SAVE_UPDATE', 2 );
define( 'TOPLISTS_HOT_MIN_COUNT', 10 );
define( 'TOPLISTS_HOT_MIN_TIMESPAN', 60 * 60 * 24);
define( 'TOPLISTS_ITEM_REMOVED', 'removed');
define( 'TOPLISTS_ITEM_CREATED', 'created');
define( 'TOPLISTS_ITEM_UPDATED', 'updated');
define( 'TOPLISTS_STATUS_SEPARATOR', ', ' );

$dir = dirname( __FILE__ );

//namespaces
global $wgNamespacesWithSubpages, $wgExtensionNamespacesFiles, $wgSuppressNamespacePrefix, $wgArticleCommentsNamespaces;

define( 'NS_TOPLIST', 700 );
define( 'NS_TOPLIST_TALK', 701 );

$wgNamespacesWithSubpages[ NS_TOPLIST ] = true;
$wgNamespacesWithSubpages[ NS_TOPLIST_TALK ] = true;

$wgExtensionNamespacesFiles[ 'TopLists' ] = "{$dir}/TopLists.namespaces.php";

wfLoadExtensionNamespaces( 'TopLists', array( NS_TOPLIST, NS_TOPLIST_TALK ) );

$wgSuppressNamespacePrefix[] = NS_TOPLIST;
$wgArticleCommentsNamespaces[] = NS_TOPLIST;

//messages
global $wgExtensionMessagesFiles;

$wgExtensionMessagesFiles[ 'TopLists' ] = "{$dir}/TopLists.i18n.php";
$wgExtensionMessagesFiles[ 'TopListsAliases' ] = "{$dir}/TopLists.alias.php";

//special pages
global $wgSpecialPages;

$wgSpecialPages['CreateTopList'] = 'SpecialCreateTopList';
$wgSpecialPages['EditTopList'] = 'SpecialEditTopList';

$wgSpecialPageGroups['CreateTopList'] = 'wikia';
$wgSpecialPageGroups['EditTopList'] = 'wikia';

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

//ajax exports
global $wgAjaxExportList;

$wgAjaxExportList[] = 'TopListHelper::renderImageBrowser';
$wgAjaxExportList[] = 'TopListHelper::uploadImage';
$wgAjaxExportList[] = 'TopListHelper::voteItem';
$wgAjaxExportList[] = 'TopListHelper::checkListStatus';
$wgAjaxExportList[] = 'TopListHelper::addItem';
$wgAjaxExportList[] = 'TopListHelper::getImageData';

//hooks
global $wgHooks;

$wgHooks[ 'ArticleFromTitle' ][] = 'TopListHelper::onArticleFromTitle';
$wgHooks[ 'AlternateEdit' ][] = 'TopListHelper::onAlternateEdit';
$wgHooks[ 'CreatePage::FetchOptions' ][] = 'TopListHelper::onCreatePageFetchOptions';
$wgHooks[ 'ComposeCommonSubjectMail' ][] = 'TopListHelper::onComposeCommonSubjectMail';
$wgHooks[ 'ComposeCommonBodyMail' ][] = 'TopListHelper::onComposeCommonBodyMail';
$wgHooks[ 'BeforePageDisplay' ][] = 'TopListHelper::onBeforePageDisplay';
$wgHooks[ 'ArticleSaveComplete' ][] = 'TopListHelper::onArticleSaveComplete';
$wgHooks[ 'ArticleDeleteComplete' ][] = 'TopListHelper::onArticleDeleteComplete';
$wgHooks[ 'ArticleRevisionUndeleted' ][] = 'TopListHelper::onArticleRevisionUndeleted';
$wgHooks[ 'TitleMoveComplete' ][] = 'TopListHelper::onTitleMoveComplete';
$wgHooks[ 'UserGetRights' ][] = 'TopListHelper::onUserGetRights';
$wgHooks[ 'getUserPermissionsErrors' ][] = 'TopListHelper::onGetUserPermissionsErrors';
$wgHooks[ 'ArticleService::getTextSnippet::beforeStripping' ][] = 'TopListHelper::onArticleServiceBeforeStripping';

//parser functions, tags and attributes
define( 'TOPLIST_TAG', 'toplist' );
define( 'TOPLIST_ATTRIBUTE_RELATED', 'related');
define( 'TOPLIST_ATTRIBUTE_PICTURE', 'picture');
define( 'TOPLIST_ATTRIBUTE_LASTUPDATE', 'lastupdate');
define( 'TOPLIST_ATTRIBUTE_DESCRIPTION', 'description');

$wgHooks['ParserFirstCallInit'][] = "TopListParser::onParserFirstCallInit";
