<?php
/**
 * GlobalWatchlist extension - sending weekly digest email witch watchlisted pages on all wikis
 *
 * !IMPORTANT! see GlobalWatchlist.sql file for db schema !IMPORTANT!
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 *
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'GlobalWatchlist',
	'author' => '[http://www.wikia.com/wiki/User:Adi3ek Adrian \'ADi\' Wieczorek]',
	'descriptionmsg' => 'globalwatchlist-desc',
);

// configuration
$wgGlobalWatchlistMaxDigestedArticlesPerWiki = 50;

// message file
$wgExtensionMessagesFiles['GlobalWatchlist'] = dirname( __FILE__ ) . '/GlobalWatchlist.i18n.php';

// classes
$wgAutoloadClasses['GlobalWatchlistBot'] = dirname( __FILE__ ) . '/GlobalWatchlistBot.class.php';

// hooks
$wgHooks['GetPreferences'][] = 'wfGlobalWatchlistOnGetPreferences';

function wfGlobalWatchlistOnGetPreferences($user, &$defaultPreferences) {
	global $wgUser, $wgExternalDatawareDB;

	$defaultPreferences['watchlistdigest'] = array(
		'type' => 'toggle',
		'label-message' => 'tog-watchlistdigest',
		'section' => 'watchlist/advancedwatchlist',
	);

	$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalDatawareDB);
	$oResource = $dbr->query("SELECT count(*) AS count FROM global_watchlist WHERE gwa_user_id='" . $wgUser->getID() . "'");
	$oResultRow = $dbr->fetchObject($oResource);

	if($oResultRow->count) {
		// show this toggle only when there was actaully any global watchlist sent for this user
		$defaultPreferences['watchlistdigestclear'] = array(
			'type' => 'toggle',
			'label-message' => 'tog-watchlistdigestclear',
			'section' => 'watchlist/advancedwatchlist',
		);
	}

	return true;
}
