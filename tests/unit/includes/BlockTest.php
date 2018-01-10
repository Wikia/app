<?php

class BlockTest extends WikiaDatabaseTest {
	const BLOCKED_USER_ONE_ID = 1;
	const BLOCKED_USER_ONE_NAME = 'BlockedUser';

	const BLOCKED_USER_ONE_BLOCK_ID = 1;
	const BLOCKED_USER_ONE_BLOCK_REASON = 'Vandalism';
	const BLOCKED_USER_ONE_BLOCK_TS = '20110101000000';
	const BLOCKED_USER_ONE_BLOCK_EXPIRY = 'infinity';

	const BLOCKED_ANON_USER = '8.8.8.8';

	const BLOCKED_ANON_USER_BLOCK_ID = 2;
	const BLOCKED_ANON_USER_BLOCK_REASON = 'Spam';
	const BLOCKED_ANON_USER_BLOCK_TS = '20130412050100';
	const BLOCKED_ANON_USER_BLOCK_EXPIRY = '20360712050100';

	const BLOCKING_ADMIN_ID = 2;
	const BLOCKING_ADMIN_NAME = 'BlockingAdmin';

	const NOT_BLOCKED_USER_ID = 3;
	const NOT_BLOCKED_USER_NAME = 'NotBlockedUser';

	const NOT_BLOCKED_ANON = '5.5.5.5';

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

		$this->assertEquals( Block::TYPE_USER, $block->getType() );

		$this->assertTrue( (bool)$block->prevents( 'edit' ) );
		$this->assertTrue( (bool)$block->prevents( 'sendemail' ) );
		$this->assertFalse( (bool)$block->prevents( 'editownusertalk' ) );
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

		$this->assertEquals( Block::TYPE_USER, $block->getType() );

		$this->assertTrue( (bool)$block->prevents( 'edit' ) );
		$this->assertTrue( (bool)$block->prevents( 'sendemail' ) );
		$this->assertFalse( (bool)$block->prevents( 'editownusertalk' ) );
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

		$this->assertEquals( Block::TYPE_IP, $block->getType() );

		$this->assertTrue( (bool)$block->prevents( 'edit' ) );
		$this->assertTrue( (bool)$block->prevents( 'sendemail' ) );
		$this->assertFalse( (bool)$block->prevents( 'editownusertalk' ) );
	}

	public function testLoadBlockForNotBlockedUser() {
		$notBlockedUserById = User::newFromId( static::NOT_BLOCKED_USER_ID );
		$this->assertFalse( $notBlockedUserById->isBlocked() );

		$notBlockedUserByName = User::newFromName( static::NOT_BLOCKED_USER_NAME );
		$this->assertFalse( $notBlockedUserByName->isBlocked() );

		$notBlockedAnon = User::newFromName( static::NOT_BLOCKED_ANON, false );
		$this->assertFalse( $notBlockedAnon->isBlocked() );
	}

	public function testLoadAutoBlockByIdReference() {
		$autoBlock = Block::newFromTarget( '#3' );

		$this->assertInstanceOf( Block::class, $autoBlock );
		$this->assertEquals( Block::TYPE_AUTO, $autoBlock->getType() );
		$this->assertEquals( '1.1.1.1', $autoBlock->getTarget() );
	}

	public function testAutoBlockTargetIsRedacted() {
		$autoBlock = Block::newFromTarget( '#3' );

		$this->assertInstanceOf( Block::class, $autoBlock );
		$this->assertNotContains( '1.1.1.1', $autoBlock->getRedactedName() );
	}

	/**
	 * @dataProvider provideNumericUserNames
	 * @param string $numericUserName
	 */
	public function testNoBlockFoundForNumericUserName( string $numericUserName ) {
		$block = Block::newFromTarget( $numericUserName );

		$this->assertNull( $block );
	}

	public function provideNumericUserNames(): Generator {
		yield [ '1234' ]; // existing user
		yield [ '9999' ]; // nonexistent user
	}

	public function testCorrectBlockFoundForBlockedNumericUserName() {
		$user = User::newFromName( '78910' );
		$block = Block::newFromTarget( '78910' );

		$this->assertInstanceOf( Block::class, $block );
		$this->assertEquals( 4, $block->getId() );
		$this->assertEquals( Block::TYPE_USER, $block->getType() );
		$this->assertEquals( $user, $block->getTarget() );
	}

	public function testLoadBlockById() {
		$block = Block::newFromID( static::BLOCKED_USER_ONE_BLOCK_ID );

		$this->assertInstanceOf( Block::class, $block );

		$this->assertEquals( static::BLOCKED_USER_ONE_BLOCK_ID, $block->getId() );
		$this->assertEquals( static::BLOCKED_USER_ONE_BLOCK_REASON, $block->mReason );
		$this->assertEquals( static::BLOCKED_USER_ONE_BLOCK_TS, $block->mTimestamp );
		$this->assertEquals( static::BLOCKED_USER_ONE_BLOCK_EXPIRY, $block->getExpiry() );
	}

	public function testDeleteExpiredBlock() {
		$oldBlock = Block::newFromID( 5 );

		$this->assertInstanceOf( Block::class, $oldBlock );
		$this->assertTrue( $oldBlock->isExpired() );

		$oldBlock->deleteIfExpired();

		$this->assertNull( Block::newFromID( 5 ) );
	}

	public function testUpdateBlock() {
		$block = Block::newFromID( static::BLOCKED_USER_ONE_BLOCK_ID );

		$this->assertInstanceOf( Block::class, $block );
		$this->assertEquals( static::BLOCKED_USER_ONE_BLOCK_REASON, $block->mReason );

		$block->mReason = 'testing';

		$block->update();

		$newBlock = Block::newFromID( static::BLOCKED_USER_ONE_BLOCK_ID );

		$this->assertInstanceOf( Block::class, $newBlock );
		$this->assertEquals( 'testing', $newBlock->mReason );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/../../fixtures/BlockTest.yaml' );
	}
}
