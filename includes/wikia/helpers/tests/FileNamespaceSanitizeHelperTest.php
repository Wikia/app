<?php

use Wikia\Util\GlobalStateWrapper;

class FileNamespaceSanitizeHelperTest extends WikiaBaseTest {
	private $fileNamespaceSanitizeHelper;

	public function setUp() {
		require_once( __DIR__ . '/../FileNamespaceSanitizeHelper.php' );
		parent::setUp();

		$class = new ReflectionClass("FileNamespaceSanitizeHelper");
		$instance = $class->getProperty('instance');
		$instance->setAccessible(true);
		$filePrefixRegex = $class->getProperty('filePrefixRegex');
		$filePrefixRegex->setAccessible(true);

		$this->fileNamespaceSanitizeHelper = FileNamespaceSanitizeHelper::getInstance();
		$instance->setValue($this->fileNamespaceSanitizeHelper, null);
		$filePrefixRegex->setValue($this->fileNamespaceSanitizeHelper, null);
	}

	/**
	 * @param $inputFileName
	 * @param $contentLanguageCode
	 * @param $fileNamespaceAlias
	 * @param $expectedOutput
	 * @param $description
	 * @dataProvider testSanitizeFilenameDataProvider
	 */
	public function testSanitizeFilename( $inputFileName, $contentLanguageCode, $fileNamespaceAlias, $expectedOutput, $description ) {
		$language = new \Language();
		$language->setCode( $contentLanguageCode );
		$actualOutput = '';

		if ( isset( $fileNamespaceAlias ) ) {
			$wrapper = new GlobalStateWrapper( [
				'wgNamespaceAliases' => [ $fileNamespaceAlias => NS_FILE ],
			] );

			$actualOutput = $wrapper->wrap( function() use ( $inputFileName, $language ) {
				return $this->fileNamespaceSanitizeHelper->sanitizeImageFileName( $inputFileName, $language );
			});
		} else {
			$actualOutput = $this->fileNamespaceSanitizeHelper->sanitizeImageFileName( $inputFileName, $language );
		}

		$this->assertEquals( $expectedOutput, $actualOutput, $description );
	}

