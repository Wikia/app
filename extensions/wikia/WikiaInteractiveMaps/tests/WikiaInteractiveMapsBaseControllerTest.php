<?php
class WikiaInteractiveMapsBaseControllerTest extends WikiaBaseTest {

	const TEST_IMG_NAME = 'Mocked name';
	const TEST_IMG_URL = 'http://placekitten.com/640/480';

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/WikiaInteractiveMaps/WikiaInteractiveMaps.setup.php";
		parent::setUp();
	}

	public function testGetStashedImage_default_parameters() {
		$fileMock = $this->getWikiaUploadStashFileMock();
		$wikiaInteractiveMapsBase = new WikiaInteractiveMapsBaseController();
		$wikiaInteractiveMapsBase->getStashedImage( $fileMock );
	}

	public function testGetStashedImage_thumb_parameters() {
		$fileMock = $this->getWikiaUploadStashFileMock( 'thumb' );
		$wikiaInteractiveMapsBase = new WikiaInteractiveMapsBaseController();
		$wikiaInteractiveMapsBase->getStashedImage( $fileMock, WikiaInteractiveMapsBaseController::IMAGE_THUMBNAIL );
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

		$controller = new WikiaInteractiveMapsBaseController();
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
