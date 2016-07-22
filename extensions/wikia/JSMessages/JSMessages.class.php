<?php

/**
 * Use JSMessages::registerPackage() to register messages package to be used in JS.
 *
 * Require messages to be accessible via JS using JSMessages::enqueuePackage() method.
 * SUS-623: use ResourceLoader instead
 */

class JSMessages {

	/**
	 * @var int INLINE unused - reserved for backwards compatibility
	 */
	const INLINE = 1;
	/**
	 * @var int EXTERNAL unused - reserved for backwards compatibility
	 */
	const EXTERNAL = 2;

	/**
	 * @var string RL_MODULE_PREFIX ResourceLoader module prefix used for packages
	 */
	const RL_MODULE_PREFIX = 'ext.jsmessages.';

	/**
	 * @var array $queue List of ResourceLoader module names that will be added to the output
	 */
	static private $queue = [];

	/**
	 * @var array $packages List of registered message packages (ResourceLoader modules)
	 */
	static private $packages = [];

	/**
	 * @var array|null $allMessageKeys Cache for all message keys
	 */
	static private $allMessageKeys = null;


	/**
	 * Debug logging
	 *
	 * @param string $method - name of the method
	 * @param string $msg - log message to be added
	 */
	static private function log($method, $msg) {
		wfDebug($method  . ": {$msg}\n");
	}

	/**
	 * Registers given messages package
	 *
	 * This will NOT load this package, you must also use enqueuePackage() method
	 *
	 * @deprecated SUS-623: use ResourceLoader instead
	 * @param string $packageName - name of the package
	 * @param array $messages - list of messages in the package
	 */
	static public function registerPackage( $packageName, $messages ) {
		self::log( __METHOD__, $packageName );
		self::$packages[self::RL_MODULE_PREFIX . $packageName] = $messages;
	}

	/**
	 * Queue a package to be added to output
	 * Packages added to queue this way will be added via BeforePageDisplay hook handler
	 *
	 * @deprecated SUS-623: use ResourceLoader instead
	 * @param string $package - package name
	 * @param int $mode unused - reserved for backwards compatibility
	 */
	static public function enqueuePackage( $package, $mode ) {
		self::$queue[] = self::RL_MODULE_PREFIX . $package;
	}

	/**
	 * Helper method to get all messages
	 *
	 * @param Language $lang - Language object to get all messages from
	 * @return array - list of all message keys
	 */
	static private function getAllMessageKeys( Language $lang ) {
		wfProfileIn( __METHOD__ );

		if ( is_null( self::$allMessageKeys ) ) {
			wfProfileIn( __METHOD__ . '::miss' );
			$messageKeys = $lang->getAllMessageKeys();
			self::$allMessageKeys = $messageKeys['messages'];

			$langCode = $lang->getCode();

			// append legacy data
			if ( isset( Language::$dataCache->legacyData[$langCode]['messages'] ) ) {
				self::$allMessageKeys = array_unique(
					array_keys( Language::$dataCache->legacyData[$langCode]['messages'] ),
					self::$allMessageKeys
				);
			}

			wfProfileOut( __METHOD__ . '::miss' );
		}

		wfProfileOut( __METHOD__ );
		return self::$allMessageKeys;
	}

	/**
	 * Get messages from given packages
	 *
	 * @deprecated SUS-623: use ResourceLoader instead
	 * @param array $packages - list packages names
	 * @param boolean $allowWildcards unused - reserved for backwards compatibility
	 * @return array - key/value array of messages
	 */
	static public function getPackages( $packages, $allowWildcards = true ) {
		$wg = F::app()->wg;

		$loader = $wg->Out->getResourceLoader();
		$messages = [];
		foreach ( $packages as $packageName ) {
			if ( $loader->getModuleInfo( self::RL_MODULE_PREFIX . $packageName ) ) {
				$messageNames = $loader->getModule( self::RL_MODULE_PREFIX . $packageName )->getMessages();
				foreach ( $messageNames as $msg ) {
					$messages[$msg] = wfMessage( $msg )->inLanguage( $wg->Lang )->plain();
				}
			}
		}

		return $messages;
	}

	/**
	 * Given a message name ending with a wildcard (*), get a list of all matching message names
	 *
	 * @param string $pattern message name pattern ending with a *
	 * @return array list of matching message names
	 */
	static private function getMatchingMessagesForPattern( $pattern ) {
		$pattern = substr( $pattern, 0, -1 );
		$patternLen = strlen( $pattern );

		$messages = self::getAllMessageKeys( Language::factory( F::app()->wg->Lang->getCode() ) );
		$matching = [];
		foreach( $messages as $msg ) {
			if (substr( $msg, 0, $patternLen ) === $pattern) {
				$matching[] = $msg;
			}
		}

		return $matching;
	}

	/**
	 * Expand wildcards in the message list of a given package.
	 *
	 * @param array $keys list of message keys, including wildcards
	 * @return array list of message keys with all wildcards expanded
	 */
	static private function expandWildcards( $keys ) {
		$list = [];
		if ( is_array( $keys ) ) {
			// Expand any wildcards, otherwise just push the message onto the list
			foreach ( $keys as $message ) {
				if ( substr( $message, -1 ) == '*' ) {
					$list += self::getMatchingMessagesForPattern( $message );
				} else {
					$list[] = $message;
				}
			}
		}

		return $list;
	}

	/**
	 * Hook: ResourceLoaderRegisterModules
	 * Registers JSMessage packages as ResourceLoader modules, prefixed with 'ext.jsmessages' to minimize potential conflicts
	 * If a module with the same name already exists, the messages are appended to the existing module.
	 *
	 * @param ResourceLoader $resourceLoader
	 * @return bool true to continue hook processing
	 */
	static public function onResourceLoaderRegisterModules( ResourceLoader &$resourceLoader ) {
		global $wgResourceModules;

		foreach ( self::$packages as $packageName => $messageKeys ) {
			$module = [
				'messages' => self::expandWildcards( $messageKeys ),
			];

			// If a module with this name already exists, append our messages to it.
			if ( is_array( $wgResourceModules[$packageName] ) ) {
				$wgResourceModules[$packageName] += $module;
			} else {
				$resourceLoader->register( $packageName, $module );
			}
		}

		return true;
	}

	/**
	 * Hook: BeforePageDisplay
	 * Adds all queued modules to the output along with the cachebuster global variable
	 *
	 * @param OutputPage $out
	 * @param Skin $skin
	 * @return bool true to continue hook processing
	 */
	static public function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {
		// OutputPage::addModules is used so that these resources
		// can be loaded in the same HTTP request as other extension modules
		$out->addModules(
			self::$queue
		);
		$out->addJsConfigVars( 'wgJSMessagesCB', JSMessagesHelper::getMessagesCacheBuster() );
		return true;
	}
}
