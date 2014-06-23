<?php
require_once( $IP . '/extensions/wikia/WikiaInteractiveMaps/WikiaInteractiveMapsUploadImageFromFile.class.php' );

class WikiaInteractiveMapsUploadImageFromFileTest extends WikiaBaseTest {

	/**
	 * @dataProvider verifyUploadDataProvider
	 */
	public function testVerifyUpload(
		$testDescription,
		$uploadDetailsMock,
		$isUploadSuccessfulMock,
		$isUploadPoiCategoryMock,
		$uploadImageSizeMock,
		$expected
	) {
		$uploadImageFromFileMock = $this->getMock( 'WikiaInteractiveMapsUploadImageFromFile', [
			'getUploadDetails',
			'isUploadSuccessful',
			'isUploadPoiCategory',
			'getUploadedImageSize',
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
			->expects( $this->any() )
			->method( 'getUploadedImageSize' )
			->will( $this->returnValue( $uploadImageSizeMock ) );

		/**
		 * @var WikiaInteractiveMapsUploadImageFromFile $uploadImageFromFileMock
		 */
		$this->assertEquals( $expected, $uploadImageFromFileMock->verifyUpload( 'mocked type' ), $testDescription );
	}

	public function verifyUploadDataProvider() {
		return [
			[
				'Successful update which IS NOT POI category image upload',
				'uploadDetailsMock' => [ 'status' => 'success' ],
				'isUploadSuccessfulMock' => true,
				'isUploadPoiCategory' => false,
				'uploadImageSizeMock' => [ 1, 2 ],
				'expected' => [ 'status' => 'success' ],
			],
			[
				'Successful update which IS POI category image upload',
				'uploadDetailsMock' => [ 'status' => 'success' ],
				'isUploadSuccessfulMock' => true,
				'isUploadPoiCategory' => true,
				'uploadImageSizeMock' => [ 64, 64 ],
				'expected' => [ 'status' => 'success' ],
			],
			[
				'Failed update which IS POI category image upload',
				'uploadDetailsMock' => [ 'status' => 'success' ],
				'isUploadSuccessfulMock' => true,
				'isUploadPoiCategory' => true,
				'uploadImageSizeMock' => [ 1, 2 ],
				'expected' => [ 'status' => WikiaInteractiveMapsUploadImageFromFile::PIN_TYPE_MARKER_IMAGE_TOO_SMALL_ERROR ],
			],
		];
	}

}
