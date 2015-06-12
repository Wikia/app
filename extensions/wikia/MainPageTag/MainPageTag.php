<?php

/*
 * Enable easy column formatting for wiki mainpages
 *
 * @author Christian Williams
 */


if( !defined( 'MEDIAWIKI' ) ) {
	die( 1 );
}

$wgExtensionCredits[ 'other' ][ ] = array(
	'name' => 'MainPageTag',
	'author' => 'Christian Williams',
	'descriptionmsg' => 'mainpagetag-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/MainPageTag',
);

//i18n
$wgExtensionMessagesFiles['MainPageTag'] = __DIR__ . '/MainPageTag.i18n.php';

$wgHooks['ParserFirstCallInit'][] = 'wfMainPageTag';

// Set to "true" once the right column parser tag has run. Used to establish the order in which the column tags were called.
$wfMainPageTag_rcs_called = false;

// Set to "true" once the left column parser tag has run. Used to establish the order in which the column tags were called.
$wfMainPageTag_lcs_called = false;

// Open tag count; Counts mainpage tag openings to avoid more closing tags than opening tags
// Note: this does not check the order of the tags
$wgMainPageTag_count = 0;


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
	global $wfMainPageTag_rcs_called, $wfMainPageTag_lcs_called, $wgMainPageTag_count;

	if ( !$wfMainPageTag_lcs_called ) {
		$wfMainPageTag_rcs_called = true;
	}

	$wgMainPageTag_count++;

	$isGridLayoutEnabled = F::app()->checkSkin( 'oasis' ) && BodyController::isGridLayoutEnabled();
	$html = '<div class="main-page-tag-rcs' . ( $isGridLayoutEnabled ? ' grid-2' : '' ) . '"><div class="rcs-container">';

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
	global $wfMainPageTag_rcs_called, $wfMainPageTag_lcs_called, $wgMainPageTag_count;

	$wfMainPageTag_lcs_called = true;
	$wgMainPageTag_count++;

	$isOasis = F::app()->checkSkin( 'oasis' );
	$isGridLayoutEnabled = $isOasis && BodyController::isGridLayoutEnabled();
	$isResponsiveLayoutEnabled = $isOasis && BodyController::isResponsiveLayoutEnabled();
	$areBreakpointsLayoutEnabled = $isOasis && BodyController::isOasisBreakpoints();
	$gutter = isset( $args['gutter'] ) ? str_replace( 'px', '', $args['gutter'] ) : 10;

	$html = '<div class="main-page-tag-lcs ';

	if ( $isGridLayoutEnabled ) {
		$html .= 'grid-4 alpha ';
	}

	if ( $wfMainPageTag_rcs_called ) {
		$html .= 'main-page-tag-lcs-collapsed"';

		if ( !$isResponsiveLayoutEnabled && !$areBreakpointsLayoutEnabled ) {
			$html .= ' style="padding-right: '. $gutter .'px"';
		}

		$html .= '><div class="lcs-container">';
	} else {
		$gutter += 300;
		$html .= 'main-page-tag-lcs-exploded" ';
		if ( $isGridLayoutEnabled || $isResponsiveLayoutEnabled || $areBreakpointsLayoutEnabled ) {
			$html .= '><div class="lcs-container">';
		} else {
			$html .= 'style="margin-right: -'. $gutter .'px; "><div class="lcs-container" style="margin-right: '. $gutter .'px;">';
		}
	}

	return $html;
}

/**
 * Inserts the necessary HTML to end either left or right column
 * only if there was a column start tag parsed
 */
function wfMainPageTag_ec( $input, $args, $parser ) {
	global $wgMainPageTag_count;

	$html = '';
	if ( $wgMainPageTag_count > 0 ) {
		$html .= '</div></div>';
		$wgMainPageTag_count--;
	}

	return $html;
}
