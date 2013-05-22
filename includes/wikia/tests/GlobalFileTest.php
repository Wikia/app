<?php

class GlobalFileTest extends WikiaBaseTest {

	public function setUp() {
		parent::setUp();

		// assume we're in production environment
		$this->mockGlobalVariable('wgDevelEnvironment', false);
		$this->mockApp();
	}

	public function testNewFromText() {
		$file = GlobalFile::newFromText('Gzik.jpg', 5915 /* poznan.wikia.com */);
		var_dump($file->getTitle()->getFullURL());
		var_dump($file->getUrl());
		var_dump($file->getWidth());
		var_dump($file);
	}
}