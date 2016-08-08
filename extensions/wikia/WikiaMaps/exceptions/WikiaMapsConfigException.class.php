<?php
class WikiaMapsConfigException extends WikiaHttpException {
	protected $code = 500;
	protected $message = "Invalid configuration";

	public function __construct($details) {
		parent::__construct($details);
	}
}
