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
