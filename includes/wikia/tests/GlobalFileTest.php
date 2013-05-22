<?php

class GlobalFileTest extends WikiaBaseTest {

	const POZNAN_CITY_ID = 5915;

	public function setUp() {
		parent::setUp();

		// assume we're in production environment
		$this->mockGlobalVariable('wgDevelEnvironment', false);
		$this->mockApp();
	}

	public function testNewFromText() {
		$this->mockGlobalFunction('GetDB', $this->mockClassWithMethods('Database', [
			'selectRow' => (object) [
				'img_width' => '600',
				'img_height' => '450',
				'img_major_mime' => 'image',
				'img_minor_mime' => 'jpeg',
				'img_timestamp' => '20111213221639',
			]
		]));
		$this->mockApp();

		$file = GlobalFile::newFromText('Gzik.jpg', self::POZNAN_CITY_ID /* poznan.wikia.com */);
		$title = $file->getTitle();

		$this->assertInstanceOf('GlobalTitle', $title);
		$this->assertTrue($file->exists());

		$this->assertEquals('http://images.wikia.com/poznan/pl/images/0/06/Gzik.jpg', $file->getUrl());
		$this->assertContains('/poznan/pl/images/thumb/0/06/Gzik.jpg/200px-0%2C201%2C0%2C200-Gzik.jpg', $file->getCrop(200, 200));

		// metadata
		$this->assertEquals(600, $file->getWidth());
		$this->assertEquals(450, $file->getHeight());
		$this->assertEquals('image/jpeg', $file->getMimeType());
	}

	public function testNewFromTextNotExisting() {
		$this->mockGlobalFunction('GetDB', $this->mockClassWithMethods('Database', [
			'selectRow' => false
		]));
		$this->mockApp();

		$file = GlobalFile::newFromText('Gzik.jpg', self::POZNAN_CITY_ID /* poznan.wikia.com */);
		$title = $file->getTitle();

		$this->assertInstanceOf('GlobalTitle', $title);
		$this->assertFalse($file->exists());

		$this->assertEquals('http://images.wikia.com/poznan/pl/images/0/06/Gzik.jpg', $file->getUrl());

		// metadata
		$this->assertNull($file->getWidth());
		$this->assertNull($file->getHeight());
		$this->assertNull($file->getMimeType());
	}
}
