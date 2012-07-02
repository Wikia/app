<?php

/**
 * Adapted form of the MultiLang extension from Arnomane
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */
 
if( !defined( 'MEDIAWIKI' ) ) {
	die;
}

$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'Multilang',
	'author'         => '',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Multilang',
);

$wgAutoloadClasses['Multilang'] = dirname( __FILE__ ) . '/Multilang.class.php';

$wgHooks['ParserClearState'][] = 'Multilang::clearState';
$wgHooks['ParserFirstCallInit'][] = 'Multilang::onParserFirstCallInit';
