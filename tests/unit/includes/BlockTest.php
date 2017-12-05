<?php

class BlockTest extends WikiaDatabaseTest {
	const BLOCKED_USER_ONE_ID = 174;
	const BLOCKED_USER_ONE_NAME = 'BlockedUser';

	const BLOCKED_USER_ONE_BLOCK_ID = 15;
	const BLOCKED_USER_ONE_BLOCK_REASON = 'Vandalism';
	const BLOCKED_USER_ONE_BLOCK_TS = '20110101000000';
	const BLOCKED_USER_ONE_BLOCK_EXPIRY = 'infinity';

	const BLOCKED_ANON_USER = '8.8.8.8';

	const BLOCKED_ANON_USER_BLOCK_ID = 20;
	const BLOCKED_ANON_USER_BLOCK_REASON = 'Spam';
	const BLOCKED_ANON_USER_BLOCK_TS = '20130412050100';
	const BLOCKED_ANON_USER_BLOCK_EXPIRY = '20360712050100';

	const BLOCKING_ADMIN_ID = 192;
	const BLOCKING_ADMIN_NAME = 'BlockingAdmin';

	const NOT_BLOCKED_USER_ID = 283;
	const NOT_BLOCKED_USER_NAME = 'NotBlockedUser';

	const NOT_BLOCKED_ANON = '1.1.1.1';

	private $wgMemc;

	protected function setUp() {
		parent::setUp();

		$this->wgMemc = $GLOBALS['wgMemc'];
		$GLOBALS['wgMemc'] = new EmptyBagOStuff();
	}

	public function testLoadBlockForRegisteredUserIdProvided() {
		$user = User::newFromId( static::BLOCKED_USER_ONE_ID );
		$block = $user->getBlock();

		$this->assertTrue( $user->isBlocked() );

		$this->assertEquals( static::BLOCKING_ADMIN_ID, $block->getBlocker()->getId() );
		$this->assertEquals( static::BLOCKING_ADMIN_NAME, $block->getBlocker()->getName() );

		$this->assertEquals( static::BLOCKED_USER_ONE_BLOCK_ID, $block->getId() );
		$this->assertEquals( static::BLOCKED_USER_ONE_BLOCK_REASON, $block->mReason );
		$this->assertEquals( static::BLOCKED_USER_ONE_BLOCK_TS, $block->mTimestamp );
		$this->assertEquals( static::BLOCKED_USER_ONE_BLOCK_EXPIRY, $block->getExpiry() );
	}

	public function testLoadBlockForRegisteredUserNameProvided() {
		$user = User::newFromName( static::BLOCKED_USER_ONE_NAME );
		$block = $user->getBlock();

		$this->assertTrue( $user->isBlocked() );

		$this->assertEquals( static::BLOCKING_ADMIN_ID, $block->getBlocker()->getId() );
		$this->assertEquals( static::BLOCKING_ADMIN_NAME, $block->getBlocker()->getName() );

		$this->assertEquals( static::BLOCKED_USER_ONE_BLOCK_ID, $block->getId() );
		$this->assertEquals( static::BLOCKED_USER_ONE_BLOCK_REASON, $block->mReason );
		$this->assertEquals( static::BLOCKED_USER_ONE_BLOCK_TS, $block->mTimestamp );
		$this->assertEquals( static::BLOCKED_USER_ONE_BLOCK_EXPIRY, $block->getExpiry() );
	}

	public function testLoadBlockForAnonUser() {
		$user = User::newFromName( static::BLOCKED_ANON_USER, false );
		$block = $user->getBlock();

		$this->assertTrue( $user->isBlocked() );

		$this->assertEquals( static::BLOCKING_ADMIN_ID, $block->getBlocker()->getId() );
		$this->assertEquals( static::BLOCKING_ADMIN_NAME, $block->getBlocker()->getName() );

		$this->assertEquals( static::BLOCKED_ANON_USER_BLOCK_ID, $block->getId() );
		$this->assertEquals( static::BLOCKED_ANON_USER_BLOCK_REASON, $block->mReason );
		$this->assertEquals( static::BLOCKED_ANON_USER_BLOCK_TS, $block->mTimestamp );
		$this->assertEquals( static::BLOCKED_ANON_USER_BLOCK_EXPIRY, $block->getExpiry() );
	}

	public function testLoadBlockForNotBlockedUser() {
		$notBlockedUserById = User::newFromId( static::NOT_BLOCKED_USER_ID );
		$this->assertFalse( $notBlockedUserById->isBlocked() );

		$notBlockedUserByName = User::newFromName( static::NOT_BLOCKED_USER_NAME );
		$this->assertFalse( $notBlockedUserByName->isBlocked() );

		$notBlockedAnon = User::newFromName( static::NOT_BLOCKED_ANON, false );
		$this->assertFalse( $notBlockedAnon->isBlocked() );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/../../fixtures/BlockTest.yaml' );
	}

	protected function tearDown() {
		parent::tearDown();
		$GLOBALS['wgMemc'] = $this->wgMemc;
	}
}
