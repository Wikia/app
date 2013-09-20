<?php

/**
 * Use JSMessages::registerPackage() to register messages package to be used in JS.
 *
 * Require messages to be accessible via JS using JSMessages::enqueuePackage() method.
 */

class JSMessages {

	// flags: add messages inline (in <head> section) or external (using "faked" JS script)
	const INLINE = 1;
	const EXTERNAL = 2;

	// queue of messages packages to emit as JS script and inline
	static private $queue = array( 'inline' => array(), 'external' => array() );

	// list of registered message packages
	static private $packages = array();

	// cache for all message keys
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
	 * @param string $packageName - name of the package
	 * @param array $messages - list of messages in the package
	 */
	static public function registerPackage($packageName, $messages) {
		self::log(__METHOD__, $packageName);
		self::$packages[$packageName] = $messages;
	}

	/**
	 * Add a package to be available in JS
	 *
	 * @param string $name - package name
	 * @param int $mode - how to emit messages (inline / external)
	 */
	static public function enqueuePackage($package, $mode) {
		wfProfileIn(__METHOD__);

		// add to proper queue
		$queueName = ($mode == self::INLINE) ? 'inline' : 'external';
		self::$queue[$queueName][] = $package;

		self::log(__METHOD__ , "{$package} (added to '{$queueName}' queue)");
		wfProfileOut(__METHOD__);
	}

	/*
	 * Returns a package as a JS tag
	 *
	 * @param array $packages - list packages names
	 *
	 * @return string A string containing the package as an inline-able tag to use in templates
	 */
	static public function printPackages( Array $packages ) {
		wfProfileIn(__METHOD__);

		$pkgs = implode(',', $packages);
		$ret = '<script>' . F::app()->sendRequest( 'JSMessages', 'getMessages', array( 'packages' => $pkgs ), true )->toString() . '</script>';

		wfProfileOut(__METHOD__);

		return $ret;
	}

	/**
	 * Return list of messages matching given pattern
	 *
	 * Example: 'feature-foo-*'
	 *
	 * @param string $pattern - pattern to match against ALL messages in the system
	 * @return array - key/value list of matching messages
	 */
	static private function resolveMessagesPattern($pattern) {
		$fname = __METHOD__ . "::$pattern";
		wfProfileIn($fname);

		self::log(__METHOD__, $pattern);

		$pattern = substr($pattern, 0, -1);
		$patternLen = strlen($pattern);

		// get list of all messages loaded by MW
		$lang = wfGetLangObj(false /* $langCode */);
		$langCode = $lang->getCode();

		if($lang instanceof StubUserLang) {
			$lang = $lang->_newObject();
		}
		$messageKeys = self::getAllMessageKeys( $lang );

		$ret = array();
		foreach( $messageKeys as $msg ) {
			if ( is_array( $msg ) ) {
				var_dump( $msg );
			}
			if (substr($msg, 0, $patternLen) === $pattern) {
				$ret[$msg] = wfmsgExt($msg, array('language' => $langCode));
			}
		}


		wfProfileOut($fname);
		return $ret;
	}

	/**
	 * Helper method to get all messages
	 *
	 * @param Language $lang - Language object to get all messages from
	 * @return array - list of all message keys
	 */
	static private function getAllMessageKeys(Language $lang) {
		wfProfileIn(__METHOD__);

		if (is_null(self::$allMessageKeys)) {
			wfProfileIn(__METHOD__ . '::miss');
			$messageKeys = $lang->getAllMessageKeys();
			self::$allMessageKeys = $messageKeys['messages'];

			$langCode = $lang->getCode();

			// append legacy data
			if (isset(Language::$dataCache->legacyData[$langCode]['messages'])) {
				self::$allMessageKeys = array_unique(
					array_keys( Language::$dataCache->legacyData[$langCode]['messages']),
					self::$allMessageKeys
				);
			}

			wfProfileOut(__METHOD__ . '::miss');
		}

		wfProfileOut(__METHOD__);
		return self::$allMessageKeys;
	}

