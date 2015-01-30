<?php
/**
 * GlobalWatchlist extension - sending weekly digest email witch watchlisted pages on all wikis
 *
 * !IMPORTANT! see GlobalWatchlist.sql file for db schema !IMPORTANT!
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 * @author Piotr 'Moli' Molski <moli(at)wikia.com>
 * @author James Sutterfield <james@wikia-inc.com>
 *
 */

$wgExtensionCredits['specialpage'][] = [
	'name' => 'GlobalWatchlist',
	'author' => ['[http://www.wikia.com/wiki/User:Adi3ek Adrian \'ADi\' Wieczorek]', '[http://www.wikia.com/wiki/User:Moli.wikia Piotr Molski]'],
	'descriptionmsg' => 'globalwatchlist-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/GlobalWatchlist'
];

// message file
$wgExtensionMessagesFiles['GlobalWatchlist'] = dirname( __FILE__ ) . '/GlobalWatchlist.i18n.php';

// classes
$wgAutoloadClasses['GlobalWatchlistBot'] = dirname( __FILE__ ) . '/GlobalWatchlistBot.class.php';
$wgAutoloadClasses['GlobalWatchlistHooks'] = dirname( __FILE__ ) . '/GlobalWatchlistHooks.class.php';
$wgAutoloadClasses['GlobalWatchlistTask'] = dirname( __FILE__ ) . '/GlobalWatchlistTask.class.php';

// hooks
$wgHooks[ 'GetPreferences' ][] = 'GlobalWatchlistHooks::getPreferences'; // good
$wgHooks[ 'SavePreferences' ][] = 'GlobalWatchlistHooks::savePreferences'; // good
$wgHooks[ 'WatchedItem::removeWatch' ][] = 'GlobalWatchlistHooks::removeWatcher';
$wgHooks[ 'WatchedItem::updateWatch' ][] = 'GlobalWatchlistHooks::updateGlobalWatchList';
$wgHooks[ 'WatchedItem::replaceWatch'][] = 'GlobalWatchlistHooks::renameTitleInGlobalWatchlist';
$wgHooks[ 'SpecialEditWatchlist::clearWatchlist'][] = 'GlobalWatchlistHooks::clearGlobalWatch';
$wgHooks[ 'User::resetWatch' ][] = 'GlobalWatchlistHooks::clearGlobalWatch';