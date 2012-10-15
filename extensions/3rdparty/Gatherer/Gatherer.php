<?php

/**
 * Gatherer extension for mtg.wikia.com
 * Grabs card images from the Gatherer database and uploads them locally with good names
 * Then, uses data from the Gatherer database to fill out the Cardpage template, the Gallery page, and the Rulings page
 * Finally, saves the three pages to the database and redirects the user to the card page
 *
 * Copyright (c) 2009 Ryan Schmidt
 * Licensed under the GNU General Public License
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 1 );
}

$wgExtensionCredits['other'][] = array(
	'name' => 'Gatherer',
	'description' => 'Creates a new card page based on info from Wizard of the Coast\'s Gatherer database',
	'version' => '1.0 beta',
	'author' => '[[User:Skizzerz|Ryan Schmidt (Skizzerz)]]',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['Gatherer'] = $dir . 'Gatherer.i18n.php';
$wgAutoloadClasses['Gatherer'] = $dir . 'Gatherer_body.php';
$wgSpecialPages['Gatherer'] = 'Gatherer';

if( !defined( 'NS_FILE' ) ) {
	define( 'NS_FILE', NS_IMAGE );
}