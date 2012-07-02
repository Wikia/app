<?php
/**
 * Initialization file for the Storyboard extension.
 * Extension documentation: http://www.mediawiki.org/wiki/Extension:Storyboard
 *
 * @file Storyboard.php
 * @ingroup Storyboard
 *
 * @author Jeroen De Dauw
 */

/**
 * This documenation group collects source code files belonging to Storyboard.
 *
 * Please do not use this group name for other code.
 *
 * @defgroup Storyboard Storyboard
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

define( 'Storyboard_VERSION', '0' );

define( 'Storyboard_TABLE', 'storyboard' );

define( 'Storyboard_STORY_UNPUBLISHED', 0 );
define( 'Storyboard_STORY_PUBLISHED', 1 );
define( 'Storyboard_STORY_HIDDEN', 2 );

$egStoryboardScriptPath = ( isset( $wgExtensionAssetsPath ) && $wgExtensionAssetsPath ? $wgExtensionAssetsPath : $wgScriptPath . '/extensions' ) . '/Storyboard';
$egStoryboardDir = dirname( __FILE__ ) . '/';
$egStoryboardStyleVersion = $wgStyleVersion . '-' . Storyboard_VERSION;

// Include the settings file.
require_once( $egStoryboardDir . 'Storyboard_Settings.php' );

// Register the initernationalization and aliasing files of Storyboard.
$wgExtensionMessagesFiles['Storyboard'] = $egStoryboardDir . 'Storyboard.i18n.php';
$wgExtensionMessagesFiles['StoryboardAlias'] = $egStoryboardDir . 'Storyboard.alias.php';

// Load classes
$wgAutoloadClasses['StoryboardUtils'] = $egStoryboardDir . 'Storyboard_Utils.php';
$wgAutoloadClasses['SpecialStory'] = $egStoryboardDir . 'specials/Story/Story_body.php';
$wgAutoloadClasses['SpecialStorySubmission'] = $egStoryboardDir . 'specials/StorySubmission/StorySubmission_body.php';
$wgAutoloadClasses['SpecialStoryReview'] = $egStoryboardDir . 'specials/StoryReview/StoryReview_body.php';
$wgAutoloadClasses['TagStoryboard'] = $egStoryboardDir . 'tags/Storyboard/Storyboard_body.php';
$wgAutoloadClasses['TagStorysubmission'] = $egStoryboardDir . 'tags/Storysubmission/Storysubmission_body.php';

// Load and register the StoryReview special page and register it's group.
$wgSpecialPages['StoryReview'] = 'SpecialStoryReview';
$wgSpecialPageGroups['StoryReview'] = 'contribution';
$wgSpecialPages['Story'] = 'SpecialStory';
$wgSpecialPageGroups['Story'] = 'contribution';
$wgSpecialPages['StorySubmission'] = 'SpecialStorySubmission';

// API
$wgAutoloadClasses['ApiStoryExists'] = "{$egStoryboardDir}api/ApiStoryExists.php";
$wgAPIModules['storyexists'] = 'ApiStoryExists';
$wgAutoloadClasses['ApiQueryStories'] = "{$egStoryboardDir}api/ApiQueryStories.php";
$wgAPIListModules['stories'] = 'ApiQueryStories';
$wgAutoloadClasses['ApiStoryReview'] = "{$egStoryboardDir}api/ApiStoryReview.php";
$wgAPIModules['storyreview'] = 'ApiStoryReview';

// Hooks
$wgHooks['ParserFirstCallInit'][] = 'efStoryboardParserFirstCallInit';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'efStoryboardSchemaUpdate';
// TODO: these hooks for adding an edit 'tab' to the Special:Story page are not working
// as they should, since they are only getting called for content pages. There is no
// good reason why they are not called on special pages, sho this should be changed in core.
$wgHooks['SkinTemplateTabs'][] = 'efStoryboardAddStoryEditAction';
$wgHooks['SkinTemplateNavigation::SpecialPage'][] = 'efStoryboardAddStoryEditActionVector';


/**
 * The 'storyboard' permission key can be given out to users
 * to enable them to review, edit, publish, and hide stories.
 *
 * By default, only sysops will be able to do this.
 */
$wgAvailableRights[] = 'storyreview';
$wgGroupPermissions['sysop']['storyreview'] = true;

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'Storyboard',
	'version' => Storyboard_VERSION,
	'author' => array( '[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:Storyboard',
	'descriptionmsg' => 'storyboard-desc',
);

function efStoryboardSchemaUpdate( $updater = null ) {
	global $egStoryboardDir;

	if ( $updater === null ) {
		global $wgExtNewTables;
		$wgExtNewTables[] = array(
			'storyboard',
			$egStoryboardDir . 'storyboard.sql'
		);
	} else {
		$updater->addExtensionUpdate( array(
			'addTable', 'storyboard',
			$egStoryboardDir . 'storyboard.sql', true
		) );
	}

	return true;
}

function efStoryboardParserFirstCallInit( &$parser ) {
	$parser->setHook( 'storyboard', array( 'TagStoryboard', 'render' ) );
	$parser->setHook( 'storysubmission', array( 'TagStorysubmission', 'render' ) );
	return true;
}

function efStoryboardAddStoryEditActionVector( &$sktemplate, &$links ) {
	$views_links = $links['views'];
	efStoryboardAddStoryEditAction( $sktemplate, $views_links );
	$links['views'] = $views_links;

	return true;
}

function efStoryboardAddStoryEditAction( &$sktemplate, &$content_actions ) {
	global $wgRequest;

	$action = $wgRequest->getText( 'action' );
	$title = $sktemplate->getTitle();

	if ( $title->isSpecial( 'Story' ) ) {
		$content_actions['edit'] = array(
			'class' => $action == 'edit' ? 'selected' : false,
			'text' => wfMsg( 'edit' ),
			'href' => $title->getLocalUrl( 'action=edit' )
		);
	}

	return true;
}

function efStoryboardAddJSLocalisation( $parser = false ) {
	

	$messages = array(
		'storyboard-charstomany',
		'storyboard-morecharsneeded',
		'storyboard-charactersleft',
		'storyboard-needtoagree',
		'storyboard-anerroroccured',
		'storyboard-storymetadata',
		'storyboard-storymetadatafrom',
		'storyboard-done',
		'storyboard-working',
		'storyboard-imagedeleted',
		'storyboard-showimage',
		'storyboard-hideimage',
		'storyboard-imagedeletionconfirm',
		'storyboard-alreadyexistschange',
		'edit',
		'storyboard-unpublish',
		'storyboard-publish',
		'storyboard-hide',
		'storyboard-deleteimage',
		'storyboard-deletestory',
		'storyboard-storydeletionconfirm'
	);

	$data = array();

	foreach ( $messages as $msg ) {
		$data[$msg] = wfMsgNoTrans( $msg );
	}

	$js = 'var wgStbMessages = ' . json_encode( $data ) . ';';
	
	if ( $parser ) {
		$parser->getOutput()->addHeadItem( Html::inlineScript( $js ) );
	} else {
		global $wgOut;
		$wgOut->addInlineScript( $js );		
	}
}
