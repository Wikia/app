<?php
class SpecialRenameUser extends SpecialPage {

	public function __construct() {
		parent::__construct( 'UserRenameTool', 'renameuser', true );
	}

	/**
	 * Show the special page
	 *
	 * @param mixed $par Parameter passed to the page
	 * @throws PermissionsError
	 * @throws ReadOnlyError
	 */
	public function execute( $par ) {
		global $wgOut, $wgUser, $wgTitle, $wgRequest, $wgStatsDBEnabled, $wgJsMimeType;

		$this->setHeaders();

		$oAssetsManager = AssetsManager::getInstance();

		$sSrc = $oAssetsManager->getOneCommonURL( '/extensions/wikia/UserRenameTool/js/NewUsernameUrlEncoder.js' );
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$sSrc}\"></script>" );

		if ( wfReadOnly() || !$wgStatsDBEnabled ) {
			$wgOut->readOnlyPage();
			return;
		}

		if ( !$wgUser->isAllowed( 'renameuser' ) ) {
			throw new PermissionsError( 'renameuser' );
		}

		// Get the request data
		$oldUsername = $wgRequest->getText( 'oldusername', $par );
		$newUsername = $wgRequest->getText( 'newusername' );
		$reason = $wgRequest->getText( 'reason' );
		$token = $wgUser->getEditToken();
		$notifyRenamed = $wgRequest->getBool( 'notify_renamed', false );
		$confirmAction = false;

		if ( $wgRequest->wasPosted() && $wgRequest->getInt( 'confirmaction' ) ) {
			$confirmAction = true;
		}

		$warnings = [];
		$errors = [];
		$info = [];

		if ( $this->validRenameRequest() ) {
			$process = new RenameUserProcess( $oldUsername, $newUsername, $confirmAction, $reason, $notifyRenamed );
			$status = $process->run();
			$warnings = $process->getWarnings();
			$errors = $process->getErrors();
			if ( $status ) {
				$info[] = wfMessage( 'userrenametool-info-in-progress' )->inContentLanguage()->text();
			}
		}

		$showConfirm = ( empty( $errors ) && empty( $info ) );

		// note: errors and info beyond this point are non-blocking

		if ( !empty( $oldUsername ) ) {
			$oldUser = User::newFromName( $oldUsername );
			if ( $oldUser->getGlobalFlag( 'requested-rename', 0 ) ) {
				$info[] = wfMsg( 'userrenametool-requested-rename', $oldUsername );
			} else {
				$errors[] = wfMsg( 'userrenametool-did-not-request-rename', $oldUsername );
			}
			if ( $oldUser->getGlobalFlag( 'wasRenamed', 0 ) ) {
				$errors[] = wfMsg( 'userrenametool-previously-renamed', $oldUsername );
			}
		}

		$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$template->set_vars(
			[
				"submitUrl"     	=> $wgTitle->getLocalUrl(),
				"oldusername"   	=> $oldUsername,
				"oldusername_hsc"	=> htmlspecialchars( $oldUsername ),
				"newusername"   	=> $newUsername,
				"newusername_hsc"	=> htmlspecialchars( $newUsername ),
				"reason"        	=> $reason,
				"move_allowed"  	=> $wgUser->isAllowed( 'move' ),
				"confirmaction" 	=> $confirmAction,
				"warnings"      	=> $warnings,
				"errors"        	=> $errors,
				"infos"         	=> $info,
				"show_confirm"  	=> $showConfirm,
				"token"         	=> $token,
				"notify_renamed" 	=> $notifyRenamed,
			]
		);

		$text = $template->render( "rename-form" );
		$wgOut->addHTML( $text );

		return;
	}

	private function validRenameRequest() {
		$wg = F::app()->wg;

		if ( !$wg->Request->wasPosted() ) {
			return false;
		}

		$token = $wg->Request->getText( 'token' );
		if ( $token === '' ) {
			return false;
		}

		return $wg->User->matchEditToken( $token );
	}
}
