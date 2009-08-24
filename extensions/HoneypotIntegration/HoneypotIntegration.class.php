<?php

class HoneypotIntegration {
	public static function onAbuseFilterFilterAction( &$vars, $title ) {
		$vars->setVar( 'honeypot_list_count', self::listingCount() ? 1 : 0 );
		return true;
	}

	public static function onAbuseFilterBuilder( &$builder ) {
		wfLoadExtensionMessages( 'HoneypotIntegration' );
		$builder['vars']['honeypot_list_count'] = 'honeypot-list-count';
		return true;
	}

	public static function listingCount( $ip = null ) {
		if ( $ip === null )
			$ip = wfGetIP();

			// TODO IMPLEMENT
			return 0;
	}

	public static function onShowEditForm( &$editPage, &$out ) {

		// Spammers are more likely to fall for real text than for a random token.
		// Extract a decent-sized string from the text
		$editText = $editPage->textbox1;
		$randomText = '';

		if ( strlen( $editText ) > 10 ) {
			// Start somewhere in the first quarter of the text,
			//  run for somewhere between a quarter and a half of the text, or 100-1000 bytes,
			//  whichever is shorter.
			$start = rand( 0, strlen( $editText ) / 4 );
			$length = rand( min( strlen( $editText ) / 4, 100 ), min( strlen( $editText ) / 2, 1000 ) );
			$randomText = substr( $editText, $start, $length );
		}

		$out->addHTML( self::generateHoneypotLink( $randomText ) );
		return 1;
	}

	public static function generateHoneypotLink( $randomText = null ) {
		global $wgHoneypotURLs, $wgHoneypotTemplates;

		$index = rand( 0, count( $wgHoneypotURLs ) - 1 );
		$url = $wgHoneypotURLs[$index];
		$index = rand( 0, count( $wgHoneypotTemplates ) - 1 );
		$template = $wgHoneypotTemplates[$index];

		if ( !$randomText )
			$randomText = wfGenerateToken( );

		// Variable replacement
		$output = strtr( $template,
			array(
				'honeypoturl' => $url,
				'randomtext' => htmlspecialchars( $randomText )
			)
		);

		return "$output\n";
	}
}
