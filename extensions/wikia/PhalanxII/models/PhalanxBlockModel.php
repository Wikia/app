<?php
class PhalanxBlockModel extends PhalanxModel {
	const PHALANX_USER = 0;
	
	private $blockId = 0;
	private $user = null;
	
	public static function newFromBlock( Int $id ) {
		$oModel = F::build( 'PhalanxModel' );
		$oModel->setBlockId( $id );
	}
	
	public static function newFromUser ( User $user ) {
		$oModel = F::build( 'PhalanxModel' );
		$oModel->setUser( $user );
	}
	
	public function allowedCheck() {
		return $this->user->isAllowed( 'phalanxexempt' );
	}
	
	public function blockData( $type = 'exact' ) {
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
		$this->user->mBlock->setId( $this->blockId );
		$this->user->mBlock->setBlockEmail( true );
		// public
		$this->user->mBlock->mExpiry = 'infinity'; // is_null($blockData['expire']) ? 'infinity' : $blockData['expire'];
		$this->user->mBlock->mTimestamp = $this->wf->TimestampNow(); //wfTimestamp( TS_MW, $blockData['timestamp'] );
		$this->user->mBlock->mAddress = ''; //$blockData['text'];

		if ( $type == 'ip' ) {
			$this->user->mBlock->setCreateAccount( 1 );
		}

		$this->wf->profileOut( __METHOD__ );
	}
	
	public function setBlockId( $id ) {
		$this->blockId = ( int ) $id;
	}
	
	private function setUser( $user ) {
		$this->user = $user
	}
	
	public function getUser() {
		return $this->user;
	}
}
