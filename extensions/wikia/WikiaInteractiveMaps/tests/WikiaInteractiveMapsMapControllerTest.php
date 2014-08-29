<?php
class WikiaInteractiveMapsMapControllerTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/WikiaInteractiveMaps/WikiaInteractiveMaps.setup.php";
		parent::setUp();
	}

	public function testCreateMap_throws_bad_request_api_exception() {
		$controllerMock = $this->getWikiaInteractiveMapsMapControllerMock();
		$controllerMock->expects( $this->any() )
			->method( 'getData' )
			->will( $this->returnValueMap( [
				[ 'tileSetId', false, 0 ],
				[ 'image', false, null ],
				[ 'title', false, null ],
			] ) );

		$userMock = $this->getUserMock();
		$userMock->expects( $this->never() )
			->method( 'isLoggedIn' );

		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'BadRequestApiException' );
		$controllerMock->createMap();
	}

	public function testCreateMap_throws_invalid_parameter_api_exception() {
		$controllerMock = $this->getWikiaInteractiveMapsMapControllerMock();

		$userMock = $this->getUserMock();
		$userMock->expects( $this->never() )
			->method( 'isLoggedIn' );

		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'InvalidParameterApiException' );
		$controllerMock->createMap();
	}

	public function testCreateMap_throws_permission_exception_when_anon() {
		$controllerMock = $this->getWikiaInteractiveMapsMapControllerMock();

		$userMock = $this->getUserMock();
		$userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( false );
		$userMock->expects( $this->never() )
			->method( 'getName' );
		$userMock->expects( $this->never() )
			->method( 'isBlocked' );

		$this->mockGetDataForUserTests( $controllerMock );
		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'WikiaInteractiveMapsPermissionException' );
		$controllerMock->createMap();
	}

	public function testCreateMap_throws_permission_exception_when_blocked() {
		$controllerMock = $this->getWikiaInteractiveMapsMapControllerMock();

		$userMock = $this->getUserMock();
		$userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );
		$userMock->expects( $this->never() )
			->method( 'getName' );
		$userMock->expects( $this->once() )
			->method( 'isBlocked' )
			->willReturn( true );

		$this->mockGetDataForUserTests( $controllerMock );
		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'WikiaInteractiveMapsPermissionException' );
		$controllerMock->createMap();
	}

	public function testUpdateMapDeletionStatus_anon() {
		$userMock = $this->getUserMock();
		$userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( false );

		$requestMock = $this->getWikiaRequestMock();
		$requestMock->expects( $this->any() )
			->method( 'getInt' )
			->will( $this->returnValueMap( [
				[ 'mapId', 0, 1 ],
				[ 'deleted', 0, WikiaMaps::MAP_DELETED ],
			] ) );

		$controllerMock = $this->getWikiaInteractiveMapsMapControllerMock();
		$controllerMock->expects( $this->never() )
			->method( 'getModel' );
		$controllerMock->request = $requestMock;
		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'WikiaInteractiveMapsPermissionException' );
		$controllerMock->updateMapDeletionStatus();
	}

	public function testUpdateMapDeletionStatus_blocked() {
		$userMock = $this->getUserMock();
		$userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );
		$userMock->expects( $this->once() )
			->method( 'isBlocked' )
			->willReturn( true );

		$requestMock = $this->getWikiaRequestMock();
		$requestMock->expects( $this->any() )
			->method( 'getInt' )
			->will( $this->returnValueMap( [
				[ 'mapId', 0, 1 ],
				[ 'deleted', 0, WikiaMaps::MAP_DELETED ],
			] ) );

		$modelMock = $this->getMockBuilder( 'WikiaMaps' )
			->setMethods( [ 'updateMapDeletionStatus' ] )
			->disableOriginalConstructor()
			->getMock();
		$modelMock->expects( $this->never() )
			->method( 'updateMapDeletionStatus' );

		$controllerMock = $this->getWikiaInteractiveMapsMapControllerMock();
		$controllerMock->expects( $this->any() )
			->method( 'getModel' )
			->willReturn( $modelMock );
		$controllerMock->request = $requestMock;
		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'WikiaInteractiveMapsPermissionException' );
		$controllerMock->updateMapDeletionStatus();
	}

	private function getWikiaRequestMock() {
		$requestMock = $this->getMockBuilder( 'WikiaRequest' )
			->setMethods( [ 'getVal', 'getInt' ] )
			->disableOriginalConstructor()
			->getMock();

		return $requestMock;
	}

	private function getUserMock() {
		$userMock = $this->getMockBuilder( 'User' )
			->setMethods( [ 'isLoggedIn', 'getName', 'isBlocked' ] )
			->disableOriginalConstructor()
			->getMock();

		return $userMock;
	}

	private function getWikiaInteractiveMapsMapControllerMock() {
		$controllerMock = $this->getMockBuilder( 'WikiaInteractiveMapsMapController' )
			->setMethods( [ 'getData', 'getModel' ] )
			->disableOriginalConstructor()
			->getMock();

		$controllerMock->request = $this->getWikiaRequestMock();
		$controllerMock->wg->CityId = 123;

		return $controllerMock;
	}

	private function mockGetDataForUserTests( $controllerMock ) {
		$controllerMock->expects( $this->any() )
			->method( 'getData' )
			->will( $this->returnValueMap( [
				[ 'tileSetId', false, 1 ],
				[ 'image', false, 'http://mocked.image.url.com' ],
				[ 'title', false, 'Mocked Map Title' ],
			] ) );
	}

}
