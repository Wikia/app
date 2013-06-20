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

	public function testSassBuilder() {
		// disable memcache layer in this test
		$mock_memc = $this->getMock('stdClass',array('get','set'));
		$mock_memc->expects($this->any())
			->method('get')
			->will($this->returnValue(false));
		$mock_memc->expects($this->any())
			->method('set')
			->will($this->returnValue(true));
		$this->mockGlobalVariable('wgMemc', $mock_memc);

		$request = new WebRequest();
		$request->setVal('oid', self::SASS_FILE);
		$request->setVal('cb', $this->cb);

		$builder = new AssetsManagerSassBuilder($request);

		$this->assertContains('#foo', $builder->getContent());

		// test URLs rewriting
		$this->assertContains('sprite.png', $builder->getContent());
		$this->assertContains("{$this->cdn}/skins/oasis/images/sprite.png", $builder->getContent());
		$this->assertNotContains('/* $wgCdnStylePath */', $builder->getContent());

		// test base64 encoding
		$this->assertNotContains('blank.gif', $builder->getContent());
		$this->assertContains('data:image/gif;base64,', $builder->getContent());
		$this->assertNotContains('/* base64 */', $builder->getContent());
	}
}
