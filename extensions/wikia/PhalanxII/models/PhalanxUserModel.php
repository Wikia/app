<?php
class PhalanxUserModel extends PhalanxModel {
	private $user = null;
	const PHALANX_USER = 0;	

	public function __construct( $user, $id = 0 ) {
		parent::__construct( __CLASS__, array( 'user' => $user, 'id' => $id ) );
	}
	
	public function isOk() {
		return $this->user->isAllowed( 'phalanxexempt' );
	}

	public function setUser( $user ) {
		$this->user = $user;
		$this->setText( $this->user->getName() );
		return $this;
	}
	
	public function getUser() {
		return $this->user;
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
	}
}
