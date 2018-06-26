<?php

/**
 * @group sass
 */
class AssetsManagerSassBuilderTest extends WikiaBaseTest {

	const SASS_FILE = '/extensions/wikia/AssetsManager/tests/test.scss';

	public function setUp() {
		parent::setUp();

		if ( !extension_loaded( 'sass' ) ) {
			$this->markTestSkipped( 'the sassphp extension is not available' );
		}
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.85936 ms
	 */
	public function testSassBuilder() {
		global $wgStyleVersion, $wgResourceBasePath;
		$this->disableMemCache();

		$request = new WebRequest();
		$request->setVal('oid', self::SASS_FILE);
		$request->setVal('cb', $wgStyleVersion);

		$builder = new AssetsManagerSassBuilder($request);

		$this->assertContains('#foo', $builder->getContent());

		// test URLs rewriting
		$this->assertContains('sprite.png', $builder->getContent());
		$this->assertContains("{$wgResourceBasePath}/skins/shared/images/sprite.png", $builder->getContent());
		$this->assertNotContains('/* $wgResourceBasePath */', $builder->getContent());

		// test base64 encoding
		$this->assertNotContains('blank.gif', $builder->getContent());
		$this->assertContains('data:image/gif;base64,', $builder->getContent());
		$this->assertNotContains('/* base64 */', $builder->getContent());
	}
}
