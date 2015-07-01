<?php

/**
 * Initialization file for the Semantic Watchlist extension.
 * 
 * Documentation:	 		http://www.mediawiki.org/wiki/Extension:Semantic_Watchlist
 * Support					http://www.mediawiki.org/wiki/Extension_talk:Semantic_Watchlist
 * Source code:			 http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/SemanticWatchlist
 *
 * @file SemanticWatchlist.php
 * @ingroup SemanticWatchlist
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

/**
 * This documenation group collects source code files belonging to Semantic Watchlist.
 *
 * @defgroup SemanticWatchlist Semantic Watchlist
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

if ( version_compare( $wgVersion, '1.17', '<' ) ) {
	die( '<b>Error:</b> Semantic Watchlist requires MediaWiki 1.17 or above.' );
}

// Show a warning if Semantic MediaWiki is not loaded.
if ( ! defined( 'SMW_VERSION' ) ) {
	die( '<b>Error:</b> You need to have <a href="http://semantic-mediawiki.org/wiki/Semantic_MediaWiki">Semantic MediaWiki</a> installed in order to use Semantic Watchlist.' );
}

if ( version_compare( SMW_VERSION, '1.6 alpha', '<' ) ) {
	die( '<b>Error:</b> Semantic Watchlist requires Semantic MediaWiki 1.6 or above.' );
}

define( 'SemanticWatchlist_VERSION', '0.1' );

$wgExtensionCredits[defined( 'SEMANTIC_EXTENSION_TYPE' ) ? 'semantic' : 'other'][] = array(
	'path' => __FILE__,
	'name' => 'Semantic Watchlist',
	'version' => SemanticWatchlist_VERSION,
	'author' => array(
		'[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw] for [http://www.wikiworks.com/ WikiWorks]',
	),
	'url' => 'http://www.mediawiki.org/wiki/Extension:Semantic_Watchlist',
	'descriptionmsg' => 'semanticwatchlist-desc'
);

$egSWLScriptPath = $wgExtensionAssetsPath === false ? $wgScriptPath . '/extensions/SemanticWatchlist' : $wgExtensionAssetsPath . '/SemanticWatchlist';

$wgExtensionMessagesFiles['SemanticWatchlist']	  	= dirname( __FILE__ ) . '/SemanticWatchlist.i18n.php';
$wgExtensionAliasesFiles['SemanticWatchlist'] 		= dirname( __FILE__ ) . '/SemanticWatchlist.i18n.alias.php';

$wgAutoloadClasses['SWLHooks']					  	= dirname( __FILE__ ) . '/SemanticWatchlist.hooks.php';

$wgAutoloadClasses['ApiAddWatchlistGroup']		  	= dirname( __FILE__ ) . '/api/ApiAddWatchlistGroup.php';
$wgAutoloadClasses['ApiDeleteWatchlistGroup']		= dirname( __FILE__ ) . '/api/ApiDeleteWatchlistGroup.php';
$wgAutoloadClasses['ApiEditWatchlistGroup']		 	= dirname( __FILE__ ) . '/api/ApiEditWatchlistGroup.php';
$wgAutoloadClasses['ApiQuerySemanticWatchlist']	 	= dirname( __FILE__ ) . '/api/ApiQuerySemanticWatchlist.php';

$wgAutoloadClasses['SWLChangeSet']		  			= dirname( __FILE__ ) . '/includes/SWL_ChangeSet.php';
$wgAutoloadClasses['SWLEdit']		  				= dirname( __FILE__ ) . '/includes/SWL_Edit.php';
$wgAutoloadClasses['SWLEmailer']		  			= dirname( __FILE__ ) . '/includes/SWL_Emailer.php';
$wgAutoloadClasses['SWLGroup']		  				= dirname( __FILE__ ) . '/includes/SWL_Group.php';
$wgAutoloadClasses['SWLGroups']		  				= dirname( __FILE__ ) . '/includes/SWL_Groups.php';
$wgAutoloadClasses['SWLPropertyChange']		  		= dirname( __FILE__ ) . '/includes/SWL_PropertyChange.php';
$wgAutoloadClasses['SWLPropertyChanges']		  	= dirname( __FILE__ ) . '/includes/SWL_PropertyChanges.php';

$wgAutoloadClasses['SpecialSemanticWatchlist']	  	= dirname( __FILE__ ) . '/specials/SpecialSemanticWatchlist.php';
$wgAutoloadClasses['SpecialWatchlistConditions']	= dirname( __FILE__ ) . '/specials/SpecialWatchlistConditions.php';

$wgSpecialPages['SemanticWatchlist'] = 'SpecialSemanticWatchlist';
$wgSpecialPageGroups['SemanticWatchlist'] = 'changes';

$wgSpecialPages['WatchlistConditions'] = 'SpecialWatchlistConditions';
$wgSpecialPageGroups['WatchlistConditions'] = 'changes';

$wgAPIModules['addswlgroup'] = 'ApiAddWatchlistGroup';
$wgAPIModules['deleteswlgroup'] = 'ApiDeleteWatchlistGroup';
$wgAPIModules['editswlgroup'] = 'ApiEditWatchlistGroup';
$wgAPIListModules['semanticwatchlist'] = 'ApiQuerySemanticWatchlist';

$wgHooks['LoadExtensionSchemaUpdates'][] = 'SWLHooks::onSchemaUpdate';
$wgHooks['SMWStore::updateDataBefore'][] = 'SWLHooks::onDataUpdate';
$wgHooks['GetPreferences'][] = 'SWLHooks::onGetPreferences';
$wgHooks['UserSetPreferences'][] = 'SWLHooks::onUserSaveOptions';
$wgHooks['UserSaveOptions'][] = 'SWLHooks::onUserSaveOptions';
$wgHooks['AdminLinks'][] = 'SWLHooks::addToAdminLinks';
$wgHooks['PersonalUrls'][] = 'SWLHooks::onPersonalUrls';

$moduleTemplate = array(
	'localBasePath' => dirname( __FILE__ ),
	'remoteBasePath' => $egSWLScriptPath
);

$wgResourceModules['ext.swl.watchlist'] = $moduleTemplate + array(
	'styles' => array( 'specials/ext.swl.watchlist.css' ),
	'scripts' => array(
	),
	'dependencies' => array(),
	'messages' => array(
	)
);

$wgResourceModules['ext.swl.watchlistconditions'] = $moduleTemplate + array(
	'styles' => array( 'specials/ext.swl.watchlistconditions.css' ),
	'scripts' => array(
		'specials/jquery.watchlistcondition.js',
		'specials/ext.swl.watchlistconditions.js'
	),
	'dependencies' => array(),
	'messages' => array(
		'swl-group-name',
		'swl-group-properties',
		'swl-group-remove-property',
		'swl-group-add-property',
		'swl-group-page-selection',
		'swl-group-save',
		'swl-group-delete',
		'swl-group-category',
		'swl-group-namespace',
		'swl-group-concept',
		'swl-group-confirmdelete',
	)
);

require_once 'SemanticWatchlist.settings.php';

// This overrides the default value for the setting in SMW, as the behaviour it enables is used by this extension.
$smwgCheckChangesBeforeUpdate = true;

$wgAvailableRights[] = 'semanticwatch';
$wgAvailableRights[] = 'semanticwatchgroups';

if ( $egSWLEnableEmailNotify ) {
	$wgHooks['SWLGroupNotify'][] = 'SWLHooks::onGroupNotify';
}
