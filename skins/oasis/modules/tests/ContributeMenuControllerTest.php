<?php
class ContributeMenuControllerTest extends WikiaBaseTest {

	const USER_ALLOWED = 'allowed';
	const USER_NOT_ALLOWED = 'not-allowed';

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/skins/oasis/modules/ContributeMenuController.class.php";
		parent::setUp();
	}

	public function testExecuteIndex_default() {
		$skinTplObjMock = new stdClass();
		$skinTplObjMock->data['content_actions'] = [];
		$appMock = $this->getWikiaAppMock();
		$appMock->expects( $this->once() )
			->method( 'getSkinTemplateObj' )
			->willReturn( $skinTplObjMock );

		$responseMock = $this->getWikiaResponseMock();

		$userMock = $this->getUserMock( self::USER_NOT_ALLOWED );

		$controllerMock = $this->getContributeMenuControllerMock( $appMock, $responseMock, $userMock );
		$controllerMock->expects( $this->never() )
			->method( 'getEditPageItem' );
		$controllerMock->expects( $this->once() )
			->method( 'getSpecialPagesLinks' );
		$controllerMock->expects( $this->never() )
			->method( 'getEditNavItem' );

		$controllerMock->executeIndex();
	}

	public function testExecuteIndex_with_edit() {
		$skinTplObjMock = new stdClass();
		$skinTplObjMock->data[ 'content_actions' ] = [
			'edit' => [
				'href' => '',
				'class' => '',
			]
		];
		$appMock = $this->getWikiaAppMock();
		$appMock->expects( $this->once() )
			->method( 'getSkinTemplateObj' )
			->willReturn( $skinTplObjMock );

		$responseMock = $this->getWikiaResponseMock();

		$userMock = $this->getUserMock( self::USER_NOT_ALLOWED );

		$controllerMock = $this->getContributeMenuControllerMock( $appMock, $responseMock, $userMock );
		$controllerMock->expects( $this->once() )
			->method( 'getEditPageItem' );
		$controllerMock->expects( $this->once() )
			->method( 'getSpecialPagesLinks' );
		$controllerMock->expects( $this->never() )
			->method( 'getEditNavItem' );

		$controllerMock->executeIndex();
	}

	public function testExecuteIndex_with_video() {
		$this->markTestSkipped( 'WIP: refactoring test' );

		$skinTplObjMock = new stdClass();
		$skinTplObjMock->data['content_actions'] = [];
		$appMock = $this->getWikiaAppMock();
		$appMock->expects( $this->once() )
			->method( 'getSkinTemplateObj' )
			->willReturn( $skinTplObjMock );

		$dropDownItems = $this->getDefaultDropdownItems();
		$dropDownItems = array_merge(
			$dropDownItems,
			[
				'wikiavideoadd' => [
					'text' => 'Add a Video',
					'href' => '/wiki/Special:WikiaVideoAdd',
				]
			]
		);
		$responseMock = $this->getWikiaResponseMock( $dropDownItems );

		$controller = new ContributeMenuController();
		$controller->app = $appMock;
		$controller->wg->EnableSpecialVideosExt = true;
		$controller->wg->EnableWikiaInteractiveMaps = false;
		$controller->setResponse( $responseMock );

		$controller->executeIndex();
	}

	public function testExecuteIndex_with_maps() {
		$this->markTestSkipped( 'WIP: refactoring test' );

		$skinTplObjMock = new stdClass();
		$skinTplObjMock->data['content_actions'] = [];
		$appMock = $this->getWikiaAppMock();
		$appMock->expects( $this->once() )
			->method( 'getSkinTemplateObj' )
			->willReturn( $skinTplObjMock );

		$dropDownItems = $this->getDefaultDropdownItems();
		$dropDownItems = array_merge(
			$dropDownItems,
			[
				'maps' => [
					'text' => 'Create a Map',
					'href' => '/wiki/Special:Maps',
					'class' => 'wikia-maps-create-map',
				]
			]
		);
		$responseMock = $this->getWikiaResponseMock( $dropDownItems );

		$controller = new ContributeMenuController();
		$controller->app = $appMock;
		$controller->wg->EnableSpecialVideosExt = false;
		$controller->wg->EnableWikiaInteractiveMaps = true;
		$controller->setResponse( $responseMock );

		$controller->executeIndex();
	}

	public function testExecuteIndex_with_edit_nav() {
		$this->markTestSkipped( 'WIP: refactoring test' );

		$skinTplObjMock = new stdClass();
		$skinTplObjMock->data['content_actions'] = [];
		$appMock = $this->getWikiaAppMock();
		$appMock->expects( $this->once() )
			->method( 'getSkinTemplateObj' )
			->willReturn( $skinTplObjMock );

		$dropDownItems = $this->getDefaultDropdownItems();
		$dropDownItems = array_merge(
			$dropDownItems,
			[
				'wikinavedit' => [
					'text' => 'Edit Wiki Navigation',
					'href' => '/wiki/MediaWiki:Wiki-navigation?action=edit',
				],
			]
		);
		$responseMock = $this->getWikiaResponseMock( $dropDownItems );

		$userMock = $this->getMockBuilder( 'User' )
			->setMethods( [ 'isAllowed', 'getOption' ] )
			->disableOriginalConstructor()
			->getMock();
		$userMock->expects( $this->any() )
			->method( 'getOption' )
			->willReturn( 'Mocked Option.' );
		$userMock->expects( $this->any() )
			->method( 'isAllowed' )
			->willReturn( true );

		$controller = new ContributeMenuController();
		$controller->app = $appMock;
		$controller->wg->EnableSpecialVideosExt = false;
		$controller->wg->EnableWikiaInteractiveMaps = false;
		$controller->wg->User = $userMock;
		$controller->setResponse( $responseMock );

		$controller->executeIndex();
	}

	private function getWikiaAppMock() {
		return $this->getMockBuilder( 'WikiaApp' )
			->setMethods( [ 'getSkinTemplateObj' ] )
			->disableOriginalConstructor()
			->getMock();
	}

	private function getWikiaResponseMock() {
		return $this->getMockBuilder( 'WikiaResponse' )
			->setMethods( [ 'setVal', 'getVal' ] )
			->disableOriginalConstructor()
			->getMock();
	}

	private function getUserMock( $option ) {
		$userMock = $this->getMockBuilder( 'User' )
			->setMethods( [ 'isAllowed', 'getOption' ] )
			->disableOriginalConstructor()
			->getMock();
		$userMock->expects( $this->any() )
			->method( 'getOption' )
			->willReturn( 'Mocked Option.' );

		if( $option === self::USER_NOT_ALLOWED ) {
			$userMock->expects( $this->any() )
				->method( 'isAllowed' )
				->willReturn( false );
		} else if( $option === self::USER_ALLOWED ) {
			$userMock->expects( $this->any() )
				->method( 'isAllowed' )
				->willReturn( true );
		}

		return $userMock;
	}

	private function getContributeMenuControllerMock( $appMock, $responseMock, $userMock ) {
		$controllerMock = $this->getMockBuilder( 'ContributeMenuController' )
			->setMethods( [ 'getEditPageItem', 'getSpecialPagesLinks', 'getEditNavItem' ] )
			->disableOriginalConstructor()
			->getMock();

		$controllerMock->app = $appMock;
		$controllerMock->response = $responseMock;
		$controllerMock->wg->EnableSpecialVideosExt = false;
		$controllerMock->wg->EnableWikiaInteractiveMaps = false;
		$controllerMock->wg->User = $userMock;

		return $controllerMock;
	}

}
