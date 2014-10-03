<?php
class WikiaMapsConfigException extends WikiaHttpException {
	protected $code = 500;
	protected $message = "Invalid configuration";

	public function __construct($details) {
		$this->details = $details;
	}
}
