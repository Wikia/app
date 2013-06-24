<?php

class PhalanxUserModel extends PhalanxModel {
	const PHALANX_USER = 0;	

	public function __construct( $user, $lang = '', $id = 0 ) {
		parent::__construct( __CLASS__, array( 'user' => $user, 'lang' => $lang, 'id' => $id ) );
	}
	
	public function getText() {
		return ( !empty( $this->text ) ) ? $this->text : array( ( $this->user instanceof User ) ? $this->user->getName() : "", $this->ip );
	}
	
	public function userBlock( $type = 'exact' ) {
		wfProfileIn( __METHOD__ );
	
		$this->user->mBlockedby = $this->block->authorId;
		$this->user->mBlockedGlobally = true;

		if ( $type == 'exact' ) {
			$this->user->mBlockreason = wfMsg( 'phalanx-user-block-reason-exact' );
		} elseif ( $type = 'ip' ) {
			$this->user->mBlockreason = wfMsg( 'phalanx-user-block-reason-ip' );
		} else {
			$this->user->mBlockreason = wfMsg( 'phalanx-user-block-reason-similar' );
		}

		// set expiry information
		$this->user->mBlock = new Block();
		// protected
		$this->user->mBlock->setId( $this->block->id );
		$this->user->mBlock->setBlockEmail( true );
		$this->user->mBlock->setBlocker( User::newFromID( $this->block->authorId ) );
		// public
		$this->user->mBlock->mExpiry = ( isset( $this->block->expires ) && !empty( $this->block->expires ) ) ? $this->block->expires : 'infinity';
		$this->user->mBlock->mTimestamp = wfTimestampNow();
		$this->user->mBlock->mAddress = $this->block->text;

		if ( $type == 'ip' ) {
			$this->user->mBlock->setCreateAccount( 1 );
		}

		wfProfileOut( __METHOD__ );
		return $this;
	}
	
	public function match_user() {
		return $this->match( "user" );
	}
	
	public function match_user_old() {
		/* problem with Phalanx service? - use previous version of Phalanx extension - tested */
		return UserBlock::blockCheck( $this->user, $this->block );
	}
	
	public function match_email() {
		return $this->setText( $this->user->getEmail() )->match( "email" );
	}
	
	public function match_email_old() {
		/* problem with Phalanx service? - use previous version of Phalanx extension - tested */
		$abortError = '';
		return UserBlock::onAbortNewAccount( $this->user, $abortError, $this->block );
	}
}
