<?php

/**
 * @group UsingDB
 */
class HAWelcomeTaskHookDispatcherTest extends WikiaBaseTest {

	public function testDispatchWhenDisabled() {
		/** @var HAWelcomeTaskHookDispatcher|PHPUnit_Framework_MockObject_MockObject $dispatcher */
		$dispatcher = $this->getMockBuilder( HAWelcomeTaskHookDispatcher::class )
			->setMethods( [ 'welcomeMessageDisabled' ] )
			->getMock();

		$dispatcher->expects( $this->once() )
			->method( 'welcomeMessageDisabled' )
			->will( $this->returnValue( true ) );

		$this->assertTrue( $dispatcher->dispatch() );
	}

	public function testDispatchBeenWelcomed() {
		/** @var HAWelcomeTaskHookDispatcher|PHPUnit_Framework_MockObject_MockObject $dispatcher */
		$dispatcher = $this->getMockBuilder( HAWelcomeTaskHookDispatcher::class )
			->setMethods( [ 'currentUserHasBeenWelcomed', 'welcomeMessageDisabled' ] )
			->getMock();

		$dispatcher->expects( $this->once() )
			->method( 'welcomeMessageDisabled' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'currentUserHasBeenWelcomed' )
			->will( $this->returnValue( true ) );

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
		$revision = $this->createMock( Revision::class );

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
		$revision = $this->createMock( Revision::class );

		$dispatcher->setRevisionObject( $revision );
		$this->assertTrue( $dispatcher->dispatch() );
	}

	public function testDispatchRegisteredUserQueueTask() {
		/** @var HAWelcomeTaskHookDispatcher|PHPUnit_Framework_MockObject_MockObject $dispatcher */
		$dispatcher = $this->getMockBuilder( HAWelcomeTaskHookDispatcher::class )
			->setMethods( [
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
			] )
			->getMock();

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
		$revision = $this->createMock( Revision::class );

		$title = new Title;

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
		$dispatcher = $this->getMockBuilder( HAWelcomeTaskHookDispatcher::class )
			->setMethods( [
				'welcomeMessageDisabled',
				'currentUserHasBeenWelcomed',
				'markCurrentUserAsWelcomed',
				'currentUserIsWelcomeExempt',
				'currentUserIsDefaultWelcomer',
				'currentUserIsFounder',
				'currentUserHasLocalEdits',
				'getTitleObjectFromRevision',
				'queueWelcomeTask',
			] )
			->getMock();

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
		$memcacheClient = $this->getMockBuilder( MemcachedPhpBagOStuff::class )
			->disableOriginalConstructor()
			->setMethods( [ 'set' ] )
			->getMock();

		$memcacheClient->expects( $this->once() )
			->method( 'set' )
			->with( $this->stringContains( 'HAWelcome-isPosted' ) )
			->will( $this->returnValue( null ) );

		/** @var Revision|PHPUnit_Framework_MockObject_MockObject $revision */
		$revision = $this->createMock( Revision::class );

		$revision->expects( $this->once() )
			->method( 'getRawUserText' )
			->will( $this->returnValue( 'someone' ) );

		$title = new Title;

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
		$dispatcher = $this->getMockBuilder( HAWelcomeTaskHookDispatcher::class )
			->setMethods( ['getWelcomeUserFromMessages'] )
			->getMock();

		$dispatcher->expects( $this->once() )
			->method( 'getWelcomeUserFromMessages' )
			->will( $this->returnValue( '@latest' ) );

		/** @var User|PHPUnit_Framework_MockObject_MockObject $user */
		$user = $this->createMock( User::class );

		$userGroups = array( 'sysop' );
		$user->expects( $this->once() )
			->method( 'getEffectiveGroups' )
			->will( $this->returnValue( $userGroups ) );

		$user->expects( $this->once() )
			->method( 'getId' )
			->will( $this->returnValue( 1 ) );

		/** @var MemcachedPhpBagOStuff|PHPUnit_Framework_MockObject_MockObject $memcacheClient */
		$memcacheClient = $this->getMockBuilder( MemcachedPhpBagOStuff::class )
			->disableOriginalConstructor()
			->setMethods( [ 'set' ] )
			->getMock();

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
		$dispatcher = $this->getMockBuilder( HAWelcomeTaskHookDispatcher::class )
			->setMethods( ['getWelcomeUserFromMessages'] )
			->getMock();

		$dispatcher->expects( $this->once() )
			->method( 'getWelcomeUserFromMessages' )
			->will( $this->returnValue( '@bot' ) );

		$dispatcher->updateAdminActivity();
	}

}
