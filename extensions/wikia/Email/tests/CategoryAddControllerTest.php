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
		$this->mockMemcache( CategoryAddController::EMAILS_PER_THROTTLE_PERIOD );

		$controller = new CategoryAddController();
		$controller->setRequest( $this->wikiaRequestMock );
		$controller->init();
		$controller->assertCanEmail();
	}

	public function testAssertCanEmailSucceedsBeforeThrottleAmountReached() {
		$this->mockUser();
		$this->mockTitle();
		$this->mockInternalRequest();
		$this->mockMemcache( CategoryAddController::EMAILS_PER_THROTTLE_PERIOD - 1 );

		$controller = new CategoryAddController();
		$controller->setRequest( $this->wikiaRequestMock );
		$controller->init();

		// If an exception is thrown from this call, this test fails. No exception indicates
		// all checks that an email can be sent passed, and therefore this test passes.
		$controller->assertCanEmail();
	}

	private function mockUser() {
		// In order have a mocked method return different values based on different inputs, you use
		// a return value map. If that mocked method has default arguments, you have to add values for
		// those args as well. That's what the 2nd and 3rd arguments here are doing (null and false).
		// See: http://stackoverflow.com/questions/12748607/phpunits-returnvaluemap-not-yielding-expected-results#answer-15300642
		$returnValueMap = [
			[ 'unsubscribed', null, false, false ],
			[ 'language', null, false, 'en' ]
		];

		$mockUser = $this->getMockBuilder( User::class )
			->setMethods( [ 'getEmail', 'getGlobalPreference', 'isBlocked', 'isEmailConfirmed' ] )
			->getMock();

		$mockUser->expects( $this->once() )
			->method( 'getEmail' )
			->will( $this->returnValue( 'some.email@example.com' ) );
		$mockUser->expects( $this->any() )
			->method( 'getGlobalPreference' )
			->will($this->returnValueMap( $returnValueMap ) );
		$mockUser->expects( $this->once() )
			->method( 'isBlocked' )
			->will( $this->returnValue( false ) );
		$mockUser->expects( $this->once() )
			->method( 'isEmailConfirmed' )
			->will( $this->returnValue( true ) );

		$this->mockGlobalVariable( 'wgUser', $mockUser );
	}

	private function mockTitle() {
		$mockedTitle = $this->getMockBuilder( Title::class )
			->setMethods( [ 'getPrefixedText', 'getText', 'exists' ] )
			->getMock();

		$mockedTitle->expects( $this->once() )
			->method( 'exists' )
			->will( $this->returnValue( true ) );

		$this->mockClassEx('Title',  $mockedTitle );
	}

	private function mockInternalRequest() {
		$this->wikiaRequestMock = $this->getMockBuilder( WikiaRequest::class )
			->setMethods( [ 'isInternal' ] )
			->setConstructorArgs( [ [] ] )
			->getMock();

		$this->wikiaRequestMock->expects( $this->once() )
			->method( 'isInternal' )
			->willReturn( true );
	}

	private function mockMemcache( $emailsSent ) {
		$mock_cache = $this->getMockBuilder( stdClass::class )
			->setMethods( [ 'get', 'set', 'delete' ] )
			->getMock();

		$mock_cache->expects( $this->once() )
			->method('get')
			->will( $this->returnValue( $emailsSent ) );

		$this->mockGlobalVariable( 'wgMemc', $mock_cache );
	}
}
