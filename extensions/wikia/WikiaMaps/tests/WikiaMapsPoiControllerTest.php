<?php
class WikiaMapsPoiControllerTest extends WikiaBaseTest {

	const USER_TYPE_LOGGED_IN = 'logged-in';
	const USER_TYPE_LOGGED_OUT = 'logged-out';
	const USER_TYPE_BLOCKED = 'blocked';

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/WikiaMaps/WikiaMaps.setup.php";
		parent::setUp();
	}

	public function testEditPoi_throws_permission_error_when_anon() {
		$userMock = $this->getUserMock( self::USER_TYPE_LOGGED_OUT );

		$controllerMock = $this->getWikiaMapsPoiControllerMock();
		$controllerMock->expects( $this->any() )
			->method( 'getData' )
			->willReturn( 'Mocked Data.' );

		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'WikiaMapsPermissionException' );
		$controllerMock->editPoi();
	}

	public function testEditPoi_throws_permission_error_when_blocked() {
		$userMock = $this->getUserMock( self::USER_TYPE_BLOCKED );

		$controllerMock = $this->getWikiaMapsPoiControllerMock();
		$controllerMock->expects( $this->any() )
			->method( 'getData' )
			->willReturn( 'Mocked Data.' );

		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'WikiaMapsPermissionException' );
		$controllerMock->editPoi();
	}

	public function testDeletePoi_throws_permission_error_when_anon() {
		$userMock = $this->getUserMock( self::USER_TYPE_LOGGED_OUT );

		$controllerMock = $this->getWikiaMapsPoiControllerMock();
		$controllerMock->expects( $this->any() )
			->method( 'getData' )
			->with( 'poiId' )
			->willReturn( 1 );

		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'WikiaMapsPermissionException' );
		$controllerMock->deletePoi();
	}

	public function testDeletePoi_throws_permission_error_when_blocked() {
		$userMock = $this->getUserMock( self::USER_TYPE_BLOCKED );

		$controllerMock = $this->getWikiaMapsPoiControllerMock();
		$controllerMock->expects( $this->any() )
			->method( 'getData' )
			->with( 'poiId' )
			->willReturn( 1 );

		$controllerMock->wg->User = $userMock;

		$this->setExpectedException( 'WikiaMapsPermissionException' );
		$controllerMock->deletePoi();
	}
	
	/**
	 * @dataProvider isValidUrlDataProvider
	 */
	public function testIsValidUrl( $description, $urlMock, $isValidCalledTimes, $isValidMock, $expected ) {
		$poiControllerMock = $this->getMockBuilder( 'WikiaMapsPoiController' )
			->disableOriginalConstructor()
			->setMethods( [ 'getData' ] )
			->getMock();

		$poiControllerMock->expects( $this->once() )
			->method( 'getData' )
			->with( 'articleTitleOrExternalUrl' )
			->willReturn( $urlMock );

		$wikiaValidatorUrlMock = $this->getMockBuilder( 'WikiaValidatorUrl' )
			->disableOriginalConstructor()
			->setMethods( [ 'isValid' ] )
			->getMock();

		$wikiaValidatorUrlMock->expects( $this->$isValidCalledTimes() )
			->method( 'isValid' )
			->willReturn( $isValidMock );

		/** @var WikiaMapsPoiController $poiControllerMock */
		$this->assertEquals( $poiControllerMock->isValidUrl( $wikiaValidatorUrlMock ), $expected, $description );
	}

	public function isValidUrlDataProvider() {
		return [
			[
				'empty BUT valid URL',
				'urlMock' => '',
				'isValidCalledTimes' => 'never',
				'isValidMock' => false,
				'expected' => true,
			],
			[
				'not empty, valid URL',
				'urlMock' => 'http://www.wikia.com',
				'isValidCalledTimes' => 'once',
				'isValidMock' => true,
				'expected' => true,
			],
			[
				'not empty, valid URL - HTML5 URL encoded',
				'urlMock' => 'http://www.wikia.com/%D0%A1%D0%BB%D1%83%D0%B6%D0%B5%D0%B1%D0%BD%D0%B0%D1%8F',
				'isValidCalledTimes' => 'once',
				'isValidMock' => true,
				'expected' => true,
			],
			[
				'not empty, valid URL with UTF8 characters',
				'urlMock' => 'http://www.wikia.com/Служебная',
				'isValidCalledTimes' => 'once',
				'isValidMock' => true,
				'expected' => true,
			],
			[
				'not empty and invalid URL',
				'urlMock' => 'This is not an URL',
				'isValidCalledTimes' => 'once',
				'isValidMock' => false,
				'expected' => false,
			]
		];
	}

	/**
	 * @dataProvider appendLinkAndPhotoIfValidDataProvider
	 */
	public function testAppendLinkIfValidData(
		$description,
		$articleTitleOrUrlMock,
		$getArticleUrlCalls,
		$articleUrlMock,
		$isValidArticleTitleMock,
		$expectedPoiData
	) {
		$poiControllerMock = $this->getMockBuilder( 'WikiaMapsPoiController' )
			->disableOriginalConstructor()
			->setMethods( [ 'getData', 'getArticleUrl', 'isValidArticleTitle' ] )
			->getMock();

		$poiControllerMock->expects( $this->any() )
			->method( 'getData' )
			->willReturn($articleTitleOrUrlMock);

		$poiControllerMock->expects( $this->$getArticleUrlCalls() )
			->method( 'getArticleUrl' )
			->willReturn( $articleUrlMock );

		$poiControllerMock->expects( $this->any() )
			->method( 'isValidArticleTitle' )
			->willReturn( $isValidArticleTitleMock );

		$poiData = [];
		/** @var $poiControllerMock WikiaMapsPoiController */
		$poiControllerMock->appendLinkIfValidData( $poiData );
		$this->assertEquals( $expectedPoiData, $poiData, $description );
	}

	public function appendLinkAndPhotoIfValidDataProvider() {
		return [
			[
				'no link',
				'$articleTitleOrUrlMock' => '',
				'$getArticleUrlCalls' => 'never',
				'$articleUrlMock' => '',
				'$isValidArticleTitleMock' => false,
				'$expectedPoiData' => [
					'link_title' => '',
					'link' => ''
				]
			],
			[
				'internal link with image',
				'$articleTitleOrUrlMock' => 'Existing Article With An Image',
				'$getArticleUrlCalls' => 'once',
				'$articleUrlMock' => 'http://www.test.wikia.com/wiki/Existing_Article_With_An_Image',
				'$isValidArticleTitleMock' => true,
				'$expectedPoiData' => [
					'link_title' => 'Existing Article With An Image',
					'link' => 'http://www.test.wikia.com/wiki/Existing_Article_With_An_Image'
				]
			],
			[
				'internal link without image',
				'$articleTitleOrUrlMock' => 'Existing Article With An Image',
				'$getArticleUrlCalls' => 'once',
				'$articleUrlMock' => 'http://www.test.wikia.com/wiki/Existing_Article_With_An_Image',
				'$isValidArticleTitleMock' => true,
				'$expectedPoiData' => [
					'link_title' => 'Existing Article With An Image',
					'link' => 'http://www.test.wikia.com/wiki/Existing_Article_With_An_Image'
				]
			],
			[
				'external link',
				'$articleTitleOrUrlMock' => 'http://www.wikia.com',
				'$getArticleUrlCalls' => 'once',
				'$articleUrlMock' => '',
				'$isValidArticleTitleMock' => false,
				'$expectedPoiData' => [
					'link_title' => 'http://www.wikia.com',
					'link' => 'http://www.wikia.com'
				]
			],
			[
				'external link with hacked POST data and image passed',
				'$articleTitleOrUrlMock' => 'http://www.wikia.com',
				'$getArticleUrlCalls' => 'once',
				'$articleUrlMock' => '',
				'$isValidArticleTitleMock' => false,
				'$expectedPoiData' => [
					'link_title' => 'http://www.wikia.com',
					'link' => 'http://www.wikia.com'
				]
			],
			[
				'external link without http',
				'$articleTitleOrUrlMock' => 'www.wikia.com',
				'$getArticleUrlCalls' => 'once',
				'$articleUrlMock' => '',
				'$isValidArticleTitleMock' => false,
				'$expectedPoiData' => [
					'link_title' => 'www.wikia.com',
					'link' => 'http://www.wikia.com'
				]
			],
		];
	}

	/**
	 * @dataProvider appendPhotoIfValidDataDataProvider
	 */
	public function testAppendPhotoIfValidData( $description, $imageUrlMock, $isValidArticleTitleMock, $linkMock, $expectedPoiData ) {
		$poiControllerMock = $this->getMockBuilder( 'WikiaMapsPoiController' )
			->disableOriginalConstructor()
			->setMethods( [ 'getData', 'isValidArticleTitle' ] )
			->getMock();

		$poiControllerMock->expects( $this->any() )
			->method( 'getData' )
			->willReturn($imageUrlMock);

		$poiControllerMock->expects( $this->once() )
			->method( 'isValidArticleTitle' )
			->willReturn( $isValidArticleTitleMock );

		$poiData = [
			'link' => $linkMock
		];

		/** @var $poiControllerMock WikiaMapsPoiController */
		$poiControllerMock->appendPhotoIfValidData( $poiData );
		$this->assertEquals( $expectedPoiData, $poiData, $description );
	}

	public function appendPhotoIfValidDataDataProvider() {
		return [
			[
				'no link',
				'$imageUrlMock' => '',
				'$isValidArticleTitleMock' => false,
				'$linkMock' => '',
				'$expectedPoiData' => [
					'link' => '',
					'photo' => ''
				]
			],
			[
				'internal link with image',
				'$imageUrlMock' => 'http://images.nocookie.wikia.com/t/test/an_image.jpg',
				'$isValidArticleTitleMock' => true,
				'$linkMock' => 'http://www.test.wikia.com/wiki/Existing_Article_With_An_Image',
				'$expectedPoiData' => [
					'link' => 'http://www.test.wikia.com/wiki/Existing_Article_With_An_Image',
					'photo' => 'http://images.nocookie.wikia.com/t/test/an_image.jpg'
				]
			],
			[
				'internal link without image',
				'$imageUrlMock' => '',
				'$isValidArticleTitleMock' => true,
				'$linkMock' => 'http://www.test.wikia.com/wiki/Existing_Article_With_An_Image',
				'$expectedPoiData' => [
					'link' => 'http://www.test.wikia.com/wiki/Existing_Article_With_An_Image',
					'photo' => ''
				]
			],
			[
				'external link',
				'$imageUrlMock' => '',
				'$isValidArticleTitleMock' => false,
				'$linkMock' => 'http://www.wikia.com',
				'$expectedPoiData' => [
					'link' => 'http://www.wikia.com',
					'photo' => ''
				]
			],
			[
				'external link with hacked POST data and image passed',
				'$imageUrlMock' => 'http://placekitten.com/g/200/400',
				'$isValidArticleTitleMock' => false,
				'$linkMock' => 'http://www.wikia.com',
				'$expectedPoiData' => [
					'link' => 'http://www.wikia.com',
					'photo' => ''
				]
			]
		];
	}

	/**
	 * @return WikiaMapsPoiController
	 */
	private function getWikiaMapsPoiControllerMock() {
		$requestMock = $this->getMockBuilder( 'WikiaRequest' )
			->setMethods( [ 'getVal', 'getArray', 'getInt' ] )
			->disableOriginalConstructor()
			->getMock();

		$controllerMock = $this->getMockBuilder( 'WikiaMapsPoiController' )
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
			/** @noinspection PhpMissingBreakStatementInspection */
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
