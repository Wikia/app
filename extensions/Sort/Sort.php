<?php

/**
 * Parser hook extension adds a <sort> tag to wiki markup
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence GNU General Public Licence 2.0
 */

if( defined( 'MEDIAWIKI' ) ) {

	$wgAutoloadClasses['Sorter'] = dirname( __FILE__ ) . '/Sort.class.php';
	$wgExtensionFunctions[] = 'efSort';
	$wgExtensionCredits['parserhook'][] = array(
		'name' => 'Sort',
		'author' => 'Rob Church',
		'description' => 'Create simple sorted lists using <tt>&lt;sort&gt;</tt>',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Sort',
	);

	/**
	 * Register hook function
	 */
	function efSort() {
		global $wgParser;
		$wgParser->setHook( 'sort', 'efRenderSort' );
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

} else {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 );
}