<?php

namespace Wikia\Security;

use Wikia\Logger\WikiaLogger;

/**
 * Automate detection of cases where revision is inserted, but the edit token is not checked
 *
 * @see PLATFORM-1540
 */
class CSRFDetector {
	private static $userMatchEditTokenCalled = false;

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
	 * Edit token should be checked before a revision is inserted
	 *
	 * @see MAIN-5465
	 *
	 * @param \Revision $revision
	 * @param $data
	 * @param $flags
	 * @return bool true, continue hook processing
	 */
	public static function onRevisionInsertComplete( \Revision $revision, $data, $flags ) {
		self::assertEditTokenWasChecked( __METHOD__ );
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
		self::assertEditTokenWasChecked( __METHOD__ );
		return true;
	}

	/**
	 * Edit token should be checked before uploading a file
	 *
	 * @return bool true, continue hook processing
	 */
	public static function onUploadComplete() {
		self::assertEditTokenWasChecked( __METHOD__ );
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
		self::assertEditTokenWasChecked( __METHOD__ );
		return true;
	}

	/**
	 * Assert that User::matchEditToken was called in this request
	 *
	 * @param string $fname the caller name
	 */
	private static function assertEditTokenWasChecked( $fname ) {
		// filter out maintenance scripts
		if ( \RequestContext::getMain()->getRequest() instanceof \FauxRequest ) {
			return;
		}

		if ( self::$userMatchEditTokenCalled === false ) {
			wfDebug( __METHOD__ . ": {$fname} called, but edit token was not checked\n" );

			WikiaLogger::instance()->warning( __METHOD__, [
				'caller' => $fname,
				'exception' => new Exception(),
			] );
		}
	}
}
