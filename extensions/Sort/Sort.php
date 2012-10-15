<?php

/**
 * Parser hook extension adds a <sort> tag to wiki markup
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence GNU General Public Licence 2.0
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 );
}

$wgAutoloadClasses['Sorter'] = dirname( __FILE__ ) . '/Sort.class.php';
$wgHooks['ParserFirstCallInit'][] = 'efSortSetHook';
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'Sort',
	'author' => 'Rob Church',
	'description' => 'Create simple sorted lists using <tt>&lt;sort&gt;</tt>',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Sort',
);

/**
 * Register hook function
 *
 * @param $parser Parser
 */
function efSortSetHook( $parser ) {
	$parser->setHook( 'sort', 'efRenderSort' );
	return true;
}

/**
 * Hook callback for <sort>
 *
 * @param string $input Input text
 * @param array $args Tag arguments
 * @param Parser $parser Parent parser
 * @return string
 */
function efRenderSort( $input, $args, &$parser ) {
	$sorter = new Sorter( $parser );
	$sorter->loadSettings( $args );
	return $sorter->sort( $input );
}

