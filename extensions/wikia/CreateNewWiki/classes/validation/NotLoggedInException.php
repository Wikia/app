<?php
namespace Wikia\CreateNewWiki;

class NotLoggedInException extends ValidationException {
	protected $httpStatusCode = 401;
	protected $errorMessageKey = 'cnw-error-anon-user';
	protected $headerMessageKey = 'cnw-error-anon-user-header';
}
