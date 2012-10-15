<?php
/**
 * GlobalWatchlist extension - sending weekly digest email witch watchlisted pages on all wikis
 *
 * !IMPORTANT! see GlobalWatchlist.sql file for db schema !IMPORTANT!
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 * @author Piotr 'Moli' Molski <moli(at)wikia.com>
 *
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'GlobalWatchlist',
	'author' => '[http://www.wikia.com/wiki/User:Adi3ek Adrian \'ADi\' Wieczorek], [http://www.wikia.com/wiki/User:Moli.wikia Piotr Molski]',
	'descriptionmsg' => 'globalwatchlist-desc',
);

// configuration
$wgGlobalWatchlistMaxDigestedArticlesPerWiki = 50;

// message file
$wgExtensionMessagesFiles['GlobalWatchlist'] = dirname( __FILE__ ) . '/GlobalWatchlist.i18n.php';

// classes
$wgAutoloadClasses['GlobalWatchlistBot'] = dirname( __FILE__ ) . '/GlobalWatchlist.bot.php';
$wgAutoloadClasses['GlobalWatchlistHook'] = dirname( __FILE__ ) . '/GlobalWatchlist.hooks.php';

// hooks
$wgHooks[ 'GetPreferences' ][] = 'GlobalWatchlistHook::getPreferences';
$wgHooks[ 'WatchedItem::addWatch' ][] = 'GlobalWatchlistHook::addGlobalWatch';
$wgHooks[ 'WatchedItem::removeWatch' ][] = 'GlobalWatchlistHook::removeGlobalWatch';
$wgHooks[ 'WatchedItem::updateWatch' ][] = 'GlobalWatchlistHook::updateGlobalWatch';
$wgHooks[ 'WatchedItem::replaceWatch'][] = 'GlobalWatchlistHook::replaceGlobalWatch';
$wgHooks[ 'SpecialEditWatchlist::clearWatchlist'][] = 'GlobalWatchlistHook::clearGlobalWatch';
$wgHooks[ 'User::resetWatch' ][] = 'GlobalWatchlistHook::resetGlobalWatch';
