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

		if ( wfReadOnly() || !$wgStatsDBEnabled ) {
			$this->getOutput()->readOnlyPage();

			return;
		}

		$user = $this->getUser();

		// TODO: remove after QA tests
		if ( static::shouldUnlock() ) {
			$user->setGlobalFlag( 'wasRenamed', false );
			$user->saveSettings();
		}
		// TODO: end

		if ( \RenameUserHelper::canUserChangeUsername( $user ) ) {
			$this->renderForm( $user );
		} else {
			$this->renderDisallow();
		}

		return;
	}

	public static function validateData( array $data, User $user ) {
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

		if ( !ctype_alnum( $newUsername ) ) {
			$errorList[] = 'userrenametool-error-non-alphanumeric';
		}

		if ( strlen( $newUsername ) > \RenameUserHelper::MAX_USERNAME_LENGTH ) {
			$errorList[] = 'userrenametool-error-too-long';
		}

		if ( $data['understandConsequences'] !== 'true' ) {
			$errorList[] = 'userrenametool-error-consequences';
		}

		if ( !$user->matchEditToken( $data['token'] ) ) {
			$errorList[] = 'userrenametool-error-token-not-match';
		}

		if ( !$user->checkPassword( $data['password'] )->success() ) {
			$errorList[] = 'userrenametool-error-password-not-match';
		}

		if ( !\RenameUserHelper::canUserChangeUsername( $user ) ) {
			$errorList[] = 'userrenametool-error-alreadyrenamed';
		}

		return $errorList;
	}

	// TODO: remove after QA tests
	public static function shouldUnlock( ) {
		global $wgStagingEnvironment, $wgDevelEnvironment;
		parse_str( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_QUERY ), $queryParams );
		return isset( $queryParams['unlock'] ) && ( $wgStagingEnvironment || $wgDevelEnvironment );
	}
	// TODO: end

	private function renderForm( $user ) {
		$errors = [];
		$infos = [];
		$warnings = [];
		$showConfirm = false;
		$showForm = true;
		$cannonicalUsername = '';
		$out = $this->getOutput();
		$request = $this->getRequest();
		$requestData = $this->getData();
		$isConfirmed = $requestData['isConfirmed'] === 'true';

		if ( $request->wasPosted() ) {
			$errors = $this->parseMessages( static::validateData( $requestData, $user ) );
			$cannonicalUsername = \User::getCanonicalName( $requestData['newUsername'] );

			if ( empty( $errors ) && $isConfirmed ) {
				$oldUsername = $user->getName();
				$newUsername = $requestData['newUsername'];
				$process = new RenameUserProcess( $oldUsername, $newUsername, true );
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
				'submitUrl' => $this->getTitle()->getLocalURL(),
				'token' => $user->getEditToken(),
				'maxUsernameLength' => \RenameUserHelper::MAX_USERNAME_LENGTH,
				'showForm' => $showForm,
				'warnings' => $warnings,
				'errors' => $errors,
				'infos' => $infos
			]
		) );

		$out->addModules( 'ext.renameuser.modal' );
		$out->addJsConfigVars( [
			'renameUser' => [
				'showConfirm' => $showConfirm,
				'cannonicalUsername' => $cannonicalUsername
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

		return $data;
	}
}
