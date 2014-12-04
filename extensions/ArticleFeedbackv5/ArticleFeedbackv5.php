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

/* Configuration */

// How long text-based feedback is allowed to be before returning an error.
// Set to 0 to disable length checking entirely.
$wgArticleFeedbackv5MaxCommentLength =  0;

// How long to keep ratings in the squids (they will also be purged when needed)
$wgArticleFeedbackv5SMaxage = 2592000;

// Enable/disable dashboard page
$wgArticleFeedbackv5Dashboard = true;

// Number of revisions to keep a rating alive for
$wgArticleFeedbackv5RatingLifetime = 30;

// Which categories the pages must belong to have the rating widget added (with _ in text)
// Extension is "disabled" if this field is an empty array (as per default configuration)
$wgArticleFeedbackv5Categories = array( 'Article_Feedback_5' );

// Which categories the pages must not belong to have the rating widget added (with _ in text)
$wgArticleFeedbackv5BlacklistCategories = array( 'Article_Feedback_Blacklist' );

// Which category's pages can be shown on the feedback dashboard
$wgArticleFeedbackv5DashboardCategory = 'Article_Feedback_5';

// Only load the module / enable the tool in these namespaces
// Default to $wgContentNamespaces (defaults to array( NS_MAIN ) ).
$wgArticleFeedbackv5Namespaces = $wgContentNamespaces;

// Articles not categorized as one of the values in $wgArticleFeedbackv5Categories can still have the
// tool pseudo-randomly activated by applying the following odds to a lottery based on wgArticleId.
// The value can be a floating point number (percentage) in range of 0 - 100. Tenths of a percent
// are the smallest increments used.
$wgArticleFeedbackv5LotteryOdds = 0;

// This puts the JavaScript into debug mode. In debug mode, you can set your
// own bucket by passing it in the url (e.g., ?bucket=1), and the showstopper
// error mode will have a useful error message, if one exists, rather than the
// default message.
$wgArticleFeedbackv5Debug = false;

// The rating categories for bucket 5 -- these MUST match the field names in the database.
$wgArticleFeedbackv5Bucket5RatingCategories = array( 'trustworthy', 'objective', 'complete', 'wellwritten' );

// The tag names and values for bucket 2 -- these MUST match the option names in the database.
$wgArticleFeedbackv5Bucket2TagNames = array( 'suggestion', 'praise', 'problem', 'question' );

// Bucket settings for display options
$wgArticleFeedbackv5DisplayBuckets = array(
	// Users can fall into one of several display buckets (these are defined in
	// modules/jquery.articlefeedbackv5/jquery.articlefeedbackv5.js).  When a
	// user arrives at the page, this config will be used by core bucketing to
	// decide which of the available form options they see.  Whenever there's
	// an update to the available buckets, change the version number to ensure
	// the new odds are applied to everyone, not just people who have yet to be
	// placed in a bucket.
	'buckets' => array(
		'zero' => 0,
		'one' => 34,
		'two' => 33,
		'three' => 33,
		'four' => 0,
		'five' => 0,
	),
	// This version number is added to all tracking event names, so that
	// changes in the software don't corrupt the data being collected. Bump
	// this when you want to start a new "experiment".
	'version' => 0,
	// Let users be tracked for a month, and then rebucket them, allowing some
	// churn.
	'expires' => 30,
	// Track the event of users being bucketed - so we can be sure the odds
	// worked out right. [LATER - depends on UDP logging being set up]
	'tracked' => false,
);

