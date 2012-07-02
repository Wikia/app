<?php
/**
 * Translations of the namespaces introduced by SocialProfile.
 *
 * @file
 */

$namespaceNames = array();

// For wikis where the SocialProfile extension is not installed.
if( !defined( 'NS_USER_WIKI' ) ) {
	define( 'NS_USER_WIKI', 200 );
}

if( !defined( 'NS_USER_WIKI_TALK' ) ) {
	define( 'NS_USER_WIKI_TALK', 201 );
}

if( !defined( 'NS_USER_PROFILE' ) ) {
	define( 'NS_USER_PROFILE', 202 );
}

if( !defined( 'NS_USER_PROFILE_TALK' ) ) {
	define( 'NS_USER_PROFILE_TALK', 203 );
}

/** English */
$namespaceNames['en'] = array(
	NS_USER_WIKI => 'UserWiki',
	NS_USER_WIKI_TALK => 'UserWiki_talk',
	NS_USER_PROFILE => 'User_profile',
	NS_USER_PROFILE_TALK => 'User_profile_talk',
);

/** Finnish (Suomi) */
$namespaceNames['fi'] = array(
	NS_USER_WIKI => 'Käyttäjäwiki',
	NS_USER_WIKI_TALK => 'Keskustelu_käyttäjäwikistä',
	NS_USER_PROFILE => 'Käyttäjäprofiili',
	NS_USER_PROFILE_TALK => 'Keskustelu_käyttäjäprofiilista',
);