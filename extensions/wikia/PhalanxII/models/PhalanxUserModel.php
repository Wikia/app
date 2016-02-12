<?php

class PhalanxUserModel extends PhalanxModel {
	const PHALANX_USER = 0;	

	public function __construct( $user, $lang = '', $id = 0 ) {
		parent::__construct( __CLASS__, array( 'user' => $user, 'lang' => $lang, 'id' => $id ) );
	}

	/**
	 * Return the list of string to be checked by Phalanx.
	 *
	 * It can be:
	 *  - an email address (provided via setText method)
	 *  - a user name (passed via $user constructor argument)
	 *  - the IP address taken from the current request (only when performing an action that can be blocked) - see SUS-141
	 *
	 * @return array|string
	 */
	public function getText() {
		if ( !empty( $this->text ) ) {
			// text is used for checking email addresses
			$ret = $this->text;
		}
		else {
			$ret = [
				$this->user instanceof User ? $this->user->getName() : ""
			];

			/**
			 * SUS-141: only check the current user ($wgUser, not $this->user) IP address
			 * when checking the block when trying to perform an action
			 *
			 * Example: do not pass the current IP address when checking the block status
			 * of the owner of user page we're currently visiting (via Masthead code)
			 */
			if ( $this->getShouldLogInStats() === true ) {
				$ret[] = $this->ip;
			}
		}

		return $ret;
	}
	
	public function userBlock( $type = 'exact' ) {
		wfProfileIn( __METHOD__ );
	
		$this->user->mBlockedby = $this->block->authorId;
		$this->user->mBlockedGlobally = true;
		$this->user->mBlockreason = UserBlock::getBlockReasonMessage( $this->block->reason, $type == 'exact', $type == 'ip' );

		// set expiry information
		$this->user->mBlock = new Block();
		// protected
		$this->user->mBlock->setId( $this->block->id );
		$this->user->mBlock->setBlockEmail( true );
		$this->user->mBlock->setBlocker( User::newFromID( $this->block->authorId ) );
		// public
		$this->user->mBlock->mExpiry = ( isset( $this->block->expires ) && !empty( $this->block->expires ) ) ? $this->block->expires : 'infinity';
		$this->user->mBlock->mTimestamp = ( isset( $this->block->timestamp ) ? $this->block->timestamp : wfTimestampNow() );
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