// Bucket settings for click tracking across the plugin
$wgArticleFeedbackv5Tracking = array(
	// Not all users need to be tracked, but we do want to track some users over time - these
	// buckets are used when deciding to track someone or not, placing them in one of two buckets:
	// "ignore" or "track". When the 'version' key changes, users will be
	// re-bucketed, so you should always increment the 'version' key when changing
	// this number to ensure the new odds are applied to everyone, not just people who have yet to
	// be placed in a bucket.
	'buckets' => array(
		'ignore' => 0,
		'track'  => 100,
	),
	// This version number is added to all tracking event names, so that changes in the software
	// don't corrupt the data being collected. Bump this when you want to start a new "experiment".
	'version' => 0,
	// Let users be tracked for a month, and then rebucket them, allowing some churn
	'expires' => 30,
	// Track the event of users being bucketed - so we can be sure the odds
	// worked out right [LATER - depends on UDP logging being set up]
	'tracked' => false,
);

// Bucket settings for extra expertise checkboxes in the Option 5 feedback form
$wgArticleFeedbackv5Options = array(
	'buckets' => array(
		'show' => 100,
		'hide' => 0,
	),
	'version' => 0,
	'expires' => 30,
	'tracked' => false,
);

// Bucket settings for links to the feedback form
$wgArticleFeedbackv5LinkBuckets = array(
	// Users can fall into one of several buckets for links.  These are:
	//  -: No link; user must scroll to the bottom of the page
	//  A: After the site tagline (below the article title)
	//  B: Below the titlebar on the right
	//  C: Button fixed to right side
	//  D: Button fixed to bottom right
	//  E: Button fixed to bottom center
	//  F: Button fixed to left side
	//  G: Button below logo
	//  H: Link on each section bar
	'buckets' => array(
		'-' => 0,
		'A' => 0,
		'B' => 0,
		'C' => 0,
		'D' => 100,
		'E' => 0,
		'F' => 0,
		'G' => 0,
		'H' => 0,
	),
	// This version number is added to all tracking event names, so that
	// changes in the software don't corrupt the data being collected. Bump
	// this when you want to start a new "experiment".
	'version' => 1,
	// Let users be tracked for a month, and then rebucket them, allowing some
	// churn.
	'expires' => 30,
	// Track the event of users being bucketed - so we can be sure the odds
	// worked out right. [LATER - depends on UDP logging being set up]
	'tracked' => false
);

/**
 * Abusive threshold
 *
 * After this many users flag a comment as abusive, it is marked as such.
 *
 * @var int
 */
$wgArticleFeedbackv5AbusiveThreshold = 3;

/**
 * Hide abuse threshold
 *
 * After this many users flag a comment as abusive, it is hidden.
 *
 * @var int
 */
$wgArticleFeedbackv5HideAbuseThreshold = 5;

/**
 * Temporary hack: for now, only one CTA is allowed, so set it here.
 *
 * Allowed values: 0 (just a confirm message), 1 (call to edit), 2 (learn
 * more), or 3 (survey)
 *
 * @var int
 */
$wgArticleFeedbackv5SelectedCTA = 3;

/**
 * Turn on abuse filtering
 *
 * If this is set to true, comments will be run through:
 *   1. $wgSpamRegex, if set
 *   2. SpamBlacklist, if installed
 *   3. AbuseFilter, if installed
 *
 * @var boolean
 */
$wgArticleFeedbackv5AbuseFiltering = false;

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
$wgArticleFeedbackv5DashboardTalkPage = "//www.mediawiki.org/wiki/Talk:Article_feedback";

/**
 * The full URL for the "Learn to Edit" link
 *
 * @var string
 */
$wgArticleFeedbackv5LearnToEdit = "//en.wikipedia.org/wiki/Wikipedia:Tutorial";

/**
 * The full URL for the survey link
 *
 * @var string
 */
$wgArticleFeedbackv5SurveyUrls = array(
	'1' => 'https://www.surveymonkey.com/s/aft5-1',
	'2' => 'https://www.surveymonkey.com/s/aft5-2',
	'3' => 'https://www.surveymonkey.com/s/aft5-3',
);

// Replace default emailcapture message
$wgEmailCaptureAutoResponse['body-msg'] = 'articlefeedbackv5-emailcapture-response-body';

