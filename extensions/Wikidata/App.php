<?php

if ( !defined( 'MEDIAWIKI' ) ) die( 'Invalid entry point.' );

$wgExtensionCredits['other'][] = array(
	'path'            => __FILE__,
	'name'            => 'Wikidata',
	'version'         => '0.1.0',
	'author'          => array(
		'Erik Möller',
		'Kim Bruning',
		'Maarten van Hoof',
		'André Malafaya Baptista'
	),
	'url'             => 'http://meta.wikimedia.org/wiki/Wikidata',
	'description'     => 'Adds wiki-like database for various types of content.',
	'descriptionmsg'  => 'wikidata-desc',
);

$dir = dirname( __FILE__ ) . '/';

$wgExtensionFunctions[] = 'initializeWikidata';
$wgHooks[ 'BeforePageDisplay'     ][] = 'addWikidataHeader';
$wgHooks[ 'SkinTemplateTabs'      ][] = 'modifyTabs';
$wgHooks[ 'GetPreferences'        ][] = 'efWikidataGetPreferences';
$wgHooks[ 'ArticleFromTitle'      ][] = 'efWikidataOverrideArticle';
$wgHooks[ 'CustomEditor'          ][] = 'efWikidataOverrideEditPage';
$wgHooks[ 'MediaWikiPerformAction'][] = 'efWikidataOverridePageHistory';
$wgHooks[ 'AbortMove'             ][] = 'efWikidataHandlerNamespacePreventMove';
$wgAutoloadClasses[ 'WikidataArticle'      ] = $dir . 'includes/WikidataArticle.php';
$wgAutoloadClasses[ 'WikidataEditPage'     ] = $dir . 'includes/WikidataEditPage.php';
$wgAutoloadClasses[ 'WikidataPageHistory'  ] = $dir . 'includes/WikidataPageHistory.php';
$wgAutoloadClasses[ 'ApiWikiData'          ] = $dir . 'includes/api/ApiWikiData.php';
$wgAutoloadClasses[ 'ApiWikiDataFormatBase'] = $dir . 'includes/api/ApiWikiDataFormatBase.php';
$wgAutoloadClasses[ 'ApiWikiDataFormatXml' ] = $dir . 'includes/api/ApiWikiDataFormatXml.php';
$wgAPIModules['wikidata'] = 'ApiWikiData';
$wgExtensionMessagesFiles['Wikidata'] = $dir . 'Wikidata.i18n.php';

# FIXME: Rename this to reduce chance of collision.
$wgAutoloadClasses['OmegaWiki'] = $dir . 'OmegaWiki/OmegaWiki.php';
$wgAutoloadClasses['DefinedMeaning'] = $dir . 'OmegaWiki/DefinedMeaning.php';
$wgAutoloadClasses['NeedsTranslationTo'] = $dir . 'OmegaWiki/NeedsTranslationTo.php';
$wgAutoloadClasses['Search'] = $dir . 'OmegaWiki/Search.php';

# FIXME: These should be modified to make Wikidata more reusable.
$wgAvailableRights[] = 'editwikidata-uw';
$wgAvailableRights[] = 'wikidata-copy';
$wgGroupPermissions['wikidata-omega']['editwikidata-uw'] = true;
$wgGroupPermissions['wikidata-copy']['wikidata-copy'] = true;
$wgGroupPermissions['wikidata-omega']['wikidata-copy'] = true;

// Wikidata Configuration.

# Removed as part of migration from branch to trunk.
# $wgCustomHandlerPath = array( '*' => "{$IP}/extensions/Wikidata/OmegaWiki/" );

# Array of namespace ids and the handler classes they use.
//$wdHandlerClasses = array();
# Path to the handler class directory, will be deprecated in favor of autoloading shortly.
//$wdHandlerPath = '';

# The term dataset prefix identifies the Wikidata instance that will
# be used as a resource for obtaining language-independent strings
# in various places of the code. If the term db prefix is empty,
# these code segments will fall back to (usually English) strings.
# If you are setting up a new Wikidata instance, you may want to
# set this to ''.
$wdTermDBDataSet = 'uw';

# This is the dataset that should be shown to all users by default.
# It _must_ exist for the Wikidata application to be executed 
# successfully.
$wdDefaultViewDataSet = 'uw';

$wdShowCopyPanel = false;
$wdShowEditCopy = true;

# FIXME: These should be modified to make Wikidata more reusable.
$wdGroupDefaultView = array();
$wdGroupDefaultView['wikidata-omega'] = 'uw';
# $wdGroupDefaultView['wikidata-umls']='umls';
# $wdGroupDefaultView['wikidata-sp']='sp';

