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

	public function testExecuteIndex_with_edit_nav() {
		$skinTplObjMock = new stdClass();
		$skinTplObjMock->data['content_actions'] = [];
		$appMock = $this->getWikiaAppMock();
		$appMock->expects( $this->once() )
			->method( 'getSkinTemplateObj' )
			->willReturn( $skinTplObjMock );

		$responseMock = $this->getWikiaResponseMock();

		$userMock = $this->getUserMock( self::USER_ALLOWED );

		$controllerMock = $this->getContributeMenuControllerMock( $appMock, $responseMock, $userMock );
		$controllerMock->expects( $this->never() )
			->method( 'getEditPageItem' );
		$controllerMock->expects( $this->once() )
			->method( 'getSpecialPagesLinks' );
		$controllerMock->expects( $this->once() )
			->method( 'getEditNavItem' );

		$controllerMock->executeIndex();
	}

	/**
	 * @param String $message - test case description
	 * @param Boolean $wgEnableSpecialVideosExtMock
	 * @param Boolean $wgEnableWikiaInteractiveMapsMock
	 * @param String $isUserAllowed - one of class constants: USER_ALLOWED or USER_NOT_ALLOWED
	 * @param Array $expected
	 *
	 * @dataProvider getSpecialPagesDataProvider
	 */
	public function testGetSpecialPagesLinks(
		$message,
		$wgEnableSpecialVideosExtMock,
		$wgEnableWikiaInteractiveMapsMock,
		$isUserAllowed,
		$expected
	) {
		$userMock = $this->getUserMock( $isUserAllowed );
		$controllerMock = $this->getMockBuilder( 'ContributeMenuController' )
			->setMethods( [ 'getDefaultSpecialPagesData' ] )
			->disableOriginalConstructor()
			->getMock();
		$controllerMock->expects( $this->once() )
			->method( 'getDefaultSpecialPagesData' )
			->willReturn( [] );
		$controllerMock->wg->EnableSpecialVideosExt = $wgEnableSpecialVideosExtMock;
		$controllerMock->wg->EnableWikiaInteractiveMaps = $wgEnableWikiaInteractiveMapsMock;
		$controllerMock->wg->User = $userMock;

		$this->assertEquals( $expected, $controllerMock->getSpecialPagesLinks(), $message );
	}

	public function getSpecialPagesDataProvider() {
		return [
			[
				'No additional extensions enabled',
				false,
				false,
				self::USER_ALLOWED,
				[]
			],
			[
				'Video extension is enabled',
				true,
				false,
				self::USER_ALLOWED,
				[
					'WikiaVideoAdd' => [
						'label' => 'oasis-navigation-v2-add-video'
					]
				]
			],
			[
				'Video extension is enabled but user does not have rights',
				true,
				false,
				self::USER_NOT_ALLOWED,
				[]
			],
			[
				'Map extension is enabled',
				false,
				true,
				self::USER_NOT_ALLOWED,
				[
					'Maps' => [
						'label' => 'wikia-interactive-maps-create-a-map',
						'class' => 'wikia-maps-create-map'
					]
				]
			],
			[
				'Video and maps extensions are enabled',
				true,
				true,
				self::USER_ALLOWED,
				[
					'WikiaVideoAdd' => [
						'label' => 'oasis-navigation-v2-add-video'
					],
					'Maps' => [
						'label' => 'wikia-interactive-maps-create-a-map',
						'class' => 'wikia-maps-create-map'
					]
				]
			],
			[
				'Video and maps extensions are enabled but user is not allowed to add videos',
				true,
				true,
				self::USER_NOT_ALLOWED,
				[
					'Maps' => [
						'label' => 'wikia-interactive-maps-create-a-map',
						'class' => 'wikia-maps-create-map'
					]
				]
			]
		];
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
