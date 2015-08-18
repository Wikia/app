<?php

/**
 * @group UsingDB
 */
class HAWelcomeTaskHookDispatcherTest extends WikiaBaseTest {

	public function testDispatchWhenDisabled() {
		/** @var HAWelcomeTaskHookDispatcher|PHPUnit_Framework_MockObject_MockObject $dispatcher */
		$dispatcher = $this->getMock( HAWelcomeTaskHookDispatcher::class, ['welcomeMessageDisabled'], [], '', false );
		$dispatcher->expects( $this->once() )
			->method( 'welcomeMessageDisabled' )
			->will( $this->returnValue( true ) );

		$this->assertTrue( $dispatcher->dispatch() );
	}

	public function testDispatchBeenWelcomed() {
		/** @var HAWelcomeTaskHookDispatcher|PHPUnit_Framework_MockObject_MockObject $dispatcher */
		$dispatcher = $this->getMock( HAWelcomeTaskHookDispatcher::class, ['currentUserHasBeenWelcomed', 'welcomeMessageDisabled'] );

		$dispatcher->expects( $this->once() )
			->method( 'welcomeMessageDisabled' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'currentUserHasBeenWelcomed' )
			->will( $this->returnValue( true ) );

		$this->assertTrue( $dispatcher->dispatch() );
	}

	public function testDispatchAnonymousUser() {
		/** @var HAWelcomeTaskHookDispatcher|PHPUnit_Framework_MockObject_MockObject $dispatcher */
		$dispatcher = $this->getMock( HAWelcomeTaskHookDispatcher::class, [
			'welcomeMessageDisabled',
			'currentUserHasBeenWelcomed',
			'markCurrentUserAsWelcomed',
			'markHAWelcomePosted',
			'getTitleObjectFromRevision',
			'queueWelcomeTask',
			] );

		$dispatcher->expects( $this->once() )
			->method( 'welcomeMessageDisabled' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'currentUserHasBeenWelcomed' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'markCurrentUserAsWelcomed' );

		$dispatcher->expects( $this->once() )
			->method( 'markHAWelcomePosted' )
			->will( $this->returnValue( null ) );

		/** @var Revision|PHPUnit_Framework_MockObject_MockObject $revision */
		$revision = $this->getMock( Revision::class, ['getRawUser'], [], '', false );

		$revision->expects( $this->once() )
			->method( 'getRawUser' )
			->will( $this->returnValue( 0 ) );

		$title = $this->getMock( Title::class, [] );

		$dispatcher->expects( $this->once() )
			->method( 'getTitleObjectFromRevision' )
			->will( $this->returnValue( $title ) );

		$dispatcher->expects( $this->once() )
			->method( 'queueWelcomeTask' )
			->with( $title )
			->will( $this->returnValue( null ) );

		$dispatcher->setRevisionObject( $revision );
		$this->assertTrue( $dispatcher->dispatch() );
	}

	public function testDispatchRegisteredUserShortCircuit() {
		/** @var HAWelcomeTaskHookDispatcher|PHPUnit_Framework_MockObject_MockObject $dispatcher */
		$dispatcher = $this->getMock( HAWelcomeTaskHookDispatcher::class, [
			'welcomeMessageDisabled',
			'currentUserHasBeenWelcomed',
			'markCurrentUserAsWelcomed',
			'currentUserIsWelcomeExempt',
			] );

		$dispatcher->expects( $this->once() )
			->method( 'welcomeMessageDisabled' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'currentUserHasBeenWelcomed' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'markCurrentUserAsWelcomed' );

		$dispatcher->expects( $this->once() )
			->method( 'currentUserIsWelcomeExempt' )
			->will( $this->returnValue( true ) );

		/** @var Revision|PHPUnit_Framework_MockObject_MockObject $revision */
		$revision = $this->getMock( Revision::class, ['getRawUser'], [], '', false );

		$revision->expects( $this->once() )
			->method( 'getRawUser' )
			->will( $this->returnValue( 1 ) );

		$dispatcher->setRevisionObject( $revision );
		$this->assertTrue( $dispatcher->dispatch() );
	}

