<?php
class WikiaInteractiveMapsPoiControllerTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/WikiaInteractiveMaps/WikiaInteractiveMaps.setup.php";
		parent::setUp();
	}

	public function testEditPoiCategories_throws_permission_error_when_anon() {
		$userMock = $this->getUserMock();
		$userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( false );

		$controllerMock = $this->getWikiaInteractiveMapsPoiControllertMock();
		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'WikiaInteractiveMapsPermissionException' );
		$controllerMock->editPoiCategories();
	}

	public function testEditPoiCategories_throws_permission_error_when_user_blocked() {
		$userMock = $this->getUserMock();
		$userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );
		$userMock->expects( $this->once() )
			->method( 'isBlocked' )
			->willReturn( true );

		$controllerMock = $this->getWikiaInteractiveMapsPoiControllertMock();
		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'WikiaInteractiveMapsPermissionException' );
		$controllerMock->editPoiCategories();
	}

	public function testEditPoi_throws_permission_error_when_anon() {
		$userMock = $this->getUserMock();

		$userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( false );

		$controllerMock = $this->getWikiaInteractiveMapsPoiControllertMock();
		$controllerMock->expects( $this->any() )
			->method( 'getData' )
			->willReturn( 'Mocked Data.' );
		$controllerMock->expects( $this->any() )
			->method( 'isValidArticleTitle' )
			->willReturn( true );

		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'PermissionsException' );
		$controllerMock->editPoi();
	}

	public function testEditPoi_throws_permission_error_when_blocked() {
		$userMock = $this->getUserMock();

		$userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );
		$userMock->expects( $this->once() )
			->method( 'isBlocked' )
			->willReturn( true );

		$controllerMock = $this->getWikiaInteractiveMapsPoiControllertMock();
		$controllerMock->expects( $this->any() )
			->method( 'getData' )
			->willReturn( 'Mocked Data.' );
		$controllerMock->expects( $this->any() )
			->method( 'isValidArticleTitle' )
			->willReturn( true );

		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'PermissionsException' );
		$controllerMock->editPoi();
	}

	public function testDeletePoi_throws_permission_error_when_anon() {
		$userMock = $this->getUserMock();

		$userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );
		$userMock->expects( $this->once() )
			->method( 'isBlocked' )
			->willReturn( true );

		$controllerMock = $this->getWikiaInteractiveMapsPoiControllertMock();
		$controllerMock->expects( $this->any() )
			->method( 'getData' )
			->with( 'poiId' )
			->willReturn( 1 );

		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'PermissionsException' );
		$controllerMock->deletePoi();
	}

	public function testDeletePoi_throws_permission_error_when_blocked() {
		$userMock = $this->getUserMock();

		$userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( false );

		$controllerMock = $this->getWikiaInteractiveMapsPoiControllertMock();
		$controllerMock->expects( $this->any() )
			->method( 'getData' )
			->with( 'poiId' )
			->willReturn( 1 );

		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'PermissionsException' );
		$controllerMock->deletePoi();
	}

	private function getWikiaInteractiveMapsPoiControllertMock() {
		$requestMock = $this->getMockBuilder( 'WikiaRequest' )
			->setMethods( [ 'getVal', 'getArray', 'getInt' ] )
			->disableOriginalConstructor()
			->getMock();

		$controllerMock = $this->getMockBuilder( 'WikiaInteractiveMapsPoiController' )
			->setMethods( [
				'setData',
				'getData',
				'getModel',
				'isValidArticleTitle',
			] )
			->disableOriginalConstructor()
			->getMock();
		$controllerMock->request = $requestMock;

		return $controllerMock;
	}

	private function getUserMock() {
		return $this->getMockBuilder( 'User' )
			->setMethods( [ 'getName', 'isLoggedIn', 'isBlocked' ] )
			->disableOriginalConstructor()
			->getMock();
	}

}
