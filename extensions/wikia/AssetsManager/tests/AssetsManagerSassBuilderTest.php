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

	public function testSassService() {
		$css = <<<CSS
@import "skins/shared/color";
header {
	div {
		color: \$color-body;
	}
}
CSS;
		$sass = SassService::newFromString($css);
		$sass->setSassVariables([
			'color-body' => '#112233',
		]);

		$result = $sass->getCss(false); # no cache

		$this->assertContains( 'header div {', $result, 'CSS selector is properly compiled' );
		$this->assertContains( 'color: #112233;', $result, 'Color variable is properly passed' );
	}
}
