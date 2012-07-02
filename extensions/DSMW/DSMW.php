<?php

/**
 * Initialization file for the Distributed Semantic MediaWiki extension.
 * See https://secure.wikimedia.org/wikipedia/mediawiki/wiki/Extension:DSMW 
 * 
 * @file DSMW.php
 * @ingroup DSMW
 * 
 * @copyright 2009 INRIA-LORIA-ECOO project
 * 
 * @author jean-philippe muller
 * @author Morel Émile
 */

/**
 * This documenation group collects source code files belonging to DSMW.
 *
 * @defgroup DSMW Distributed Semantic MediaWiki
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not a valid entry point.' );
}

require_once "$IP/includes/GlobalFunctions.php";
require_once dirname( __FILE__ ) . '/includes/DSMW_GlobalFunctions.php';
$wgDSMWIP = dirname( __FILE__ );

require_once( "$wgDSMWIP/includes/DSMWButton.php" );

require_once 'includes/SemanticFunctions.php';
require_once 'includes/IntegrationFunctions.php';

define( 'DSMW_VERSION', '1.1 alpha' );

// Load and register the StoryReview special page and register it's group.
$wgSpecialPages['ArticleAdminPage'] = 'ArticleAdminPage';
$wgSpecialPageGroups['ArticleAdminPage'] = 'dsmw_group';

$wgSpecialPages['DSMWAdmin'] = 'DSMWAdmin';
$wgSpecialPageGroups['DSMWAdmin'] = 'dsmw_group';

$wgSpecialPages['DSMWGeneralExhibits'] = 'DSMWGeneralExhibits';
$wgSpecialPageGroups['DSMWGeneralExhibits'] = 'dsmw_group';

$wgGroupPermissions['*']['upload_by_url'] = true;
$wgGroupPermissions['*']['reupload'] = true;
$wgGroupPermissions['*']['upload'] = true;

$wgAllowCopyUploads = true;

$wgExtensionMessagesFiles['DSMW'] = dirname( __FILE__ ) . '/DSMW.i18n.php';
$wgExtensionMessagesFiles['DSMWAlias'] = dirname( __FILE__ ) . '/DSMW.alias.php';

$wgAutoloadClasses['DSMWHooks'] = dirname( __FILE__ )  . '/DSMW.hooks.php';

$wgAutoloadClasses['logootEngine'] = "$wgDSMWIP/logootComponent/logootEngine.php";
$wgAutoloadClasses['logoot'] = "$wgDSMWIP/logootComponent/logoot.php";
$wgAutoloadClasses['LogootId'] = "$wgDSMWIP/logootComponent/LogootId.php";
$wgAutoloadClasses['LogootPosition'] = "$wgDSMWIP/logootComponent/LogootPosition.php";
$wgAutoloadClasses['Diff1']
	= $wgAutoloadClasses['_DiffEngine1']
	= $wgAutoloadClasses['_DiffOp1']
	= $wgAutoloadClasses['_DiffOp_Add1']
	= $wgAutoloadClasses['_DiffOp_Change1']
	= $wgAutoloadClasses['_DiffOp_Copy1']
	= $wgAutoloadClasses['_DiffOp_Delete1']
	= "$wgDSMWIP/logootComponent/DiffEngine.php";

$wgAutoloadClasses['LogootIns'] = "$wgDSMWIP/logootComponent/LogootIns.php";
$wgAutoloadClasses['LogootDel'] = "$wgDSMWIP/logootComponent/LogootDel.php";

$wgAutoloadClasses['DSMWRevisionManager'] 		= dirname( __FILE__ ) . '/includes/DSMW_RevisionManager.php';
$wgAutoloadClasses['DSMWPersistentClock']		= dirname( __FILE__ ) . '/includes/DSMW_PersistentClock.php';
$wgAutoloadClasses['DSMWPatch']					= dirname( __FILE__ ) . '/includes/DSMW_Patch.php';

$wgAutoloadClasses['ApiQueryPatch'] = "$wgDSMWIP/api/ApiQueryPatch.php";
$wgAutoloadClasses['ApiQueryChangeSet'] = "$wgDSMWIP/api/ApiQueryChangeSet.php";

$wgAutoloadClasses['ApiPatchPush'] = "$wgDSMWIP/api/ApiPatchPush.php";
$wgAutoloadClasses['utils'] = "$wgDSMWIP/files/utils.php";
$wgAutoloadClasses['Math_BigInteger'] = "$wgDSMWIP/logootComponent/Math/BigInteger.php";

//// / Register Jobs
$wgJobClasses['DSMWUpdateJob'] = 'DSMWUpdateJob';
$wgAutoloadClasses['DSMWUpdateJob'] = "$wgDSMWIP/jobs/DSMWUpdateJob.php";
$wgJobClasses['DSMWPropertyTypeJob'] = 'DSMWPropertyTypeJob';
$wgAutoloadClasses['DSMWPropertyTypeJob'] = "$wgDSMWIP/jobs/DSMWPropertyTypeJob.php";

$wgAutoloadClasses['DSMWSiteId'] = "$wgDSMWIP/includes/DSMWSiteId.php";

$wgExtensionFunctions[] = 'dsmwgSetupFunction';

$wgHooks['LoadExtensionSchemaUpdates'][] = 'DSMWHooks::onExtensionSchemaUpdates';
$wgHooks['UnknownAction'][] = 'DSMWHooks::onUnknownAction';
$wgHooks['EditPage::attemptSave'][] = 'DSMWHooks::onAttemptSave';
$wgHooks['EditPageBeforeConflictDiff'][] = 'DSMWHooks::onEditConflict';
$wgHooks['UploadComplete'][] = 'DSMWHooks::onUploadComplete';

$wgExtensionCredits[defined( 'SEMANTIC_EXTENSION_TYPE' ) ? 'semantic' : 'other'][] = array(
	'path' => __FILE__,
	'name' => 'Distributed&#160;Semantic&#160;MediaWiki',
	'version' => DSMW_VERSION,
	'author' => array(
		'[http://www.loria.fr/~mullejea Jean–Philippe&#160;Muller]',
		'[http://www.loria.fr/~molli Pascal&#160;Molli]',
		'[http://www.loria.fr/~skaf Hala&#160;Skaf–Molli]',
		'[http://www.loria.fr/~canals Gérôme&#160;Canals]',
		'[http://www.loria.fr/~rahalcha Charbel&#160;Rahal]',
		'[http://www.loria.fr/~weiss Stéphane&#160;Weiss]',
		'[http://m3p.gforge.inria.fr/pmwiki/pmwiki.php?n=Site.Team others]'
	),
	'url' => 'http://www.dsmw.org',
	'descriptionmsg' => 'dsmw-desc'
);

$wgAPIMetaModules['patch'] = 'ApiQueryPatch';
$wgAPIMetaModules['changeSet'] = 'ApiQueryChangeSet';
$wgAPIMetaModules['patchPushed'] = 'ApiPatchPush';

function dsmwgSetupFunction() {
	global $smwgNamespacesWithSemanticLinks;

	$smwgNamespacesWithSemanticLinks += array(
		PATCH => true,
		PUSHFEED => true,
		PULLFEED => true,
		CHANGESET => true
	);
}

require_once dirname( __FILE__ ) . '/DSMW_Settings.php';
