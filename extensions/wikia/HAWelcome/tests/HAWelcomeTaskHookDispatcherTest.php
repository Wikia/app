<?php

/**
 * @group UsingDB
 */
class HAWelcomeTaskHookDispatcherTest extends WikiaBaseTest {

	public function testDispatchWhenDisabled() {
		$dispatcher = $this->getMock( '\HAWelcomeTaskHookDispatcher', ['welcomeMessageDisabled'], [], '', false );
		$dispatcher->expects( $this->once() )
			->method( 'welcomeMessageDisabled' )
			->will( $this->returnValue( true ) );

		$this->assertTrue( $dispatcher->dispatch() );
	}

	public function testDispatchBeenWelcomed() {
		$dispatcher = $this->getMock( '\HAWelcomeTaskHookDispatcher', ['hasContributorBeenWelcomedRecently', 'welcomeMessageDisabled'] );

		$dispatcher->expects( $this->once() )
			->method( 'welcomeMessageDisabled' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'hasContributorBeenWelcomedRecently' )
			->will( $this->returnValue( true ) );

		$this->assertTrue( $dispatcher->dispatch() );
	}

	public function testDispatchAnonymousUser() {
		$dispatcher = $this->getMock( '\HAWelcomeTaskHookDispatcher', [
			'welcomeMessageDisabled',
			'hasContributorBeenWelcomedRecently',
			'markHAWelcomePosted',
			'getTitleObjectFromRevision',
			'queueWelcomeTask',
			] );

		$dispatcher->expects( $this->once() )
			->method( 'welcomeMessageDisabled' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'hasContributorBeenWelcomedRecently' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'markHAWelcomePosted' )
			->will( $this->returnValue( null ) );

		$revision = $this->getMock( '\Revision', ['getRawUser'], [], '', false );

		$revision->expects( $this->once() )
			->method( 'getRawUser' )
			->will( $this->returnValue( 0 ) );

		$title = $this->getMock( '\Title', [] );

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
		$dispatcher = $this->getMock( '\HAWelcomeTaskHookDispatcher', [
			'welcomeMessageDisabled',
			'hasContributorBeenWelcomedRecently',
			'currentUserIsWelcomeExempt',
			] );

		$dispatcher->expects( $this->once() )
			->method( 'welcomeMessageDisabled' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'hasContributorBeenWelcomedRecently' )
			->will( $this->returnValue( false ) );

		$dispatcher->expects( $this->once() )
			->method( 'currentUserIsWelcomeExempt' )
			->will( $this->returnValue( true ) );

		$revision = $this->getMock( '\Revision', ['getRawUser'], [], '', false );

		$revision->expects( $this->once() )
			->method( 'getRawUser' )
			->will( $this->returnValue( 1 ) );

		$dispatcher->setRevisionObject( $revision );
		$this->assertTrue( $dispatcher->dispatch() );
	}

	public function testDispatchRegisteredUserHasLocalEdits() {
		$dispatcher = $this->getMock( '\HAWelcomeTaskHookDispatcher', [
			'welcomeMessageDisabled',
			'hasContributorBeenWelcomedRecently',
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
			->method( 'hasContributorBeenWelcomedRecently' )
			->will( $this->returnValue( false ) );

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

		$revision = $this->getMock( '\Revision', ['getRawUser'], [], '', false );

		$revision->expects( $this->once() )
			->method( 'getRawUser' )
			->will( $this->returnValue( 1 ) );

		$dispatcher->setRevisionObject( $revision );
		$this->assertTrue( $dispatcher->dispatch() );
	}

	public function testDispatchRegisteredUserQueueTask() {
		$dispatcher = $this->getMock( '\HAWelcomeTaskHookDispatcher', [
			'welcomeMessageDisabled',
			'hasContributorBeenWelcomedRecently',
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
			->method( 'hasContributorBeenWelcomedRecently' )
			->will( $this->returnValue( false ) );

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

		$revision = $this->getMock( '\Revision', ['getRawUser'], [], '', false );

		$revision->expects( $this->once() )
			->method( 'getRawUser' )
			->will( $this->returnValue( 1 ) );

		$title = $this->getMock( '\Title', [] );

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
		$dispatcher = $this->getMock( '\HAWelcomeTaskHookDispatcher', [
			'welcomeMessageDisabled',
			'hasContributorBeenWelcomedRecently',
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
			->method( 'hasContributorBeenWelcomedRecently' )
			->will( $this->returnValue( false ) );

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

		$memcacheClient = $this->getMock( '\MemcachedPhpBagOStuff', ['set'] );

		$memcacheClient->expects( $this->once() )
			->method( 'set' )
			->with( $this->stringContains( 'HAWelcome-isPosted' ) )
			->will( $this->returnValue( null ) );

		$revision = $this->getMock( '\Revision', ['getRawUser', 'getRawUserText'], [], '', false );

		$revision->expects( $this->once() )
			->method( 'getRawUser' )
			->will( $this->returnValue( 1 ) );

		$revision->expects( $this->once() )
			->method( 'getRawUserText' )
			->will( $this->returnValue( 'someone' ) );

		$title = $this->getMock( '\Title', [] );

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
		$dispatcher = $this->getMock( '\HAWelcomeTaskHookDispatcher', ['getWelcomeUserFromMessages'] );

		$dispatcher->expects( $this->once() )
			->method( 'getWelcomeUserFromMessages' )
			->will( $this->returnValue( '@latest' ) );

		$user = $this->getMock( '\User', ['getEffectiveGroups', 'getId'] );

		$userGroups = array( 'sysop' );
		$user->expects( $this->once() )
			->method( 'getEffectiveGroups' )
			->will( $this->returnValue( $userGroups ) );

		$user->expects( $this->once() )
			->method( 'getId' )
			->will( $this->returnValue( 1 ) );

		$memcacheClient = $this->getMock( '\MemcachedPhpBagOStuff', ['set'] );

		$memcacheClient->expects( $this->once() )
			->method( 'set' )
			->with( $this->stringContains( 'last-sysop-id' ) )
			->will( $this->returnValue( null ) );

		$dispatcher->setCurrentUser( $user )
			->setMemcacheClient( $memcacheClient );

		$dispatcher->updateAdminActivity();
	}

	public function testUpdateAdminActivityBot() {
		$dispatcher = $this->getMock( '\HAWelcomeTaskHookDispatcher', ['getWelcomeUserFromMessages'] );

		$dispatcher->expects( $this->once() )
			->method( 'getWelcomeUserFromMessages' )
			->will( $this->returnValue( '@bot' ) );

		$dispatcher->updateAdminActivity();
	}

}
