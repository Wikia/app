<?php

class PhalanxUserModel extends PhalanxModel {
	protected $user = null;
	const PHALANX_USER = 0;	

	public function __construct( $user, $lang = '', $id = 0 ) {
		parent::__construct( __CLASS__, array( 'user' => $user, 'lang' => $lang, 'id' => $id ) );
	}
	
	public function isOk() {
		return $this->user->isAllowed( 'phalanxexempt' );
	}

	public function userBlock( $type = 'exact' ) {
		$this->wf->profileIn( __METHOD__ );
	
		$this->user->mBlockedby = self::PHALANX_USER;
		$this->user->mBlockedGlobally = true;

		if ( $type == 'exact' ) {
			$this->user->mBlockreason = $this->wf->Msg( 'phalanx-user-block-reason-exact' );
		} elseif ( $type = 'ip' ) {
			$this->user->mBlockreason = $this->wf->Msg( 'phalanx-user-block-reason-ip' );
		} else {
			$this->user->mBlockreason = $this->wf->Msg( 'phalanx-user-block-reason-similar' );
		}

		// set expiry information
		$this->user->mBlock = new Block();
		// protected
		$this->user->mBlock->setId( $this->block->id );
		$this->user->mBlock->setBlockEmail( true );
		// public
		$this->user->mBlock->mExpiry = ( isset( $this->block->expires ) && !empty( $this->block->expires ) ) ? $this->block->expires : 'infinity';
		$this->user->mBlock->mTimestamp = $this->wf->TimestampNow();
		$this->user->mBlock->mAddress = $this->block->text;

		if ( $type == 'ip' ) {
			$this->user->mBlock->setCreateAccount( 1 );
		}

		$this->wf->profileOut( __METHOD__ );
		return $this;
	}
	
	public function match_user( &$user ) {
		$result = $this->setText( $this->user->getName() )->match( "user" );
		$user = $this->userBlock( $user->isAnon() ? 'ip' : 'exact' )->getUser();
		return $result;
	}
	
	public function match_user_old() {
		// TO DO
		/* problem with Phalanx service? */
		// include_once( dirname(__FILE__) . '/../prev_hooks/UserBlock.class.php';
		// $ret = UserBlock::blockCheck( $user );
	}
	
	public function match_email() {
		return $this->setText( $this->user->getEmail() )->match( "email" );
	}
	
	public function match_email_old() {
		// TO DO
		/* problem with Phalanx service? */
		// include_once( dirname(__FILE__) . '/../prev_hooks/UserBlock.class.php';
		// $ret = UserBlock::onAbortNewAccount( $user, $abortError );
	}
}
