<?php
class SwaggerErrorResponse {
	public $context = "";
	public $reason;
	public $code;

	public function __construct($code, $reason) {
		$this->code = $code;
		$this->reason = $reason;
	}
}