$wgCommunity_dc = 'uw';
$wgCommunityEditPermission = 'editwikidata-uw';

$wdCopyAltDefinitions = false;
$wdCopyDryRunOnly = false;

# FIXME: Should be renamed to prefix with wd rather than wg.
$wgShowClassicPageTitles = false;
$wgDefinedMeaningPageTitlePrefix = '';
$wgExpressionPageTitlePrefix = 'Multiple meanings';

// Hacks?
$wgDefaultGoPrefix = 'Expression:';
$wgDefaultClassMids = array( 402295 );

require_once( "$IP/extensions/Wikidata/OmegaWiki/GotoSourceTemplate.php" );
$wgGotoSourceTemplates = array( 5 => $swissProtGotoSourceTemplate );

# The site prefix allows us to have multiple sets of customized
# messages (for different, typically site-specific UIs)
# in a single database.
if ( !isset( $wdSiteContext ) ) $wdSiteContext = "uw";

require_once( "{$IP}/extensions/Wikidata/SpecialLanguages.php" );

# FIXME: These should be migrated to make Wikidata more reusable.
require_once( "{$IP}/extensions/Wikidata/OmegaWiki/SpecialSuggest.php" );
require_once( "{$IP}/extensions/Wikidata/OmegaWiki/SpecialSelect.php" );
require_once( "{$IP}/extensions/Wikidata/OmegaWiki/SpecialDatasearch.php" );
require_once( "{$IP}/extensions/Wikidata/OmegaWiki/SpecialTransaction.php" );
require_once( "{$IP}/extensions/Wikidata/OmegaWiki/SpecialNeedsTranslation.php" );
require_once( "{$IP}/extensions/Wikidata/OmegaWiki/SpecialImportLangNames.php" );
require_once( "{$IP}/extensions/Wikidata/OmegaWiki/SpecialAddCollection.php" );
require_once( "{$IP}/extensions/Wikidata/OmegaWiki/SpecialConceptMapping.php" );
require_once( "{$IP}/extensions/Wikidata/OmegaWiki/SpecialCopy.php" );
require_once( "{$IP}/extensions/Wikidata/OmegaWiki/SpecialExportTSV.php" );
require_once( "{$IP}/extensions/Wikidata/OmegaWiki/SpecialImportTSV.php" );

require_once( "{$IP}/extensions/Wikidata/LocalApp.php" );

# FIXME: This should be migrated to make Wikidata more reusable.
function addWikidataHeader( &$out, &$skin ) {
	global $wgScriptPath;
	$out->addScript( "<script type='text/javascript' src='$wgScriptPath/extensions/Wikidata/OmegaWiki/suggest.js'></script>" );
	
	global $wgLang;
	if ( $wgLang->isRTL() ) {
		$rtl = '-rtl';
	} else {
		$rtl = '';
	}

	$out->addLink( array( 'rel' => 'stylesheet', 'type' => 'text/css', 'media' => 'screen', 'href' => "$wgScriptPath/extensions/Wikidata/OmegaWiki/suggest$rtl.css" ) );
	$out->addLink( array( 'rel' => 'stylesheet', 'type' => 'text/css', 'media' => 'screen', 'href' => "$wgScriptPath/extensions/Wikidata/OmegaWiki/tables$rtl.css" ) );
	return true;
}

function wdIsWikidataNs() {
	global $wgTitle, $wdHandlerClasses;
	return array_key_exists( $wgTitle->getNamespace(), $wdHandlerClasses );

}

function addWikidataEditLinkTrail( &$trail ) {
	if ( wdIsWikidataNs() ) {
		$dc = wdGetDatasetContext();
		$trail = "&dataset=$dc";
	}
	return true;
}

function addHistoryLinkTrail( &$trail ) {
	if ( wdIsWikidataNs() ) {
	    	$dc = wdGetDatasetContext();
	    	$trail = "&dataset=$dc";
  	}
	return true;
}

/**
 * Purpose: Add custom tabs
 *
 * When editing in read-only data-set, if you have the copy permission, you can
 * make a copy into the designated community dataset and edit the data there.
 * This is accessible through an 'edit copy' tab which is added below.
 *
 * @param $skin Skin as passed by MW
 * @param $tabs as passed by MW
 */
