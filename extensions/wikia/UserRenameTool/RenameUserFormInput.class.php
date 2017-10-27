<?php

class RenameUserFormInput {
	private $newUsername;
	private $repeatUsername;
	private $reason;
	private $user;
	private $token;
	private $isConfirmed;

	public function __construct( WebRequest $request, User $user ) {
		$this->newUsername = $request->getText( 'newusername' );
		$this->repeatUsername = $request->getText( 'newusernamerepeat' );
		$this->reason = $request->getText( 'reason' );
		$this->user = $user;
		$this->token = $request->getText( 'token' );
		$this->isConfirmed = $request->wasPosted() && $request->getInt( 'confirm_action' );

		if ( !$request->wasPosted() ) {
			$this->token = $user->getEditToken();
		}
	}

	public function validateInputVariables() {
		$errorList = [];

		if ( $this->token === '' ) {
			$errorList[] = 'userrenametool-error-token_not_exists';
		}

		if ( $this->newUsername !== $this->repeatUsername ) {
			$errorList[] = 'userrenametool-error-not-repeated_correctly';
		}

		if ( !$this->user->matchEditToken( $this->token ) ) {
			$errorList[] = 'userrenametool-error-token_not_matched';
		}

		if ( !$this->isUserAbleToChangeUsername() ) {
			$errorList[] = 'userrenametool-error-alreadyrenamed';
		}

		return $errorList;
	}

	public function createRenameUserProcess(): RenameUserProcess {
		return new RenameUserProcess( $this->user->getName(), $this->newUsername,
			$this->isConfirmed, $this->reason );
	}

	public function getFallbackData() {
		return [
			"oldusername" => $this->user->getName(),
			"oldusername_hsc" => htmlspecialchars( $this->user->getName() ),
			"newusername" => $this->newUsername,
			"newusername_hsc" => htmlspecialchars( $this->newUsername ),
			"newusername_repeat_hsc" => $this->repeatUsername,
			"reason" => $this->reason,
			"move_allowed" => $this->user->isAllowed( 'move' ),
			"confirm_action" => $this->isConfirmed,
			"token" => $this->token,
		];
	}

	private function isUserAbleToChangeUsername(): bool {
		return !$this->user->getGlobalFlag( 'wasRenamed', 0 );
	}

}