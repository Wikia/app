<?php
/**
 * RandomWiki
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @author Maciej Błaszkowski (Marooned) <marooned@wikia-inc.com>
 * @author Owen Davis <owen@wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 * @date 2009-01-30
 * @version 1.0
 * @copyright Copyright © 2008 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension named RandomWiki.\n";
	exit (1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'RandomWiki',
	'version' => '1.0',
	'author' => array(
		"[http://www.wikia.com/wiki/User:TOR Łukasz 'TOR' Garczewski]",
		'[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
		'Owen Davis',
		'Federico "Lox" Lucignano'
	),
	'description' => 'Lets users explore a random wiki.'
);

// Set up the new special page
$dir = dirname(__FILE__) . '/';

//classes
$wgAutoloadClasses['RandomWikiHelper'] = $dir. 'RandomWikiHelper.class.php';
$wgAutoloadClasses['RandomWiki'] = $dir. 'SpecialRandomWiki_body.php';

//special oages
$wgSpecialPages['RandomWiki'] = 'RandomWiki';
$wgSpecialPageGroups['RandomWiki'] = 'redirects';

//i18n
$wgExtensionMessagesFiles['SpecialRandomWiki'] = $dir . '/SpecialRandomWiki.i18n.php';
