<?php

class ArticleAsJsonParserException extends WikiaHttpException {
	protected $code = 503;
	protected $message = 'Service Unavailable';

	public function __construct($details) {
		$this->details = $details;
	}
} 

