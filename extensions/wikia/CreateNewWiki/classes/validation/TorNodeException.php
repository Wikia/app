<?php
namespace Wikia\CreateNewWiki;

class TorNodeException extends ValidationException {
	protected $httpStatusCode = 403;
	protected $errorMessageKey = 'cnw-error-torblock';
	protected $headerMessageKey = 'cnw-error-blocked-header';
}