	public function testSanitizeFilenameDataProvider() {
		return [
			[
				'filename.jpg',
				'en',
				null,
				'filename.jpg',
				'Plain filename'
			],
			[
				'File:filename.jpg',
				'en',
				null,
				'filename.jpg',
				'Filename with namespace'
			],
			[
				'Plik:filename.jpg',
				'pl',
				null,
				'filename.jpg',
				'Filename with localized namespace'
			],
			[
				'Grafika:filename.jpg',
				'pl',
				null,
				'filename.jpg',
				'Filename with localized namespace alias'
			],
			[
				'File:filename.jpg|300px',
				'en',
				null,
				'filename.jpg',
				'Filename with namespace and width'
			],
			[
				'[[File:filename.jpg|300px|lorem ipsum]]',
				'en',
				null,
				'filename.jpg',
				'Link to filename with namespace, width and caption'
			],
			[
				'[[File:filename.jpg|lorem ipsum]]',
				'en',
				null,
				'filename.jpg',
				'Link to filename with namespace and caption'
			],
			[
				'{{File:filename.jpg|lorem ipsum}}',
				'en',
				null,
				'{{File:filename.jpg',
				'Non-file string; sanitized, though useless'
			],
			[
				'',
				'en',
				null,
				'',
				'Empty file name'
			],
			[
				'[[File:image.jpg|300px|lorem ipsum]]',
				'es',
				null,
				'image.jpg',
				'Link to filename with canonical namespace, width and caption on a non-EN wiki'
			],
			[
				'[[File:image.jpg|lorem ipsum]]',
				'es',
				null,
				'image.jpg',
				'Link to filename with canonical namespace and caption on a non-EN wiki'
			],
			[
				'<gallery>' . PHP_EOL .
				'</gallery>' . PHP_EOL,
				'en',
				null,
				'',
				'Empty gallery'
			],
			[
				'<gallery></gallery>',
				'en',
				null,
				'',
				'Empty gallery'
			],
			[
				'<gallery />',
				'en',
				null,
				'',
				'Empty gallery'
			],
			[
				'<gallery>' . PHP_EOL .
				'image.jpg' . PHP_EOL .
				'</gallery>' . PHP_EOL,
				'en',
				null,
				'image.jpg',
				'Gallery with one image'
			],
			[
				'<gallery>' . PHP_EOL .
				'File:image.jpg' . PHP_EOL .
				'</gallery>' . PHP_EOL,
				'en',
				null,
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
				null,
				'文件名óśłżźćńę?.jpg',
				'Gallery with diacritics and UTF characters'
			],
			[
				PHP_EOL .
				PHP_EOL,
				'en',
				null,
				'',
				'Content of empty gallery with newlines'
			],
			[
				'',
				'en',
				null,
				'',
				'Content of empty gallery'
			],
			[
				PHP_EOL .
				'image.jpg' . PHP_EOL .
				PHP_EOL,
				'en',
				null,
				'image.jpg',
				'Content of gallery with one image'
			],
			[
				PHP_EOL .
				'File:image.jpg' . PHP_EOL .
				PHP_EOL,
				'en',
				null,
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
				null,
				'文件名óśłżźćńę?.jpg',
				'Content of gallery with diacritics and UTF characters'
			],
			[
				'Image:filename.jpg',
				'en',
				null,
				'filename.jpg',
				'Filename with alias to namespace'
			],
			[
				'[[File:Su-47_-iDOLM%40STER_Miki-EX-.jpg|300px]]',
				'en',
				null,
				'Su-47_-iDOLM@STER_Miki-EX-.jpg',
				'Link to filename with canonical namespace, width urlencoded character in the middle'
			],
			[
				'[[Tập tin:Naruto-Opening01_222.jpg|200px]]',
				'vi',
				null,
				'Naruto-Opening01_222.jpg',
				'File namespace that include a space'
			],
			[
				'[[いくつかのファイ ルテスト:Naruto-Opening01_222.jpg|200px]]',
				'en',
				"いくつかのファイ_ルテスト",
				'Naruto-Opening01_222.jpg',
				'File namespace that include a space'
			],
			[
				'[[File:Blaabla+2plus+.png|300px]]',
				'en',
				null,
				'Blaabla+2plus+.png',
				'Link to filename with canonical namespace, width and plus (+) characters'
			],
			[
				'[[File:Luke+1.jpg]]',
				'en',
				null,
				'Luke+1.jpg',
				'Link to filename with canonical namespace, width and plus (+) characters'
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

	/**
	 * @param $wikitext
	 * @param $lang
	 * @param $expectedOutput
	 *
	 * @dataProvider testGetCleanFileMarkersFromWikitextDataProvider
	 */
	public function testGetCleanFileMarkersFromWikitext( $wikitext, $lang, $expectedOutput ) {
		$language = new \Language();
		$language->setCode( $lang );
		$actualOutput = $this->fileNamespaceSanitizeHelper->getCleanFileMarkersFromWikitext( $wikitext, $language );

		$this->assertEquals( $expectedOutput, $actualOutput );
	}

	public function testGetCleanFileMarkersFromWikitextDataProvider() {
		return [
			[
				'His clothes are not the same as they were in The Sims 2.',
				'en',
				false
			],
			[
				'His [[Image:image.jpg|300px|lorem ipsum|other param]]clothes are not the same as they were in The Sims 2[[File:image.jpg|300px|lorem ipsum]].',
				'en',
				[
					'Image:image.jpg',
					'File:image.jpg'
				]
			],
			[
				'Der ehrgeizige Sim nimmt sich mehr vor, als seine Zeitgenossen und verfolgt seine Ziele mit eiserner Disziplin.[[Datei:Merkmal-Ehrgeizig.jpg|left]]',
				'de',
				[
					'Datei:Merkmal-Ehrgeizig.jpg'
				]
			],
			[
				'[[Plik:Medina_Hoit.png]]Ma siwe włosy, ciemną skórę, [[Grafika:Medina_Hoit.png]]małe okulary oraz nosi białą koszulę i niebieskie spodnie. [[File:Merkmal-Ehrgeizig.jpg|left]]',
				'pl',
				[
					'Plik:Medina_Hoit.png',
					'Grafika:Medina_Hoit.png',
					'File:Merkmal-Ehrgeizig.jpg'
				]
			]
		];
	}

	/**
	* @param $wikitext
	* @param $expectedOutput
	*
	* @dataProvider testRemoveImageParamsDataProvider
	*/
	public function testRemoveImageParams( $wikitext, $expectedOutput ) {
		$actualOutput = $this->fileNamespaceSanitizeHelper->removeImageParams( $wikitext );

		$this->assertEquals( $expectedOutput, $actualOutput );
	}

	public function testRemoveImageParamsDataProvider() {
		return [
			[
				'File:image.jpg|300px|lorem ipsum',
				'File:image.jpg',
			],
			[
				'File:image.jpg|300px',
				'File:image.jpg',
			],
		];
	}
}
