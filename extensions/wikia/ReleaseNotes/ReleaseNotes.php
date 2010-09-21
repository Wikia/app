<?php

/**
 * Displays Release Notes in-wiki
 *
 * @author Lucas 'TOR' Garczewski <tor@wikia-inc.com>
 */

$wgHooks['ParserFirstCallInit'][] = 'efReleaseNotesSetup';

function efReleaseNotesSetup(&$parser) {
	$parser->setHook( 'releasenotes', 'efDisplayReleaseNotes' );
	return true;
}

function efDisplayReleaseNotes( $contents, $attributes, $parser ) {
	global $IP;

	// fail on empty release param
	if ( empty( $attributes['release'] ) ) {
		return '';
	}

	$file = file_get_contents( $IP . '/RELEASE-NOTES.wikia' );
	if ( empty( $file ) ) {
		// should never heppen, but..
		return '';
	}

	$ret = '';
	$display = $attributes['release'];

	$chunks = explode( '== Changes since', $file );

	array_shift( $chunks );

	for ( $i = 0; ( $i <= count( $chunks ) && empty( $ret ) ); $i++ ) {
		$chunk = $chunks[$i];
		$chunk = explode( "\n", $chunk, 2 );
		$release = trim( $chunk[0], " =" );

		if ( $release == $display ) {
			$ret = $chunk[1];
		}	
	}
	
	if ( !empty( $ret ) ) {
		// strip user names from the list
		$ret = preg_replace( '/ \([A-Za-z]+\)$/m', '', $ret );

		// strip ticket numbers from the list
		$ret = preg_replace( '/^\* rt#[0-9]+: /m', '* ', $ret );
	}

	return $ret;
}
