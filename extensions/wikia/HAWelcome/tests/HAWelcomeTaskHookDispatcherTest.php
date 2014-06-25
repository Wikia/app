<?php

class HAWelcomeTaskHookDispatcherTest extends WikiaBaseTest {

	public function testDispatchBeenWelcomed() {
		$dispatcher = $this->getMock( '\HAWelcomeTaskHookDispatcher', ['hasContributorBeenWelcomedRecently']);

		$dispatcher->expects( $this->once() )
			->method( 'hasContributorBeenWelcomedRecently' )
			->will( $this->returnValue( true ) );

		$this->assertTrue( $dispatcher->dispatch() );
	}

	public function testDispatchAnonymousUser() {
		$dispatcher = $this->getMock( '\HAWelcomeTaskHookDispatcher', ['hasContributorBeenWelcomedRecently']);

		$dispatcher->expects( $this->once() )
			->method( 'hasContributorBeenWelcomedRecently' )
			->will( $this->returnValue( false ) );


		$revision = $this->getMock( '\Revision', ['getRawUser'], [], '', false );

		$revision->expects( $this->once() )
			->method( 'getRawUser' )
			->will( $this->returnValue( 0 ) );

		$dispatcher->setRevisionObject( $revision );
		$this->assertTrue( $dispatcher->dispatch() );
	}

	public function testDispatchRegisteredUserShortCircuit() {
		$dispatcher = $this->getMock( '\HAWelcomeTaskHookDispatcher', [
			'hasContributorBeenWelcomedRecently',
			'currentUserIsWelcomeExempt',
			]);

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
			'hasContributorBeenWelcomedRecently',
			'currentUserIsWelcomeExempt',
			'currentUserIsDefaultWelcomer',
			'currentUserIsFounder',
			'currentUserHasLocalEdits',
			]);

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

		$revision = $this->getMock( '\Revision', ['getRawUser'], [], '', false );

		$revision->expects( $this->once() )
			->method( 'getRawUser' )
			->will( $this->returnValue( 1 ) );

		$dispatcher->setRevisionObject( $revision );
		$this->assertTrue( $dispatcher->dispatch() );
	}

	public function testDispatchRegisteredUserQueueTask() {
		$dispatcher = $this->getMock( '\HAWelcomeTaskHookDispatcher', [
			'hasContributorBeenWelcomedRecently',
			'currentUserIsWelcomeExempt',
			'currentUserIsDefaultWelcomer',
			'currentUserIsFounder',
			'currentUserHasLocalEdits',
			'markHAWelcomePosted',
			'getTitleObjectFromRevision',
			'queueWelcomeTask',
			]);

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

		$title = $this->getMock( '\Title', []);

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
}
