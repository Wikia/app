<?php
/**
 * Usability Initiative OptIn extension
 *
 * @file
 * @ingroup Extensions
 *
 * This file contains the include file for the OptIn portion of the
 * UsabilityInitiative extension of MediaWiki.
 *
 * Usage: Include the following line in your LocalSettings.php
 * require_once( "$IP/extensions/UsabilityInitiative/OptIn/OptIn.php" );
 *
 * @author Roan Kattouw <roan.kattouw@gmail.com>, Trevor Parscal <tparscal@wikimedia.org>
 * @license GPL v2 or later
 * @version 0.1.1
 */

/* Configuration */

/**
 * The default behavior of this extension is to show a link at the begining of
 * the personal tools while a user is opted in, allowing them to easily opt back
 * out at any time. Using the following global configuration variables you can
 * make the link always show, resulting in a link that invites them to opt-in
 * when they aren't opted-in, or never show, even if they are opted in.
 */
$wgOptInAlwaysShowPersonalLink = false;
$wgOptInNeverShowPersonalLink = false;

$wgOptInStyleVersion = 11;

// Preferences to set when users opt in
// array( prefname => value )
$wgOptInPrefs = array( 'skin' => 'vector', 'usebetatoolbar' => 1 );

// Survey questions to ask when users opt out
$wgOptInSurvey = array(
	'likedislike' => array(
		'question' => 'optin-survey-question-likedislike',
		'type' => 'textarea' ),
	'whyoptout' => array(
		'question' => 'optin-survey-question-whyoptout',
		'type' => 'checkboxes',
		'answers' => array(
			'hard' => 'optin-survey-answer-whyoptout-hard',
			'didntwork' => 'optin-survey-answer-whyoptout-didntwork',
			'notpredictable' => 'optin-survey-answer-whyoptout-notpredictable',
			'look' => 'optin-survey-answer-whyoptout-didntlike-look',
			'layout' => 'optin-survey-answer-whyoptout-didntlike-layout',
			'toolbar' => 'optin-survey-answer-whyoptout-didntlike-toolbar' ),
		'other' => 'optin-survey-answer-whyoptout-other' ),
	'explainwhyoptout' => array(
		'question' => 'optin-survey-question-explain',
		'type' => 'textarea' ),
	'techfail' => array(
		'question' => 'optin-survey-question-techfail',
		'type' => 'yesno',
		'ifyes' => 'optin-survey-question-techfail-ifyes' ),
	'usedtoolbar' => array(
		'question' => 'optin-survey-question-usedtoolbar',
		'type' => 'yesno',
		'ifyes' => 'optin-survey-question-usedtoolbar-ifyes' ),
	'different' => array(
		'question' => 'optin-survey-question-different',
		'type' => 'textarea' ),
	'feedback' => array(
		'question' => 'optin-survey-question-feedback',
		'type' => 'textarea' ),
	'browser' => array(
		'question' => 'optin-survey-question-browser',
		'type' => 'dropdown',
		'answers' => array(
			'ie5' => 'optin-survey-answer-browser-ie5',
			'ie6' => 'optin-survey-answer-browser-ie6',
			'ie7' => 'optin-survey-answer-browser-ie7',
			'ie8' => 'optin-survey-answer-browser-ie8',
			'ff1' => 'optin-survey-answer-browser-ff1',
			'ff2' => 'optin-survey-answer-browser-ff2',
			'ff3'=> 'optin-survey-answer-browser-ff3',
			'cb' => 'optin-survey-answer-browser-cb',
			'c1' => 'optin-survey-answer-browser-c1',
			'c2' => 'optin-survey-answer-browser-c2',
			's3' => 'optin-survey-answer-browser-s3',
			's4' => 'optin-survey-answer-browser-s4',
			'o9' => 'optin-survey-answer-browser-o9',
			'o9.5' => 'optin-survey-answer-browser-o9.5',
			'o10' => 'optin-survey-answer-browser-o10' ),
		'other' => 'optin-survey-answer-browser-other' ),
	'os' => array(
		'question' => 'optin-survey-question-os',
		'type' => 'dropdown',
		'answers' => array(
			'windows' => 'optin-survey-answer-os-windows',
			'windowsmobile' => 'optin-survey-answer-os-windowsmobile',
			'macos' => 'optin-survey-answer-os-macos',
			'iphoneos' => 'optin-survey-answer-os-iphoneos',
			'linux' => 'optin-survey-answer-os-linux' ),
		'other' => 'optin-survey-answer-os-other' ),
	'res' => array(
		'question' => 'optin-survey-question-res',
		'type' => 'resolution' ),
);

$wgOptInFeedBackSurvey = $wgOptInSurvey;
unset( $wgOptInFeedBackSurvey['whyoptout'] );
unset( $wgOptInFeedBackSurvey['explainwhyoptout'] );
unset( $wgOptInFeedBackSurvey['different'] );
$wgOptInFeedBackSurvey['usedtoolbar']['ifno'] = 'optin-survey-question-usedtoolbar-ifno';
$wgOptInFeedBackSurvey['changes'] = array(
	'question' => 'optin-survey-question-changes',
	'type' => 'checkboxes',
	'answers' => array(
		'nav' => 'optin-survey-answer-changes-nav',
		'edittools' => 'optin-survey-answer-changes-edittools',
		'upload' => 'optin-survey-answer-changes-upload',
		'richtext' => 'optin-survey-answer-changes-richtext',
		'lookfeel' => 'optin-survey-answer-changes-lookfeel',
		'predictability' => 'optin-survey-answer-changes-predictability',
		'custom' => 'optin-survey-answer-changes-custom' ),
	'other' => 'optin-survey-answer-changes-other'
);
$wgOptInBrowserSurvey = array(
	'browser' => $wgOptInSurvey['browser'],
	'os' => $wgOptInSurvey['os'],
	'res' => $wgOptInSurvey['res']
);

/* Setup */

// Credits
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'OptIn',
	'author' => 'Roan Kattouw',
	'version' => '0.1.2',
	'url' => 'http://www.mediawiki.org/wiki/Extension:UsabilityInitiative',
	'descriptionmsg' => 'optin-desc',
);

// Includes parent extension
require_once( dirname( dirname( __FILE__ ) ) . "/UsabilityInitiative.php" );

// Adds Autoload Classes
$wgAutoloadClasses['SpecialOptIn'] =
	dirname( __FILE__ ) . '/SpecialOptIn.php';
$wgAutoloadClasses['OptInHooks'] =
	dirname( __FILE__ ) . '/OptIn.hooks.php';

// Adds Internationalized Messages
$wgExtensionMessagesFiles['OptInLink'] =
	dirname( __FILE__ ) . '/OptInLink.i18n.php';
$wgExtensionMessagesFiles['OptIn'] =
	dirname( __FILE__ ) . '/OptIn.i18n.php';
$wgExtensionAliasesFiles['OptIn'] =
	dirname( __FILE__ ) . '/OptIn.alias.php';

$wgSpecialPages['OptIn'] = 'SpecialOptIn';
$wgSpecialPageGroups['OptIn'] = 'wiki';

$wgHooks['LoadExtensionSchemaUpdates'][] = 'OptInHooks::schema';

$wgHooks['PersonalUrls'][] = 'OptInHooks::personalUrls';
