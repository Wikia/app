<?php
namespace Wikia\CreateNewWiki;

class MissingParamsException extends ValidationException {
	protected $httpStatusCode = 400;
	protected $errorMessageKey = 'cnw-error-general';
	protected $headerMessageKey = 'cnw-error-general-heading';
}
