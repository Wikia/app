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

/** Polish */
$aliases['pl'] = array(
    'Connect'    => array( 'Połącz_z_Facebookiem', 'Connect', 'ConnectAccount' ),
);

/** Spanish */
$aliases['es'] = array(
    'Connect'    => array( 'Conectar', 'Connect', 'ConnectAccount' ),
);

// begin wikia change
// VOLDEV-94, VOLDEV-97
/**
 * Korean (한국어)
 */
$aliases['ko'] = array(
    'Connect'	=> array( '연동하기' ),
);

/**
 * Vietnamese (Tiếng Việt)
 */
$aliases['vi'] = array(
    'Connect'	=> array( 'Kết_nối' ),
);
// end wikia change
