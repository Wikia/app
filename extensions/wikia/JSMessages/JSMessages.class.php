<?php

/**
 * Use F::build('JSMessages')->registerPackage() to register messages package to be used in JS.
 *
 * Require messages to be accessible via JS using F::build('JSMessages')->enqueuePackage() method.
 */

class JSMessages {

	// flags: add messages inline (in <head> section) or external (using "faked" JS script)
	const INLINE = 1;
	const EXTERNAL = 2;

	// application
	private $app;

	// instance of JSMessagesHelper class
	private $helper;

	// queue of messages packages to emit as JS script and inline
	private $queue = array();

	// list of registered message packages
	private $packages = array();

	function __construct() {
		$this->app = WF::build('App');
		$this->helper = F::build('JSMessagesHelper');

		$this->queue = array(
			'inline' => array(),
			'external' => array(),
		);
	}

	/**
	 * Debug logging
	 *
	 * @param string $method - name of the method
	 * @param string $msg - log message to be added
	 */
	private function log($method, $msg) {
		$this->app->wf->debug($method  . ": {$msg}\n");
	}

	/**
	 * Registers given messages package
	 *
	 * This will NOT load this package, you must also use enqueuePackage() method
	 *
	 * @param string $packageName - name of the package
	 * @param array $messages - list of messages in the package
	 */
	public function registerPackage($packageName, $messages) {
		$this->log(__METHOD__, $packageName);
		$this->packages[$packageName] = $messages;
	}

	/**
	 * Add a package to be available in JS
	 *
	 * @param string $name - package name
	 * @param int $mode - how to emit messages (inline / external)
	 */
	public function enqueuePackage($package, $mode) {
		$this->app->wf->ProfileIn(__METHOD__);

		// add to proper queue
		$queueName = ($mode == self::INLINE) ? 'inline' : 'external';
		$this->queue[$queueName][] = $package;

		$this->log(__METHOD__ , "{$package} (added to '{$queueName}' queue)");
		$this->app->wf->ProfileOut(__METHOD__);
	}

	/*
	 * Returns a package as a JS tag
	 *
	 * @param array $packages - list packages names
	 * 
	 * @return string A string containing the package as an inline-able tag to use in templates
	 */
	public function printPackages( Array $packages ) {
		$this->app->wf->ProfileIn(__METHOD__);

		$pkgs = implode(',', $packages);
		$ret = '<script>' . $this->app->sendRequest( 'JSMessagesController', 'getMessages', array( 'packages' => $pkgs ), true )->toString() . '</script>';

		$this->app->wf->ProfileOut(__METHOD__);

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
	private function resolveMessagesPattern($pattern) {
		$this->app->wf->ProfileIn(__METHOD__ . "::$pattern");
		$this->log(__METHOD__, $pattern);

		$pattern = substr($pattern, 0, -1);
		$patternLen = strlen($pattern);

		// get list of all messages loaded by MW
		$this->app->wf->ProfileIn(__METHOD__ . '::getAllMessages');

		$lang = $this->app->wf->GetLangObj(false /* $langCode */);
		$messages = $lang->getAllMessages();

		// append legacy data
		if (isset(Language::$dataCache->legacyData[$lang->getCode()]['messages'])) {
			$messages = Language::$dataCache->legacyData[$lang->getCode()]['messages'] + $messages;
		}

		$this->app->wf->ProfileOut(__METHOD__ . '::getAllMessages');

		// apply pattern
		$ret = array();
		foreach($messages as $msg => $val) {
			if (substr($msg, 0, $patternLen) == $pattern) {
				$ret[$msg] = $this->app->wf->msgExt( $msg, array( 'language' => $lang->getCode() ) );
			}
		}

		$this->app->wf->ProfileOut(__METHOD__ . "::$pattern");
		return $ret;
	}

	/**
	 * Get messages for a given package as key => value structure
	 *
	 * Resolve messages list (entries matching "feature-*" pattern)
	 *
	 * @param string $name - name of the messages package
	 * @return array - key/value array of messages
	 */
	private function getPackage($name) {
		$this->app->wf->ProfileIn(__METHOD__);
		$ret = null;

		if (isset($this->packages[$name])) {
			$this->log(__METHOD__, $name);

			// get messages
			$messages = $this->packages[$name];
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
					$msg = $this->app->wf->MsgGetKey($message, true /* $useDB */);

					// check for not existing message
					if ($msg == htmlspecialchars("<{$message}>")) {
						$msg = false;
					}

					$ret[$message] = $msg;
				}
			}
		}

		$this->app->wf->ProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Get messages from given packages
	 *
	 * @param array $packages - list packages names
	 * @return array - key/value array of messages
	 */
	public function getPackages($packages) {
		$messages = array();

		foreach($packages as $packageName) {
			$packageMessages = $this->getPackage($packageName);

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
		$this->app->wf->ProfileIn(__METHOD__);
		$this->log(__METHOD__, 'preparing list of inline messages...');

		// get items to be rendered as a variable in <head> section
		$packages = $this->queue['inline'];

		if (!empty($packages)) {
			$vars['wgMessages'] = $this->getPackages($packages);
		}

		// messages cache buster used by JSMessages (BugId:6324)
		$vars['wgJSMessagesCB'] = $this->helper->getMessagesCacheBuster();

		$this->app->wf->ProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Emit messages from the queue as external JS requested via <script> tag at the bottom of the page
	 */
	public function onSkinAfterBottomScripts($skin, $text) {
		$this->app->wf->ProfileIn(__METHOD__);
		$this->log(__METHOD__, 'preparing list of external packages...');

		$url = $this->getExternalPackagesUrl();
		if ($url != "") {
			// request a script
			$this->app->wg->Out->addScript(Html::linkedScript($url));
		}

		$this->app->wf->ProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Return the URL of the ajax-call to load all of the JS messages packages (enqueued as "external")
	 *
	 * If there are no packages to load, returns an empty-string.
	 *
	 * @return string - URL to "dynamic" JS file with messages
	 */
	public function getExternalPackagesUrl() {
		$this->app->wf->ProfileIn( __METHOD__ );

		// get items to be loaded via JS file
		$packages = $this->queue['external'];
		$url = '';

		if (!empty($packages)) {
			sort(array_unique($packages));

			// /wikia.php?controller=HelloWorld&method=index&format=html
			$url = $this->app->wf->AppendQuery($this->app->wg->ScriptPath . '/wikia.php', array(
				'controller' => 'JSMessages',
				'method' => 'getMessages',
				'format' => 'html',

				// params for controller
				'packages' => implode(',', $packages),

				// cache separately for different languages
				'uselang' => $this->app->wg->Lang->getCode(),

				// cache buster
				'cb' => $this->helper->getMessagesCacheBuster(),
			));
		}

		$this->app->wf->ProfileOut( __METHOD__ );
		return $url;
	}
}
