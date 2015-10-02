<?php

namespace Wikia\Security;

use Wikia\Logger\WikiaLogger;

/**
 * Automate detection of cases where revision is inserted, but the edit token is not checked
 *
 * @see PLATFORM-1540
 */
class CSRFDetector {

	// flags to be checked when performing certain actions
	private static $userMatchEditTokenCalled = false;
	private static $requestWasPostedCalled = false;

	/**
	 * Set a flag when User::matchEditToken is called
	 *
	 * @return bool true, continue hook processing
	 */
	public static function onUserMatchEditToken() {
		self::$userMatchEditTokenCalled = true;
		return true;
	}

	/**
	 * Set a flag when WebRequest::wasPosted or WikiaRequest::wasPosted is called
	 *
	 * @return bool true, continue hook processing
	 */
	public static function onRequestWasPosted() {
		self::$requestWasPostedCalled = true;
		return true;
	}


	/**
	 * Edit token should be checked before a revision is inserted
	 *
	 * @see MAIN-5465
	 *
	 * @return bool true, continue hook processing
	 */
	public static function onRevisionInsertComplete() {
		self::assertEditTokenAndMethodWereChecked( __METHOD__ );
		return true;
	}

	/**
	 * Edit token should be checked before uploading image via URL
	 *
	 * @see PLATFORM-1531
	 *
	 * @return bool true, continue hook processing
	 */
	public static function onUploadFromUrlReallyFetchFile() {
		self::assertEditTokenAndMethodWereChecked( __METHOD__ );
		return true;
	}

	/**
	 * Edit token should be checked before uploading a file
	 *
	 * @return bool true, continue hook processing
	 */
	public static function onUploadComplete() {
		self::assertEditTokenAndMethodWereChecked( __METHOD__ );
		return true;
	}

	/**
	 * Edit token should be checked before saving user settings
	 *
	 * @see CE-1224
	 *
	 * @return bool true, continue hook processing
	 */
	public static function onUserSaveSettings() {
		self::assertEditTokenAndMethodWereChecked( __METHOD__ );
		return true;
	}

	/**
	 * Edit token should be checked before making changes in WikiFactory
	 *
	 * @return bool true, continue hook processing
	 */
	public static function onWikiFactory() {
		self::assertEditTokenAndMethodWereChecked( __METHOD__ );
		return true;
	}

	/**
	 * Assert that edit token and HTTP method were checked in this request
	 *
	 * @see https://kibana.wikia-inc.com/#/dashboard/elasticsearch/PLATFORM-1540
	 *
	 * @param string $fname the caller name
	 */
	private static function assertEditTokenAndMethodWereChecked( $fname ) {
		// filter out maintenance scripts
		if ( \RequestContext::getMain()->getRequest() instanceof \FauxRequest ) {
			return;
		}

		if ( self::$userMatchEditTokenCalled === false || self::$requestWasPostedCalled == false ) {
			wfDebug( __METHOD__ . ": {$fname} called, but edit token and / or HTTP method was not checked\n" );

			WikiaLogger::instance()->warning( __METHOD__, [
				'caller' => $fname,
				'transaction' => \Transaction::getInstance()->getType(), # e.g. api/nirvana/Videos
				'editTokenChecked' => self::$userMatchEditTokenCalled,
				'httpMethodChecked' => self::$requestWasPostedCalled,
				'exception' => new Exception(),
			] );
		}
	}
}
