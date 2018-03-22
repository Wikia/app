<?php

class PhalanxUserModel extends PhalanxModel {
	const PHALANX_USER = 0;

	public function __construct( User $user ) {
		parent::__construct();
		$this->user = $user;
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
		} else {
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

    /**
     * Format the message with user block reason. If additional description was provided when creating that block,
     * it's included in the message.
     *
     * @param String $reason Optional reason that came with the block
     * @param bool $isExact Set to true for exact block
     * @param bool $isBlockIP Set to true for IP blocks
     * @return String Translated message with optional reason details
     */
    protected function getBlockReasonMessage( $reason, $isExact, $isBlockIP ) {
        if ( $reason ) {
            // a reason was given
            if ( $isExact ) {
                $result = wfMsg( 'phalanx-user-block-withreason-exact', $reason );
            } elseif ( $isBlockIP ) {
                $result = wfMsg( 'phalanx-user-block-withreason-ip', $reason );
            } else {
                $result = wfMsg( 'phalanx-user-block-withreason-similar', $reason );
            }
        } else {
            // no reason in block data, so use preexisting no-param worded versions
            if ( $isExact ) {
                $result = wfMsg( 'phalanx-user-block-reason-exact' );
            } elseif ( $isBlockIP ) {
                $result = wfMsg( 'phalanx-user-block-reason-ip' );
            } else {
                $result = wfMsg( 'phalanx-user-block-reason-similar' );
            }
        }
        return $result;
    }

	public function userBlock( $type = 'exact' ) {
		wfProfileIn( __METHOD__ );

		$this->user->mBlockedby = $this->block->getAuthorId();
		$this->user->mBlockedGlobally = true;
		$this->user->mBlockreason = $this->getBlockReasonMessage( $this->block->getReason(), $type == 'exact', $type == 'ip' );

		// set expiry information
		$this->user->mBlock = new Block();
		// protected
		$this->user->mBlock->setId( $this->block->getId() );
		$this->user->mBlock->setBlockEmail( true );
		$this->user->mBlock->setBlocker( User::newFromID( $this->block->getAuthorId() ) );

		// SUS-351: Prevent Phalanxed user from posting on their own Wall
		$this->user->mBlock->prevents( 'editownusertalk', true );

		$blockExpiry = $this->block->getExpires();
		$this->user->mBlock->mExpiry = !empty( $blockExpiry ) ? $blockExpiry : 'infinity';
		$this->user->mBlock->mTimestamp = $this->block->getTimestamp();
		$this->user->mBlock->mAddress = $this->block->getText();

		wfProfileOut( __METHOD__ );
		return $this;
	}

	public function match_user() {
		return $this->match( "user" );
	}

	public function match_email() {
		return $this->setText( $this->user->getEmail() )->match( "email" );
	}
}
