<?php

class ArticleCommentsTitle {

	/**
	 * Normalizes given comments title text by removing user names and replacing them with user ID
	 *
	 * @param string $oldTitleText
	 * @return string
	 */
	static public function normalize( string $oldTitleText ) : string {
		// Macbre/@comment-Macbre-20170301152835/@comment-Kirkburn-20170302153001
		return preg_replace_callback( '#/@comment-([^/]+)-(\d{14})#', function( $match ) {
			// we got a user name, numeric values signal that this entry has already been mograted
			if ( !is_numeric( $match[1] ) && !Ip::isIPAddress( $match[1] ) ) {
				return sprintf( '/@comment-%s-%s', User::idFromName( $match[1] ), $match[2] );
			}
			else {
				return $match[0];
			}
		}, $oldTitleText );
	}

}
