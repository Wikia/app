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
		$this->addJSFiles();

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
		$request = $this->getRequest();
		$userRenameInput = new RenameUserFormInput( $request, $user );

		$errors = [];
		$info = [];
		$warnings = [];
		$showConfirm = false;
		$showForm = true;

		if ( $request->wasPosted() ) {
			$validationErrors = $this->parseMessages( $userRenameInput->validateInputVariables() );
			$errors = array_merge( $validationErrors, $errors );

			if ( empty( $errors ) && $userRenameInput->isRenameConfirmed() ) {
				$process = $userRenameInput->createRenameUserProcess();
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

		$template = new EasyTemplate( __DIR__ . '/templates/' );
		$template->set_vars( array_merge( $userRenameInput->getFallbackData(), [
			"submitUrl" => $this->getTitle()->getLocalURL(),
			"warnings" => $warnings,
			"errors" => $errors,
			"infos" => $info,
			"show_confirm" => $showConfirm,
			"show_form" => $showForm,
		] ) );

		$this->getOutput()->addHTML( $template->render( "rename-form" ) );
	}

	private function renderRejection() {
		$template = new EasyTemplate( __DIR__ . '/templates/' );
		$this->getOutput()->addHTML( $template->render( "rename-disallowed" ) );
	}

	private function addJSFiles() {
		$this->getOutput()->addScript( Html::linkedScript( AssetsManager::getInstance()
			->getOneCommonURL( '/extensions/wikia/UserRenameTool/js/NewUsernameUrlEncoder.js' ) ) );
	}

	private function parseMessages( array $messageNames ) {
		return array_map( function ( $label ) {
			return $this->msg( $label )->inContentLanguage();
		}, $messageNames );
	}
}
