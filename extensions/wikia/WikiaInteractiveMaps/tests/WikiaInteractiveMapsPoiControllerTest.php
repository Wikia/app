<?php
class WikiaInteractiveMapsPoiControllerTest extends WikiaBaseTest {

	const USER_TYPE_LOGGED_IN = 'logged-in';
	const USER_TYPE_LOGGED_OUT = 'logged-out';
	const USER_TYPE_BLOCKED = 'blocked';

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/WikiaInteractiveMaps/WikiaInteractiveMaps.setup.php";
		parent::setUp();
	}

	public function testEditPoiCategories_throws_permission_error_when_anon() {
		$userMock = $this->getUserMock( self::USER_TYPE_LOGGED_OUT );

		$controllerMock = $this->getWikiaInteractiveMapsPoiControllerMock();
		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'WikiaInteractiveMapsPermissionException' );
		$controllerMock->editPoiCategories();
	}

	public function testEditPoiCategories_throws_permission_error_when_user_blocked() {
		$userMock = $this->getUserMock( self::USER_TYPE_BLOCKED );

		$controllerMock = $this->getWikiaInteractiveMapsPoiControllerMock();
		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'WikiaInteractiveMapsPermissionException' );
		$controllerMock->editPoiCategories();
	}

	public function testEditPoi_throws_permission_error_when_anon() {
		$userMock = $this->getUserMock( self::USER_TYPE_LOGGED_OUT );

		$controllerMock = $this->getWikiaInteractiveMapsPoiControllerMock();
		$controllerMock->expects( $this->any() )
			->method( 'getData' )
			->willReturn( 'Mocked Data.' );

		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'WikiaInteractiveMapsPermissionException' );
		$controllerMock->editPoi();
	}

	public function testEditPoi_throws_permission_error_when_blocked() {
		$userMock = $this->getUserMock( self::USER_TYPE_BLOCKED );

		$controllerMock = $this->getWikiaInteractiveMapsPoiControllerMock();
		$controllerMock->expects( $this->any() )
			->method( 'getData' )
			->willReturn( 'Mocked Data.' );

		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'WikiaInteractiveMapsPermissionException' );
		$controllerMock->editPoi();
	}

	public function testDeletePoi_throws_permission_error_when_anon() {
		$userMock = $this->getUserMock( self::USER_TYPE_LOGGED_OUT );

		$controllerMock = $this->getWikiaInteractiveMapsPoiControllerMock();
		$controllerMock->expects( $this->any() )
			->method( 'getData' )
			->with( 'poiId' )
			->willReturn( 1 );

		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'WikiaInteractiveMapsPermissionException' );
		$controllerMock->deletePoi();
	}

	public function testDeletePoi_throws_permission_error_when_blocked() {
		$userMock = $this->getUserMock( self::USER_TYPE_BLOCKED );

		$controllerMock = $this->getWikiaInteractiveMapsPoiControllerMock();
		$controllerMock->expects( $this->any() )
			->method( 'getData' )
			->with( 'poiId' )
			->willReturn( 1 );

		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'WikiaInteractiveMapsPermissionException' );
		$controllerMock->deletePoi();
	}

	private function getWikiaInteractiveMapsPoiControllerMock() {
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

		$controllerMock->expects( $this->any() )
			->method( 'isValidArticleTitle' )
			->willReturn( true );

		$controllerMock->request = $requestMock;

		return $controllerMock;
	}

	private function getUserMock( $type = 'default' ) {
		$userMock = $this->getMockBuilder( 'User' )
			->setMethods( [ 'getName', 'isLoggedIn', 'isBlocked' ] )
			->disableOriginalConstructor()
			->getMock();

		switch( $type ) {
			case self::USER_TYPE_LOGGED_OUT:
				$userMock->expects( $this->once() )
					->method( 'isLoggedIn' )
					->willReturn( false );
				break;
			case self::USER_TYPE_BLOCKED:
				$userMock->expects( $this->once() )
					->method( 'isBlocked' )
					->willReturn( true );
				// no break for purpose - if user is blocked she's logged-in as well
			case self::USER_TYPE_LOGGED_IN:
				$userMock->expects( $this->once() )
					->method( 'isLoggedIn' )
					->willReturn( true );
				break;
		}

		return $userMock;
	}

}
