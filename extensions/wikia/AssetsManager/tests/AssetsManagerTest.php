<?php

class AssetsManagerTest extends WikiaBaseTest {

	const SASS_FILE = '/skins/oasis/css/oasis.scss';

	private $cb;
	/** @var AssetsManager */
	private $instance;

	public function setUp() {
		parent::setUp();

		$this->cb = $this->app->wg->StyleVersion;
		$this->instance = AssetsManager::getInstance();
	}

	public function testGetSassCommonURL() {
		$url =  $this->instance->getSassCommonURL(self::SASS_FILE, true /* $minify */);

		$this->assertContains('__am', $url);
		$this->assertContains("/{$this->cb}/", $url);
		$this->assertContains(self::SASS_FILE, $url);
	}

	public function testGetGroupsCommonURL() {
		$url =  $this->instance->getGroupsCommonURL(array('foo', 'bar'), array(), true /* $combine */, true /* $minify */);

		$this->assertEquals(1, count($url));
		$this->assertContains('__am', $url[0]);
		$this->assertContains("/{$this->cb}/", $url[0]);
		$this->assertContains('foo,bar', $url[0]);
	}

	/** @dataProvider isSassFileDataProvider */
	public function testIsSassUrl($file, $expected) {
		$this->assertEquals($this->instance->isSassUrl($file), $expected);
	}

	/** @dataProvider testGetSassFilePathProvider */
	public function testGetSassFilePath($url, $expected) {
		$filePath = $this->instance->getSassFilePath($url);
		$this->assertEquals($filePath, $expected);
	}

	public function testGetSassesUrl() {
		$otherSass = 'path/to/another/sass.scss';
		$sassList = [self::SASS_FILE, $otherSass];
		$url = $this->instance->getSassesUrl($sassList);

		$this->assertContains('__am', $url);
		$this->assertContains('/sasses/', $url);
		$this->assertContains(self::SASS_FILE, $url);
		$this->assertContains($otherSass, $url);
	}

	/**
	 * @dataProvider duplicateAssetsDataProvider
	 */
	public function testDuplicateAssets( $setName, $files ) {
		$counts = array();
		foreach ($files as $file) {
			if (empty($counts[$file])) {
				$counts[$file] = 0;
			}

			$counts[$file]++;
		}
		foreach ($counts as $k => $v) {
			if ( $v <= 1 ) {
				unset($counts[$k]);
			}
		}
		$this->assertEquals(array(),$counts);
	}

	public function duplicateAssetsDataProvider() {
		$dataSets = array();

		$config = new AssetsConfig();
		// single assets
		$packages = $config->getGroupNames();
		foreach ($packages as $name) {
			$files = $config->resolve($name,/*combine*/false,/*minify*/false);
			$dataSets[] = array( $name, $files );
		}

		return $dataSets;
	}

	/**
	 * @dataProvider getMultiTypePackageURLDataProvider
	 */
	public function testgetMultiTypePackageURL($expectedUrl, $options) {
		$expectedUrl = '/wikia.php?controller=AssetsManager&method=getMultiTypePackage&format=json&' .
			$expectedUrl .
			"&cb={$this->cb}";

		$this->assertEquals($expectedUrl, AssetsManager::getInstance()->getMultiTypePackageURL($options, true /* $local */));
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

	public function testGetSassFilePathProvider() {
		return [
			[AssetsManager::getInstance()->getSassCommonURL(self::SASS_FILE), self::SASS_FILE],
			[self::SASS_FILE, self::SASS_FILE],
			['http://google.com'.self::SASS_FILE, 'http://google.com'.self::SASS_FILE],
		];
	}
}
