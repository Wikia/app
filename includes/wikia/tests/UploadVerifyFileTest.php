<?php

class TestUploadClass extends UploadBase {
	public function initializeFromRequest( &$request ) {}
}

/**
 * @category Wikia
 * @group Integration
 */
class UploadVerifyFile extends WikiaBaseTest {
	private $tmpPath = false;

	public function tearDown() {
		parent::tearDown();

		if ($this->tmpPath !== false) {
			unlink($this->tmpPath);
		}
	}

	/**
	 * @dataProvider uploadVerifyFileDataProvider
	 */
	public function testUploadVerifyFile($mime, $expectedReturnVal, $uploadContent = '') {
		if ($uploadContent !== '') {
			$this->tmpPath = tempnam("/tmp", "UploadTest");
			file_put_contents($this->tmpPath, $uploadContent);
		}

		$uploadMock = $this->createConfiguredMock( TestUploadClass::class, [
			'getTempPath' => $this->tmpPath,
		] );

		$status = array();
		$ret = Wikia::onUploadVerifyFile($uploadMock, $mime, $status);

		$this->assertEquals($expectedReturnVal, $ret);
		$this->assertEquals($ret ? array() : array('verification-error'), $status);
	}

	public function uploadVerifyFileDataProvider() {
		return array(
			// valid image
			array(
				'mime' => 'image/gif',
				'expectedReturnVal' => true,
				'uploadContent' => base64_decode('R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D'), // blank 1x1 gif
			),
			// invalid image
			// identify.im6: no decode delegate for this image format `/tmp/UploadTestBUg4ue' @ error/constitute.c/ReadImage/544
			array(
				'mime' => 'image/gif',
				'expectedReturnVal' => false,
				'uploadContent' => 'foobar',
			),
			// don't do anything if uploaded file is not a supported image
			array(
				'mime' => 'image/svg',
				'expectedReturnVal' => true,
			),
			array(
				'mime' => 'application/pdf',
				'expectedReturnVal' => true,
			)
		);
	}
}
