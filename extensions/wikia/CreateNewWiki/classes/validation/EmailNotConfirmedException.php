<?php
namespace Wikia\CreateNewWiki;

class EmailNotConfirmedException extends ValidationException {
	protected $httpStatusCode = 403;
	protected $errorMessageKey = 'cnw-error-unconfirmed-email';
	protected $headerMessageKey = 'cnw-error-unconfirmed-email-header';
}
