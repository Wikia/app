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
}
