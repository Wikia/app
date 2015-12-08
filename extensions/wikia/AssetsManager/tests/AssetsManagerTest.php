<?php

class AssetsManagerTest extends WikiaBaseTest {

	const SASS_FILE = '/skins/oasis/css/oasis.scss';
	const JS_GROUP = 'oasis_jquery';

	private $cb;
	/** @var AssetsManager */
	private $instance;

	public function setUp() {
		parent::setUp();
		$this->cb = $this->app->wg->StyleVersion;
		$this->instance = AssetsManager::getInstance();
	}

	/**
	 * @group UsingDB
	 */
	public function testGetSassCommonURL() {
		$url =  $this->instance->getSassCommonURL( self::SASS_FILE, true /* $minify */ );

		$this->assertContains( '__am', $url );
		$this->assertContains( "/{$this->cb}/", $url );
		$this->assertContains( self::SASS_FILE, $url );
	}

	public function testGetGroupsCommonURL() {
		$url =  $this->instance->getGroupsCommonURL( array( 'foo', 'bar' ), array(), true /* $combine */, true /* $minify */ );

		$this->assertEquals( 1, count( $url ) );
		$this->assertContains( '__am', $url[0] );
		$this->assertContains( "/{$this->cb}/", $url[0] );
		$this->assertContains( 'foo,bar', $url[0] );
	}

	/** @dataProvider isSassFileDataProvider */
	public function testIsSassUrl( $file, $expected ) {
		$this->assertEquals( $this->instance->isSassUrl( $file ), $expected );
	}

	/** @dataProvider isGroupUrlDataProvider */
	public function testIsGroupUrl( $url, $expected ) {
		$this->assertEquals( $this->instance->isGroupUrl( $url ), $expected );
	}

	/** @dataProvider getGroupNameFromUrlDataProvider */
	public function testGetGroupNameFromUrl( $url, $expected ) {
		$this->assertEquals( $this->instance->getGroupNameFromUrl( $url ), $expected );
	}

	/**
	 * @dataProvider getSassFilePathProvider
	 * @group UsingDB
	 */
	public function testGetSassFilePath( $url, $expected ) {
		$filePath = $this->instance->getSassFilePath( $url );
		$this->assertEquals( $filePath, $expected );
	}

	/**
	 * @group UsingDB
	 */
	public function testGetSassesUrl() {
		$otherSass = 'path/to/another/sass.scss';
		$sassList = [self::SASS_FILE, $otherSass];
		$url = $this->instance->getSassesUrl( $sassList );

		$this->assertContains( '__am', $url );
		$this->assertContains( '/sasses/', $url );
		$this->assertContains( self::SASS_FILE, $url );
		$this->assertContains( $otherSass, $url );
	}

	/**
	 * @dataProvider duplicateAssetsDataProvider
	 * @group UsingDB
	 */
	public function testDuplicateAssets( $setName, $files ) {
		$counts = array();
		foreach ( $files as $file ) {
			if ( empty( $counts[$file] ) ) {
				$counts[$file] = 0;
			}

			$counts[$file]++;
		}
		foreach ( $counts as $k => $v ) {
			if ( $v <= 1 ) {
				unset( $counts[$k] );
			}
		}
		$this->assertEquals( array(), $counts, "'{$setName}' group should not contain duplicated assets" );
	}

	/**
	 * @dataProvider getGroupsForSkin
	 */
	public function testCheckIfGroupForSkin( $skin, $skinRegisteredInGroup, $isSkinStrict, $expectedValue ) {
		$wikiaSkinMock = $this->getMock( 'WikiaSkin', ['getSkinName', 'isStrict'] );
		$wikiaSkinMock
			->expects( $this->any() )
			->method( 'getSkinName' )
			->will( $this->returnValue( $skin ) );

		$wikiaSkinMock
			->expects( $this->any() )
			->method( 'isStrict' )
			->will( $this->returnValue( $isSkinStrict) );

		$assetsManagerConfigMock = $this->getMock( 'AssetsConfig', ['getGroupSkin'] );
		$assetsManagerConfigMock
			->expects( $this->any() )
			->method( 'getGroupSkin' )
			->will( $this->returnValue( $skinRegisteredInGroup ) );

		// This needs to be called because AssetsConfig is a private singleton inside AssetsManager class
		$this->mockClass( 'AssetsConfig', $assetsManagerConfigMock );
		$assetsManagerMock = $this->getMock( 'AssetsManager', null, [], '', false );

		$this->assertEquals( $assetsManagerMock->checkIfGroupForSkin( 'foo', $wikiaSkinMock ), $expectedValue );
	}

