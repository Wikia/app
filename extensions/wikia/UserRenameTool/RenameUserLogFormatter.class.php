<?php

/**
 * @author: Władysław Bodzek
 *
 * A helper class for the User rename tool
 * @copyright (C) 2010, Wikia Inc.
 * @licence GNU General Public Licence 3.0 or later
 */
class RenameUserLogFormatter {
	static public function getCommunityUser( $name, $noRedirect = false ) {
		if ( is_int( $name ) )
			$name = User::whoIs( $name );
		$title = GlobalTitle::newFromText( $name, NS_USER, COMMUNITY_CENTRAL_CITY_ID );
		return Xml::element( 'a', [ 'href' => $title->getFullURL(
			$noRedirect ? 'redirect=no' : ''
		) ], $name, false );
	}

	static private function log( $type, $requestor, $oldUsername, $newUsername ) {
		return wfMessage( $type,
			self::getCommunityUser( $requestor ),
			self::getCommunityUser( $oldUsername, true ),
			self::getCommunityUser( $newUsername )
		)->inContentLanguage()->text();
	}

	static public function start( $requestor, $oldUsername, $newUsername ) {
		return self::log( 'userrenametool-info-started', $requestor, $oldUsername, $newUsername );
	}

	static public function finish( $requestor, $oldUsername, $newUsername ) {
		return self::log( 'userrenametool-info-finished', $requestor, $oldUsername, $newUsername );
	}

	static public function fail( $requestor, $oldUsername, $newUsername ) {
		return self::log( 'userrenametool-info-failed', $requestor, $oldUsername, $newUsername );
	}
}
