<?php
/**
 * FBConnect.alias.php - FBConnect for MediaWiki
 * 
 * Special Page alias file... for when we actually define some special pages ;-)
 */


/*
 * Not a valid entry point, skip unless MEDIAWIKI is defined.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

$aliases = array();

/** English */
$aliases['en'] = array(
    'Connect'    => array( 'Connect', 'ConnectAccount' ),
);
