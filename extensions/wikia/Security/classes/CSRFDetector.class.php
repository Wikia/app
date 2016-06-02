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
	 * In some cases we consider GET requests to be secure when they're provided with a secret token
	 *
	 * @see PLATFORM-2207
	 */
	public static function markRequestAsSecure( $caller ) {
		wfDebug( __METHOD__ . ": {$caller} marked the current request as a secure one\n" );

		// make assertEditTokenAndMethodWereChecked() method think that we checked the request method
		self::$requestWasPostedCalled = true;
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
