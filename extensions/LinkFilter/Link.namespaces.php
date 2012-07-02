<?php
/**
 * Translations of the Link namespace.
 *
 * @file
 */

$namespaceNames = array();

// For wikis where the LinkFilter extension is not installed.
if( !defined( 'NS_LINK' ) ) {
	define( 'NS_LINK', 700 );
}

if( !defined( 'NS_LINK_TALK' ) ) {
	define( 'NS_LINK_TALK', 701 );
}

/** English */
$namespaceNames['en'] = array(
	NS_LINK => 'Link',
	NS_LINK_TALK => 'Link_talk',
);

/** Finnish (Suomi) */
$namespaceNames['fi'] = array(
	NS_LINK => 'Linkki',
	NS_LINK_TALK => 'Keskustelu_linkistä',
);

/** Dutch (Nederlands) */
$namespaceNames['nl'] = array(
	NS_LINK => 'Link',
	NS_LINK_TALK => 'Overleg_link',
);