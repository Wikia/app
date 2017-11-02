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
	private $app;
	private $newUsername;
	private $repeatUsername;
	private $reason;
	private $user;
	private $token;
	private $isConfirmed;

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'UserRenameTool', 'renameuser', true );
		$this->app = F::app();
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

		if ( wfReadOnly() || !$wgStatsDBEnabled ) {
			$this->getOutput()->readOnlyPage();

			return;
		}

		$user = $this->getUser();

		if ( \RenameUserHelper::canUserChangeUsername( $user ) ) {
			$this->renderForm( $user );
		} else {
			$this->renderRejection();
		}

		return;
	}

	private function renderForm( $user ) {
		// Get the request data
		$this->addModule("ext.userRename.modal");

		$errors = [];
		$info = [];
		$warnings = [];
		$showConfirm = false;
		$showForm = true;
		$request = $this->getRequest();
		$requestData = $this->getData();

		if ( $request->wasPosted() ) {
			$errors = $this->parseMessages( self::validateData( $requestData, $user ) );

			if ( empty( $errors ) ) {
				$oldUsername = $user->getName();
				$newUsername = $requestData['newUsername'];
				$process = new RenameUserProcess( $oldUsername, $newUsername, true, "" );
				$status = $process->run();
				$warnings = $process->getWarnings();
				$errors = $process->getErrors();

				if ( $status ) {
					$info[] =
						$this->msg( 'userrenametool-info-in-progress' )
							->inContentLanguage()->escaped();
					$showForm = false;
				}
			}

			$showConfirm = ( empty( $errors ) && empty( $info ) );
		}

		// unset password for security reasons
		unset($requestData['password']);

		$template = new EasyTemplate( __DIR__ . '/templates/' );
		$template->set_vars( array_merge(
			array_map('htmlspecialchars', $requestData),
			[
				"submitUrl" => $this->getTitle()->getLocalURL(),
				"token" => $user->getEditToken(),
				"warnings" => $warnings,
				"errors" => $errors,
				"infos" => $info
			]
		) );

		$this->getOutput()->addHTML( $template->render( "rename-form" ) );
	}

	private function renderRejection() {
		$template = new EasyTemplate( __DIR__ . '/templates/' );
		$this->getOutput()->addHTML( $template->render( "rename-disallowed" ) );
	}

	private function addModule( $name ) {
		$this->app->wg->Out->addModules( $name );
	}

	private function parseMessages( array $messageNames ) {
		return array_map( function ( $label ) {
			return $this->msg( $label )->inContentLanguage();
		}, $messageNames );
	}

	private function getData() {
		$fields = ['newUsername', 'newUsernameRepeat', 'password', 'understandConsequences', 'token'];
		$data = [];
		$request = $this->getRequest();

		foreach ( $fields as $field ) {
			$data[$field] = $request->getText( $field );
		}

		return $data;
	}

	private static function validateData( array $data, User $user ) {
		$errorList = [];

		if ( $data['token'] === '' ) {
			$errorList[] = 'userrenametool-error-token_not_exists';
		}

		if ( $data['newUsername'] !== $data['newUsernameRepeat'] ) {
			$errorList[] = 'userrenametool-error-not-repeated_correctly';
		}

		if ( $data['understandConsequences'] !== 'true' ) {
			$errorList[] = 'userrenametool-error-not-understand';
		}

		if ( !$user->matchEditToken( $data['token'] ) ) {
			$errorList[] = 'userrenametool-error-token_not_matched';
		}

		if ( !$user->checkPassword( $data['password'] )->success() ) {
			$errorList[] = 'userrenametool-error-password_not_matched';
		}

		if ( !\RenameUserHelper::canUserChangeUsername( $user ) ) {
			$errorList[] = 'userrenametool-error-alreadyrenamed';
		}

		return $errorList;
	}
}
