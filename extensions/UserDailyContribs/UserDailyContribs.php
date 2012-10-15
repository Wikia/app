<?php
/**
 * User Daily Contributions extension
 *
 * This extension adds a step to saving an article that incriments a counter for a user's activity in a given day.
 *
 * @file
 * @ingroup Extensions
 *
 * @author Nimish Gautam <ngautam@wikimedia.org>
 * @author Trevor Parscal <tparscal@wikimedia.org>
 * @license GPL v2 or later
 * @version 0.2.0
 */

/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'User Daily Contributions',
	'author' => array( 'Nimish Gautam', 'Trevor Parscal' ),
	'version' => '0.2.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:UsabilityInitiative',
	'descriptionmsg' => 'userdailycontribs-desc',
);
$wgAutoloadClasses['UserDailyContribsHooks'] = dirname( __FILE__ ) . '/UserDailyContribs.hooks.php';
$wgAutoloadClasses['ApiUserDailyContribs'] = dirname( __FILE__ ) . '/api/ApiUserDailyContribs.php';
$wgExtensionMessagesFiles['UserDailyContribs'] = dirname( __FILE__ ) . '/UserDailyContribs.i18n.php';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'UserDailyContribsHooks::loadExtensionSchemaUpdates';
$wgHooks['ArticleSaveComplete'][] = 'UserDailyContribsHooks::articleSaveComplete';
$wgHooks['ParserTestTables'][] = 'UserDailyContribsHooks::parserTestTables';
$wgAPIModules['userdailycontribs'] = 'ApiUserDailyContribs';

/**
 * Whether or not API calls should require
 * that the given user name exists in whatever authentication
 * is set up in $wgAuth. Note that by default, on a plain install
 * there is no authentication plugin, hence all checks for existance
 * return to false.
 * If you use CentralAuth you'd probably want to set this to true.
 */
$wgUserDailyContributionsApiCheckAuthPlugin = false;

/**
 * Get the number of revisions a user has made since a given time
 *
 * @param $fromtime: beginning timestamp
 * @param $user User: (optional) User object to get edit count for
 * @param $totime: (optional) ending timestamp
 * @return number of revsions this user has made
 */
function getUserEditCountSince( $fromtime = null, User $user = null, $totime = null ) {
	global $wgUser;

	// Fallback on current user
	if ( is_null( $user ) ) {
		$user = $wgUser;
	}

	// Round times down to a whole day, possibly letting a null value
	// pass to wfTimestamp which will give us today.
	$fromtime = gmdate( 'Y-m-d', wfTimestamp( TS_UNIX, $fromtime ) );
	$totime = gmdate( 'Y-m-d', wfTimestamp( TS_UNIX, $totime ) );

	// Query the user contribs table
	$dbr = wfGetDB( DB_SLAVE );
	$edits = $dbr->selectField(
		'user_daily_contribs',
		'SUM(contribs)',
		array(
			'user_id' => $user->getId(),
			'day >= ' . $dbr->addQuotes( $fromtime ),
			'day <= ' . $dbr->addQuotes( $totime )
		),
		__METHOD__
	);
	// Return edit count as an integer
	return is_null( $edits ) ? 0 : (integer) $edits;
}
