<?php

/**
 * Initialization file for the Contest extension.
 *
 * Documentation:	 		https://www.mediawiki.org/wiki/Extension:Contest
 * Support					https://www.mediawiki.org/wiki/Extension_talk:Contest
 * Source code:			    http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/Contest
 *
 * @file Contest.php
 * @ingroup Contest
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

/**
 * This documentation group collects source code files belonging to Contest.
 *
 * @defgroup Contest Contest
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

if ( version_compare( $wgVersion, '1.18c', '<' ) ) { // Needs to be 1.18c because version_compare() works in confusing ways
	die( '<b>Error:</b> Contest requires MediaWiki 1.18 or above.' );
}

define( 'CONTEST_VERSION', '0.2 alpha' );

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Contest',
	'version' => CONTEST_VERSION,
	'author' => array(
		'[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]',
	),
	'url' => 'https://www.mediawiki.org/wiki/Extension:Contest',
	'descriptionmsg' => 'contest-desc'
);

// i18n
$wgExtensionMessagesFiles['Contest'] 			= dirname( __FILE__ ) . '/Contest.i18n.php';
$wgExtensionMessagesFiles['ContestAlias']		= dirname( __FILE__ ) . '/Contest.alias.php';

// Autoloading
$wgAutoloadClasses['ContestHooks'] 				= dirname( __FILE__ ) . '/Contest.hooks.php';
$wgAutoloadClasses['ContestSettings'] 			= dirname( __FILE__ ) . '/Contest.settings.php';

$wgAutoloadClasses['ApiContestQuery'] 			= dirname( __FILE__ ) . '/api/ApiContestQuery.php';
$wgAutoloadClasses['ApiDeleteContest'] 			= dirname( __FILE__ ) . '/api/ApiDeleteContest.php';
$wgAutoloadClasses['ApiMailContestants'] 		= dirname( __FILE__ ) . '/api/ApiMailContestants.php';
$wgAutoloadClasses['ApiQueryChallenges'] 		= dirname( __FILE__ ) . '/api/ApiQueryChallenges.php';
$wgAutoloadClasses['ApiQueryContestants'] 		= dirname( __FILE__ ) . '/api/ApiQueryContestants.php';
$wgAutoloadClasses['ApiQueryContestComments'] 	= dirname( __FILE__ ) . '/api/ApiQueryContestComments.php';
$wgAutoloadClasses['ApiQueryContests'] 			= dirname( __FILE__ ) . '/api/ApiQueryContests.php';

$wgAutoloadClasses['Contest'] 					= dirname( __FILE__ ) . '/includes/Contest.class.php';
$wgAutoloadClasses['ContestantPager'] 			= dirname( __FILE__ ) . '/includes/ContestantPager.php';
$wgAutoloadClasses['ContestChallenge'] 			= dirname( __FILE__ ) . '/includes/ContestChallenge.php';
$wgAutoloadClasses['ContestComment'] 			= dirname( __FILE__ ) . '/includes/ContestComment.php';
$wgAutoloadClasses['ContestContestant'] 		= dirname( __FILE__ ) . '/includes/ContestContestant.php';
$wgAutoloadClasses['ContestDBObject'] 			= dirname( __FILE__ ) . '/includes/ContestDBObject.php';
$wgAutoloadClasses['ContestReminderJob'] 		= dirname( __FILE__ ) . '/includes/ContestReminderJob.php';
$wgAutoloadClasses['ContestUtils'] 				= dirname( __FILE__ ) . '/includes/ContestUtils.php';
$wgAutoloadClasses['ContestVote'] 				= dirname( __FILE__ ) . '/includes/ContestVote.php';

$wgAutoloadClasses['SpecialContest'] 			= dirname( __FILE__ ) . '/specials/SpecialContest.php';
$wgAutoloadClasses['SpecialContestant'] 		= dirname( __FILE__ ) . '/specials/SpecialContestant.php';
$wgAutoloadClasses['SpecialContestPage'] 		= dirname( __FILE__ ) . '/specials/SpecialContestPage.php';
$wgAutoloadClasses['SpecialContests'] 			= dirname( __FILE__ ) . '/specials/SpecialContests.php';
$wgAutoloadClasses['SpecialContestSignup'] 		= dirname( __FILE__ ) . '/specials/SpecialContestSignup.php';
$wgAutoloadClasses['SpecialContestWelcome'] 	= dirname( __FILE__ ) . '/specials/SpecialContestWelcome.php';
$wgAutoloadClasses['SpecialEditContest'] 		= dirname( __FILE__ ) . '/specials/SpecialEditContest.php';
$wgAutoloadClasses['SpecialMyContests'] 		= dirname( __FILE__ ) . '/specials/SpecialMyContests.php';

// Special pages
$wgSpecialPages['Contest'] 						= 'SpecialContest';
$wgSpecialPages['Contestant'] 					= 'SpecialContestant';
$wgSpecialPages['Contests'] 					= 'SpecialContests';
$wgSpecialPages['ContestSignup'] 				= 'SpecialContestSignup';
$wgSpecialPages['ContestWelcome'] 				= 'SpecialContestWelcome';
$wgSpecialPages['EditContest'] 					= 'SpecialEditContest';
$wgSpecialPages['MyContests'] 					= 'SpecialMyContests';

$wgSpecialPageGroups['Contest'] 				= 'contest';
$wgSpecialPageGroups['Contestant'] 				= 'contest';
$wgSpecialPageGroups['Contests'] 				= 'contest';
$wgSpecialPageGroups['ContestSignup'] 			= 'contest';
$wgSpecialPageGroups['ContestWelcome'] 			= 'contest';
$wgSpecialPageGroups['EditContest'] 			= 'contest';
$wgSpecialPageGroups['MyContests'] 				= 'contest';

// API
$wgAPIModules['deletecontest'] 					= 'ApiDeleteContest';
$wgAPIModules['mailcontestants'] 				= 'ApiMailContestants';
$wgAPIListModules['challenges'] 				= 'ApiQueryChallenges';
$wgAPIListModules['contestants'] 				= 'ApiQueryContestants';
$wgAPIListModules['contestcomments'] 			= 'ApiQueryContestComments';
$wgAPIListModules['contests'] 					= 'ApiQueryContests';

// Jobs
$wgJobClasses['ContestReminderJob'] 			= 'ContestReminderJob';

// Hooks
$wgHooks['LoadExtensionSchemaUpdates'][] 		= 'ContestHooks::onSchemaUpdate';
$wgHooks['UnitTestsList'][] 					= 'ContestHooks::registerUnitTests';
$wgHooks['UserSetEmail'][] 						= 'ContestHooks::onUserSetEmail';
$wgHooks['PersonalUrls'][] 						= 'ContestHooks::onPersonalUrls';
$wgHooks['GetPreferences'][] 					= 'ContestHooks::onGetPreferences';
$wgHooks['LinkEnd'][] 							= 'ContestHooks::onLinkEnd';

// Rights
$wgAvailableRights[] = 'contestadmin';
$wgAvailableRights[] = 'contestant';
$wgAvailableRights[] = 'contestjudge';

# Users that can manage the contests.
$wgGroupPermissions['*'            ]['contestadmin'] = false;
//$wgGroupPermissions['user'         ]['contestadmin'] = false;
//$wgGroupPermissions['autoconfirmed']['contestadmin'] = false;
//$wgGroupPermissions['bot'          ]['contestadmin'] = false;
$wgGroupPermissions['sysop'        ]['contestadmin'] = true;
$wgGroupPermissions['contestadmin' ]['contestadmin'] = true;

# Users that can be contest participants.
$wgGroupPermissions['*'            ]['contestant'] = false;
$wgGroupPermissions['user'         ]['contestant'] = true;
//$wgGroupPermissions['autoconfirmed']['contestant'] = true;
//$wgGroupPermissions['bot'          ]['contestant'] = false;
$wgGroupPermissions['sysop'        ]['contestant'] = true;
$wgGroupPermissions['contestant']['contestant'] = true;

# Users that can vote and comment on submissions.
$wgGroupPermissions['*'            ]['contestjudge'] = false;
//$wgGroupPermissions['user'         ]['contestjudge'] = false;
//$wgGroupPermissions['autoconfirmed']['contestjudge'] = false;
//$wgGroupPermissions['bot'          ]['contestjudge'] = false;
$wgGroupPermissions['sysop'        ]['contestjudge'] = true;
$wgGroupPermissions['contestjudge' ]['contestjudge'] = true;


// Resource loader modules
$moduleTemplate = array(
	'localBasePath' => dirname( __FILE__ ) . '/resources',
	'remoteExtPath' => 'Contest/resources'
);

$wgResourceModules['contest.special.contests'] = $moduleTemplate + array(
	'scripts' => array(
		'contest.special.contests.js'
	),
	'messages' => array(
		'contest-special-confirm-delete',
		'contest-special-delete-failed',
	)
);

$wgResourceModules['contest.special.contest'] = $moduleTemplate + array(
	'scripts' => array(
		'contest.special.contest.js'
	),
	'messages' => array(
		'contest-contest-reminder-title',
		'contest-contest-reminder-cancel',
		'contest-contest-reminder-send',
		'contest-contest-reminder-preview',
		'contest-contest-reminder-sending',
		'contest-contest-reminder-success',
		'contest-contest-reminder-close',
		'contest-contest-reminder-retry',
		'contest-contest-reminder-failed',
		'contest-contest-reminder-subject',
	),
	'dependencies' => array(
		'jquery.ui.button', 'jquery.ui.dialog', 'mediawiki.jqueryMsg',
	)
);

$wgResourceModules['jquery.ui.timepicker'] = $moduleTemplate + array(
	'scripts' => array(
		'jquery.ui.timepicker.js',
	),
	'styles' => array(
		'jquery.ui.timepicker.css',
	),
	'dependencies' => array(
		'jquery.ui.slider',
		'jquery.ui.datepicker'
	)
);

$wgResourceModules['contest.special.editcontest'] = $moduleTemplate + array(
	'scripts' => array(
		'contest.special.editcontest.js',
	),
	'messages' => array(
		'contest-edit-delete',
		'contest-edit-add-first',
		'contest-edit-add-another',
		'contest-edit-confirm-delete',
		'contest-edit-challenge-title',
		'contest-edit-challenge-text',
		'contest-edit-challenge-oneline',
	),
	'dependencies' => array(
		'jquery.ui.button',
		'jquery.ui.timepicker'
	)
);

$wgResourceModules['jquery.contestChallenges'] = $moduleTemplate + array(
	'scripts' => array(
		'jquery.contestChallenges.js'
	),
	'messages' => array(
		'contest-welcome-accept-challenge'
	),
	'dependencies' => array(
		'jquery.ui.button'
	)
);

$wgResourceModules['contest.special.welcome'] = $moduleTemplate + array(
	'scripts' => array(
		'contest.special.welcome.js'
	),
	'styles' => array(
		'contest.special.welcome.css',
	),
	'dependencies' => array(
		'jquery.contestChallenges', 'jquery.fancybox',
	),
	'messages' => array(
		'contest-welcome-select-header'
	)
);

$wgResourceModules['contest.special.signup'] = $moduleTemplate + array(
	'scripts' => array(
		'contest.special.signup.js',
	),
	'dependencies' => array(
		'jquery.ui.button', 'jquery.fancybox', 'jquery.contestEmail',
	),
);

$wgResourceModules['contest.special.submission'] = $moduleTemplate + array(
	'scripts' => array(
		'contest.special.submission.js',
	),
	'dependencies' => array(
		'jquery.ui.button', 'jquery.contestSubmission', 'jquery.contestEmail'
	),
);

$wgResourceModules['jquery.contestEmail'] = $moduleTemplate + array(
	'scripts' => array(
		'jquery.contestEmail.js',
	),
	'messages' => array(
		'contest-signup-emailwarn',
	),
);

$wgResourceModules['jquery.contestSubmission'] = $moduleTemplate + array(
	'scripts' => array(
		'jquery.contestSubmission.js',
	),
	'messages' => array(
		'contest-submission-new-submission',
		'contest-submission-current-submission',
		'contest-submission-domains',
	)
);

$wgResourceModules['contest.special.contestant'] = $moduleTemplate + array(
	'styles' => array(
		'contest.special.contestant.css',
	),
);

$wgResourceModules['jquery.fancybox'] = $moduleTemplate + array(
	'scripts' => array(
		'fancybox/jquery.fancybox-1.3.4.js',
	),
	'styles' => array(
		'fancybox/jquery.fancybox-1.3.4.css'
	),
);

unset( $moduleTemplate );

$egContestSettings = array();

$wgContestEmailParse = false;
