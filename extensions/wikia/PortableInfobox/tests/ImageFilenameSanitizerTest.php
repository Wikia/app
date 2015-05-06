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
	public function testSanitizeFilename( $inputFileName, $contentLanguageCode, $expectedOutput, $description ) {
		$language = new \Language();
		$language->setCode( $contentLanguageCode );
		$actualOutput = $this->imageFilenameSanitizer->sanitizeImageFileName( $inputFileName, $language );

		$this->assertEquals( $expectedOutput, $actualOutput, $description );
	}

	public function testSanitizeFilenameDataProvider() {
		return [
			[
				'filename.jpg',
				'en',
				'filename.jpg',
				'Plain filename'
			],
			[
				'File:filename.jpg',
				'en',
				'filename.jpg',
				'Filename with namespace'
			],
			[
				'Plik:filename.jpg',
				'pl',
				'filename.jpg',
				'Filename with localized namespace'
			],
			[
				'Grafika:filename.jpg',
				'pl',
				'filename.jpg',
				'Filename with localized namespace alias'
			],
			[
				'File:filename.jpg|300px',
				'en',
				'filename.jpg',
				'Filename with namespace and width'
			],
			[
				'[[File:filename.jpg|300px|lorem ipsum]]',
				'en',
				'filename.jpg',
				'Link to filename with namespace, width and caption'
			],
			[
				'[[File:filename.jpg|lorem ipsum]]',
				'en',
				'filename.jpg',
				'Link to filename with namespace and caption'
			],
			[
				'{{File:filename.jpg|lorem ipsum}}',
				'en',
				'{{File:filename.jpg',
				'Non-file string; sanitized, though useless'
			],
			[
				'',
				'en',
				'',
				'Empty file name'
			],
			[
				'[[File:image.jpg|300px|lorem ipsum]]',
				'es',
				'image.jpg',
				'Link to filename with canonical namespace, width and caption on a non-EN wiki '
			],
			[
				'[[File:image.jpg|lorem ipsum]]',
				'es',
				'image.jpg',
				'Link to filename with canonical namespace and caption on a non-EN wiki '
			]
		];
	}
}
