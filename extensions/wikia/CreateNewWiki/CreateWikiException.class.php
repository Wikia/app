<?php

use \Wikia\Logger\WikiaLogger;

class CreateWikiException extends Exception {

	public function __construct($message = '', $code = 0, Array $params = []) {
		parent::__construct($message, $code);

		WikiaLogger::instance()->error(__CLASS__, [
			'err' => $message,
			'errno' => $code,
			'params' => $params,
			'exception' => $this
		]);
	}
}