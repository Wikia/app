<?php

$dir = dirname( __FILE__ ) . '/';

// from prefswitch in usability initiative
$prefswitchdir = dirname( dirname( __FILE__ ) ) . '/PrefSwitch';
// Horrible back for back compat with pre-r73480 installs
if ( !is_dir( $prefswitchdir ) ) {
	$prefswitchdir = dirname( dirname( __FILE__ ) ) . '/UsabilityInitiative/PrefSwitch';
}

require_once( $prefswitchdir . '/PrefSwitch.php' );

// Use this to override the URL of ext.prefSwitch.{js,css} if needed
$wgSimpleSurveyJSPath = null;
$wgSimpleSurveyCSSPath = null;

// Adds Autoload Classes
$wgAutoloadClasses['SimpleSurvey'] = $dir . 'SimpleSurvey.classes.php';
$wgAutoloadClasses['SpecialSimpleSurvey'] = $dir . 'SpecialSimpleSurvey.php';

// add special pages
$wgSpecialPages['SimpleSurvey'] = 'SpecialSimpleSurvey';
$wgSpecialPageGroups['SimpleSurvey'] = 'wiki';
$wgExtensionMessagesFiles['SimpleSurvey'] = $dir . 'SimpleSurvey.i18n.php';


$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'SimpleSurvey',
	'author' => array( 'Nimish Gautam' ),
	'version' => '0.1',
	'url' => 'https://www.mediawiki.org/wiki/Extension:UsabilityInitiative',
);

// Register database operations
$wgHooks['LoadExtensionSchemaUpdates'][] = 'SimpleSurvey::schema';

$wgValidSurveys = array();

// add surveys
require_once( $dir . 'Surveys.php' );

// Always include the browser stuff...
foreach ( $wgPrefSwitchSurveys as &$survey ) {
	$survey['questions']['browser'] = array(
		'question' => 'prefswitch-survey-question-browser',
		'type' => 'select',
		'answers' => array(
			'ie5' => 'prefswitch-survey-answer-browser-ie5',
			'ie6' => 'prefswitch-survey-answer-browser-ie6',
			'ie7' => 'prefswitch-survey-answer-browser-ie7',
			'ie8' => 'prefswitch-survey-answer-browser-ie8',
			'ie9' => 'prefswitch-survey-answer-browser-ie9',
			'ffb' => 'prefswitch-survey-answer-browser-ffb',
			'ff1' => 'prefswitch-survey-answer-browser-ff1',
			'ff2' => 'prefswitch-survey-answer-browser-ff2',
			'ff3' => 'prefswitch-survey-answer-browser-ff3',
			'cb' => 'prefswitch-survey-answer-browser-cb',
			'cd' => 'prefswitch-survey-answer-browser-cd',
			'c1' => 'prefswitch-survey-answer-browser-c1',
			'c2' => 'prefswitch-survey-answer-browser-c2',
			'c3' => 'prefswitch-survey-answer-browser-c3',
			'c4' => 'prefswitch-survey-answer-browser-c4',
			'c5' => 'prefswitch-survey-answer-browser-c5',
			's3' => 'prefswitch-survey-answer-browser-s3',
			's4' => 'prefswitch-survey-answer-browser-s4',
			's5' => 'prefswitch-survey-answer-browser-s5',
			'o9' => 'prefswitch-survey-answer-browser-o9',
			'o9.5' => 'prefswitch-survey-answer-browser-o9.5',
			'o10' => 'prefswitch-survey-answer-browser-o10',
		),
		'other' => 'prefswitch-survey-answer-browser-other',
	);
	$survey['questions']['os'] = array(
		'question' => 'prefswitch-survey-question-os',
		'type' => 'select',
		'answers' => array(
			'windows' => 'prefswitch-survey-answer-os-windows',
			'windowsmobile' => 'prefswitch-survey-answer-os-windowsmobile',
			'macos' => 'prefswitch-survey-answer-os-macos',
			'iphoneos' => 'prefswitch-survey-answer-os-iphoneos',
			'ios' => 'prefswitch-survey-answer-os-ios',
			'linux' => 'prefswitch-survey-answer-os-linux',
		),
		'other' => 'prefswitch-survey-answer-os-other',
	);
	$survey['questions']['res'] = array(
		'question' => 'prefswitch-survey-question-res',
		'type' => 'dimensions',
	);
}
unset( $survey );

