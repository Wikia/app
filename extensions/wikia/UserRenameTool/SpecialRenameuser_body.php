<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "RenameUser extension\n";
	exit( 1 );
}

# Add messages
wfLoadExtensionMessages( 'UserRenameTool' );

/**
 * Special page allows authorised users to rename
 * user accounts
 */
class SpecialRenameuser extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'UserRenameTool', 'renameuser', false );
	}

	/**
	 * Show the special page
	 *
	 * @param mixed $par Parameter passed to the page
	 */
	public function execute( $par ) {
		wfProfileIn(__METHOD__);

		global $wgOut, $wgUser, $wgTitle, $wgRequest, $wgContLang, $wgLang;
		global $wgVersion, $wgMaxNameChars, $wgCapitalLinks;

		$this->setHeaders();

		if( !$wgUser->isAllowed( 'renameuser' ) ) {
			$wgOut->permissionRequired( 'renameuser' );

			wfProfileOut(__METHOD__);
			return;
		}

		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();

			wfProfileOut(__METHOD__);
			return;
		}


		// Get the request data
		$oldusername = $wgRequest->getText( 'oldusername' );
		$newusername = $wgRequest->getText( 'newusername' );
		$reason = $wgRequest->getText( 'reason' );
		$token = $wgUser->editToken();
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
			$process = new RenameUserProcess($oldusername, $newusername, $confirmaction, $reason);
			$status = $process->run();
			$warnings = $process->getWarnings();
			$errors = $process->getErrors();
			if ($status) {
				$infos[] = wfMsgForContent('renameuser-info-in-progress');
			}
		}

		$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$template->set_vars(
			array (
				"submitUrl"     => $wgTitle->getLocalUrl(),
				"oldusername"   => $oldusername,
				"newusername"   => $newusername,
				"reason"        => $reason,
				"move_allowed"  => $wgUser->isAllowed( 'move' ),
				"confirmaction" => $confirmaction,
				"warnings"      => $warnings,
				"errors"        => $errors,
				"infos"         => $infos,
				"token"         => $token,
			)
		);

		$text = $template->render( "rename-form" );
		$wgOut->addHTML($text);
		
		wfProfileOut(__METHOD__);
		return;
	}
}