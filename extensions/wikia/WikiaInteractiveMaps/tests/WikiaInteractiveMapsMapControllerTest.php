<?php
class WikiaInteractiveMapsMapControllerTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/WikiaInteractiveMaps/WikiaInteractiveMaps.setup.php";
		parent::setUp();
	}

	public function testCreateMap_throws_bad_request_api_exception() {
		$controllerMock = $this->getWikiaInteractiveMapsMapController();
		$controllerMock->expects( $this->any() )
			->method( 'getData' )
			->will( $this->onConsecutiveCalls(
				0,
				null,
				null
			) );

		$userMock = $this->getUserMock();
		$userMock->expects( $this->never() )
			->method( 'isLoggedIn' );

		$controllerMock->request = $this->getWikiaRequestMock();
		$controllerMock->wg->CityId = 123;
		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'BadRequestApiException' );
		$controllerMock->createMap();
	}

	public function testCreateMap_throws_invalid_parameter_api_exception() {
		$controllerMock = $this->getWikiaInteractiveMapsMapController();
		$controllerMock->expects( $this->any() )
			->method( 'getData' );

		$userMock = $this->getUserMock();
		$userMock->expects( $this->never() )
			->method( 'isLoggedIn' );

		$controllerMock->request = $this->getWikiaRequestMock();
		$controllerMock->wg->CityId = 123;
		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'InvalidParameterApiException' );
		$controllerMock->createMap();
	}

	public function testCreateMap_throws_permission_exception() {
		$controllerMock = $this->getWikiaInteractiveMapsMapController();
		$controllerMock->expects( $this->any() )
			->method( 'getData' )
			->will( $this->onConsecutiveCalls(
				1,
				'http://mocked.image.url.com',
				'Mocked Map Title'
			) );

		$userMock = $this->getUserMock();
		$userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( false );

		$controllerMock->request = $this->getWikiaRequestMock();
		$controllerMock->wg->CityId = 123;
		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'PermissionsException' );
		$controllerMock->createMap();
	}

	private function getWikiaRequestMock() {
		$requestMock = $this->getMockBuilder( 'WikiaRequest' )
			->setMethods( [ 'getVal', 'getInt' ] )
			->disableOriginalConstructor()
			->getMock();

		$requestMock->expects( $this->any() )
			->method( 'getVal' )
			->willReturn( $this->returnValue( 'A mocked value' ) );

		$requestMock->expects( $this->once() )
			->method( 'getInt' )
			->willReturn( $this->returnValue( 1 ) );

		return $requestMock;
	}

	private function getUserMock() {
		$userMock = $this->getMockBuilder( 'User' )
			->setMethods( [ 'isLoggedIn' ] )
			->disableOriginalConstructor()
			->getMock();

		return $userMock;
	}

	private function getWikiaInteractiveMapsMapController() {
		$controllerMock = $this->getMockBuilder( 'WikiaInteractiveMapsMapController' )
			->setMethods( [ 'getData' ] )
			->disableOriginalConstructor()
			->getMock();

		return $controllerMock;
	}
}
