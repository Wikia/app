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

require_once( "$IP/extensions/Collection/Version.php" );

# ==============================================================================

# Configuration:

/** URL of PDF server */
$wgCollectionMWServeURL = 'http://tools.pediapress.com/mw-serve/';

/** Login credentials to this MediaWiki as 'USERNAME:PASSWORD' string */
$wgCollectionMWServeCredentials = null;

/** Namespace for "community collections" */
$wgCommunityCollectionNamespace = NS_MEDIAWIKI;

/** Maximum no. of articles in a collection */
$wgCollectionMaxArticles = 500;

/** Name of license */
$wgLicenseName = null;

/** HTTP(s) URL pointing to license in wikitext format: */
$wgLicenseURL = null;

/** Template blacklist article */
$wgPDFTemplateBlacklist = 'MediaWiki:PDF Template Blacklist';

/** List of available download formats,
    as mapping of mwlib writer to format name */
$wgCollectionFormats = array(
	'rl' => 'PDF',
);

# ==============================================================================


$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Collection',
	'version' => '1.0',
	'author' => 'PediaPress GmbH',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Collection',
	'description' => 'Collect articles, generate PDFs',
	'descriptionmsg' => 'coll-desc',
);

# register Special:Collection:

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['Collection'] = $dir . 'Collection.body.php';
$wgExtensionMessagesFiles['Collection'] = $dir . 'Collection.i18n.php';
$wgSpecialPages['Collection'] = 'Collection';
$wgHooks['LanguageGetSpecialPageAliases'][] = 'collectionLocalizedPageName';

$wgHooks['SkinTemplateBuildNavUrlsNav_urlsAfterPermalink'][] = 'Collection::createNavURLs';
$wgHooks['MonoBookTemplateToolboxEnd'][] = 'Collection::insertMonoBookToolboxLink';


function collectionLocalizedPageName(&$specialPageArray, $code) {
	wfLoadExtensionMessages( 'Collection' );
	$text = wfMsg( 'coll-collection' );
	$title = Title::newFromText( $text );
	$specialPageArray['Collection'][] = $title->getDBKey();
	return true;
}

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
