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

	public function testSendMessageWithTalkPage() {
		$task = $this->getMock( '\HAWelcomeTask', ['getMessageWallExtensionEnabled', 'postTalkPageMessageToRecipient'], [], '', false );

		$task->expects( $this->atLeastOnce() )
			->method( 'getMessageWallExtensionEnabled' )
			->will( $this->returnValue( false ) );

		$task->expects( $this->atLeastOnce() )
			->method( 'postTalkPageMessageToRecipient' )
			->will( $this->returnValue(null) );

		$task->sendMessage();
	}

	public function testPostTalkPageToRecipientWhenExists() {
		$talkPage = $this->getMock( '\Article', ['exists', 'getContent', 'doEdit'], [], '', false );

		$talkPage->expects( $this->atLeastOnce() )
			->method( 'exists' )
			->will( $this->returnValue( true ));

		$talkPageContent = 'foo';
		$talkPage->expects( $this->atLeastOnce() )
			->method( 'getContent' )
			->will( $this->returnValue( $talkPageContent ));

		$talkPage->expects( $this->atLeastOnce() )
			->method( 'doEdit' )
			->will( $this->returnValue( $talkPageContent ));

		$task = $this->getMock( '\HAWelcomeTask', ['getRecipientTalkPage'], [], '', false );

		$task->expects( $this->exactly(3) )
			->method( 'getRecipientTalkPage' )
			->will( $this->returnValue( $talkPage ));

		$task->postTalkPageMessageToRecipient();
	}

	public function testPostTalkPageToRecipientWhenNotExists() {
		$talkPage = $this->getMock( '\Article', ['exists', 'getContent', 'doEdit'], [], '', false );

		$talkPage->expects( $this->atLeastOnce() )
			->method( 'exists' )
			->will( $this->returnValue( false ));

		$talkPageContent = 'foo';
		$talkPage->expects( $this->exactly( 0 ) )
			->method( 'getContent' )
			->will( $this->returnValue( $talkPageContent ));

		$talkPage->expects( $this->atLeastOnce() )
			->method( 'doEdit' )
			->will( $this->returnValue( $talkPageContent ));

		$task = $this->getMock( '\HAWelcomeTask', ['getRecipientTalkPage'], [], '', false );

		$task->expects( $this->exactly(2) )
			->method( 'getRecipientTalkPage' )
			->will( $this->returnValue( $talkPage ));

		$task->postTalkPageMessageToRecipient();
	}


}
