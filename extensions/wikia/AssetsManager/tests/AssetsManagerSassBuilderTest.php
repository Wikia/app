<?php

class AssetsManagerSassBuilderTest extends WikiaBaseTest {

	const SASS_FILE = '/extensions/wikia/AssetsManager/tests/test.scss';

	private $cb;
	private $cdn;

	public function setUp() {
		parent::setUp();

		$this->cb = $this->app->wg->StyleVersion;
		$this->cdn = $this->app->wg->CdnStylePath;
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.85936 ms
	 */
	public function testSassBuilder() {
		$this->disableMemCache();

		$request = new WebRequest();
		$request->setVal('oid', self::SASS_FILE);
		$request->setVal('cb', $this->cb);

		$builder = new AssetsManagerSassBuilder($request);

		$this->assertContains('#foo', $builder->getContent());

		// test URLs rewriting
		$this->assertContains('sprite.png', $builder->getContent());
		$this->assertContains("{$this->cdn}/skins/shared/images/sprite.png", $builder->getContent());
		$this->assertNotContains('/* $wgCdnStylePath */', $builder->getContent());

		// test base64 encoding
		$this->assertNotContains('blank.gif', $builder->getContent());
		$this->assertContains('data:image/gif;base64,', $builder->getContent());
		$this->assertNotContains('/* base64 */', $builder->getContent());
	}
}
