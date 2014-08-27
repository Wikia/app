<?php
class WikiaInteractiveMapsPoiControllerTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/WikiaInteractiveMaps/WikiaInteractiveMaps.setup.php";
		parent::setUp();
	}

	public function testEditPoiCategories_throws_permission_error() {
		$requestMock = $this->getMockBuilder( 'WikiaRequest' )
			->setMethods( [ 'getVal', 'getArray' ] )
			->disableOriginalConstructor()
			->getMock();

		$userMock = $this->getMockBuilder( 'User' )
			->setMethods( [ 'getName', 'isLoggedIn' ] )
			->disableOriginalConstructor()
			->getMock();

		$controllerMock = $this->getMockBuilder( 'WikiaInteractiveMapsPoiController' )
			->setMethods( [ 'setData', 'getData', 'organizePoiCategoriesData', 'getModel' ] )
			->disableOriginalConstructor()
			->getMock();

		$controllerMock->request = $requestMock;
		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'PermissionsException' );
		$controllerMock->editPoiCategories();
	}

}
