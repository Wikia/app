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
		$this->wf->profileIn( __METHOD__ );

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
		$this->wf->profileOut( __METHOD__ );
		return $ret;
	}

	public function userCanSendEmail( &$user, &$canSend ) {
		$canSend = $this->blockCheck( $user );
		return true;
	}

	public function abortNewAccount( $user, &$abortError ) {
		$this->wf->profileIn( __METHOD__ );
		$ret = $this->blockCheck( $user );

		if ( $ret === false ) {
			$abortError = $this->wf->Msg( ( $this->typeBlock == 'email' ) ? 'phalanx-email-block-new-account' : 'phalanx-user-block-new-account' );
		}

		$this->wf->profileOut( __METHOD__ );
		return $ret;
	}

	public function validateUserName( $userName, &$abortError ) {
		$this->wf->profileIn( __METHOD__ );

		$user = User::newFromName( $userName );
		if ( $user instanceof User ) {
			$ret = $this->abortNewAccount( $user, $abortError );
		} else { 
			$ret = false;
		}

		$this->wf->profileOut( __METHOD__ );
		return $ret;
	}
}
