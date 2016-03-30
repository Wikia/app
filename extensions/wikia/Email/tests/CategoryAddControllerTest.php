<?php

use \Email\Controller\CategoryAddController;

class CategoryAddControllerTest extends WikiaBaseTest {

	private $wikiaRequestMock;

	/**
	 * @expectedException \Email\Check
	 */
	public function testAssertCanEmailFailsAfterThrottleAmountReached() {
		$this->mockUser();
		$this->mockTitle();
		$this->mockInternalRequest();
		$this->mockMemcache();

		$controller = new CategoryAddController();
		$controller->setRequest( $this->wikiaRequestMock );
		$controller->init();
		$controller->assertCanEmail();
	}

	private function mockUser() {
		// wtf... http://stackoverflow.com/questions/12748607/phpunits-returnvaluemap-not-yielding-expected-results

		$returnValueMap = [
			[ 'unsubscribed', null, false, false ],
			[ 'language', null, false, 'en' ]
		];

		$mockUser = $this->getMock( 'User', [ 'getEmail', 'getGlobalPreference', 'isBlocked' ] );
		$mockUser->expects( $this->any() )
			->method( 'getEmail' )
			->will( $this->returnValue( 'some.email@example.com' ) );
		$mockUser->expects( $this->any() )
			->method( 'getGlobalPreference' )
			->will($this->returnValueMap( $returnValueMap ) );
		$mockUser->expects( $this->any() )
			->method( 'isBlocked' )
			->will( $this->returnValue( false ) );

		$this->mockGlobalVariable( 'wgUser', $mockUser );
	}

	private function mockTitle() {
		$mockedTitle = $this->getMock( '\Title', [ 'getPrefixedText', 'getText', 'exists' ] );
		$mockedTitle->expects( $this->any() )
			->method( 'exists' )
			->will( $this->returnValue( true ) );

		$this->mockClassEx('Title',  $mockedTitle );
	}

	private function mockInternalRequest() {
		$this->wikiaRequestMock = $this->getMock( '\WikiaRequest', [ 'isInternal' ], [], '', false );
		$this->wikiaRequestMock->expects( $this->any() )
			->method( 'isInternal' )
			->willReturn( true );
	}

	private function mockMemcache() {
		$mock_cache = $this->getMock( 'stdClass', [ 'get', 'set', 'delete' ] );
		$mock_cache->expects( $this->any() )
			->method('get')
			->will( $this->returnValue(
				[ 'sent' => CategoryAddController::EMAILS_PER_THROTTLE_PERIOD + 1, 'ttl' => time() ]
			) );

		$this->mockGlobalVariable( 'wgMemc', $mock_cache );
	}
}
