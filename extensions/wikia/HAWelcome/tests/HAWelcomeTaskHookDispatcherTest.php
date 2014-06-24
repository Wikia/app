<?php

class HAWelcomeTaskHookDispatcherTest extends WikiaBaseTest {

	public function testDispatchBeenWelcomed() {
		$dispatcher = $this->getMock( '\HAWelcomeTaskHookDispatcher', ['hasContributorBeenWelcomedRecently'], [], '', false );
		$dispatcher->expects( $this->atLeastOnce() )
			->method( 'hasContributorBeenWelcomedRecently' )
			->will( $this->returnValue( true ) );

		$this->assertTrue( $dispatcher->dispatch() );
	}



}
