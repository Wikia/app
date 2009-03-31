<?php

/*
 * Collection Extension for MediaWiki
 *
 * Copyright (C) 2008, PediaPress GmbH
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

require_once( $dir . 'Version.php' );

# ==============================================================================

# Configuration:

/** Bump the version number every time you change any of the JavaScript files */
$wgCollectionStyleVersion = 2;

/** URL of mw-serve render server */
$wgCollectionMWServeURL = 'http://tools.pediapress.com/mw-serve/';

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
	100, // Portal
	101, // Portal talk
	102, // Author
	103, // Author talk
);

/** Namespace for "community collections" */
$wgCommunityCollectionNamespace = NS_MEDIAWIKI;

/** Maximum no. of articles in a collection */
$wgCollectionMaxArticles = 500;

/** Name of license */
$wgLicenseName = null;

/** HTTP(s) URL pointing to license in wikitext format: */
$wgLicenseURL = null;

/** List of available download formats,
    as mapping of mwlib writer to format name */
$wgCollectionFormats = array(
	'rl' => 'PDF',
);

$wgCollectionPortletForLoggedInUsersOnly = false;

# ==============================================================================


$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Collection',
	'version' => '1.1',
	'author' => 'PediaPress GmbH',
	'svn-date' => '$LastChangedDate: 2008-12-18 08:28:22 +0000 (Thu, 18 Dec 2008) $',
	'svn-revision' => '$LastChangedRevision: 44757 $',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Collection',
	'description' => 'Collect articles, generate PDFs',
	'descriptionmsg' => 'coll-desc',
);

# register Special:Collection:

$wgAutoloadClasses['Collection'] = $dir . 'Collection.body.php';
$wgAutoloadClasses['CollectionPageTemplate'] = $dir . 'Collection.templates.php';
$wgAutoloadClasses['CollectionListTemplate'] = $dir . 'Collection.templates.php';
$wgAutoloadClasses['CollectionLoadOverwriteTemplate'] = $dir . 'Collection.templates.php';
$wgAutoloadClasses['CollectionSaveOverwriteTemplate'] = $dir . 'Collection.templates.php';
$wgAutoloadClasses['CollectionRenderingTemplate'] = $dir . 'Collection.templates.php';
$wgAutoloadClasses['CollectionFinishedTemplate'] = $dir . 'Collection.templates.php';
$wgExtensionMessagesFiles['Collection'] = $dir . 'Collection.i18n.php';
$wgExtensionAliasesFiles['Collection'] = $dir . 'Collection.alias.php';
$wgSpecialPages['Collection'] = 'Collection';
$wgSpecialPageGroups['Collection'] = 'pagetools';

$wgHooks['SkinTemplateBuildNavUrlsNav_urlsAfterPermalink'][] = 'Collection::createNavURLs';
$wgHooks['MonoBookTemplateToolboxEnd'][] = 'Collection::insertMonoBookToolboxLink';
$wgHooks['SkinBuildSidebar'][] = 'Collection::buildSidebar';
$wgHooks['OutputPageCheckLastModified'][] = 'Collection::checkLastModified';

# register global Ajax functions:

function wfAjaxGetCollection() {
	$json = new Services_JSON();
	if ( isset( $_SESSION['wsCollection'] ) ) {
		$collection = $_SESSION['wsCollection'];
	} else {
		$collection = array();
	}
	return $json->encode( array( 'collection' => $collection ) );
}

$wgAjaxExportList[] = 'wfAjaxGetCollection';

function wfAjaxPostCollection( $collection='' ) {
	$json = new Services_JSON( SERVICES_JSON_LOOSE_TYPE );
	if( session_id() == '' ) {
		wfSetupSession();
	}
	$collection = $json->decode( $collection );
	$_SESSION['wsCollection'] = $collection;
	return $json->encode( array( 'collection' => $collection ) );
}

$wgAjaxExportList[] = 'wfAjaxPostCollection';

function wfAjaxGetMWServeStatus( $collection_id='', $writer='rl' ) {
	$json = new Services_JSON();
	$result = Collection::mwServeCommand( 'render_status', array(
		'collection_id' => $collection_id,
		'writer' => $writer
	) );
	return $json->encode( $result );
}

$wgAjaxExportList[] = 'wfAjaxGetMWServeStatus';

function wfAjaxCollectionAddArticle( $namespace=0, $title='', $oldid='' ) {
	Collection::addArticleFromName( $namespace, $title, $oldid );
	return '';
}

$wgAjaxExportList[] = 'wfAjaxCollectionAddArticle';

function wfAjaxCollectionRemoveArticle( $namespace=0, $title='', $oldid='' ) {
	Collection::removeArticleFromName( $namespace, $title, $oldid );
	return '';
}

$wgAjaxExportList[] = 'wfAjaxCollectionRemoveArticle';

function wfAjaxCollectionAddCategory( $title='' ) {
	Collection::addCategoryFromName( $title );
	return '';
}

$wgAjaxExportList[] = 'wfAjaxCollectionAddCategory';

function wfAjaxCollectionGetPortlet( $ajaxHint='' ) {
	return Collection::getPortlet( $ajaxHint );
}

$wgAjaxExportList[] = 'wfAjaxCollectionGetPortlet';

function wfAjaxCollectionGetItemList() {
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
	Collection::removeItem( $index );
	return wfAjaxCollectionGetItemList();
}

$wgAjaxExportList[] = 'wfAjaxCollectionRemoveItem';

function wfAjaxCollectionAddChapter( $name ) {
	Collection::addChapter( $name );
	return wfAjaxCollectionGetItemList();
}

$wgAjaxExportList[] = 'wfAjaxCollectionAddChapter';

function wfAjaxCollectionRenameChapter( $index, $name ) {
	Collection::renameChapter( $index, $name );
	return wfAjaxCollectionGetItemList();
}

$wgAjaxExportList[] = 'wfAjaxCollectionRenameChapter';

function wfAjaxCollectionSetTitles( $title, $subtitle ) {
	Collection::setTitles( $title, $subtitle );
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
	Collection::setSorting( $items );
	return wfAjaxCollectionGetItemList();
}

$wgAjaxExportList[] = 'wfAjaxCollectionSetSorting';

function wfAjaxCollectionClear() {
	Collection::clearCollection();
	return wfAjaxCollectionGetItemList();
}

$wgAjaxExportList[] = 'wfAjaxCollectionClear';
