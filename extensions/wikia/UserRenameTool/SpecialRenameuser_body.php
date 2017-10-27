<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "RenameUser extension\n";
	exit( 1 );
}

/**
 * Special page allows authorised users to rename
 * user accounts
 */
class SpecialRenameuser extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'UserRenameTool', 'renameuser', true );
	}

	/**
	 * Show the special page
	 *
	 * @param mixed $par Parameter passed to the page
	 *
	 * @throws PermissionsError
	 * @throws ReadOnlyError
	 */
	public function execute( $par ) {
		global $wgStatsDBEnabled;

		$this->setHeaders();
		$this->checkPermissions();

		$out = $this->getOutput();
		$this->addJSFiles();

		if ( wfReadOnly() || !$wgStatsDBEnabled ) {
			$out->readOnlyPage();
			return;
		}

		// Get the request data
		$request = $this->getRequest();
		$userRenameInput = new UserRenameInput($request, $this->getUser());

		$errors = [];
		$info = [];
		$warnings = [];

		if ( $request->wasPosted() ) {
			$validationErrors = $this->parseMessages( $userRenameInput->validateInputVariables() );
			$errors = array_merge( $validationErrors, $errors);

			if ( empty( $errors ) ) {
				$process = $userRenameInput->createRenameUserProcess();
				$status = $process->run();
				$warnings = $process->getWarnings();
				$errors = $process->getErrors();

				if ( $status ) {
					$info[] = $this->msg( 'userrenametool-info-in-progress' )
							->inContentLanguage()->escaped();
				}
			}
		}

		$showConfirm = ( empty( $errors ) && empty( $info ) );

		$template = new EasyTemplate( __DIR__ . '/templates/' );
		$template->set_vars( array_merge( $userRenameInput->getFallbackData(), [
				"submitUrl" => $this->getTitle()->getLocalURL(),
				"warnings" => $warnings,
				"errors" => $errors,
				"infos" => $info,
				"show_confirm" => $showConfirm,
			] ) );

		$out->addHTML( $template->render( "rename-form" ) );

		return;
	}

	private function addJSFiles() {
		$this->getOutput()->addScript( Html::linkedScript( AssetsManager::getInstance()
			->getOneCommonURL( '/extensions/wikia/UserRenameTool/js/NewUsernameUrlEncoder.js' ) ) );
	}

	private function parseMessages( array $messageNames ) {
		return array_map(function ($label) {
			return $this->msg( $label )->inContentLanguage()->escaped();
		}, $messageNames);
	}
}

class UserRenameInput {
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

		if (!$request->wasPosted()) {
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

		if ( $this->user->getGlobalFlag( 'wasRenamed', 0 ) ) {
			$errorList[] = 'userrenametool-error-alreadyrenamed';
		}

		return $errorList;
	}

	public function createRenameUserProcess() : RenameUserProcess {
		return new RenameUserProcess( $this->user->getName(), $this->newUsername,
			$this->isConfirmed,
			$this->reason );
	}

	public function getFallbackData() {
		return [
			"oldusername"   	=> $this->user->getName(),
			"oldusername_hsc"	=> htmlspecialchars( $this->user->getName() ),
			"newusername"   	=> $this->newUsername,
			"newusername_hsc"	=> htmlspecialchars( $this->newUsername ),
			"newusername_repeat_hsc" => $this->repeatUsername,
			"reason"        	=> $this->reason,
			"move_allowed"  	=> $this->user->isAllowed( 'move' ),
			"confirm_action" 	=> $this->isConfirmed,
			"token"         	=> $this->token
		];
	}

}