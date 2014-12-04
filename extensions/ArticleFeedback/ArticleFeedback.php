<?php
/**
 * Article Feedback extension
 * 
 * @file
 * @ingroup Extensions
 * 
 * @author Trevor Parscal <trevor@wikimedia.org>
 * @license GPL v2 or later
 * @version 0.1.0
 */

/* XXX: Survey setup */
require_once( dirname( dirname( __FILE__ ) ) . '/SimpleSurvey/SimpleSurvey.php' );

/* Configuration */

// How long to keep ratings in the squids (they will also be purged when needed)
$wgArticleFeedbackSMaxage = 2592000;

// Enable/disable dashboard page
$wgArticleFeedbackDashboard = false;

// Number of revisions to keep a rating alive for
$wgArticleFeedbackRatingLifetime = 30;

// Array of rating types
$wgArticleFeedbackRatingTypes = array( 1 => 'trustworthy', 2 => 'objective', 3 => 'complete', 4 => 'wellwritten' );

// Which categories the pages must belong to have the rating widget added (with _ in text)
// Extension is "disabled" if this field is an empty array (as per default configuration)
$wgArticleFeedbackCategories = array();

// Which categories the pages must not belong to have the rating widget added (with _ in text)
$wgArticleFeedbackBlacklistCategories = array();

// Only load the module / enable the tool in these namespaces
// Default to $wgContentNamespaces (defaults to array( NS_MAIN ) ).
$wgArticleFeedbackNamespaces = $wgContentNamespaces;

// Articles not categorized as on of the values in $wgArticleFeedbackCategories can still have the
// tool psudo-randomly activated by applying the following odds to a lottery based on $wgArticleId.
// The value can be a floating point number (percentage) in range of 0 - 100. Tenths of a percent
// are the smallest increments used.
$wgArticleFeedbackLotteryOdds = 0;

// Bucket settings for tracking users
$wgArticleFeedbackTracking = array(
	// Not all users need to be tracked, but we do want to track some users over time - these
	// buckets are used when deciding to track someone or not, placing them in one of two buckets:
	// "ignore" or "track". When $wgArticleFeedbackTrackingVersion changes, users will be
	// re-bucketed, so you should always increment $wgArticleFeedbackTrackingVersion when changing
	// this number to ensure the new odds are applied to everyone, not just people who have yet to
	// be placed in a bucket.
	'buckets' => array(
		'ignore' => 100,
		'track' => 0,
	),
	// This version number is added to all tracking event names, so that changes in the software
	// don't corrupt the data being collected. Bump this when you want to start a new "experiment".
	'version' => 0,
	// Let user's be tracked for a month, and then rebucket them, allowing some churn
	'expires' => 30,
	// Track the event of users being bucketed - so we can be sure the odds worked out right
	'tracked' => true
);

// Bucket settings for extra options in the UI
$wgArticleFeedbackOptions = array(
	'buckets' => array(
		'show' => 100,
		'hide' => 0,
	),
	'version' => 0,
	'expires' => 30,
	'tracked' => true
);

/**
 * The full URL for a discussion page about the Article Feedback Dashboard
 *
 * Since the dashboard is powered by a SpecialPage, we cannot rel on the built-in
 * MW talk page for this, so we must expose our own page - internally or externally.
 * 
 * This value will be passed into an i18n message which will parse the URL as an 
 * external link using wikitext, so this must be a full URL.
 * @var string
 */
$wgArticleFeedbackDashboardTalkPage = "http://www.mediawiki.org/wiki/Talk:Article_feedback";

// Would ordinarily call this articlefeedback but survey names are 16 chars max
$wgPrefSwitchSurveys['articlerating'] = array(
	'updatable' => false,
	'submit-msg' => 'articlefeedback-survey-submit',
	'questions' => array(
		'origin' => array(
			'visibility' => 'hidden',
			'question' => 'articlefeedback-survey-question-origin',
			'type' => 'text',
		),
		'whyrated' => array(
			'question' => 'articlefeedback-survey-question-whyrated',
			'type' => 'checks',
			'answers' => array(
				'contribute-rating' => 'articlefeedback-survey-answer-whyrated-contribute-rating',
				'development' => 'articlefeedback-survey-answer-whyrated-development',
				'contribute-wiki' => 'articlefeedback-survey-answer-whyrated-contribute-wiki',
				'sharing-opinion' => 'articlefeedback-survey-answer-whyrated-sharing-opinion',
				'didntrate' => 'articlefeedback-survey-answer-whyrated-didntrate',
			),
			'other' => 'articlefeedback-survey-answer-whyrated-other',
		),
		'useful' => array(
			'question' => 'articlefeedback-survey-question-useful',
			'type' => 'boolean',
			'iffalse' => 'articlefeedback-survey-question-useful-iffalse',
		),
		'comments' => array(
			'question' => 'articlefeedback-survey-question-comments',
			'type' => 'text',
		),
	),
);
$wgValidSurveys[] = 'articlerating';

// Replace default emailcapture message
$wgEmailCaptureAutoResponse['body-msg'] = 'articlefeedback-emailcapture-response-body';

/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Article Feedback',
	'author' => array(
		'Sam Reed',
		'Roan Kattouw',
		'Trevor Parscal',
		'Brandon Harris',
		'Adam Miller',
		'Nimish Gautam',
		'Arthur Richards',
		'Timo Tijhof',
	),
	'version' => '0.2.0',
	'descriptionmsg' => 'articlefeedback-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:ArticleFeedback'
);

// Autoloading
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['ApiQueryArticleFeedback'] = $dir . 'api/ApiQueryArticleFeedback.php';
$wgAutoloadClasses['ApiArticleFeedback'] = $dir . 'api/ApiArticleFeedback.php';
$wgAutoloadClasses['ArticleFeedbackHooks'] = $dir . 'ArticleFeedback.hooks.php';
$wgAutoloadClasses['SpecialArticleFeedback'] = $dir . 'SpecialArticleFeedback.php';
$wgExtensionMessagesFiles['ArticleFeedback'] = $dir . 'ArticleFeedback.i18n.php';
$wgExtensionMessagesFiles['ArticleFeedbackAlias'] = $dir . 'ArticleFeedback.alias.php';

// Hooks
$wgHooks['LoadExtensionSchemaUpdates'][] = 'ArticleFeedbackHooks::loadExtensionSchemaUpdates';
$wgHooks['ParserTestTables'][] = 'ArticleFeedbackHooks::parserTestTables';
$wgHooks['BeforePageDisplay'][] = 'ArticleFeedbackHooks::beforePageDisplay';
$wgHooks['ResourceLoaderRegisterModules'][] = 'ArticleFeedbackHooks::resourceLoaderRegisterModules';
$wgHooks['ResourceLoaderGetConfigVars'][] = 'ArticleFeedbackHooks::resourceLoaderGetConfigVars';
$wgHooks['GetPreferences'][] = 'ArticleFeedbackHooks::getPreferences';

// API Registration
$wgAPIListModules['articlefeedback'] = 'ApiQueryArticleFeedback';
$wgAPIModules['articlefeedback'] = 'ApiArticleFeedback';

// Special Page
$wgSpecialPages['ArticleFeedback'] = 'SpecialArticleFeedback';
$wgSpecialPageGroups['ArticleFeedback'] = 'other';
