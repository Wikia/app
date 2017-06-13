<?php
namespace Wikia\CreateNewWiki;

use User;

class UserBlockedException extends ValidationException {
	protected $httpStatusCode = 403;
	protected $headerMessageKey = 'cnw-error-blocked-header';
	protected $errorMessageKey = 'cnw-error-blocked';

	public function __construct( User $user ) {
		parent::__construct();

		$block = $user->getBlock();

		$this->headerMessageParams = [
			$block->getByName(),
			$block->mReason,
			$block->getId(),
		];
	}
}
