<?php
/**
 * HealthCheck
 *
 * @file
 * @ingroup Extensions
 * @author Garth Webb <garth@wikia-inc.com>
 * @date 2011-03-28
 * @copyright Copyright © 2011 Garth Webb, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension named UUID.\n";
	exit( 1 );
}

class WikiaUUID {
	const COOKIE_BASE_NAME = 'WIKIA_UUID';

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'UUID'/*class*/ );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function getUUID () {
		global $wgOut, $wgRequest, $wgMimeType;

		// Check for the UUID cookie
		$uuid = WikiaUUID::getUUIDCookie();

		// If we don't have it generate a new UUID and set the cookie
		if (! $uuid) {
			$uuid = WikiaUUID::generateUUID();
			WikiaUUID::setUUIDCookie($uuid);
		}

		return json_encode(array("uuid" => $uuid));
	}
	
	public function cookieName () {
		global $wgCookiePrefix;
		
		return $wgCookiePrefix.self::COOKIE_BASE_NAME;
	}
	
	private function getUUIDCookie () {
		$name = UUID::cookieName();

		if (array_key_exists($name, $_COOKIE)) {
			return $_COOKIE[ $name ];
		} else {
			return false;
		}
	}

	private function generateUUID () {
		return microtime(true).'.'.rand(1000000000, 2000000000);
	}

	private function setUUIDCookie ($uuid) {
		global $wgRequest;
		// This doesn't use the cookieName method since 'setcookie' does its own
		// magic.  Bleh.
		$wgRequest->response()->setcookie(self::COOKIE_BASE_NAME, $uuid, 0);
	}
}
