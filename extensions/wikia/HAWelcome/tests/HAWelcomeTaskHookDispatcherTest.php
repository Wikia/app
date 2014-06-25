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


}
