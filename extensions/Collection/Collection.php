<?php

/*
 * Collection Extension for MediaWiki
 *
 * Copyright (C) PediaPress GmbH
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

# Not a valid entry point, skip unless MEDIAWIKI is defined
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install the Collection extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/Collection/Collection.php" );
EOT;
	exit( 1 );
}

$dir = dirname(__FILE__) . '/';

# Extension version
$wgCollectionVersion = "1.4";

# ==============================================================================

# Configuration:

/** Bump the version number every time you change any of the JavaScript files */
$wgCollectionStyleVersion = 6;

/** URL of mw-serve render server */
$wgCollectionMWServeURL = 'http://87.118.99.164:8899/';

/** Login credentials to this MediaWiki as 'USERNAME:PASSWORD' string */
$wgCollectionMWServeCredentials = null;

/** PEM-encoded SSL certificate for the mw-serve render server to pass to CURL */
$wgCollectionMWServeCert = null;

/** Array of namespaces that can be added to a collection */
$wgCollectionArticleNamespaces = array(
	NS_MAIN,
	NS_TALK,
	NS_USER,
	NS_USER_TALK,
	NS_PROJECT,
	NS_PROJECT_TALK,
	NS_MEDIAWIKI,
	NS_MEDIAWIKI_TALK,
	100,
	101,
	102,
	103,
	104,
	105,
	106,
	107,
	108,
	109,
	110,
	111,
);

/** Namespace for "community books" */
$wgCommunityCollectionNamespace = NS_PROJECT;

/** Maximum no. of articles in a book */
$wgCollectionMaxArticles = 500;

/** Name of license */
$wgCollectionLicenseName = null;

/** HTTP(s) URL pointing to license in wikitext format: */
$wgCollectionLicenseURL = null;

/** List of available download formats,
		as mapping of mwlib writer to format name */
$wgCollectionFormats = array(
	'rl' => 'PDF',
);


$wgCollectionContentTypeToFilename = array(
	'application/pdf' => 'collection.pdf',
	'application/vnd.oasis.opendocument.text' => 'collection.odt',
);

$wgCollectionPortletFormats = array( 'rl' );

$wgCollectionPortletForLoggedInUsersOnly = false;

$wgCollectionMaxSuggestions = 10;

$wgCollectionSuggestCheapWeightThreshhold = 50;

$wgCollectionSuggestThreshhold = 100;

# ==============================================================================

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Collection',
	'version' => $wgCollectionVersion,
	'author' => array( 'PediaPress GmbH', 'Siebrand Mazeland' ),
	'url' => 'http://www.mediawiki.org/wiki/Extension:Collection',
	'descriptionmsg' => 'coll-desc',
);

# register Special:Book:
$wgAutoloadClasses['SpecialCollection'] = $dir . 'Collection.body.php';
$wgAutoloadClasses['CollectionSession'] = $dir . 'Collection.session.php';
$wgAutoloadClasses['CollectionHooks'] = $dir . 'Collection.hooks.php';
$wgAutoloadClasses['CollectionSuggest'] = $dir . 'Collection.suggest.php';
$wgAutoloadClasses['CollectionPageTemplate'] = $dir . 'Collection.templates.php';
$wgAutoloadClasses['CollectionListTemplate'] = $dir . 'Collection.templates.php';
$wgAutoloadClasses['CollectionLoadOverwriteTemplate'] = $dir . 'Collection.templates.php';
$wgAutoloadClasses['CollectionSaveOverwriteTemplate'] = $dir . 'Collection.templates.php';
$wgAutoloadClasses['CollectionRenderingTemplate'] = $dir . 'Collection.templates.php';
$wgAutoloadClasses['CollectionFinishedTemplate'] = $dir . 'Collection.templates.php';
$wgAutoloadClasses['CollectionSuggestTemplate'] = $dir . 'Collection.templates.php';
$wgExtensionMessagesFiles['CollectionCore'] = $dir . 'CollectionCore.i18n.php'; // Only contains essential messages outside the special page
$wgExtensionMessagesFiles['Collection'] = $dir . 'Collection.i18n.php'; // Contains all messages used on special page
$wgExtensionAliasesFiles['Collection'] = $dir . 'Collection.alias.php';
$wgSpecialPages['Book'] = 'SpecialCollection';
$wgSpecialPageGroups['Book'] = 'pagetools';

