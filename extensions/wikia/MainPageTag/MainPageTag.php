<?php

/*
 * Enable easy column formatting for wiki mainpages
 *
 * @author Christian Williams
 */


if( !defined( 'MEDIAWIKI' ) ) {
	die( 1 );
}

$wgHooks['ParserFirstCallInit'][] = 'wfMainPageTag';
/// Set to "true" once the right column parser tag has run. Used to establish the order in which the column tags were called.
$wfMainPageTag_rcs_called = false;
/// Set to "true" once the left column parser tag has run. Used to establish the order in which the column tags were called.
$wfMainPageTag_lcs_called = false;

/**
 * Set hooks for each of the three parser tags
 * @param Parser $parser reference to MediaWiki Parser object
 */
function wfMainPageTag( &$parser ) {
	$parser->setHook( 'mainpage-rightcolumn-start', 'wfMainPageTag_rcs' );
	$parser->setHook( 'mainpage-leftcolumn-start', 'wfMainPageTag_lcs' );
	$parser->setHook( 'mainpage-endcolumn', 'wfMainPageTag_ec' );
	return true;
}

/**
 * Inserts the necessary HTML to start the right column
 *
 * @param string $input Input between the <sample> and </sample> tags, or null if the tag is "closed", i.e. <sample />
 * @param array $args Tag arguments, which are entered like HTML tag attributes; this is an associative array indexed by attribute name.
 * @param Parser $parser The parent parser (a Parser object); more advanced extensions use this to obtain the contextual Title, parse wiki text, expand braces, register link relationships and dependencies, etc.
 */
function wfMainPageTag_rcs( $input, $args, $parser ) {
	global $wfMainPageTag_rcs_called, $wfMainPageTag_lcs_called, $wgOasisGrid;
	if(!$wfMainPageTag_lcs_called) {
		$wfMainPageTag_rcs_called = true;
	}
	$html = '<div class="main-page-tag-rcs'.(empty($wgOasisGrid) ? '' : ' grid-2').'"><div>';
	$html .= F::app()->renderView('Ad', 'Column');

	return $html;
}

/**
 * Inserts the necessary HTML to start the left column
 *
 * @param string $input Input between the <sample> and </sample> tags, or null if the tag is "closed", i.e. <sample />
 * @param array $args Tag arguments, which are entered like HTML tag attributes; this is an associative array indexed by attribute name.
 * @param array $parser The parent parser (a Parser object); more advanced extensions use this to obtain the contextual Title, parse wiki text, expand braces, register link relationships and dependencies, etc.
 */
function wfMainPageTag_lcs( $input, $args, $parser ) {
	global $wfMainPageTag_rcs_called, $wfMainPageTag_lcs_called, $wgOasisGrid;
	$wfMainPageTag_lcs_called = true;

	if ( !isset( $args['gutter'] ) ) {
		$args['gutter'] = '10';
	}

	$args['gutter'] = str_replace('px', '', $args['gutter']);
	$html = '<div class="main-page-tag-lcs ';
	
	if ( !empty($wgOasisGrid) ) {
		$html .= 'grid-4 alpha ';
	}

	if ( $wfMainPageTag_rcs_called ) {
		$html .= 'main-page-tag-lcs-collapsed" style="padding-right: '. $args['gutter'] .'px"><div>';
	} else {
		$gutter = 300 + $args['gutter'];
		$html .= 'main-page-tag-lcs-exploded" ';
		if ( F::app()->checkSkin( 'oasis' ) && !empty($wgOasisGrid) ) {
			$html .= '><div>';
		} else {
			$html .= 'style="margin-right: -'. $gutter .'px; "><div style="margin-right: '. $gutter .'px;">';
		}
	}
	return $html;
}

/**
 * Inserts the necessary HTML to end either left or right column
 */
function wfMainPageTag_ec( $input, $args, $parser ) {
	$html = '</div></div>';
	return $html;
}
