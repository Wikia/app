<?php
class WikiaMapsBaseControllerTest extends WikiaBaseTest {

	const TEST_IMG_NAME = 'Mocked name';
	const TEST_IMG_URL = 'http://placekitten.com/640/480';

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/WikiaMaps/WikiaMaps.setup.php";
		parent::setUp();
	}

	public function testGetStashedImage_default_parameters() {
		/** @var WikiaUploadStashFile $fileMock */
		$fileMock = $this->getWikiaUploadStashFileMock();
		$wikiaMapsBase = new WikiaMapsBaseController();
		$wikiaMapsBase->getStashedImage( $fileMock );
	}

	public function testGetStashedImage_thumb_parameters() {
		$fileMock = $this->getWikiaUploadStashFileMock( 'thumb' );
		$wikiaMapsBase = new WikiaMapsBaseController();
		$wikiaMapsBase->getStashedImage( $fileMock, WikiaMapsBaseController::IMAGE_THUMBNAIL );
	}

	/**
	 * @dataProvider isUserAllowedDataProvider
	 */
	public function testIsUserAllowed( $testCaseDesc, $isLoggedInMock, $isBlockedMock, $expected) {
		$userMock = $this->getMockBuilder( 'User' )
			->disableOriginalConstructor()
			->setMethods( ['isLoggedIn', 'isBlocked'] )
			->getMock();

		$userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( $isLoggedInMock );

		$userMock->expects( $this->any() )
			->method( 'isBlocked' )
			->willReturn( $isBlockedMock );

		$this->mockGlobalVariable( 'wgUser', $userMock );

		$controller = new WikiaMapsBaseController();
		$this->assertEquals( $expected, $controller->isUserAllowed(), $testCaseDesc );
	}

	public function isUserAllowedDataProvider() {
		return [
			[
				'logged-in BUT not blocked user',
				'isLoggedInMock' => true,
				'isBlockedMock' => false,
				'expected' => true,
			],
			[
				'logged-in AND not blocked user',
				'isLoggedInMock' => true,
				'isBlockedMock' => true,
				'expected' => false,
			],
			[
				'not logged-in user',
				'isLoggedInMock' => false,
				'isBlockedMock' => false,
				'expected' => false,
			],
		];
	}

	/**
	 * @dataProvider isUserMapCreatorDataProvider
	 */
	public function testIsUserMapCreator( $testDescription, $mapIdMock, $mapDataMock, $userNameMock, $expected ) {
		$mapsModelMock = $this->getMockBuilder( 'WikiaMaps' )
			->disableOriginalConstructor()
			->setMethods( [ 'getMapByIdFromApi' ] )
			->getMock();

		$mapsModelMock->expects( $this->once() )
			->method( 'getMapByIdFromApi' )
			->willReturn( $mapDataMock );

		$userMock = $this->getMockBuilder( 'User' )
			->disableOriginalConstructor()
			->setMethods( [ 'getName' ] )
			->getMock();

		$userMock->expects( $this->once() )
			->method( 'getName' )
			->willReturn( $userNameMock );


		/** @var WikiaMapsBaseController $mapsBaseControllerMock */
		$mapsBaseControllerMock = $this->getMockBuilder('WikiaMapsBaseController')
			->disableOriginalConstructor()
			->setMethods( [ 'getModel' ] )
			->getMock();

		$mapsBaseControllerMock->expects( $this->once() )
			->method( 'getModel' )
			->willReturn( $mapsModelMock );

		$mapsBaseControllerMock->wg->User = $userMock;

		$this->assertEquals( $mapsBaseControllerMock->isUserMapCreator( $mapIdMock ), $expected, $testDescription );
	}

	public function isUserMapCreatorDataProvider() {
		return [
			[
				'a user IS map creator',
				1,
				(object) [ 'id' => 1, 'created_by' => 'Test User' ],
				'Test User',
				true
			],
			[
				'a user IS NOT map creator',
				1,
				(object) [ 'id' => 1, 'created_by' => 'Test User' ],
				'Different Test User',
				false
			]
		];
	}

	/**
	 * Helper method returns different WikiaUploadStashFile mocks
	 *
	 * @param string $version
	 *
	 * @return PHPUnit_Framework_MockObject_MockObject
	 */
	private function getWikiaUploadStashFileMock( $version = 'original' ) {
		$fileMock = $this->getMock( 'WikiaUploadStashFile', [ 'getOriginalFileUrl', 'getThumbUrl', 'getName' ], [], '', false );

		switch( $version ) {
			case 'thumb':
				$fileMock->expects( $this->never() )
					->method( 'getOriginalFileUrl' );
				$fileMock->expects( $this->once() )
					->method( 'getThumbUrl' )
					->will( $this->returnValue( self::TEST_IMG_URL ) );
				$fileMock->expects( $this->once() )
					->method( 'getName' )
					->will( $this->returnValue( self::TEST_IMG_NAME ) );
				break;
			default:
				$fileMock->expects( $this->once() )
					->method( 'getOriginalFileUrl' )
					->will( $this->returnValue( self::TEST_IMG_URL ) );
				$fileMock->expects( $this->never() )
					->method( 'getThumbUrl' );
				$fileMock->expects( $this->never() )
					->method( 'getName' );
		}

		return $fileMock;
	}

}