	public function testDispatchRegisteredUserHasLocalEdits() {
		/** @var HAWelcomeTaskHookDispatcher|PHPUnit_Framework_MockObject_MockObject $dispatcher */
		$dispatcher = $this->getMock( HAWelcomeTaskHookDispatcher::class, [
			'welcomeMessageDisabled',
			'currentUserHasBeenWelcomed',
			'markCurrentUserAsWelcomed',
			'currentUserIsWelcomeExempt',
			'currentUserIsDefaultWelcomer',
			'currentUserIsFounder',
			'currentUserHasLocalEdits',
			'updateAdminActivity'
			] );

		$dispatcher->expects( $this->once() )
			->method( 'welcomeMessageDisabled' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'currentUserHasBeenWelcomed' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'markCurrentUserAsWelcomed' );

		$dispatcher->expects( $this->once() )
			->method( 'currentUserIsWelcomeExempt' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'currentUserIsDefaultWelcomer' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'currentUserIsFounder' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'currentUserHasLocalEdits' )
			->will( $this->returnValue( true ) );

		$dispatcher->expects( $this->once() )
			->method( 'updateAdminActivity' )
			->will( $this->returnValue( true ) );

		/** @var Revision|PHPUnit_Framework_MockObject_MockObject $revision */
		$revision = $this->getMock( Revision::class, ['getRawUser'], [], '', false );

		$revision->expects( $this->once() )
			->method( 'getRawUser' )
			->will( $this->returnValue( 1 ) );

		$dispatcher->setRevisionObject( $revision );
		$this->assertTrue( $dispatcher->dispatch() );
	}

	public function testDispatchRegisteredUserQueueTask() {
		/** @var HAWelcomeTaskHookDispatcher|PHPUnit_Framework_MockObject_MockObject $dispatcher */
		$dispatcher = $this->getMock( HAWelcomeTaskHookDispatcher::class, [
			'welcomeMessageDisabled',
			'currentUserHasBeenWelcomed',
			'markCurrentUserAsWelcomed',
			'currentUserIsWelcomeExempt',
			'currentUserIsDefaultWelcomer',
			'currentUserIsFounder',
			'currentUserHasLocalEdits',
			'markHAWelcomePosted',
			'getTitleObjectFromRevision',
			'queueWelcomeTask',
			] );

		$dispatcher->expects( $this->once() )
			->method( 'welcomeMessageDisabled' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'currentUserHasBeenWelcomed' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'markCurrentUserAsWelcomed' );

		$dispatcher->expects( $this->once() )
			->method( 'currentUserIsWelcomeExempt' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'currentUserIsDefaultWelcomer' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'currentUserIsFounder' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'currentUserHasLocalEdits' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'markHAWelcomePosted' )
			->will( $this->returnValue( null ) );

		/** @var Revision|PHPUnit_Framework_MockObject_MockObject $revision */
		$revision = $this->getMock( Revision::class, ['getRawUser'], [], '', false );

		$revision->expects( $this->once() )
			->method( 'getRawUser' )
			->will( $this->returnValue( 1 ) );

		$title = $this->getMock( Title::class, [] );

		$dispatcher->expects( $this->once() )
			->method( 'getTitleObjectFromRevision' )
			->will( $this->returnValue( $title ) );

		$dispatcher->expects( $this->once() )
			->method( 'queueWelcomeTask' )
			->with( $title )
			->will( $this->returnValue( null ) );

		$dispatcher->setRevisionObject( $revision );
		$this->assertTrue( $dispatcher->dispatch() );
	}

