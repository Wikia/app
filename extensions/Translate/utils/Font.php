<?php

/**
 * Wrapper around font-config to get useful ttf font given a language code.
 * Uses wfShellExec, wfEscapeShellArg and wfDebugLog from MediaWiki.
 * @author Niklas Laxström, 2008
 * @license PD
 */
class FCFontFinder {

	public static function find( $code ) {
		$code = wfEscapeShellArg( ":lang=$code" );
		$ok = 0;
		$cmd = "fc-match $code";
		$suggestion = wfShellExec( $cmd, $ok );
		wfDebugLog( 'fcfont', "$cmd returned $ok" );
		if ( $ok !== 0 ) {
			wfDebugLog( 'fcfont', "fc-match error output: $suggestion" );
			return false;
		}

		$pattern = '/^(.*?): "(.*)" "(.*)"$/';
		$matches = array();
		if ( !preg_match( $pattern, $suggestion, $matches ) ) {
			wfDebugLog( 'fcfont', "fc-match: return format not understood: $suggestion" );
			return false;
		}

		list( , $file, $family, $type ) = $matches;
		wfDebugLog( 'fcfont', "fc-match: got $file: $family $type" );

		$file = wfEscapeShellArg( $file );
		$family = wfEscapeShellArg( $family );
		$type = wfEscapeShellArg( $type );
		$cmd = "fc-list $family $type $code file | grep $file";

		$candidates = trim( wfShellExec( $cmd, $ok ) );

		wfDebugLog( 'fcfont', "$cmd returned $ok" );
		if ( $ok !== 0 ) {
			wfDebugLog( 'fcfont', "fc-list error output: $candidates" );
			return false;
		}

		# trim spaces
		$files = array_map( 'trim', explode( "\n",  $candidates ) );
		$count = count($files);
		if ( !$count ) wfDebugLog( 'fcfont', "fc-list got zero canditates: $candidates" );

		# remove the trailing ":"
		$chosen = substr( $files[0], 0, -1 );

		wfDebugLog( 'fcfont', "fc-list got $count candidates; using $chosen" );
		return $chosen;
	}

}