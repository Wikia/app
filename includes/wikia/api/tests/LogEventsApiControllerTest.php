<?php
use PHPUnit\Framework\TestCase;

class LogEventsApiControllerTest extends TestCase {
	/** @var LogEventsApiController $controller */
	private $controller;

	/** @var PHPUnit_Framework_MockObject_MockObject|LogPage $logPageMock */
	private $logPageMock;

	/** @var bool $wgDisableOldStyleEmail */
	private $wgDisableOldStyleEmail;

	protected function setUp() {
		parent::setUp();

		$this->logPageMock = $this->createMock( LogPage::class );
		$this->controller = new LogEventsApiController( $this->logPageMock );

		// backup global
		global $wgDisableOldStyleEmail;
		$this->wgDisableOldStyleEmail = $wgDisableOldStyleEmail;
	}

	/**
	 * @expectedException BadRequestException
	 * @expectedExceptionMessage Bad request
	 * @expectedExceptionCode 400
	 */
	public function testAcceptsOnlyPostRequests() {
		/** @var PHPUnit_Framework_MockObject_MockObject|WikiaRequest $requestMock */
		$requestMock = $this->getMockBuilder( WikiaRequest::class )
			->disableOriginalConstructor()
			->setMethods( [ 'wasPosted' ] )
			->getMock();

		$requestMock->expects( $this->once() )
			->method( 'wasPosted' )
			->willReturn( false );

		$this->controller->setRequest( $requestMock );
		$this->controller->add();
	}

	/**
	 * @expectedException BadRequestException
	 * @expectedExceptionMessage Bad request
	 * @expectedExceptionCode 400
	 */
	public function testValidatesSchwartzToken() {
		/** @var PHPUnit_Framework_MockObject_MockObject|WikiaRequest $requestMock */
		$requestMock = $this->getMockBuilder( WikiaRequest::class )
			->setConstructorArgs( [ [ 'token' => 'nie dobre' ] ] )
			->setMethods( [ 'wasPosted' ] )
			->getMock();

		$requestMock->expects( $this->once() )
			->method( 'wasPosted' )
			->willReturn( true );

		$this->controller->setRequest( $requestMock );
		$this->controller->add();
	}

	public function testCreatesLogEntry() {
		$requestMock = $this->getValidRequestMock();
		$response = new WikiaResponse( WikiaResponse::FORMAT_JSON );

		$this->logPageMock->expects( $this->once() )
			->method( 'setUpdateRecentChanges' )
			->with( true );

		$this->logPageMock->expects( $this->once() )
			->method( 'addEntry' )
			->willReturn( 123 );

		$this->controller->setRequest( $requestMock );
		$this->controller->setResponse( $response );
		$this->controller->add();

		$this->assertEquals( WikiaResponse::RESPONSE_CODE_CREATED, $response->getCode() );
		$this->assertArrayHasKey( 'id', $response->getData() );
		$this->assertEquals( 123, $response->getVal( 'id' ) );
	}

	public function testSupportsParameterToNotShowLogEntryInRecentChanges() {
		$requestMock = $this->getValidRequestMock();

		$requestMock->setVal( 'showInRc', false );

		$this->logPageMock->expects( $this->once() )
			->method( 'setUpdateRecentChanges' )
			->with( false );

		$this->controller->setRequest( $requestMock );
		$this->controller->setResponse( new WikiaResponse( WikiaResponse::FORMAT_JSON ) );
		$this->controller->add();
	}

	private function getValidRequestMock() {
		global $wgTheSchwartzSecretToken;

		$request = [
			'token' => $wgTheSchwartzSecretToken,
			'type' => 'foobar'
		];

		/** @var PHPUnit_Framework_MockObject_MockObject|WikiaRequest $requestMock */
		$requestMock = $this->getMockBuilder( WikiaRequest::class )
			->setConstructorArgs( [ $request ] )
			->setMethods( [ 'wasPosted' ] )
			->getMock();

		$requestMock->expects( $this->once() )
			->method( 'wasPosted' )
			->willReturn( true );

		return $requestMock;
	}

	protected function tearDown() {
		parent::tearDown();

		global $wgDisableOldStyleEmail;
		$wgDisableOldStyleEmail = $this->wgDisableOldStyleEmail;
	}
}
