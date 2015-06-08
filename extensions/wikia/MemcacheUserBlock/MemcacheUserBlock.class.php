<?php

class MemcacheUserBlock {

	use Wikia\Logger\Loggable;

	const DEFAULT_BLOCK_TTL = 300; // 5 minutes
	const BLOCKER_NAME = 'WikiaBot';

	private $mUser;
	private $memc;

	function __construct( User $user ) {
		global $wgMemc;

		$this->mUser = $user;
		$this->memc = $wgMemc;
	}

	public function setBlock( $reason, $ttl = self::DEFAULT_BLOCK_TTL ) {
		// set the key with the block expiry time and the reason
		$this->memc->set(
			$this->getMemcacheBlockKey(),
			[
				'expiry' => time() + $ttl,
				'reason' => $reason,
				'set_at' => time()
			],
			$ttl
		);

		$this->info( __METHOD__, [
			'reason' => $reason
		] );
	}

	public function removeBlock() {
		$this->memc->delete( $this->getMemcacheBlockKey() );
		$this->info( __METHOD__ );
	}

	/**
	 * Get block instance for the current user, if it exists
	 *
	 * @return Block|false
	 */
	public function getBlock() {
		$blockData = $this->memc->get( $this->getMemcacheBlockKey() );

		if ( is_array( $blockData ) ) {
			$blocker = User::newFromName( self::BLOCKER_NAME );

			$block = new Block();
			$block->setTarget( $this->mUser );
			$block->setBlocker( $blocker );
			$block->setBlockEmail( $blocker->getEmail() );
			$block->mReason = $blockData['reason'];
			$block->mExpiry = $blockData['expiry'];
			$block->mTimestamp = wfTimestamp( TS_MW, $blockData['set_at'] );

			$this->info( __METHOD__, [
				'reason' => $block->mReason,
				'expiry' => $block->getExpiry()
			] );

			return $block;
		}
		else {
			return false;
		}
	}

	/**
	 * @return String memcache key
	 */
	private function getMemcacheBlockKey( ) {
		return wfMemcKey( __CLASS__, $this->mUser->getId() );
	}

	protected function getLoggerContext() {
		return [
			'user' => $this->mUser->getName()
		];
	}

	/**
	 * Check if the given user has a local block set in memcache
	 *
	 * Called via Hook
	 *
	 * @param User $user
	 * @param Title $title
	 * @param $blocked
	 * @param $allowUsertalk
	 * @return bool
	 */
	static public function onUserIsBlockedFrom( User $user, Title $title, &$blocked, &$allowUsertalk ) {
		$instance = new self( $user );
		$block = $instance->getBlock();

		if ( $block instanceof Block ) {
			$user->mBlock = $block;
			$blocked = true;

			// dirty hack to make the block be displayed properly to the user
			$user->mBlockreason = $block->mReason;
			$user->mBlockedby = $block->getByName();
		}

		return true;
	}

}
