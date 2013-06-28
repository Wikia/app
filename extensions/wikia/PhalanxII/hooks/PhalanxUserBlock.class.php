<?php

/**
 * PhalanxUserBlock
 * @author Piotr Molski <moli@wikia-inc.com>
 * @date 2013-01-16
 */

class PhalanxUserBlock extends WikiaObject {
	private static $typeBlock = null;
	function __construct(){
		parent::__construct();
		F::setInstance( __CLASS__, $this );
	}
	
	/**
	 * handler for hook blockCheck
	 *
	 * @static
	 *
	 * @desc blockCheck() will return false if user is blocked. The reason why it was
	 * written in such way is below when you look at method UserBlock::onUserCanSendEmail().
	 */
	static public function blockCheck( User $user ) {
		wfProfileIn( __METHOD__ );

		$phalanxModel = new PhalanxUserModel( $user );
		$ret = $phalanxModel->match_user();
		if ( $ret !== false ){
			$ret = $phalanxModel->match_email();
			if ( $ret === false ) {
				self::$typeBlock = 'email';
			}
		}
		
		if ( $ret === false ) {
			$user = $phalanxModel->userBlock( $user->isAnon() ? 'ip' : 'exact' )->getUser();
			self::$typeBlock = (empty( self::$typeBlock ) ) ? 'user' : self::$typeBlock;
		}
		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * hook
	 *
	 * @static
	 */
	static public function userCanSendEmail( &$user, &$canSend ) {
		$canSend = self::blockCheck( $user );
		return true;
	}

	/**
	 * hook
	 * 
	 * @static
	 */
	static public function abortNewAccount( $user, &$abortError ) {
		wfProfileIn( __METHOD__ );

		$ret = self::blockCheck( $user );

		if ( $ret === false ) {
			$abortError = wfMsg( ( self::$typeBlock == 'email' )
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
			$ret = self::abortNewAccount( $user, $abortError );
		}
		else {
			$ret = false;
		}

		wfProfileOut( __METHOD__ );
		return $ret;
	}
}
