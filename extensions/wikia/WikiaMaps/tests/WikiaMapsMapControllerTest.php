<?php
class WikiaMapsMapControllerTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/WikiaMaps/WikiaMaps.setup.php";
		parent::setUp();
	}

	public function testCreateMap_throws_bad_request_api_exception() {
		$controllerMock = $this->getWikiaMapsMapControllerMock();
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
		$controllerMock = $this->getWikiaMapsMapControllerMock();

		$userMock = $this->getUserMock();
		$userMock->expects( $this->never() )
			->method( 'isLoggedIn' );

		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'InvalidParameterApiException' );
		$controllerMock->createMap();
	}

	public function testCreateMap_throws_permission_exception_when_anon() {
		$controllerMock = $this->getWikiaMapsMapControllerMock();

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

		$this->setExpectedException( 'WikiaMapsPermissionException' );
		$controllerMock->createMap();
	}

	public function testCreateMap_throws_permission_exception_when_blocked() {
		$controllerMock = $this->getWikiaMapsMapControllerMock();

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

		$this->setExpectedException( 'WikiaMapsPermissionException' );
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

		$controllerMock = $this->getWikiaMapsMapControllerMock();
		$controllerMock->expects( $this->never() )
			->method( 'getModel' );
		$controllerMock->request = $requestMock;
		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'WikiaMapsPermissionException' );
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
		$userMock->expects( $this->never() )
			->method( 'isAllowed' );

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

		$controllerMock = $this->getWikiaMapsMapControllerMock();
		$controllerMock->expects( $this->any() )
			->method( 'getModel' )
			->willReturn( $modelMock );
		$controllerMock->expects( $this->never() )
			->method( 'canUserDelete' );
		$controllerMock->expects( $this->never() )
			->method( 'isUserMapCreator' );
		$controllerMock->request = $requestMock;
		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'WikiaMapsPermissionException' );
		$controllerMock->updateMapDeletionStatus();
	}

	public function testUpdateMapDeletionStatus_no_rights() {
		$userMock = $this->getUserMock();
		$userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );
		$userMock->expects( $this->once() )
			->method( 'isBlocked' )
			->willReturn( false );

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

		$controllerMock = $this->getWikiaMapsMapControllerMock();
		$controllerMock->expects( $this->any() )
			->method( 'getModel' )
			->willReturn( $modelMock );
		$controllerMock->expects( $this->once() )
			->method( 'canUserDelete' )
			->willReturn( false );
		$controllerMock->expects( $this->once() )
			->method( 'isUserMapCreator' )
			->willReturn( false );
		$controllerMock->request = $requestMock;
		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'WikiaMapsPermissionException' );
		/** @var WikiaMapsMapController $controllerMock */
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

	/**
	 * @return WikiaMapsMapController
	 */
	private function getWikiaMapsMapControllerMock() {
		$controllerMock = $this->getMockBuilder( 'WikiaMapsMapController' )
			->setMethods( [ 'getData', 'getModel', 'canUserDelete', 'isUserMapCreator' ] )
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
