<?php
/**
 * Translations of the Forum namespace.
 *
 * @file
 */

$namespaceNames = array();

// For wikis where the DPLforum extension is not installed.
if( !defined( 'NS_FORUM' ) ) {
	define( 'NS_FORUM', 110 );
}

if( !defined( 'NS_FORUM_TALK' ) ) {
	define( 'NS_FORUM_TALK', 111 );
}

/** English */
$namespaceNames['en'] = array(
	NS_FORUM => 'Forum',
	NS_FORUM_TALK => 'Forum_talk',
);

/** Finnish (Suomi) */
$namespaceNames['fi'] = array(
	NS_FORUM => 'Foorumi',
	NS_FORUM_TALK => 'Keskustelu_foorumista',
);