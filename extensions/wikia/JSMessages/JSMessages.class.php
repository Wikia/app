<?php

/**
 * Use $app->registerExtensionJSMessagePackage() to register messages package to be used in JS.
 *
 * Require messages to be accessible via JS using enqueuePackage() method.
 */

class JSMessages {

	// flags: add messages inline (in <head> section) or external (using "faked" JS script)
	const INLINE = 1;
	const EXTERNAL = 2;

	private $app;

	// queue of messages packages to emit as JS script and inline
	private $queue;

	// used by singleton
	static private $instance;

	function __construct() {
		$this->app = WF::build('App');

		$this->queue = array(
			'inline' => array(),
			'external' => array(),
		);
	}

	/**
	 * Add a package to be available in JS
	 *
	 * @param string $name - package name
	 * @param int $mode - how to emit messages (inline / external)
	 */
	public function enqueuePackage($package, $mode) {
		wfProfileIn(__METHOD__);

		// add to proper queue
		$queueName = ($mode == self::INLINE) ? 'inline' : 'external';
		$this->queue[$queueName][] = $package;

		wfDebug(__METHOD__ . ": {$package} (queue '{$queueName}')\n");
		wfProfileOut(__METHOD__);
	}

	/**
	 * Return list of messages matching given pattern
	 */
	private function resolveMessagesPattern($pattern) {
		wfProfileIn(__METHOD__);
		wfDebug(__METHOD__ . ": {$pattern}\n");

		$pattern = substr($pattern, 0, -1);
		$patternLen = strlen($pattern);

		// get list of all messages loaded by MW
		wfProfileIn(__METHOD__ . '::getAllMessages');
		$lang = wfGetLangObj(false /* $langCode */);
		$messages = $lang->getAllMessages();
		// append legacy data
		if (isset(Language::$dataCache->legacyData[$lang->getCode()]['messages'])) {
			$messages = Language::$dataCache->legacyData[$lang->getCode()]['messages'] + $messages;
		}
		wfProfileOut(__METHOD__ . '::getAllMessages');

		// apply pattern
		$ret = array();
		foreach($messages as $msg => $val) {
			if (substr($msg, 0, $patternLen) == $pattern) {
				$ret[$msg] = $val;
			}
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Get messages for given package as key => value structure
	 *
	 * Resolve messages list (entries matching "feature-*" pattern)
	 */
	public function getPackage($name) {
		wfProfileIn(__METHOD__);
		$ret = null;

		// @see $app->registerExtensionJSMessagePackage
		$packages = $this->app->getGlobal('wgJSMessagesPackages');

		if (isset($packages[$name])) {
			wfDebug(__METHOD__. ": {$name}\n");

			// get messages
			$messages = $packages[$name];
			$ret = array();

			foreach($messages as $message) {
				// pattern to match messages (e.g. "feature-*")
				if (substr($message, -1) == '*') {
					$msgs = $this->resolveMessagesPattern($message);

					if (!empty($msgs)) {
						$ret = array_merge($ret, $msgs);
					}
				}
				// single message
				else {
					$msg = wfMsgGetKey($message, true /* $useDB */);

					// check for not existing message
					if ($msg == htmlspecialchars("<{$message}>")) {
						$msg = false;
					}

					$ret[$message] = $msg;
				}
			}
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Get messages from given packages
	 */
	public function getPackages($packages) {
		$messages = array();

		foreach($packages as $package) {
			$packageMessages = $this->getPackage($package);

			if (is_array($packageMessages)) {
				$messages = array_merge($messages, $packageMessages);
			}
		}

		return $messages;
	}

	/**
	 * Emit messages from the queue as JS object in <head> section of the page
	 */
	public function onMakeGlobalVariablesScript($vars) {
		wfProfileIn(__METHOD__);
		wfDebug(__METHOD__ . "\n");

		$instance = self::getInstance();
		$packages = $instance->queue['inline'];

		if (!empty($packages)) {
			$vars['wgMessages'] = $instance->getPackages($packages);
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Emit messages from the queue as external JS requested via <script> tag at the bottom of the page
	 */
	public function onSkinAfterBottomScripts($skin, $text) {
		wfProfileIn(__METHOD__);
		wfDebug(__METHOD__ . "\n");

		$instance = self::getInstance();
		$packages = $instance->queue['external'];
		sort($packages);

		// additional URL parameters
		$lang = $this->app->getGlobal('wgLang')->getCode();
		$cb = $this->app->getGlobal('wgMemc')->get(wfMemcKey('wgMWrevId'));

		$url = wfAppendQuery($this->app->getGLobal('wgScript'), array(
			'action' => 'ajax',
			'rs' => 'JSMessagesAjax',
			'packages' => implode(',', $packages),
			'uselang' => $lang,
			'cb' => intval($cb),
		));

		// request a script
		$this->app->getGlobal('wgOut')->addScriptFile($url);

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Return instance of JSMessages class
	 */
	public static function getInstance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