$wgHooks['SkinTemplateBuildNavUrlsNav_urlsAfterPermalink'][] = 'CollectionHooks::buildNavUrls';
$wgHooks['SkinBuildSidebar'][] = 'CollectionHooks::buildSidebar';
$wgHooks['SiteNoticeAfter'][] = 'CollectionHooks::siteNoticeAfter';
$wgHooks['OutputPageCheckLastModified'][] = 'CollectionHooks::checkLastModified';

$wgAvailableRights[] = 'collectionsaveasuserpage';
$wgAvailableRights[] = 'collectionsaveascommunitypage';

# register global Ajax functions:

function wfAjaxGetCollection() {
	$json = new Services_JSON();
	if ( isset( $_SESSION['wsCollection'] ) ) {
		$collection = $_SESSION['wsCollection'];
	} else {
		$collection = array();
	}
	$r = new AjaxResponse( $json->encode( array( 'collection' => $collection ) ) );
	$r->setContentType( 'application/json' );
	return $r;
}

$wgAjaxExportList[] = 'wfAjaxGetCollection';

function wfAjaxPostCollection( $collection='' ) {
	$json = new Services_JSON( SERVICES_JSON_LOOSE_TYPE );
	if( session_id() == '' ) {
		wfSetupSession();
	}
	$collection = $json->decode( $collection );
	$_SESSION['wsCollection'] = $collection;
	$r = new AjaxResponse( $json->encode( array( 'collection' => $collection ) ) );
	$r->setContentType( 'application/json' );
	return $r;
}

$wgAjaxExportList[] = 'wfAjaxPostCollection';

function wfAjaxGetMWServeStatus( $collection_id='', $writer='rl' ) {
	$json = new Services_JSON();
	$result = SpecialCollection::mwServeCommand( 'render_status', array(
		'collection_id' => $collection_id,
		'writer' => $writer
	) );
	$r = new AjaxResponse( $json->encode( $result ) );
	$r->setContentType( 'application/json' );
	return $r;
}

$wgAjaxExportList[] = 'wfAjaxGetMWServeStatus';

function wfAjaxCollectionAddArticle( $namespace=0, $title='', $oldid='' ) {
	SpecialCollection::addArticleFromName( $namespace, $title, $oldid );
	return '';
}

$wgAjaxExportList[] = 'wfAjaxCollectionAddArticle';

function wfAjaxCollectionRemoveArticle( $namespace=0, $title='', $oldid='' ) {
	SpecialCollection::removeArticleFromName( $namespace, $title, $oldid );
	return '';
}

$wgAjaxExportList[] = 'wfAjaxCollectionRemoveArticle';

function wfAjaxCollectionAddCategory( $title='' ) {
	SpecialCollection::addCategoryFromName( $title );
	return '';
}

$wgAjaxExportList[] = 'wfAjaxCollectionAddCategory';

function wfAjaxCollectionGetBookCreatorBoxContent( $ajaxHint='', $oldid=null ) {
	if( !is_null( $oldid ) ) {
		$oldid = intval( $oldid );
	}
	return CollectionHooks::getBookCreatorBoxContent( $ajaxHint, $oldid );
}

$wgAjaxExportList[] = 'wfAjaxCollectionGetBookCreatorBoxContent';

function wfAjaxCollectionGetItemList() {
	wfLoadExtensionMessages( 'CollectionCore' );
	wfLoadExtensionMessages( 'Collection' );
	$template = new CollectionListTemplate();
	$template->set( 'collection', $_SESSION['wsCollection'] );
	$template->set( 'is_ajax', true );
	ob_start();
	$template->execute();
	$html = ob_get_contents();
	ob_end_clean();
	return $html;
}

$wgAjaxExportList[] = 'wfAjaxCollectionGetItemList';

function wfAjaxCollectionRemoveItem( $index ) {
	SpecialCollection::removeItem( (int)$index );
	return wfAjaxCollectionGetItemList();
}

$wgAjaxExportList[] = 'wfAjaxCollectionRemoveItem';

function wfAjaxCollectionAddChapter( $name ) {
	SpecialCollection::addChapter( $name );
	return wfAjaxCollectionGetItemList();
}

$wgAjaxExportList[] = 'wfAjaxCollectionAddChapter';

function wfAjaxCollectionRenameChapter( $index, $name ) {
	SpecialCollection::renameChapter( (int)$index, $name );
	return wfAjaxCollectionGetItemList();
}

