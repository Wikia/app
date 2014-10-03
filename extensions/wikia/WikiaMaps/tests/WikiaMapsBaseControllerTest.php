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