	public function testDispatchRegisteredUserMarkHAWelcomePosted() {
		/** @var HAWelcomeTaskHookDispatcher|PHPUnit_Framework_MockObject_MockObject $dispatcher */
		$dispatcher = $this->getMock( HAWelcomeTaskHookDispatcher::class, [
			'welcomeMessageDisabled',
			'currentUserHasBeenWelcomed',
			'markCurrentUserAsWelcomed',
			'currentUserIsWelcomeExempt',
			'currentUserIsDefaultWelcomer',
			'currentUserIsFounder',
			'currentUserHasLocalEdits',
			'getTitleObjectFromRevision',
			'queueWelcomeTask',
			] );

		$dispatcher->expects( $this->once() )
			->method( 'welcomeMessageDisabled' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'currentUserHasBeenWelcomed' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'markCurrentUserAsWelcomed' );

		$dispatcher->expects( $this->once() )
			->method( 'currentUserIsWelcomeExempt' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'currentUserIsDefaultWelcomer' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'currentUserIsFounder' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'currentUserHasLocalEdits' )
			->will( $this->returnValue( false ) );

		/** @var MemcachedPhpBagOStuff|PHPUnit_Framework_MockObject_MockObject $memcacheClient */
		$memcacheClient = $this->getMock( MemcachedPhpBagOStuff::class, ['set'] );

		$memcacheClient->expects( $this->once() )
			->method( 'set' )
			->with( $this->stringContains( 'HAWelcome-isPosted' ) )
			->will( $this->returnValue( null ) );

		/** @var Revision|PHPUnit_Framework_MockObject_MockObject $revision */
		$revision = $this->getMock( Revision::class, ['getRawUser', 'getRawUserText'], [], '', false );

		$revision->expects( $this->once() )
			->method( 'getRawUser' )
			->will( $this->returnValue( 1 ) );

		$revision->expects( $this->once() )
			->method( 'getRawUserText' )
			->will( $this->returnValue( 'someone' ) );

		$title = $this->getMock( Title::class, [] );

		$dispatcher->expects( $this->once() )
			->method( 'getTitleObjectFromRevision' )
			->will( $this->returnValue( $title ) );

		$dispatcher->expects( $this->once() )
			->method( 'queueWelcomeTask' )
			->with( $title )
			->will( $this->returnValue( null ) );

		$dispatcher->setRevisionObject( $revision );
		$dispatcher->setMemcacheClient( $memcacheClient );
		$this->assertTrue( $dispatcher->dispatch() );
	}


	public function testUpdateAdminActivityNotBot() {
		/** @var HAWelcomeTaskHookDispatcher|PHPUnit_Framework_MockObject_MockObject $dispatcher */
		$dispatcher = $this->getMock( HAWelcomeTaskHookDispatcher::class, ['getWelcomeUserFromMessages'] );

		$dispatcher->expects( $this->once() )
			->method( 'getWelcomeUserFromMessages' )
			->will( $this->returnValue( '@latest' ) );

		/** @var User|PHPUnit_Framework_MockObject_MockObject $user */
		$user = $this->getMock( User::class, ['getEffectiveGroups', 'getId'] );

		$userGroups = array( 'sysop' );
		$user->expects( $this->once() )
			->method( 'getEffectiveGroups' )
			->will( $this->returnValue( $userGroups ) );

		$user->expects( $this->once() )
			->method( 'getId' )
			->will( $this->returnValue( 1 ) );

		/** @var MemcachedPhpBagOStuff|PHPUnit_Framework_MockObject_MockObject $memcacheClient */
		$memcacheClient = $this->getMock( MemcachedPhpBagOStuff::class, ['set'] );

		$memcacheClient->expects( $this->once() )
			->method( 'set' )
			->with( $this->stringContains( 'last-sysop-id' ) )
			->will( $this->returnValue( null ) );

		$dispatcher->setCurrentUser( $user )
			->setMemcacheClient( $memcacheClient );

		$dispatcher->updateAdminActivity();
	}

	public function testUpdateAdminActivityBot() {
		/** @var HAWelcomeTaskHookDispatcher|PHPUnit_Framework_MockObject_MockObject $dispatcher */
		$dispatcher = $this->getMock( HAWelcomeTaskHookDispatcher::class, ['getWelcomeUserFromMessages'] );

		$dispatcher->expects( $this->once() )
			->method( 'getWelcomeUserFromMessages' )
			->will( $this->returnValue( '@bot' ) );

		$dispatcher->updateAdminActivity();
	}

}
