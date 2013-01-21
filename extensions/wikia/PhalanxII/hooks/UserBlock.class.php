<?php

/**
 * UserBlock
 * @author Piotr Molski <moli@wikia-inc.com>
 * @date 2013-01-16
 */

class UserBlock extends WikiaObject {
	function __construct(){
		parent::__construct();
		F::setInstance( __CLASS__, $this );
	}
	
	/**
	 * @desc blockCheck() will return false if user is blocked. The reason why it was
	 * written in such way is below when you look at method UserBlock::onUserCanSendEmail().
	 */
	public function blockCheck(User $user) {
		$this->wf->profileIn( __METHOD__ );
		
		$ret = true;
		$phalanxModel = F::build('PhalanxModel', array( $user ), 'newFromUser' );
		 
		if ( $phalanxModel->allowedCheck() ) {
			wfDebug ( __METHOD__ . ": user has 'phalanxexempt' right - no block will be applied\n" );
			$this->wf->profileIn( __METHOD__ );
			return true;
		}

		$ret = PhalanxService::check( "user", $user->getName() );

		// to do - set mBlocked in User object
		// to do - I need block details here to set block object

		$this->wf->profileOut( __METHOD__ );
		return $ret;
	}

	public function userCanSendEmail( &$user, &$canSend ) {
		$canSend = $this->blockCheck( $user );
		return true;
	}

	public function abortNewAccount( $user, &$abortError ) {
		// check $user->getName();
		
		// check $user->getEmail();
		
		// abortError = wfMsg('')
		return true;
	}

	public function validateUserName( $userName, &$abortError ) {
		$this->wf->profileIn( __METHOD__ );
		
		$user = User::newFromName($userName);
		$message = '';
		if ( !$user || !$this->abortNewAccount( $user, $message ) ) {
			$abortError = $this->wf->Msg( 'phalanx-user-block-new-account' );
			$ret = false;
		} else { 
			$ret = true;
		}
		
		$this->wf->profileOut( __METHOD__ );
		return $ret;
	}
}
