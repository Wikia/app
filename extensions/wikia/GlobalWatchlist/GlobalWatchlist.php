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
$wgHooks['getWatchlistPreferencesCustomHtml'][] = 'wfGlobalWatchlistPrefsCustomHtml';
$wgHooks['getUserProfilePreferencesCustomEmailToggles'][] = 'wfGlobalWatchlistPrefsEmailToggle';

// user toggles
$wgHooks['UserToggles'][] = 'wfGlobalWatchlistToggle';
// $wgHooks['WatchArticleComplete'][] = 'wfGlobalWatchArticleComplete';
// $wgHooks['UnwatchArticleComplete'][] = 'wfGlobalUnwatchArticleComplete';

function wfGlobalWatchlistToggle( $extraToggles ) {
	$extraToggles['watchlistdigest'] = 'watchlistdigest';
	$extraToggles['watchlistdigestclear'] = 'watchlistdigestclear';
	return true;
}

function wfGlobalWatchlistPrefsCustomHtml( $prefsForm ) {
	global $wgOut, $wgUser, $wgExternalSharedDB;

	/* Now extension is enabled for all users so I think the check is not necessary --- wladek
	// RT#48350: Spec:Prefs - Move two watchlist/followed pages options from "misc" to "followed pages"
	$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
	$oResource = $dbr->query("SELECT count(*) AS count FROM global_watchlist WHERE gwa_user_id='" . $wgUser->getID() . "'");
	$oResultRow = $dbr->fetchObject($oResource);

	if($oResultRow->count) {
		// only for staff members at the moment
	*/
		wfLoadExtensionMessages( 'GlobalWatchlist' );

		$tname = 'watchlistdigestclear';
		$prefsForm->mUsedToggles[$tname] = true;

		$wgOut->addHtml( $prefsForm->getToggle( $tname ) );
	/*
	}
	*/

	return true;
}

function wfGlobalWatchlistPrefsEmailToggle( $prefsForm, $toggleHtml ) {
	global $wgUser;

	#if user not emailconfirmed, disable this (like the others)
	$disable = $wgUser->getEmailAuthenticationTimestamp() ? false : true;

	wfLoadExtensionMessages( 'GlobalWatchlist' );

	$tname = 'watchlistdigest';
	$prefsForm->mUsedToggles[$tname] = true;

	$toggleHtml .= $prefsForm->getToggle( $tname, false, $disable ) . '<br />';

	return true;
}
