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
	private static $disabledReason = false;

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
	 * Run code that would trigger the CSRF error without triggering it
	 *
	 * You never want to use this function, but sometimes you must. That is when pages are created
	 * automatically on the fly and the user cannot override any of the params of that process.
	 *
	 * @see ForumSpecialController::index
	 *
	 * @param \Closure $closure
	 * @param string $reason
	 */
	public static function disableCheck( \Closure $closure, $reason ) {
		self::$disabledReason = $reason;
		$closure();
		self::$disabledReason = false;
	}

	/**
	 * Bind to hooks, actions that triggered them will be checked against token and HTTP method validation
	 *
	 * Called via $wgExtensionFunctions
	 */
	public static function setupHooks() {
		global $wgCSRFDetectorHooks, $wgHooks;

		foreach( $wgCSRFDetectorHooks as $hookName ) {
			$wgHooks[$hookName][] = function() use ( $hookName ) {
				self::assertEditTokenAndMethodWereChecked( $hookName );
				return true;
			};
		}
	}

	/**
	 * Assert that edit token and HTTP method were checked in this request
	 *
	 * @see https://kibana.wikia-inc.com/#/dashboard/elasticsearch/PLATFORM-1540
	 *
	 * @param string $hookName hook that triggered the check
	 */
	private static function assertEditTokenAndMethodWereChecked( $hookName ) {
		// filter out maintenance scripts
		if ( \RequestContext::getMain()->getRequest() instanceof \FauxRequest ) {
			return;
		}

		if ( self::$userMatchEditTokenCalled === false || self::$requestWasPostedCalled == false ) {
			wfDebug( __METHOD__ . ": {$hookName} hook triggered, but edit token and / or HTTP method was not checked\n" );

			if ( is_string( self::$disabledReason ) ) {
				wfDebug( __METHOD__ . ': Not logging, because ' . self::$disabledReason . PHP_EOL );

				return;
			}

			WikiaLogger::instance()->warning( __METHOD__, [
				'hookName' => $hookName,
				'transaction' => \Transaction::getInstance()->getType(), # e.g. api/nirvana/Videos
				'editTokenChecked' => self::$userMatchEditTokenCalled,
				'httpMethodChecked' => self::$requestWasPostedCalled,
				'exception' => new Exception(),
			] );
		}
	}
}
