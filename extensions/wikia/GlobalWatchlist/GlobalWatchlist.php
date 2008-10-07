<?php
/**
 * GlobalWatchlist extension
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

// message file
$wgExtensionMessagesFiles['GlobalWatchlist'] = dirname(__FILE__) . '/GlobalWatchlist.i18n.php';

// classes
$wgAutoloadClasses['GlobalWatchlistBot'] = dirname(__FILE__) . '/GlobalWatchlistBot.class.php';

// hooks
$wgHooks['getUserProfilePreferencesCustomHtml'][] = 'wfGlobalWatchlistPrefsCustomHtml';

// user toggles
$wgHooks ['UserToggles'][] = 'wfGlobalWatchlistToggle';	

// permissions
$wgAvailableRights[] = 'globalwatchlist';
$wgGroupPermissions['staff']['globalwatchlist'] = true;

function wfGlobalWatchlistToggle($extraToggles) {
	$extraToggles['watchlistdigest'] = 'watchlistdigest';
	return true;
}

function wfGlobalWatchlistPrefsCustomHtml($prefsForm) {
	global $wgOut, $wgUser;

	if($wgUser->isAllowed('globalwatchlist')) {	
		// only for staff members at the moment
		wfLoadExtensionMessages('GlobalWatchlist');
	 
	 $tname = 'watchlistdigest';
	 $prefsForm->mUsedToggles[$tname] = true;
	 
	 $wgOut->addHTML($prefsForm->tableRow($prefsForm->getToggle($tname)));
	}
	
 return true;
}

