<?php
/**
 * GlobalWatchlist extension - sending weekly digest email witch watchlisted pages on all wikis
 *
 * !IMPORTANT! see GlobalWatchlist.sql file for db schema !IMPORTANT!
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 *
 */

if (!defined('MEDIAWIKI')) {
	echo("This file is an extension to the MediaWiki software and cannot be used standalone.\n");
	exit(1) ;
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'GlobalWatchlist',
	'author' => '[http://www.wikia.com/wiki/User:Adi3ek Adrian \'ADi\' Wieczorek]',
	'description' => 'Sending weekly digest email witch watchlisted pages on all wikis'
);

// configuration
$wgGlobalWatchlistMaxDigestedArticlesPerWiki = 50;

// message file
$wgExtensionMessagesFiles['GlobalWatchlist'] = dirname(__FILE__) . '/GlobalWatchlist.i18n.php';

// classes
$wgAutoloadClasses['GlobalWatchlistBot'] = dirname(__FILE__) . '/GlobalWatchlistBot.class.php';

// hooks
$wgHooks['getWatchlistPreferencesCustomHtml'][] = 'wfGlobalWatchlistPrefsCustomHtml';
$wgHooks['getUserProfilePreferencesCustomEmailToggles'][] = 'wfGlobalWatchlistPrefsEmailToggle';

// user toggles
$wgHooks['UserToggles'][] = 'wfGlobalWatchlistToggle';
//$wgHooks['WatchArticleComplete'][] = 'wfGlobalWatchArticleComplete';
//$wgHooks['UnwatchArticleComplete'][] = 'wfGlobalUnwatchArticleComplete';

function wfGlobalWatchlistToggle($extraToggles) {
	$extraToggles['watchlistdigest'] = 'watchlistdigest';
	$extraToggles['watchlistdigestclear'] = 'watchlistdigestclear';
	return true;
}

function wfGlobalWatchlistPrefsCustomHtml($prefsForm) {
	global $wgOut, $wgUser, $wgSharedDB;

	$dbr = wfGetDB(DB_SLAVE);
	$oResource = $dbr->query("SELECT count(*) AS count FROM $wgSharedDB.global_watchlist WHERE gwa_user_id='" . $wgUser->getID() . "'");
	$oResultRow = $dbr->fetchObject($oResource);

	if($oResultRow->count) {
		// only for staff members at the moment
		wfLoadExtensionMessages('GlobalWatchlist');

	 $tname = 'watchlistdigestclear';
	 $prefsForm->mUsedToggles[$tname] = true;

		$wgOut->addHtml( $prefsForm->getToggle($tname) );
	}

	return true;
}

function wfGlobalWatchlistPrefsEmailToggle($prefsForm, $toggleHtml) {
	global $wgUser;

	// only for staff members at the moment
	wfLoadExtensionMessages('GlobalWatchlist');

	$tname = 'watchlistdigest';
	$prefsForm->mUsedToggles[$tname] = true;

	$toggleHtml .= $prefsForm->getToggle($tname) . '<br />';

 return true;
}

/*
function wfGlobalWatchArticleComplete($oUser, $oArticle) {
	global $wgSharedDB, $wgCityId;

	echo "<pre>";
	//echo $oArticle->getTitle()->getNamespace();
	echo $oArticle->getTitle()->getPrefixedURL();
	print_r($oArticle);
	exit;

	$dbw = wfGetDB(DB_MASTER);

	$dbw->query("INSERT INTO " . $wgSharedDB . ".global_watchlist (gwa_user_id, gwa_city_id, gwa_namespace, gwa_title, gwa_rev_id, gwa_timestamp) VALUES ('" . $oUser->getId() . "', '" . $wgCityId . "','" . $aPage['namespace'] . "', '" . addslashes($aPage['title']) . "', '" . $aPage['revisionId'] . "', '" . $aPage['timestamp']. "')");

	return true;
}

function wfGlobalUnwatchArticleComplete($user, $artile) {

	return true;
}
*/