$wgAjaxExportList[] = 'wfAjaxCollectionRenameChapter';

function wfAjaxCollectionSetTitles( $title, $subtitle ) {
	SpecialCollection::setTitles( $title, $subtitle );
	return '';
}

$wgAjaxExportList[] = 'wfAjaxCollectionSetTitles';

function wfAjaxCollectionSetSorting( $items_string ) {
	$parsed = array();
	parse_str( $items_string, $parsed );
	$items = array();
	foreach ( $parsed['item'] as $s ) {
		if ( is_numeric( $s ) ) {
			$items[] = intval( $s );
		}
	}
	SpecialCollection::setSorting( $items );
	return wfAjaxCollectionGetItemList();
}

$wgAjaxExportList[] = 'wfAjaxCollectionSetSorting';

function wfAjaxCollectionClear() {
	CollectionSession::clearCollection();
	CollectionSuggest::clear();
	return wfAjaxCollectionGetItemList();
}

$wgAjaxExportList[] = 'wfAjaxCollectionClear';

function wfAjaxCollectionGetPopupData( $title ) {
	global $wgScriptPath;

	wfLoadExtensionMessages( 'CollectionCore' );
	$json = new Services_JSON();
	$result = array();
	$imagePath = "$wgScriptPath/extensions/Collection/images";
	if ( CollectionSession::findArticle( $title ) == -1 ) {
		$result['action'] = 'add';
		$result['text'] = wfMsg( 'coll-add_linked_article' );
		$result['img'] = "$imagePath/silk-add.png";
	} else {
		$result['action'] = 'remove';
		$result['text'] = wfMsg( 'coll-remove_linked_article' );
		$result['img'] = "$imagePath/silk-remove.png";
	}
	$r = new AjaxResponse( $json->encode( $result ) );
	$r->setContentType( 'application/json' );
	return $r;
}

$wgAjaxExportList[] = 'wfAjaxCollectionGetPopupData';

/**
 * Backend of several following SAJAX function handlers...
 * @param String $action provided by the specific handlers internally
 * @param String $article title passed in from client
 * @return AjaxResponse with JSON-encoded array including HTML fragment.
 */
function wfCollectionSuggestAction( $action, $article ) {
	wfLoadExtensionMessages( 'CollectionCore' );
	wfLoadExtensionMessages( 'Collection' );

	$json = new Services_JSON();
	$result = CollectionSuggest::refresh( $action, $article );
	$undoLink = Xml::element( 'a',
		array(
			'href' => SkinTemplate::makeSpecialUrl(
				'Book',
				array('bookcmd' => 'suggest', 'undo' => $action, 'arttitle' => $article )
			),
			'onclick' => "collectionSuggestCall('UndoArticle'," .
				Xml::encodeJsVar( array( $action, $article ) ) . "); return false;",
			'title' => wfMsg( 'coll-suggest_undo_tooltip' ),
		),
		wfMsg( 'coll-suggest_undo' )
	);
	$result['last_action'] = wfMsg(
		"coll-suggest_article_$action",
		htmlspecialchars( $article ),
		$undoLink
	);
	$r = new AjaxResponse( $json->encode( $result ) );
	$r->setContentType( 'application/json' );
	return $r;
}

function wfAjaxCollectionSuggestBanArticle( $article ) {
	return wfCollectionSuggestAction( 'ban', $article );
}

$wgAjaxExportList[] = 'wfAjaxCollectionSuggestBanArticle';

function wfAjaxCollectionSuggestAddArticle( $article ) {
	return wfCollectionSuggestAction( 'add', $article );
}

$wgAjaxExportList[] = 'wfAjaxCollectionSuggestAddArticle';

function wfAjaxCollectionSuggestRemoveArticle( $article ) {
	return wfCollectionSuggestAction( 'remove', $article );
}

$wgAjaxExportList[] = 'wfAjaxCollectionSuggestRemoveArticle';

function wfAjaxCollectionSuggestUndoArticle( $lastAction, $article ) {
	wfLoadExtensionMessages( 'CollectionCore' );
	wfLoadExtensionMessages( 'Collection' );

	$json = new Services_JSON();
	$result = CollectionSuggest::undo( $lastAction, $article );
	$r = new AjaxResponse( $json->encode( $result ) );
	$r->setContentType( 'application/json' );
	return $r;
}

$wgAjaxExportList[] = 'wfAjaxCollectionSuggestUndoArticle';
