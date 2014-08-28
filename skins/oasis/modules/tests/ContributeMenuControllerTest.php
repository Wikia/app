<?php
class ContributeMenuControllerTest extends WikiaBaseTest {

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

		$responseMock = $this->getWikiaResponseMock( $this->getDefaultDropdownItems() );

		$controller = new ContributeMenuController();
		$controller->app = $appMock;
		$controller->wg->EnableSpecialVideosExt = false;
		$controller->setResponse( $responseMock );

		$controller->executeIndex();
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

		$dropDownItems = $this->getDefaultDropdownItems();
		$dropDownItems = array_merge(
			$dropDownItems,
			[
				'edit' => [
					'text' => 'Edit this Page',
					'href' => '',
					'accesskey' => '',
				]
			]
		);
		$responseMock = $this->getWikiaResponseMock( $dropDownItems );

		$controller = new ContributeMenuController();
		$controller->app = $appMock;
		$controller->wg->EnableSpecialVideosExt = false;
		$controller->setResponse( $responseMock );

		$controller->executeIndex();
	}

	public function testExecuteIndex_with_video() {
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
		$controller->setResponse( $responseMock );

		$controller->executeIndex();
	}

	public function testExecuteIndex_with_edit_nav() {
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

	private function getWikiaResponseMock( $expectedDropDownItems ) {
		$responseMock = $this->getMockBuilder( 'WikiaResponse' )
			->setMethods( [ 'setVal', 'getVal' ] )
			->disableOriginalConstructor()
			->getMock();
		$responseMock->expects( $this->once() )
			->method( 'setVal' )
			->with(
				$this->equalTo( 'dropdownItems' ),
				$this->equalTo( $expectedDropDownItems )
			);

		return $responseMock;
	}

	private function getDefaultDropdownItems() {
		return [
			'upload' => [
				'text' => 'Add a Photo',
				'href' => '/wiki/Special:Upload',
			],
			'createpage' => [
				'text' => 'Add a Page',
				'href' => '/wiki/Special:CreatePage',
				'class' => 'createpage',
			],
			'wikiactivity' => [
				'text' => 'Wiki Activity',
				'href' => '/wiki/Special:WikiActivity',
				'accesskey' => 'g',
			],
		];
	}

}
