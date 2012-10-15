<?php
/**
 * PrefSwitch extension
 * 
 * @file
 * @ingroup Extensions
 * 
 * @author Roan Kattouw <roan.kattouw@gmail.com>
 * @author Trevor Parscal <tparscal@wikimedia.org>
 * @license GPL v2 or later
 * @version 0.2.0
 */

/* Configuration */

$wgPrefSwitchStyleVersion = 1;

// Set this to true to show the "New features" link in the top bar
$wgPrefSwitchShowLinks = false;

// Preferences to set when users switch prefs
$wgPrefSwitchPrefs = array(
	'off' => array(
	    'skin' => 'monobook',
	    'usebetatoolbar' => 0,
	    'usebetatoolbar-cgd' => 0,
	),
	'on' =>  array(
	    'skin' => 'vector',
	    'usebetatoolbar' => 1,
	    'usebetatoolbar-cgd' => 1,
	),
);

// Allow global opt-outs. Depends on CentralAuth
$wgPrefSwitchGlobalOptOut = false;

// Survey questions to ask when users switch prefs
$wgPrefSwitchSurveys = array();
$wgPrefSwitchSurveys['feedback'] = array(
	'submit-msg' => 'prefswitch-survey-submit-feedback',
	'updatable' => true,
	'questions' => array(
		'like' => array(
			'question' => 'prefswitch-survey-question-like',
			'type' => 'text',
		),
		'dislike' => array(
			'question' => 'prefswitch-survey-question-dislike',
			'type' => 'text',
		),
	),
);
$wgPrefSwitchSurveys['off'] = array(
	'submit-msg' => 'prefswitch-survey-submit-off',
	'updatable' => false,
	'questions' => array_merge(
		$wgPrefSwitchSurveys['feedback']['questions'],
		array(
			'whyrevert' => array(
				'question' => 'prefswitch-survey-question-whyoff',
				'type' => 'checks',
				'answers' => array(
					'hard' => 'prefswitch-survey-answer-whyoff-hard',
					'didntwork' => 'prefswitch-survey-answer-whyoff-didntwork',
					'notpredictable' => 'prefswitch-survey-answer-whyoff-notpredictable',
					'look' => 'prefswitch-survey-answer-whyoff-didntlike-look',
					'layout' => 'prefswitch-survey-answer-whyoff-didntlike-layout',
					'toolbar' => 'prefswitch-survey-answer-whyoff-didntlike-toolbar',
				),
				'other' => 'prefswitch-survey-answer-whyoff-other',
			),
		)
	),
);
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
			'ff4' => 'prefswitch-survey-answer-browser-ff4',
			'cb' => 'prefswitch-survey-answer-browser-cb',
			'cd' => 'prefswitch-survey-answer-browser-cd',
			'c1' => 'prefswitch-survey-answer-browser-c1',
			'c2' => 'prefswitch-survey-answer-browser-c2',
			'c3' => 'prefswitch-survey-answer-browser-c3',
			'c4' => 'prefswitch-survey-answer-browser-c4',
			'c5' => 'prefswitch-survey-answer-browser-c5',
			'c6' => 'prefswitch-survey-answer-browser-c6',
			'c7' => 'prefswitch-survey-answer-browser-c7',
			'c8' => 'prefswitch-survey-answer-browser-c8',
			'c9' => 'prefswitch-survey-answer-browser-c9',
			'c10' => 'prefswitch-survey-answer-browser-c10',
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

// Question for global opt out
$wgPrefSwitchSurveys['off']['questions']['global'] = array(
	'question' => 'prefswitch-survey-question-globaloff',
	'type' => 'checks',
	'answers' => array(
		'yes' => 'prefswitch-survey-answer-globaloff-yes',
	),
);

/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'PrefSwitch',
	'author' => array( 'Trevor Parscal', 'Roan Kattouw' ),
	'version' => '0.1.2',
	'url' => 'https://www.mediawiki.org/wiki/Extension:UsabilityInitiative',
	'descriptionmsg' => 'prefswitch-desc',
);
$wgAutoloadClasses = array_merge(
	$wgAutoloadClasses,
	array(
		'SpecialPrefSwitch' => dirname( __FILE__ ) . '/SpecialPrefSwitch.php',
		'PrefSwitchHooks' => dirname( __FILE__ ) . '/PrefSwitch.hooks.php',
		'PrefSwitchSurvey' => dirname( __FILE__ ) . '/PrefSwitch.classes.php',
		'PrefSwitchSurveyField' => dirname( __FILE__ ) . '/PrefSwitch.classes.php',
		'PrefSwitchSurveyFieldSelect' => dirname( __FILE__ ) . '/PrefSwitch.classes.php',
		'PrefSwitchSurveyFieldRadios' => dirname( __FILE__ ) . '/PrefSwitch.classes.php',
		'PrefSwitchSurveyFieldChecks' => dirname( __FILE__ ) . '/PrefSwitch.classes.php',
		'PrefSwitchSurveyFieldBoolean' => dirname( __FILE__ ) . '/PrefSwitch.classes.php',
		'PrefSwitchSurveyFieldDimensions' => dirname( __FILE__ ) . '/PrefSwitch.classes.php',
		'PrefSwitchSurveyFieldText' => dirname( __FILE__ ) . '/PrefSwitch.classes.php',
	)
);
$wgExtensionMessagesFiles['PrefSwitch'] = dirname( __FILE__ ) . '/PrefSwitch.i18n.php';
$wgExtensionMessagesFiles['PrefSwitchAlias'] = dirname( __FILE__ ) . '/PrefSwitch.alias.php';
$wgSpecialPages['PrefSwitch'] = 'SpecialPrefSwitch';
$wgSpecialPageGroups['PrefSwitch'] = 'wiki';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'PrefSwitchHooks::loadExtensionSchemaUpdates';
$wgHooks['PersonalUrls'][] = 'PrefSwitchHooks::personalUrls';

$wgResourceModules['ext.prefSwitch'] = array(
	'scripts' => 'ext.prefSwitch.js',
	'styles' => 'ext.prefSwitch.css',
	'dependencies' => 'jquery.client',
	'localBasePath' => dirname( __FILE__ ) . '/modules',
	'remoteExtPath' => 'PrefSwitch/modules',
);

