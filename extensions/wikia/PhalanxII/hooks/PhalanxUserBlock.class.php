<?php

/**
 * PhalanxUserBlock
 * @author Piotr Molski <moli@wikia-inc.com>
 * @date 2013-01-16
 */

class PhalanxUserBlock extends WikiaObject {
	private $typeBlock = null;
	function __construct(){
		parent::__construct();
		F::setInstance( __CLASS__, $this );
	}
	
	/**
	 * @desc blockCheck() will return false if user is blocked. The reason why it was
	 * written in such way is below when you look at method UserBlock::onUserCanSendEmail().
	 */
	public function blockCheck( User $user ) {
		wfProfileIn( __METHOD__ );

		$phalanxModel = F::build('PhalanxUserModel', array( $user ) );
		$ret = $phalanxModel->match_user();
		if ( $ret !== false ){
			$ret = $phalanxModel->match_email();
			if ( $ret === false ) {
				$this->typeBlock = 'email';
			}
		} 
		
		if ( $ret === false ) {
			$user = $phalanxModel->userBlock( $user->isAnon() ? 'ip' : 'exact' )->getUser();
			$this->typeBlock = (empty( $this->typeBlock ) ) ? 'user' : $this->typeBlock;
		}
		wfProfileOut( __METHOD__ );
		return $ret;
	}

	public function userCanSendEmail( &$user, &$canSend ) {
		$canSend = $this->blockCheck( $user );
		return true;
	}

	public function abortNewAccount( $user, &$abortError ) {
		wfProfileIn( __METHOD__ );
		$ret = $this->blockCheck( $user );

		if ( $ret === false ) {
			$abortError = $this->wf->Msg( ( $this->typeBlock == 'email' ) ? 'phalanx-email-block-new-account' :
																	 'phalanx-user-block-new-account' );
		}

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	public function validateUserName( $userName, &$abortError ) {
		wfProfileIn( __METHOD__ );

		$user = User::newFromName( $userName );
		if ( $user instanceof User ) {
			$ret = $this->abortNewAccount( $user, $abortError );
		} else { 
			$ret = false;
		}

		wfProfileOut( __METHOD__ );
		return $ret;
	}
}
