<?php

/**
 * @group Integration
 */
class GlobalFileTest extends WikiaBaseTest {

	const POZNAN_CITY_ID = 5915;

	public function setUp() {
		parent::setUp();

		// assume we're in production environment
		$this->mockGlobalVariable('wgDevelEnvironment', false);
		$this->mockApp();
	}

	public function testNewFromText() {
		$file = GlobalFile::newFromText('Gzik.jpg', self::POZNAN_CITY_ID /* poznan.wikia.com */);
		$title = $file->getTitle();

		$this->assertInstanceOf('GlobalTitle', $title);
		$this->assertEquals('http://images.wikia.com/poznan/pl/images/0/06/Gzik.jpg', $file->getUrl());

		// cropping feature
		$this->assertContains('/poznan/pl/images/thumb/0/06/Gzik.jpg/200px-0%2C201%2C0%2C200-Gzik.jpg', $file->getCrop(200, 200));

		// metadata
		$this->assertEquals(600, $file->getWidth());
		$this->assertEquals(450, $file->getHeight());
		$this->assertEquals('image/jpeg', $file->getMimeType());
	}
}
