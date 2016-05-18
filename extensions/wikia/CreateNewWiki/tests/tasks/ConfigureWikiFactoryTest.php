<?php

namespace Wikia\CreateNewWiki\Tasks;
/**
 * Class ConfigureWikiFactoryTest
 * @group Integration
 */
class ConfigureWikiFactoryTest extends \WikiaBaseTest {

	private $taskContextMock;

	public function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../CreateNewWiki_setup.php';
		parent::setUp();

		$this->taskContextMock = $this->getMock(
			'\Wikia\CreateNewWiki\Tasks\TaskContext', [ 'getLanguage', 'getWikiName' ]
		);
		$this->mockClass( 'TaskContext', $this->taskContextMock );
	}

	public function tearDown() {
		parent::tearDown();
	}

	public function testWgUploadDirectoryExistsAssertion() {
		$this->setExpectedException( '\Wikia\Util\AssertionException' );
		$this->mockStaticMethod( 'WikiFactory', 'getVarIdByName', false );
		ConfigureWikiFactory::wgUploadDirectoryExists( 'whatever-input' );
	}

	public function testWgUploadDirectoryExists() {
		$this->mockStaticMethod( 'WikiFactory', 'getVarIdByName', 17 );

		$this->mockStaticMethod( 'WikiFactory', 'getCityIDsFromVarValue', [ ] );
		$this->assertFalse( ConfigureWikiFactory::wgUploadDirectoryExists( 'a-directory-that-does-not-exist' ) );

		$this->mockStaticMethod( 'WikiFactory', 'getCityIDsFromVarValue', [ 1, 2, 3, 5, 8, 12 ] );
		$this->assertTrue( ConfigureWikiFactory::wgUploadDirectoryExists( 'a-directory-that-does-exist' ) );
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
	 * @param $language
	 * @param $taskResult
	 * @param $expectedImagesURL
	 * @param $expectedImagesDir
	 * @internal param $expected
	 * @dataProvider prepareDataProvider
	 */
	public function testPrepare( $wikiName, $language, $taskResult, $expectedImagesURL, $expectedImagesDir ) {
		$this->taskContextMock
			->expects( $this->any() )
			->method( 'getWikiName' )
			->willReturn( $wikiName );

		$this->taskContextMock
			->expects( $this->any() )
			->method( 'getLanguage' )
			->willReturn( $language );

		$configureWFTask = $this->getMockBuilder( '\Wikia\CreateNewWiki\Tasks\ConfigureWikiFactory' )
			->enableOriginalConstructor()
			->setConstructorArgs( [ $this->taskContextMock ] )
			->setMethods( [ 'prepareDirValue' ] )
			->getMock();

		$configureWFTask->expects( $this->any() )
			->method( 'prepareDirValue' )
			->willReturn( $wikiName );

		$this->mockStaticMethod( '\Wikia\CreateNewWiki\Tasks\TaskResult', 'createForSuccess', $taskResult );

		$result = $configureWFTask->prepare();
		$this->assertEquals( $configureWFTask->imagesURL, $expectedImagesURL );
		$this->assertEquals( $configureWFTask->imagesDir, $expectedImagesDir );
		$this->assertEquals( $result, $taskResult );
	}

	public function prepareDataProvider() {
		return [
			[ 'glee', 'en', 'ok', 'http://images.wikia.com/glee/images', '/images/g/glee/images' ],
			[ 'glee', 'pl', 'ok', 'http://images.wikia.com/glee/pl/images', '/images/g/glee/pl/images' ]
		];
	}

	/**
	 * @param $siteName
	 * @param $imagesURL
	 * @param $imagesDir
	 * @param $dbName
	 * @param $language
	 * @param $url
	 * @param $expected
	 * @dataProvider getStaticWikiFactoryVariablesDataProvider
	 */
	public function testGetStaticWikiFactoryVariables( $siteName, $imagesURL, $imagesDir, $dbName, $language, $url, $expected ) {
		$configureWFTask = new ConfigureWikiFactory( $this->taskContextMock );

		$result = $configureWFTask->getStaticVariables( $siteName, $imagesURL, $imagesDir, $dbName, $language, $url );
		$this->assertEquals( $result, $expected );
	}

	public function getStaticWikiFactoryVariablesDataProvider() {
		return [
			[ 'foo', 'http://images.wikia.com/foo/images', '/images/f/foo/images', 'foo', 'en', 'http://foo.wikia.com',
				[
					'wgSitename' => 'foo',
					'wgLogo' => '$wgUploadPath/b/bc/Wiki.png',
					'wgUploadPath' => 'http://images.wikia.com/foo/images',
					'wgUploadDirectory' => '/images/f/foo/images',
					'wgDBname' => 'foo',
					'wgLocalInterwiki' => 'foo',
					'wgLanguageCode' => 'en',
					'wgServer' => 'http://foo.wikia.com',
					'wgEnableSectionEdit' => true,
					'wgEnableSwiftFileBackend' => true,
					'wgOasisLoadCommonCSS' => true,
					'wgEnablePortableInfoboxEuropaTheme' => true,
					'wgDBcluster' => 'c7'
				]
			],
			[ 'foo:', 'http://images.wikia.com/foo/images', '/images/f/foo/images', 'foo', 'en', 'http://foo.wikia.com/',
				[
					'wgSitename' => 'foo:',
					'wgLogo' => '$wgUploadPath/b/bc/Wiki.png',
					'wgUploadPath' => 'http://images.wikia.com/foo/images',
					'wgUploadDirectory' => '/images/f/foo/images',
					'wgDBname' => 'foo',
					'wgLocalInterwiki' => 'foo:',
					'wgLanguageCode' => 'en',
					'wgServer' => 'http://foo.wikia.com',
					'wgEnableSectionEdit' => true,
					'wgEnableSwiftFileBackend' => true,
					'wgOasisLoadCommonCSS' => true,
					'wgEnablePortableInfoboxEuropaTheme' => true,
					'wgMetaNamespace' => 'foo',
					'wgDBcluster' => 'c7'
				]
			],
			[ 'foo_bar:fizz', 'http://images.wikia.com/foo/images', '/images/f/foo/images', 'foo', 'en', 'http://foo.wikia.com/',
				[
					'wgSitename' => 'foo_bar:fizz',
					'wgLogo' => '$wgUploadPath/b/bc/Wiki.png',
					'wgUploadPath' => 'http://images.wikia.com/foo/images',
					'wgUploadDirectory' => '/images/f/foo/images',
					'wgDBname' => 'foo',
					'wgLocalInterwiki' => 'foo_bar:fizz',
					'wgLanguageCode' => 'en',
					'wgServer' => 'http://foo.wikia.com',
					'wgEnableSectionEdit' => true,
					'wgEnableSwiftFileBackend' => true,
					'wgOasisLoadCommonCSS' => true,
					'wgEnablePortableInfoboxEuropaTheme' => true,
					'wgMetaNamespace' => 'foo_barfizz',
					'wgDBcluster' => 'c7'
				]
			]
		];
	}

	/**
	 * @param $staticVariables
	 * @param $expected
	 * @dataProvider getVariablesFromDBDataProvider
	 */
	public function testGetVariablesFromDB( $staticVariables, $expected ) {
		$configureWFTask = new ConfigureWikiFactory( $this->taskContextMock );

		$sharedDBWMock = $this->getMock( '\DatabaseMysqli', [ 'select', 'fetchObject', 'freeResult' ] );

		$result = $configureWFTask->getVariablesFromDB( $sharedDBWMock, $staticVariables );
		$this->assertEquals( $result, $expected );
	}

	public function getVariablesFromDBDataProvider() {
		return [
			[ [ ], [ ] ]
		];
	}
}
