<?php

/**
 * PhalanxUserBlock
 * @author Piotr Molski <moli@wikia-inc.com>
 * @date 2013-01-16
 */

class PhalanxUserBlock extends WikiaObject {
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
		 
		if ( !$phalanxModel->isOk() ) {
			wfDebug ( __METHOD__ . ": user has 'phalanxexempt' right - no block will be applied\n" );
			$this->wf->profileOut( __METHOD__ );
			return true;
		}

		$result = $phalanxModel->match( "user" );
		if ( $result !== false ) {
			if ( is_numeric( $result ) && $result > 0 ) {
				/* user is blocked - we have block ID */
				$phalanxModel->setBlockId( $result );
				// set block data ...
				$phalanxModel->userBlock( $user->isAnon() ? 'ip' : 'exact' );
				// ... and assign to user
				$user = $phalanxModel->getUser();
				$ret = false;
			} else {
				$ret = true;
			}
		} else {
			// TO DO
			/* problem with Phalanx service? */
			// include_once( dirname(__FILE__) . '/../prev_hooks/UserBlock.class.php';
			// $ret = UserBlock::blockCheck( $user );		
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
		
		$phalanxModel = F::build('PhalanxUserModel', array( $user ) );

		$result = $phalanxModel->match( "user" );
		if ( $result !== false && !is_numeric( $result ) ) {
			/* check also user email */
			$phalanxModel->setText( $user->getEmail() );
			$result = $phalanxModel->match( "email" );
		}
		
		if ( $result !== false && ( is_numeric( $result ) && $result > 0 ) ) {
			$abortError = $this->wf->Msg( 'phalanx-user-block-new-account' );
			$ret = false;
		} elseif ( $result === false ) {
			// TO DO
			/* problem with Phalanx service? */
			// include_once( dirname(__FILE__) . '/../prev_hooks/UserBlock.class.php';
			// $ret = UserBlock::onAbortNewAccount( $user, $abortError );		
		} else {
			$ret = true;
		}

		$this->wf->profileOut( __METHOD__ );
		return $ret;
	}

	public function validateUserName( $userName, &$abortError ) {
		$this->wf->profileIn( __METHOD__ );
		$message = '';
		
		$user = User::newFromName($userName);
		if ( !$user || !$this->abortNewAccount( $user, $abortError ) ) {
			$ret = false;
		} else { 
			$ret = true;
		}
		
		$this->wf->profileOut( __METHOD__ );
		return $ret;
	}
}
