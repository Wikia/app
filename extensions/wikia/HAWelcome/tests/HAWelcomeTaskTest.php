<?php

class HAWelcomeTaskTest extends WikiaBaseTest {

	public function testNormalizeInstanceParameters() {
		$userId    = 1;
		$username  = 'foo';
		$timestamp = 999;

		$task = new HAWelcomeTask();

		$params = array(
			'iUserId'    => $userId,
			'sUserName'  => $username,
			'iTimestamp' => $timestamp,
		);

		$task->normalizeInstanceParameters( $params );
		$this->assertEquals( $userId, $task->getRecipientId() );
		$this->assertEquals( $username, $task->getRecipientUserName() );
		$this->assertEquals( $timestamp, $task->getTimestamp() );
	}

	public function testSendWelcomeMessageWhenDisabled() {
		$task = $this->getMock( '\HAWelcomeTask', ['welcomeMessageDisabled'], [], '', false );
		$task->expects( $this->atLeastOnce() )
			->method( 'welcomeMessageDisabled' )
			->will( $this->returnValue( true ) );

		$this->assertTrue( $task->sendWelcomeMessage( array() ) );
	}


	public function testSendMessageWithWall() {
		$task = $this->getMock( '\HAWelcomeTask', ['getMessageWallExtensionEnabled', 'postWallMessageToRecipient'], [], '', false );

		$task->expects( $this->atLeastOnce() )
			->method( 'getMessageWallExtensionEnabled' )
			->will( $this->returnValue( true ) );

		$task->expects( $this->atLeastOnce() )
			->method( 'postWallMessageToRecipient' )
			->will( $this->returnValue(null) );

		$task->sendMessage();

	}

}
