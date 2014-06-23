<?php
require_once( $IP . '/extensions/wikia/WikiaInteractiveMaps/WikiaInteractiveMapsUploadImageFromFile.class.php' );

class WikiaInteractiveMapsUploadImageFromFileTest extends WikiaBaseTest {

	/**
	 * @dataProvider verifyUploadDataProvider
	 */
	public function testVerifyUpload( $testDescription, $uploadDetailsMock, $isUploadSuccessfulMock, $isUploadPoiCategoryMock, $expected ) {
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
			->will( $this->returnValue( [ 1, 2 ] ) );

		/**
		 * @var WikiaInteractiveMapsUploadImageFromFile $uploadImageFromFileMock
		 */
		$this->assertEquals( $expected, $uploadImageFromFileMock->verifyUpload( 'mocked type' ), $testDescription );
	}

	public function verifyUploadDataProvider() {
		return [
			[
				'Successful update which is not POI category image upload',
				'uploadDetailsMock' => [ 'status' => 'success' ],
				'isUploadSuccessfulMock' => true,
				'isUploadPoiCategory' => false,
				'expected' => [ 'status' => 'success' ],
			],
		];
	}

}
