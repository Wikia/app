<?php
/**
 * This is a sample filter plugin which will hit a lot of bots, good and bad.
 *
 * Apparently it's hard work writing an encoder for multipart/form-data,
 * so generally only the browsers bother with it, and the bots send
 * application/x-www-form-urlencoded regardless of the form's enctype
 * attribute.
 */

$wgHooks['EditFilterMerged'][] = 'AntiBot_GenericFormEncoding::onEditFilterMerged';
class AntiBot_GenericFormEncoding {
	public static function onEditFilterMerged( $editPage, $text, &$hookError ) {
		if ( !function_exists( 'apache_request_headers' ) ) {
			return true;
		}
		$headers = apache_request_headers();
		if ( isset( $headers['Content-Type'] )
			&& $headers['Content-Type'] == 'application/x-www-form-urlencoded' )
		{
			if ( AntiBot::trigger( __CLASS__ ) == 'fail' ) {
				return false;
			}
		}
		return true;
	}
}
