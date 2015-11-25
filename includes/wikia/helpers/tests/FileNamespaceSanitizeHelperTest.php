<?php

class FileNamespaceSanitizeHelperTest extends WikiaBaseTest {
	private $fileNamespaceSanitizeHelper;

	public function setUp() {
		require_once( __DIR__ . '/../FileNamespaceSanitizeHelper.php' );
		parent::setUp();

		$this->fileNamespaceSanitizeHelper = FileNamespaceSanitizeHelper::getInstance();
	}

	/**
	 * @param $inputFileName
	 * @param $contentLanguageCode
	 * @param $expectedOutput
	 * @param $description
	 * @dataProvider testSanitizeFilenameDataProvider
	 */
	public function testSanitizeFilename( $inputFileName, $contentLanguageCode, $expectedOutput, $description ) {
		$language = new \Language();
		$language->setCode( $contentLanguageCode );
		$actualOutput = $this->fileNamespaceSanitizeHelper->sanitizeImageFileName( $inputFileName, $language );

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
				'Link to filename with canonical namespace, width and caption on a non-EN wiki'
			],
			[
				'[[File:image.jpg|lorem ipsum]]',
				'es',
				'image.jpg',
				'Link to filename with canonical namespace and caption on a non-EN wiki'
			],
			[
				'<gallery>' . PHP_EOL .
				'</gallery>' . PHP_EOL,
				'en',
				'',
				'Empty gallery'
			],
			[
				'<gallery></gallery>',
				'en',
				'',
				'Empty gallery'
			],
			[
				'<gallery />',
				'en',
				'',
				'Empty gallery'
			],
			[
				'<gallery>' . PHP_EOL .
				'image.jpg' . PHP_EOL .
				'</gallery>' . PHP_EOL,
				'en',
				'image.jpg',
				'Gallery with one image'
			],
			[
				'<gallery>' . PHP_EOL .
				'File:image.jpg' . PHP_EOL .
				'</gallery>' . PHP_EOL,
				'en',
				'image.jpg',
				'Gallery with one image with canonical namespace',
			],
			[
				'<gallery>' . PHP_EOL .
				'文件名óśłżźćńę?.jpg' . PHP_EOL .
				'Image010.jpg' . PHP_EOL .
				'Image009.jpg' . PHP_EOL .
				'</gallery>' . PHP_EOL,
				'en',
				'文件名óśłżźćńę?.jpg',
				'Gallery with diacritics and UTF characters'
			],
			[
				PHP_EOL .
				PHP_EOL,
				'en',
				'',
				'Content of empty gallery with newlines'
			],
			[
				'',
				'en',
				'',
				'Content of empty gallery'
			],
			[
				PHP_EOL .
				'image.jpg' . PHP_EOL .
				PHP_EOL,
				'en',
				'image.jpg',
				'Content of gallery with one image'
			],
			[
				PHP_EOL .
				'File:image.jpg' . PHP_EOL .
				PHP_EOL,
				'en',
				'image.jpg',
				'Content of gallery with one image with canonical namespace',
			],
			[
				PHP_EOL .
				'文件名óśłżźćńę?.jpg' . PHP_EOL .
				'Image010.jpg' . PHP_EOL .
				'Image009.jpg' . PHP_EOL .
				PHP_EOL,
				'en',
				'文件名óśłżźćńę?.jpg',
				'Content of gallery with diacritics and UTF characters'
			],
			[
				'Image:filename.jpg',
				'en',
				'filename.jpg',
				'Filename with alias to namespace'
			],
			[
				'[[File:Su-47_-iDOLM%40STER_Miki-EX-.jpg|300px]]',
				'en',
				'Su-47_-iDOLM@STER_Miki-EX-.jpg',
				'Link to filename with canonical namespace, width urlencoded character in the middle'
			],
		];
	}

	/**
	 * @param $wikitext
	 * @param $contentLanguageCode
	 * @param $expectedOutput
	 *
	 * @dataProvider testStripFilesFromWikitextDataProvider
	 */
	public function testStripFilesFromWikitext( $wikitext, $contentLanguageCode, $expectedOutput ) {
		$language = new \Language();
		$language->setCode( $contentLanguageCode );
		$actualOutput = $this->fileNamespaceSanitizeHelper->stripFilesFromWikitext( $wikitext, $language );

		$this->assertEquals( $expectedOutput, $actualOutput );
	}

	public function testStripFilesFromWikitextDataProvider() {
		return [
			[
				'[[File:image.jpg|300px|lorem ipsum]]His clothes are not the same as they were in The Sims 2.',
				'en',
				'His clothes are not the same as they were in The Sims 2.'
			],
			[
				'His [[Image:image.jpg|300px|lorem ipsum|other param]]clothes are not the same as they were in The Sims 2[[File:image.jpg|300px|lorem ipsum]].',
				'en',
				'His clothes are not the same as they were in The Sims 2.'
			],
			[
				'Der ehrgeizige Sim nimmt sich mehr vor, als seine Zeitgenossen und verfolgt seine Ziele mit eiserner Disziplin.[[Datei:Merkmal-Ehrgeizig.jpg|left]]',
				'de',
				'Der ehrgeizige Sim nimmt sich mehr vor, als seine Zeitgenossen und verfolgt seine Ziele mit eiserner Disziplin.'
			],
			[
				'[[Plik:Medina_Hoit.png]]Ma siwe włosy, ciemną skórę, [[Grafika:Medina_Hoit.png]]małe okulary oraz nosi białą koszulę i niebieskie spodnie. [[File:Merkmal-Ehrgeizig.jpg|left]]',
				'pl',
				'Ma siwe włosy, ciemną skórę, małe okulary oraz nosi białą koszulę i niebieskie spodnie. '
			]
		];
	}
}
