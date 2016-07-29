<?php

class UserRenameToolController extends SpecialPage {
	private $oldUsername;
	private $newUsername;
	private $reason;
	private $token;
	private $notifyRenamed;
	private $confirmAction;
	private $showConfirm = true;

	private $errors = [];
	private $warnings = [];
	private $info = [];

	public function __construct() {
		parent::__construct( 'UserRenameTool', 'renameuser', true );
	}

	public function execute( $par ) {
		$this->setup();
		$this->getRequestData( $par );
		$this->runRenameProcess();
		$this->renderTemplate();
		return;
	}

	private function setup() {
		global $wgOut, $wgStatsDBEnabled, $wgJsMimeType, $wgUser;

		$this->setHeaders();
		$oAssetsManager = AssetsManager::getInstance();
		$sSrc = $oAssetsManager->getOneCommonURL( '/extensions/wikia/UserRenameTool/js/UserRenameTool.js' );
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$sSrc}\"></script>" );

		if ( wfReadOnly() || !$wgStatsDBEnabled ) {
			$wgOut->readOnlyPage();

			return;
		}

		if ( !$wgUser->isAllowed( 'renameuser' ) ) {
			throw new PermissionsError( 'renameuser' );
		}
	}

	private function getRequestData( $par ) {
		global $wgRequest, $wgUser;

		$this->oldUsername = $wgRequest->getText( 'oldusername', $par );
		$this->newUsername = $wgRequest->getText( 'newusername' );
		$this->reason = $wgRequest->getText( 'reason' );
		$this->token = $wgUser->getEditToken();
		$this->notifyRenamed = $wgRequest->getBool( 'notify_renamed', false );
		$this->confirmAction = $wgRequest->wasPosted() && $wgRequest->getInt( 'confirmaction' );
	}

	private function runRenameProcess() {
		if ( !$this->isValidRenameRequest() ) {
			return;
		}

		$process = new UserRenameTool\Process\ProcessBaseGlobal(
			$this->oldUsername,
			$this->newUsername,
			$this->confirmAction,
			$this->reason,
			$this->notifyRenamed
		);
		$status = $process->run();

		$this->collectMessages( $process, $status );
	}

	/**
	 * Make sure we can start this rename request
	 *
	 * @return bool
	 */
	private function isValidRenameRequest() {
		$wg = F::app()->wg;

		// Require a POST and edit token
		try {
			$wg->Request->isValidWriteRequest( $wg->User );
		} catch ( Exception $e ) {
			return false;
		}

		if ( !empty( $this->oldUsername ) ) {
			$oldUser = User::newFromName( $this->oldUsername );
			if ( !$oldUser->getGlobalFlag( 'requested-rename', 0 ) ) {
				$this->errors[] = wfMessage( 'userrenametool-did-not-request-rename', $this->oldUsername )->escaped();
				return false;
			}
		}

		return true;
	}

	/**
	 * @param UserRenameTool\Process\ProcessBase $process
	 * @param bool $status
	 */
	private function collectMessages( UserRenameTool\Process\ProcessBase $process, $status ) {
		$this->warnings = $process->getWarnings();
		$this->errors = $process->getErrors();

		if ( $status ) {
			$this->info[] = wfMessage( 'userrenametool-info-in-progress' )->inContentLanguage()->text();
		}

		$this->showConfirm = empty( $this->errors ) && empty( $this->info );

		if ( !empty( $this->oldUsername ) ) {
			$oldUser = User::newFromName( $this->oldUsername );

			if ( $oldUser->getGlobalFlag( 'requested-rename', 0 ) ) {
				$this->info[] = wfMessage( 'userrenametool-requested-rename', $this->oldUsername )->escaped();
			}

			if ( $oldUser->getGlobalFlag( 'wasRenamed', 0 ) ) {
				$this->errors[] = wfMessage( 'userrenametool-previously-renamed', $this->oldUsername )->escaped();
			}
		}
	}

	private function renderTemplate() {
		global $wgTitle, $wgUser, $wgOut;

		$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$template->set_vars( [
			'submitUrl' => $wgTitle->getLocalURL(),
			'oldusername' => $this->oldUsername,
			'oldusername_hsc' => htmlspecialchars( $this->oldUsername ),
			'newusername' => $this->newUsername,
			'newusername_hsc' => htmlspecialchars( $this->newUsername ),
			'reason' => $this->reason,
			'move_allowed' => $wgUser->isAllowed( 'move' ),
			'confirmaction' => $this->confirmAction,
			'warnings' => $this->warnings,
			'errors' => $this->errors,
			'infos' => $this->info,
			'show_confirm' => $this->showConfirm,
			'token' => $this->token,
			'notify_renamed' => $this->notifyRenamed,
		] );

		$wgOut->addHTML( $template->render( 'UserRenameTool' ) );
	}
}