	/**
	 * Get messages for a given package as key => value structure
	 *
	 * Resolve messages list (entries matching "feature-*" pattern)
	 *
	 * @param string $name - name of the messages package
	 * @param boolean $allowWildcards - can packages with wildcard be added?
	 * @return array - key/value array of messages
	 */
	static private function getPackage($name, $allowWildcards = true) {
		wfProfileIn(__METHOD__);
		$ret = null;

		if (isset(self::$packages[$name])) {
			self::log(__METHOD__, $name);

			// get messages
			$messages = self::$packages[$name];
			$ret = array();

			foreach($messages as $message) {
				// pattern to match messages (e.g. "feature-*")
				if (substr($message, -1) == '*') {
					// BugId:18482
					if ($allowWildcards) {
						$msgs = self::resolveMessagesPattern($message);

						if (!empty($msgs)) {
							$ret = array_merge($ret, $msgs);
						}
					}
					else {
						Wikia::logBacktrace(__METHOD__);
						wfProfileOut(__METHOD__);
						trigger_error("JSMessages: '{$name}' package with wildcard matching can only be used in EXTERNAL mode", E_USER_ERROR);
						return;
					}
				}
				// single message
				else {
					//@todo - this removes the {{PLURAL prefix, so plurals won't work in JS
					//on the other hand we cannot simply set $transform to true, as we want the wiki links to be parsed
					$msg = wfMsgGetKey($message, true /* $useDB */);

					// check for not existing message
					if ($msg == htmlspecialchars("<{$message}>")) {
						$msg = false;
					}

					$ret[ $message ] = $msg;
				}
			}
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Get messages from given packages
	 *
	 * Packages with widlcard matching can only be queued in EXTERNAL mode. Doing so in INLINE mode will cause
	 * PHP fatal error (BugId:18482)
	 *
	 * @param array $packages - list packages names
	 * @param boolean $allowWildcards - can packages with wildcard be added?
	 * @return array - key/value array of messages
	 */
	static public function getPackages($packages, $allowWildcards = true) {
		$messages = array();

		foreach($packages as $packageName) {
			$packageMessages = self::getPackage($packageName, $allowWildcards);

			if (is_array($packageMessages)) {
				$messages = array_merge($messages, $packageMessages);
			}
		}

		return $messages;
	}

	/**
	 * Emit messages from the queue as:
	 *   - JS object in <head> section of the page (INLINE mode)
	 *   - JS requested via <script> tag at the bottom of the page (EXTERNAL mode)
	 */
	static public function onWikiaSkinTopScripts( &$vars, &$scripts, $skin) {
		wfProfileIn(__METHOD__);
		self::log(__METHOD__, 'preparing list of inline messages...');

		// get items to be rendered as a variable in <head> section
		$packages = self::$queue['inline'];

		if (!empty($packages)) {
			$vars['wgMessages'] = self::getPackages($packages, false /* don't allow wildcards in INLINE mode (BugId:18482) */);
		}

		// messages cache buster used by JSMessages (BugId:6324)
		$vars['wgJSMessagesCB'] = JSMessagesHelper::getMessagesCacheBuster();

		self::log(__METHOD__, 'preparing list of external packages...');

		$url = self::getExternalPackagesUrl();

		if ($url != "") {
			// request a script
			F::app()->wg->Out->addScript(Html::linkedScript($url));
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Return the URL of the ajax-call to load all of the JS messages packages (enqueued as "external")
	 *
	 * If there are no packages to load, returns an empty-string.
	 *
	 * @return string - URL to "dynamic" JS file with messages
	 */
	static public function getExternalPackagesUrl() {
		wfProfileIn( __METHOD__ );

		$wg = F::app()->wg;

		// get items to be loaded via JS file
		$packages = self::$queue['external'];
		$url = '';

		if (!empty($packages)) {
			$packages = array_unique($packages);
			sort($packages);

			// /wikia.php?controller=HelloWorld&method=index&format=html
			$url = wfAppendQuery($wg->ScriptPath . '/wikia.php', array(
				'controller' => 'JSMessages',
				'method' => 'getMessages',
				'format' => 'html',

				// params for controller
				'packages' => implode(',', $packages),

				// cache separately for different languages
				'uselang' => $wg->Lang->getCode(),

				// cache buster
				'cb' => JSMessagesHelper::getMessagesCacheBuster(),
			));
		}

		wfProfileOut( __METHOD__ );
		return $url;
	}
}