	/**
	 * @dataProvider checkAssetUrlForSkinDataProvider
	 */
	public function testCheckAssetUrlForSkin( $url, $isSkinStrict, $expectedValue ) {
		$skinMock = $this->mockClassWithMethods('WikiaSkin', [
			'isStrict' => $isSkinStrict,
			'checkIfGroupForSkin' => false, // "block" all assets when in strict mode
			'loadConfig' => null,
		]);

		$assetsManagerMock = $this->getMock( 'AssetsManager', null, [], '', false );

		$this->assertEquals( $expectedValue, $assetsManagerMock->checkAssetUrlForSkin($url, $skinMock) );
	}

	public function checkAssetUrlForSkinDataProvider() {
		return [
			// always accept ResourceLoader URLs
			[
				'url' => 'http://foo.net/__load/123',
				'isSkinStrict' => true,
				'expectedValue' => true,
			],
			[
				'url' => 'http://foo.net/__load/123',
				'isSkinStrict' => false,
				'expectedValue' => true,
			],
		];
	}

	public function duplicateAssetsDataProvider() {
		$dataSets = array();

		$config = new AssetsConfig();
		// single assets
		$packages = $config->getGroupNames();
		foreach ( $packages as $name ) {
			$files = $config->resolve( $name, /*combine*/false, /*minify*/false );
			$dataSets[] = array( $name, $files );
		}

		return $dataSets;
	}

	/**
	 * @dataProvider getMultiTypePackageURLDataProvider
	 */
	public function testgetMultiTypePackageURL( $expectedUrl, $options ) {
		$expectedUrl = '/wikia.php?controller=AssetsManager&method=getMultiTypePackage&format=json&' .
			$expectedUrl .
			"&cb={$this->cb}";

		$this->assertEquals( $expectedUrl, AssetsManager::getInstance()->getMultiTypePackageURL( $options, true /* $local */ ) );
	}

	public function getMultiTypePackageURLDataProvider() {
		return [
			// support cooma-separated string
			[
				'url' => 'messages=foo%2Cbar',
				'options' => [
					'messages' => 'foo,bar'
				]
			],
			// support array
			[
				'url' => 'messages=foo%2Cbar',
				'options' => [
					'messages' => ['foo', 'bar']
				]
			],
			// order should be maintained
			[
				'url' => 'styles=foo%2Cbar&messages=foo%2Cbar&mustache=abc',
				'options' => [
					'messages' => 'foo,bar',
					'styles' => ['foo', 'bar'],
					'mustache' => 'abc'
				]
			],
			// order should be maintained
			[
				'url' => 'templates=%5B%7B%22controller%22%3A%22FooController%22%2C%22method%22%3A%22index%22%7D%5D',
				'options' => [
					'templates' => [
						[
							'controller' => 'FooController',
							'method' => 'index',
						]
					]
				]
			],
		];
	}

	public function isSassFileDataProvider() {
		return [
			[self::SASS_FILE, true],
			['path/to/unknown/file.jpg', false],
			['path/to/unknown/file.scss', true],
			['path/without/extension', false],
			['normal/css/file.css', false],
		];
	}

	public function isGroupUrlDataProvider() {
		return [
			[self::SASS_FILE, false],
			['path/to/unknown/file.jpg', false],
			[AssetsManager::getInstance()->getGroupCommonURL( self::JS_GROUP )[0], true],
			[AssetsManager::getInstance()->getGroupsCommonURL( ['foo', 'bar'] )[0], false],
		];
	}

	public function getGroupNameFromUrlDataProvider() {
		return [
			[self::SASS_FILE, false],
			['path/to/unknown/file.jpg', false],
			[AssetsManager::getInstance()->getGroupCommonURL( self::JS_GROUP )[0], self::JS_GROUP],
			[AssetsManager::getInstance()->getGroupsCommonURL( ['foo', 'bar'] )[0], false],
		];
	}

	public function getSassFilePathProvider() {
		return [
			[AssetsManager::getInstance()->getSassCommonURL( self::SASS_FILE ), self::SASS_FILE],
			[self::SASS_FILE, self::SASS_FILE],
			['http://google.com' . self::SASS_FILE, 'http://google.com' . self::SASS_FILE],
		];
	}

	public function getGroupsForSkin() {
		return [
			[ 'oasis', [ 'oasis' ], false, true ],
			[ 'oasis', [], false, true ],
		];
	}
}
