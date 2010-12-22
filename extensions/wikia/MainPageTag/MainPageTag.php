<?php
/**test
 * @author Christian Williams
 * This extension provides parser tags to properly render the main column layout for mainpages. One column requires two div elements, so two div elements have been added to all.
*/
if( !defined( 'MEDIAWIKI' ) ) {
	die( 1 );
}

$wgHooks['ParserFirstCallInit'][] = 'wfMainPageTag';
$wfMainPageTag_rcs_called = false;
$wfMainPageTag_lcs_called = false;

function wfMainPageTag( &$parser ) {
	$parser->setHook( 'mainpage-rightcolumn-start', 'wfMainPageTag_rcs' );
	$parser->setHook( 'mainpage-leftcolumn-start', 'wfMainPageTag_lcs' );
	$parser->setHook( 'mainpage-endcolumn', 'wfMainPageTag_ec' );
	return true;
}

function wfMainPageTag_rcs( $input, $args, $parser ) {
	global $wfMainPageTag_rcs_called, $wfMainPageTag_lcs_called;
	if(!$wfMainPageTag_lcs_called) {
		$wfMainPageTag_rcs_called = true;
	}
	$html = '<div class="main-page-tag-rcs" style="position: relative; width: 300px; float: right; clear: right;"><div>';
	return $html;
}

function wfMainPageTag_lcs( $input, $args, $parser ) {
	global $wfMainPageTag_rcs_called, $wfMainPageTag_lcs_called;
	$wfMainPageTag_lcs_called = true;

	if(!isset($args['gutter'])) {
		$args['gutter'] = '10';
	}

	$args['gutter'] = str_replace('px', '', $args['gutter']);
	
	$tagClass = 'class="main-page-tag-lcs"';
	
	if($wfMainPageTag_rcs_called) {
		$html = '<div ' . $tagClass . ' style="overflow: hidden; height: 1%; padding-right: '. $args['gutter'] .'px"><div>';
	} else {
		$gutter = 300 + $args['gutter'];
		$html = '<div ' . $tagClass . ' style="float: left; margin-right: -'. $gutter .'px; width: 100%; position: relative;"><div style="margin-right: '. $gutter .'px;">';
	}
	return $html;
}

function wfMainPageTag_ec( $input, $args, $parser ) {
	$html = '</div></div>';
	return $html;
}
