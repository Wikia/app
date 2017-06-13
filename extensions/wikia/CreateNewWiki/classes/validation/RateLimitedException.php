<?php
namespace Wikia\CreateNewWiki;

use User;

class RateLimitedException extends ValidationException {
	protected $httpStatusCode = 429;
	protected $errorMessageKey = 'cnw-error-wiki-limit';
	protected $headerMessageKey = 'cnw-error-wiki-limit-header';

	public function __construct() {
		parent::__construct();

		$this->errorMessageParams = [
			UserValidator::MAX_WIKI_CREATIONS_PER_USER_PER_DAY
		];
	}
}
