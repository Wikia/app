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

		$usernameParam = $this->getRequest()->getText( 'username', $par );

		// SUS-3549: normalize the user name
		// make the first letter uppercase, replace underscores with spaces
		$usernameParam = User::getCanonicalName( $usernameParam );

		$username = User::isValidUsername( $usernameParam ) ? $usernameParam : null;
		$requestorUser = $this->getUser();
		$canRenameAnotherUser = $requestorUser->isAllowed( 'renameanotheruser' );

		if ( $requestorUser->isAnon() || !$requestorUser->isAllowed( 'renameuser' ) ) {
			throw new PermissionsError( 'renameuser' );
		}

		if ( $username && !$canRenameAnotherUser ) {
			throw new PermissionsError( 'renameanotheruser' );
		}

		if ( wfReadOnly() || !$wgStatsDBEnabled ) {
			$this->getOutput()->readOnlyPage();

			return;
		}

		if ( \RenameUserProcess::canUserChangeUsername( $requestorUser ) ) {
			$this->renderForm( $username );
		} else {
			$this->renderDisallow();
		}

		return;
	}

	private static function validateData( array $data, User $user, bool $selfRename = true ) {
		global $wgMaxNameChars;

		$errorList = [];
		$newUsername = $data['newUsername'];

		if ( $data['token'] === '' ) {
			$errorList[] = 'userrenametool-error-token-not-exists';
		}

		if ( $newUsername === '' ) {
			$errorList[] = 'userrenametool-error-no-username';
		}

		if ( $newUsername !== $data['newUsernameRepeat' ] ) {
			$errorList[] = 'userrenametool-error-not-repeated-correctly';
		}

		if ( !\User::isValidUserName( $newUsername ) ) {
			$errorList[] = 'userrenametool-error-non-alphanumeric';
		}

		if ( mb_strlen( $newUsername ) > $wgMaxNameChars ) {
			$errorList[] = 'userrenametool-error-too-long';
		}

		if ( $data['understandConsequences'] !== 'true' ) {
			$errorList[] = 'userrenametool-error-consequences';
		}

		if ( !$user->matchEditToken( $data['token'] ) ) {
			$errorList[] = 'userrenametool-error-token-not-match';
		}

		if ( $selfRename && !$user->checkPassword( $data['password'] )->success() ) {
			$errorList[] = 'userrenametool-error-password-not-match';
		}

		if ( $selfRename && !$user->isEmailConfirmed() ) {
			$errorList[] = 'userrenametool-error-email-not-confirmed';
		}

		if ( !\RenameUserProcess::canUserChangeUsername( $user ) ) {
			$errorList[] = 'userrenametool-error-alreadyrenamed';
		}

		return $errorList;
	}

	/**
	 * @param string|null $oldUsername
	 */
	private function renderForm( $oldUsername = null ) {
		global $wgMaxNameChars;

		$errors = [];
		$infos = [];
		$warnings = [];
		$showConfirm = false;
		$showForm = true;
		$requestorUser = $this->getUser();
		$canonicalNewUsername = '';
		$out = $this->getOutput();
		$request = $this->getRequest();
		$requestData = $this->getData();
		$newUsername = $requestData['newUsername'];
		$isConfirmed = ( $requestData['isConfirmed'] === 'true' );

		if ( is_null( $oldUsername ) ) {
			$oldUsername = $requestorUser->getName();
			$selfRename = true;
		}
		else {
			// SUS-3547: staff mode, we want to rename a different user, not ourselves
			$selfRename = $requestorUser->getName() === $oldUsername;
		}

		if ( $request->wasPosted() ) {
			$errors = $this->parseMessages( self::validateData( $requestData, $requestorUser, $selfRename ) );
			$canonicalNewUsername = \User::getCanonicalName( $newUsername, 'creatable' );

			if ( empty( $errors ) && $isConfirmed ) {
				$process = new RenameUserProcess( $oldUsername, $canonicalNewUsername, true );
				$status = $process->run();
				$warnings = $process->getWarnings();
				$errors = $process->getErrors();

				if ( $status ) {
					$infos[] =
						$this->msg( 'userrenametool-info-in-progress' )
							->inContentLanguage()->escaped();
					$showForm = false;
				}
			}

			$showConfirm = ( !$isConfirmed && empty( $errors ) && empty( $info ) );
		}

		$template = new EasyTemplate( __DIR__ . '/templates/' );
		$template->set_vars( array_merge(
			array_map( 'htmlspecialchars', $requestData ),
			[
				'submitUrl' => $this->getTitle($selfRename ? false : $oldUsername )->getLocalURL(),
				'token' => $requestorUser->getEditToken(),
				'maxUsernameLength' => $wgMaxNameChars,
				'showForm' => $showForm,
				'oldUsername' => $oldUsername,
				'selfRename' => $selfRename,
				'errors' => array_merge( $errors, $warnings ),
				'infos' => $infos
			]
		) );

		$out->addModules( 'ext.renameuser.modal' );
		$out->addJsConfigVars( [
			'renameUser' => [
				'showConfirm' => $showConfirm,
				'oldUsername' => $oldUsername,
				'newUsername' => $canonicalNewUsername
			]
		] );
		$out->addHTML( $template->render( 'rename-form' ) );
	}

	private function renderDisallow() {
		$template = new EasyTemplate( __DIR__ . '/templates/' );
		$this->getOutput()->addHTML( $template->render( 'rename-disallowed' ) );
	}

	private function parseMessages( array $messageNames ) {
		return array_map( function ( $label ) {
			return $this->msg( $label )->inContentLanguage();
		}, $messageNames );
	}

	private function getData() {
		$fields = ['newUsername', 'newUsernameRepeat', 'password', 'understandConsequences', 'token', 'isConfirmed'];
		$data = [];
		$request = $this->getRequest();

		foreach ( $fields as $field ) {
			$data[$field] = $request->getText( $field );
		}

		$data['newUsername'] = ucfirst( $data['newUsername'] );
		$data['newUsernameRepeat'] = ucfirst( $data['newUsernameRepeat'] );

		return $data;
	}
}
