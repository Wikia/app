<?php

class AssetsManagerException extends WikiaException {

	function __construct($message) {
		// add referer and user agent info to the exception message
		$details = AssetsManager::getRequestDetails();
		$message .= " ({$details})";

		parent::__construct($message);
	}
}
