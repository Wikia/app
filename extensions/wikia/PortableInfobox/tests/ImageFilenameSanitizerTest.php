<?php

class ImageFilenameSanitizerTest extends WikiaBaseTest {
	private $imageFilenameSanitizer;

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();

		$this->imageFilenameSanitizer = \Wikia\PortableInfobox\Helpers\ImageFilenameSanitizer::getInstance();
	}

	/**
	 * @param $inputFileName
	 * @param $expectedOutput
	 * @param $description
	 * @dataProvider testSanitizeFilenameDataProvider
	 */
	public function testSanitizeFilename( $inputFileName, $expectedOutput, $description ) {
		$actualOutput = $this->imageFilenameSanitizer->sanitizeImageFileName( $inputFileName );

		$this->assertEquals( $expectedOutput, $actualOutput, $description );
	}

	public function testSanitizeFilenameDataProvider() {
		return [
			[
				'filename.jpg',
				'filename.jpg'
			]
		];
	}
}
