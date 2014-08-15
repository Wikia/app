<?php

/**
 * @group UsingDB
 */
class WikiaInteractiveMapsUploadImageFromFileTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/WikiaInteractiveMaps/WikiaInteractiveMaps.setup.php";
		parent::setUp();
	}

	public function testVerifyUpload_success_not_for_POI() {
		$expected = [ 'status' => 'success' ];
		$uploadImageFromFileMock = $this->getUploadImageFromFileMock(
			$expected,
			true,
			false,
			true
		);

		$uploadImageFromFileMock
			->expects( $this->never() )
			->method( 'getUploadedImageSize' );

		/**
		 * @var WikiaInteractiveMapsUploadImageFromFile $uploadImageFromFileMock
		 */
		$this->assertEquals(
			$expected,
			$uploadImageFromFileMock->verifyUpload( 'mocked type' ),
			'Successful update which IS NOT POI category image upload'
		);
	}

	public function testVerifyUpload_success_for_POI() {
		$expected = [ 'status' => 'success' ];
		$uploadImageFromFileMock = $this->getUploadImageFromFileMock(
			$expected,
			true,
			true,
			true
		);

		$uploadImageFromFileMock
			->expects( $this->once() )
			->method( 'getUploadedImageSize' )
			->will( $this->returnValue( [ 64, 64 ] ) );

		/**
		 * @var WikiaInteractiveMapsUploadImageFromFile $uploadImageFromFileMock
		 */
		$this->assertEquals(
			$expected,
			$uploadImageFromFileMock->verifyUpload( 'mocked type' ),
			'Successful update which IS POI category image upload'
		);
	}

	public function testVerifyUpload_failed_for_POI() {
		$expected = [ 'status' => WikiaInteractiveMapsUploadImageFromFile::POI_CATEGORY_MARKER_IMAGE_TOO_SMALL_ERROR ];
		$uploadImageFromFileMock = $this->getUploadImageFromFileMock(
			[ 'status' => 'success' ],
			true,
			true,
			true
		);

		$uploadImageFromFileMock
			->expects( $this->once() )
			->method( 'getUploadedImageSize' )
			->will( $this->returnValue( [ 1, 2 ] ) );

		/**
		 * @var WikiaInteractiveMapsUploadImageFromFile $uploadImageFromFileMock
		 */
		$this->assertEquals(
			$expected,
			$uploadImageFromFileMock->verifyUpload( 'mocked type' ),
			'Failed update which IS POI category image upload'
		);
	}

	public function testVerifyUpload_failed_file_extension() {
		$expected = [ 'status' => UploadBase::FILETYPE_BADTYPE ];
		$uploadImageFromFileMock = $this->getUploadImageFromFileMock(
			[ 'status' => 'success' ],
			true,
			false,
			false
		);

		$uploadImageFromFileMock
			->expects( $this->never() )
			->method( 'getUploadedImageSize' );

		/**
		 * @var WikiaInteractiveMapsUploadImageFromFile $uploadImageFromFileMock
		 */
		$this->assertEquals(
			$expected,
			$uploadImageFromFileMock->verifyUpload( 'mocked type' ),
			'Failed update due to wrong file extension'
		);
	}

	private function getUploadImageFromFileMock(
		$uploadDetailsMock,
		$isUploadSuccessfulMock,
		$isUploadPoiCategoryMock,
		$isValidFileExtensionMock
	) {
		$uploadImageFromFileMock = $this->getMock( 'WikiaInteractiveMapsUploadImageFromFile', [
			'getUploadDetails',
			'isUploadSuccessful',
			'isUploadPoiCategory',
			'getUploadedImageSize',
			'isValidFileExtension',
		] );

		$uploadImageFromFileMock
			->expects( $this->once() )
			->method( 'getUploadDetails' )
			->will( $this->returnValue( $uploadDetailsMock ) );

		$uploadImageFromFileMock
			->expects( $this->once() )
			->method( 'isUploadSuccessful' )
			->will( $this->returnValue( $isUploadSuccessfulMock ) );

		$uploadImageFromFileMock
			->expects( $this->once() )
			->method( 'isUploadPoiCategory' )
			->will( $this->returnValue( $isUploadPoiCategoryMock ) );

		$uploadImageFromFileMock
			->expects( $this->once() )
			->method( 'isValidFileExtension' )
			->will( $this->returnValue( $isValidFileExtensionMock ) );

		return $uploadImageFromFileMock;
	}

}
