<?php

namespace Wikia\CreateNewWiki\Tasks;
/**
 * Class ConfigureWikiFactoryTest
 */
class ConfigureWikiFactoryTest extends \WikiaBaseTest {

	public function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../CreateNewWiki_setup.php';
		parent::setUp();

		$this->mockGlobalVariable( 'wgCreateDatabaseActiveCluster', 'c7' );
	}

	/**
	 * @dataProvider provideSanitizeS3BucketName
	 */
	public function testSanitizeS3BucketName( $in, $out ) {
		$method = new \ReflectionMethod( '\Wikia\CreateNewWiki\Tasks\ConfigureWikiFactory', 'sanitizeS3BucketName' );
		$method->setAccessible( true );

		$this->assertEquals( $out, $method->invokeArgs( null, [ $in ] ) );
	}

	public function provideSanitizeS3BucketName() {
		return [
			'0' => [ '0', '0' ],
			'muppet' => [ 'muppet', 'muppet' ],
			'with trailing underscores' => [ 'x__', 'x__0' ],
			'with dots' => [ 'ru.google', 'ru.google' ],
			'with spaces' => [ 'save earth save life', 'save_earth_save_life' ],
			'with parenthesis' => [ 'roman_empire_(the rebirth of rome)', 'roman_empire__the_rebirth_of_rome_0' ],
			'long' => [ '012345678901234567890123456789012345678901234567890123456789', '0123456789012345678901234567890123456789012345678901234' ],
			'capital' => [ 'ABC', 'abc' ],
			'invalid-chars' => [ '@HF(^&HG@$OGH', '40hf285e26hg4024ogh' ],
			'polish' => [ 'ąćśę', 'c485c487c59bc499' ],
			'long-polish' => [ '012345678901234567890123456789012345678901234567890123ą', '012345678901234567890123456789012345678901234567890123c' ],
			'chinese' => [ '不論支持與否', 'e4b88de8ab96e694afe68c81e88887e590a6' ],
			'admin' => [ 'admin', 'adminx' ],
		];
	}

	/**
	 * @param $wikiName
	 * @param $varId
	 * @param $language
	 * @param $taskResult
	 * @param $expectedImagesURL
	 * @param $expectedImagesDir
	 * @internal param $expected
	 * @dataProvider prepareDataProvider
	 */
	public function testPrepare( $wikiName, $varId, $language, $taskResult, $expectedImagesURL, $expectedImagesDir ) {
		$taskContext = new TaskContext( [
			'wikiName' => $wikiName,
		    'language' => $language
		] );

		$configureWFTask = $this->getMockBuilder( '\Wikia\CreateNewWiki\Tasks\ConfigureWikiFactory' )
			->enableOriginalConstructor()
			->setConstructorArgs( [ $taskContext ] )
			->setMethods( [ 'prepareDirValue', 'getWgUploadDirectoryVarId' ] )
			->getMock();

		$configureWFTask->expects( $this->any() )
			->method( 'prepareDirValue' )
			->willReturn( $wikiName );

		$configureWFTask->expects( $this->any() )
			->method( 'getWgUploadDirectoryVarId' )
			->willReturn( $varId );

		$this->mockStaticMethod( '\Wikia\CreateNewWiki\Tasks\TaskResult', 'createForSuccess', 'ok' );
		$this->mockStaticMethod( '\Wikia\CreateNewWiki\Tasks\TaskResult', 'createForError', 'error' );

		$result = $configureWFTask->prepare();
		$this->assertEquals( $configureWFTask->imagesURL, $expectedImagesURL );
		$this->assertEquals( $configureWFTask->imagesDir, $expectedImagesDir );
		$this->assertEquals( $result, $taskResult );
	}

	public function prepareDataProvider() {
		return [
			[ 'glee', 99, 'en', 'ok', 'https://images.wikia.com/glee/images', '/images/g/glee/images' ],
			[ 'glee', 99, 'pl', 'ok', 'https://images.wikia.com/glee/pl/images', '/images/g/glee/pl/images' ],
			[ 'glee', 0, 'pl', 'error', null, null ]
		];
	}

	/**
	 * @param $siteName
	 * @param $imagesURL
	 * @param $imagesDir
	 * @param $dbName
	 * @param $language
	 * @param $url
	 * @param $description
	 * @param $expected
	 * @dataProvider getStaticWikiFactoryVariablesDataProvider
	 */
	public function testGetStaticWikiFactoryVariables( $siteName, $imagesURL, $imagesDir, $dbName, $language, $url,
													   $description, $expected ) {
		$configureWFTask = new ConfigureWikiFactory( new TaskContext( [] ) );

		$result = $configureWFTask->getStaticVariables(
			$siteName, $imagesURL, $imagesDir, $dbName, $language, $url, $description );
		$this->assertEquals( $expected, $result );
	}

	public function getStaticWikiFactoryVariablesDataProvider() {
		return [
			[ 'foo', 'https://images.wikia.com/foo/images', '/images/f/foo/images', 'foo', 'en',
				'https://foo.wikia.com', 'bar',
				[
					'wgSitename' => 'foo',
					'wgLogo' => '$wgUploadPath/b/bc/Wiki.png',
					'wgUploadPath' => 'https://images.wikia.com/foo/images',
					'wgUploadDirectory' => '/images/f/foo/images',
					'wgLocalInterwiki' => 'foo',
					'wgLanguageCode' => 'en',
					'wgEnableSectionEdit' => true,
					'wgOasisLoadCommonCSS' => true,
					'wgEnablePortableInfoboxEuropaTheme' => true,
					'wgWikiDescription' => 'bar',
					'wgEnableDiscussions' => true,
					'wgEnableDiscussionsNavigation' => true,
					'wgArchiveWikiForums' => true,
					'wgEnableRecirculationDiscussions' => true,
					'wgEnableRelatedPagesExt' => true,
					'wgEnableCategoryGalleriesExt' => true,
					'wgEnableFounderProgressBarExt' => true,
					'wgEnableWallExt' => true,
				]
			],
			[ 'foo:', 'https://images.wikia.com/foo/images', '/images/f/foo/images', 'foo', 'en',
				'https://foo.wikia.com/', 'bar',
				[
					'wgSitename' => 'foo:',
					'wgLogo' => '$wgUploadPath/b/bc/Wiki.png',
					'wgUploadPath' => 'https://images.wikia.com/foo/images',
					'wgUploadDirectory' => '/images/f/foo/images',
					'wgLocalInterwiki' => 'foo:',
					'wgLanguageCode' => 'en',
					'wgEnableSectionEdit' => true,
					'wgOasisLoadCommonCSS' => true,
					'wgEnablePortableInfoboxEuropaTheme' => true,
					'wgWikiDescription' => 'bar',
					'wgMetaNamespace' => 'foo',
					'wgEnableDiscussions' => true,
					'wgEnableDiscussionsNavigation' => true,
					'wgArchiveWikiForums' => true,
					'wgEnableRecirculationDiscussions' => true,
					'wgEnableRelatedPagesExt' => true,
					'wgEnableCategoryGalleriesExt' => true,
					'wgEnableFounderProgressBarExt' => true,
					'wgEnableWallExt' => true,
				]
			],
			[ 'foo_bar:fizz', 'https://images.wikia.com/foo/images', '/images/f/foo/images', 'foo', 'en',
				'https://foo.wikia.com/', 'bar',
				[
					'wgSitename' => 'foo_bar:fizz',
					'wgLogo' => '$wgUploadPath/b/bc/Wiki.png',
					'wgUploadPath' => 'https://images.wikia.com/foo/images',
					'wgUploadDirectory' => '/images/f/foo/images',
					'wgLocalInterwiki' => 'foo_bar:fizz',
					'wgLanguageCode' => 'en',
					'wgEnableSectionEdit' => true,
					'wgOasisLoadCommonCSS' => true,
					'wgEnablePortableInfoboxEuropaTheme' => true,
					'wgWikiDescription' => 'bar',
					'wgMetaNamespace' => 'foo_barfizz',
					'wgEnableDiscussions' => true,
					'wgEnableDiscussionsNavigation' => true,
					'wgArchiveWikiForums' => true,
					'wgEnableRecirculationDiscussions' => true,
					'wgEnableRelatedPagesExt' => true,
					'wgEnableCategoryGalleriesExt' => true,
					'wgEnableFounderProgressBarExt' => true,
					'wgEnableWallExt' => true,
				]
			],
			[ 'foo', 'https://images.wikia.com/foo/images', '/images/f/foo/images', 'foo', 'en',
				'https://foo.fandom.com', 'bar',
				[
					'wgSitename' => 'foo',
					'wgLogo' => '$wgUploadPath/b/bc/Wiki.png',
					'wgUploadPath' => 'https://images.wikia.com/foo/images',
					'wgUploadDirectory' => '/images/f/foo/images',
					'wgLocalInterwiki' => 'foo',
					'wgLanguageCode' => 'en',
					'wgEnableSectionEdit' => true,
					'wgOasisLoadCommonCSS' => true,
					'wgEnablePortableInfoboxEuropaTheme' => true,
					'wgWikiDescription' => 'bar',
					'wgEnableDiscussions' => true,
					'wgEnableDiscussionsNavigation' => true,
					'wgArchiveWikiForums' => true,
					'wgEnableRecirculationDiscussions' => true,
					'wgEnableRelatedPagesExt' => true,
					'wgEnableCategoryGalleriesExt' => true,
					'wgEnableFounderProgressBarExt' => true,
					'wgEnableWallExt' => true,
				]
			]
		];
	}
}