/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Article Feedback',
	'author' => array(
		'Greg Chiasson',
		'Reha Sterbin',
		'Sam Reed',
		'Roan Kattouw',
		'Trevor Parscal',
		'Brandon Harris',
		'Adam Miller',
		'Nimish Gautam',
		'Arthur Richards',
		'Timo Tijhof',
		'Ryan Kaldari',
	),
	'version' => '0.0.1',
	'descriptionmsg' => 'articlefeedbackv5-desc',
	'url' => '//www.mediawiki.org/wiki/Extension:ArticleFeedbackv5'
);

// Autoloading
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['ApiArticleFeedbackv5Utils']        = $dir . 'api/ApiArticleFeedbackv5Utils.php';
$wgAutoloadClasses['ApiArticleFeedbackv5']             = $dir . 'api/ApiArticleFeedbackv5.php';
$wgAutoloadClasses['ApiViewRatingsArticleFeedbackv5']  = $dir . 'api/ApiViewRatingsArticleFeedbackv5.php';
$wgAutoloadClasses['ApiViewFeedbackArticleFeedbackv5'] = $dir . 'api/ApiViewFeedbackArticleFeedbackv5.php';
$wgAutoloadClasses['ApiFlagFeedbackArticleFeedbackv5'] = $dir . 'api/ApiFlagFeedbackArticleFeedbackv5.php';
$wgAutoloadClasses['ArticleFeedbackv5Hooks']           = $dir . 'ArticleFeedbackv5.hooks.php';
$wgAutoloadClasses['SpecialArticleFeedbackv5']         = $dir . 'SpecialArticleFeedbackv5.php';
$wgExtensionMessagesFiles['ArticleFeedbackv5']         = $dir . 'ArticleFeedbackv5.i18n.php';
$wgExtensionMessagesFiles['ArticleFeedbackv5Alias']    = $dir . 'ArticleFeedbackv5.alias.php';

// Hooks
$wgHooks['LoadExtensionSchemaUpdates'][] = 'ArticleFeedbackv5Hooks::loadExtensionSchemaUpdates';
$wgHooks['ParserTestTables'][] = 'ArticleFeedbackv5Hooks::parserTestTables';
$wgHooks['BeforePageDisplay'][] = 'ArticleFeedbackv5Hooks::beforePageDisplay';
$wgHooks['ResourceLoaderRegisterModules'][] = 'ArticleFeedbackv5Hooks::resourceLoaderRegisterModules';
$wgHooks['ResourceLoaderGetConfigVars'][] = 'ArticleFeedbackv5Hooks::resourceLoaderGetConfigVars';
$wgHooks['GetPreferences'][] = 'ArticleFeedbackv5Hooks::getPreferences';
$wgHooks['EditPage::showEditForm:fields'][] = 'ArticleFeedbackv5Hooks::pushTrackingFieldsToEdit';
$wgHooks['EditPage::attemptSave'][] = 'ArticleFeedbackv5Hooks::trackEditAttempt';
$wgHooks['ArticleSaveComplete'][] = 'ArticleFeedbackv5Hooks::trackEditSuccess';

// API Registration
$wgAPIListModules['articlefeedbackv5-view-ratings']  = 'ApiViewRatingsArticleFeedbackv5';
$wgAPIListModules['articlefeedbackv5-view-feedback'] = 'ApiViewFeedbackArticleFeedbackv5';
$wgAPIModules['articlefeedbackv5-flag-feedback']     = 'ApiFlagFeedbackArticleFeedbackv5';
$wgAPIModules['articlefeedbackv5']                   = 'ApiArticleFeedbackv5';

// Special Page
$wgSpecialPages['ArticleFeedbackv5'] = 'SpecialArticleFeedbackv5';
$wgSpecialPageGroups['ArticleFeedbackv5'] = 'other';

$wgAvailableRights[] = 'aftv5-hide-feedback';
$wgAvailableRights[] = 'aftv5-delete-feedback';
$wgAvailableRights[] = 'aftv5-see-deleted-feedback';
$wgAvailableRights[] = 'aftv5-see-hidden-feedback';
