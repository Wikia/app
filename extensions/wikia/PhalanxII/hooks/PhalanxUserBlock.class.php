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

		$phalanxModel = new PhalanxUserModel( $user );
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

	/**
	 * setter
	 * @param string $type -- type of block
	 */
	public function setTypeBlock( $type ) {
		$this->typeBlock = $type;
	}

	/**
	 * getter
	 */
	public function getTypeBlock( $type ) {
		return $this->typeBlock;
	}

	/**
	 * hook
	 *
	 * @static
	 */
	static public function userCanSendEmail( &$user, &$canSend ) {
		$userBlock = new PhalanxUserBlock();
		$canSend = $userBlock->blockCheck( $user );
		return true;
	}

	/**
	 * hook
	 * 
	 * @static
	 */
	static public function abortNewAccount( $user, &$abortError ) {
		wfProfileIn( __METHOD__ );
		$userBlock = new PhalanxUserBlock();

		$ret = $userBlock->blockCheck( $user );

		if ( $ret === false ) {
			$abortError = wfMsg( ( $userBlock->getTypeBlock() == 'email' )
				? 'phalanx-email-block-new-account'
				: 'phalanx-user-block-new-account'
			);
		}

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * hook
	 * 
	 * @static
	 */
	static public function validateUserName( $userName, &$abortError ) {
		wfProfileIn( __METHOD__ );

		$user = User::newFromName( $userName );
		if ( $user instanceof User ) {
			$ret = PhalanxUserBlock::abortNewAccount( $user, $abortError );
		}
		else {
			$ret = false;
		}

		wfProfileOut( __METHOD__ );
		return $ret;
	}
}