function modifyTabs( $skin, $content_actions ) {
	global $wgUser, $wgTitle, $wgCommunity_dc, $wdShowEditCopy, $wdHandlerClasses;
	$dc = wdGetDataSetContext();
	$ns = $wgTitle->getNamespace();
	$editChanged = false;
	if ( wdIsWikidataNs() && $wdHandlerClasses[ $ns ] == 'DefinedMeaning' ) {
	
		# Hackishly determine which DMID we're on by looking at the page title component
		$tt = $wgTitle->getText();
		$rpos1 = strrpos( $tt, '(' );
		$rpos2 = strrpos( $tt, ')' );
		$dmid = ( $rpos1 && $rpos2 ) ? substr( $tt, $rpos1 + 1, $rpos2 - $rpos1 - 1 ) : 0;
		if ( $dmid ) {
			$copyTitle = SpecialPage::getTitleFor( 'Copy' );
			if ( wdIsWikidataNs() && $dc != $wgCommunity_dc && $wdShowEditCopy ) {
				$editChanged = true;
				$content_actions['edit'] = array(
					'class' => false,
					'text' => wfMsg( 'ow_nstab_edit_copy' ),
					'href' => $copyTitle->getLocalUrl( "action=copy&dmid=$dmid&dc1=$dc&dc2=$wgCommunity_dc" )
				);
			}
		 	$content_actions['nstab-definedmeaning'] = array(
				 'class' => 'selected',
				 'text' => wfMsg( 'ow_nstab_definedmeaning' ),
				 'href' => $wgTitle->getLocalUrl( "dataset=$dc" )
			);
		}
	}

	// Prevent move tab being shown.
	if( wdIsWikidataNs() ) unset( $content_actions['move'] );

	// Add context dataset (old hooks 'GetEditLinkTrail' and 'GetHistoryLinkTrail')
	if ( !$editChanged && $content_actions['edit'] != null ) {
		addWikidataEditLinkTrail( $linkTrail );
		$content_actions['edit']['href'] = ( $content_actions['edit']['href'] . $linkTrail );
	}
	addHistoryLinkTrail( $linkTrail );
	$content_actions['history']['href'] = ( $content_actions['history']['href'] . $linkTrail );

	return true;
}

function initializeWikidata() {
	wfLoadExtensionMessages( 'Wikidata' );

	$dbr = wfGetDB( DB_MASTER );
	$dbr->query( 'SET NAMES utf8' );

	global $wgRecordSetLanguage;
	$wgRecordSetLanguage = 0;

	global $wgLang, $wgOut;
	if ( $wgLang->isRTL() )	{
		# FIXME: Why are we including Gadget CSS here, this is Wikidata?
		$wgOut->addHTML( '<style type="text/css">/*<![CDATA[*/ @import "/index.php?title=MediaWiki:Gadget-rtl.css&action=raw&ctype=text/css"; /*]]>*/</style>' );
	}

	return true;
}

/**
 * FIXME: This does not seem to do anything, need to check whether the
 *        preferences are still being detected.
 */
function efWikidataGetPreferences( $user, &$preferences ) {
	$datasets = wdGetDatasets();
	foreach ( $datasets as $datasetid => $dataset ) {
		$datasetarray[$dataset->fetchName()] = $datasetid;
	}
	$preferences['ow_uipref_datasets'] = array(
		'type' => 'multiselect',
		'options' => $datasetarray,
		'section' => 'omegawiki',
		'label' => wfMsg( 'ow_shown_datasets' ),
		'prefix' => 'ow_datasets-',
	);
	return true;
}

function efWikidataOverrideArticle( &$title, &$article ) {
	if ( wdIsWikidataNs() ) $article = new WikidataArticle( $title );
	return true;
}

function efWikidataOverrideEditPage( $article, $user ) {
	if ( wdIsWikidataNs() ) {
		$editor = new WikidataEditPage( $article );
		$editor->edit();
	}
	return !wdIsWikidataNs() ;	
}

function efWikidataOverridePageHistory( $output, $article, $title, $user, $request, $wiki ) {
	$action = $request->getVal( 'action' );
	if ( $action === 'history' && wdIsWikidataNs() ) {
		$history = new WikidataPageHistory( $article );
		$history->history();
	}
	return !( $action === 'history' && wdIsWikidataNs() );
}

function efWikidataHandlerNamespacePreventMove( $oldtitle, $newtitle, $user, &$error, $reason ) {
	if ( wdIsWikidataNs() ) {
		$error = wfMsg( 'wikidata-handler-namespace-move-error' );
	}
	return !wdIsWikidataNs();
}
