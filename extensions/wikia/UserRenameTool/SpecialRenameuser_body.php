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
	 */
	public function execute( $par ) {
		wfProfileIn(__METHOD__);

		global $wgOut, $wgUser, $wgTitle, $wgRequest, $wgStatsDBEnabled, $wgJsMimeType;

		$this->setHeaders();

		$oAssetsManager = AssetsManager::getInstance();

		$sSrc = $oAssetsManager->getOneCommonURL( '/extensions/wikia/UserRenameTool/js/NewUsernameUrlEncoder.js' );
        $wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$sSrc}\"></script>" );

		if( wfReadOnly() || !$wgStatsDBEnabled ) {
			$wgOut->readOnlyPage();

			wfProfileOut( __METHOD__ );
			return;
		}

		if( !$wgUser->isAllowed( 'renameuser' ) ) {
			wfProfileOut(__METHOD__);
			throw new PermissionsError( 'renameuser' );
		}

		// Get the request data
		$oldusername = $wgRequest->getText( 'oldusername', $par );
		$newusername = $wgRequest->getText( 'newusername' );
		$reason = $wgRequest->getText( 'reason' );
		$token = $wgUser->getEditToken();
		$notifyRenamed = $wgRequest->getBool( 'notify_renamed', false );
		$confirmaction = false;

		if ($wgRequest->wasPosted() && $wgRequest->getInt('confirmaction')){
			$confirmaction = true;
		}

		$warnings = array();
		$errors = array();
		$infos = array();

		if (
			$wgRequest->wasPosted() &&
			$wgRequest->getText( 'token' ) !== '' &&
			$wgUser->matchEditToken($wgRequest->getVal('token'))
		){
			$process = new RenameUserProcess( $oldusername, $newusername, $confirmaction, $reason );
			$status = $process->run();
			$warnings = $process->getWarnings();
			$errors = $process->getErrors();
			if ($status) {
				$infos[] = wfMsgForContent('userrenametool-info-in-progress');
			}
		}

		$showConfirm = ( empty( $errors ) && empty( $infos ) );

		// note: errors and infos beyond this point are non-blocking

		if ( !empty( $oldusername ) ) {
			$olduser = User::newFromName( $oldusername );
			if ( $olduser->getOption( 'requested-rename', 0 ) ) {
				$infos[] = wfMsg( 'userrenametool-requested-rename', $oldusername );
			} else {
				$errors[] = wfMsg( 'userrenametool-did-not-request-rename', $oldusername );
			}
			if ( $olduser->getOption( 'wasRenamed', 0 ) ) {
				$errors[] = wfMsg( 'userrenametool-previously-renamed', $oldusername );
			}
			$phalanxMatches = RenameUserHelper::testBlock( $oldusername );
			if ( $phalanxMatches !== 'No matches found.' ) {
				$errors[] = Xml::tags(
					'p',
					null,
					wfMsg( 'userrenametool-phalanx-matches', htmlspecialchars( $oldusername ) )
				) . $phalanxMatches;
			}
		}
		if ( !empty( $newusername ) ) {
			$phalanxMatches = RenameUserHelper::testBlock( $newusername );
			if ( $phalanxMatches !== 'No matches found.' ) {
				$errors[] = Xml::tags(
					'p',
					null,
					wfMsg( 'userrenametool-phalanx-matches', htmlspecialchars( $newusername ) )
				) . $phalanxMatches;
			}
		}

		$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$template->set_vars(
			array (
				"submitUrl"     	=> $wgTitle->getLocalUrl(),
				"oldusername"   	=> $oldusername,
				"oldusername_hsc"	=> htmlspecialchars($oldusername),
				"newusername"   	=> $newusername,
				"newusername_hsc"	=> htmlspecialchars($newusername),
				"reason"        	=> $reason,
				"move_allowed"  	=> $wgUser->isAllowed( 'move' ),
				"confirmaction" 	=> $confirmaction,
				"warnings"      	=> $warnings,
				"errors"        	=> $errors,
				"infos"         	=> $infos,
				"show_confirm"  	=> $showConfirm,
				"token"         	=> $token,
				"notify_renamed" 	=> $notifyRenamed,
			)
		);

		$text = $template->render( "rename-form" );
		$wgOut->addHTML($text);

		wfProfileOut(__METHOD__);
		return;
	}
}
