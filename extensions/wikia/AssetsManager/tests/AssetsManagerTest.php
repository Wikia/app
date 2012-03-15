<?php

class AssetsManagerTest extends WikiaBaseTest {

	const SASS_FILE = '/skins/oasis/css/oasis.scss';

	private $cb;
	private $instance;

	public function setUp() {
		parent::setUp();

		$this->cb = $this->app->wg->StyleVersion;
		$this->instance = F::build('AssetsManager', array(), 'getInstance');
	}

	public function testGetSassCommonURL() {
		$url =  $this->instance->getSassCommonURL(self::SASS_FILE, true /* $minify */);

		$this->assertContains('__am', $url);
		$this->assertContains("/{$this->cb}/", $url);
		$this->assertContains(self::SASS_FILE, $url);
	}

	public function testGetGroupsCommonURL() {
		$url =  reset($this->instance->getGroupsCommonURL(array('foo', 'bar'), array(), true /* $combine */, true /* $minify */));

		$this->assertContains('__am', $url);
		$this->assertContains("/{$this->cb}/", $url);
		$this->assertContains('foo,bar', $url);
	}
}