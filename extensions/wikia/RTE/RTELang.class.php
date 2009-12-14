<?php

class RTELang {

	private static $messages;

	/**
	 * Add given mesage to array to be returned by getMessages()
	 */
	static private function addMessage($key, $value) {
		$tree = explode('-', $key);
		$deep = count($tree);

		switch($deep) {
			case 1:
				self::$messages[ $tree[0] ] = $value;
				break;

			case 2:
				self::$messages[ $tree[0] ][ $tree[1] ] = $value;
				break;

			case 3:
				self::$messages[ $tree[0] ][ $tree[1] ][ $tree[2] ] = $value;
				break;
		}
	}

	/**
	 * Return nested array with CK messages
	 */
	static public function getMessages() {
		global $wgExtensionMessagesFiles, $wgLang;

		wfProfileIn(__METHOD__);

		// load messages (core and then Wikia customized)
		wfLoadExtensionMessages('CKcore');
		wfLoadExtensionMessages('CKwikia');

		// load messages file to get list of messages we should return
		$messages = array();
		require( $wgExtensionMessagesFiles['CKcore'] );
		$list = array_keys($messages['en']);

		$messages = array();
		require( $wgExtensionMessagesFiles['CKwikia'] );
		$list = array_merge($list, array_keys($messages['en']));

		// convert flat array to nested array
		self::$messages = array();

		foreach($list as $msg) {
			$key = substr($msg, 7);
			$value = wfMsg($msg);

			self::addMessage($key, $value);
		}

		ksort(self::$messages);

		wfProfileOut(__METHOD__);

		return self::$messages;
	}
}
