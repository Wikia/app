<?php

/**
 * Set of unit tests for GlobalFile class
 *
 * @author macbre
 */
class GlobalFileTest extends WikiaBaseTest {

	const MUPPET_CITY_ID = 831; # muppet.wikia.com
	const POZNAN_CITY_ID = 5915; # poznan.wikia.com

	public function setUp() {
		parent::setUp();

		// assume we're in production environment
		$this->mockGlobalVariable('wgDevelEnvironment', false);
		$this->mockApp();
	}

	/**
	 * @dataProvider newFromTextProvider
	 */
	public function testNewFromText($row, $cityId, $path, $exists, $width, $height, $mime) {
		$this->mockGlobalFunction('GetDB', $this->mockClassWithMethods('Database', [
			'selectRow' => $row
		]));
		$this->mockApp();

		$file = GlobalFile::newFromText('Gzik.jpg', $cityId);
		$title = $file->getTitle();

		$this->assertInstanceOf('GlobalTitle', $title);
		$this->assertEquals($exists, $file->exists());

		// original image / crop
		$this->assertEquals("http://images.wikia.com/{$path}/images/0/06/Gzik.jpg", $file->getUrl());
		$this->assertContains("/{$path}/images/thumb/0/06/Gzik.jpg/200px-0%2C201%2C0%2C200-Gzik.jpg", $file->getCrop(200, 200));

		// metadata
		$this->assertEquals($width, $file->getWidth());
		$this->assertEquals($height, $file->getHeight());
		$this->assertEquals($mime, $file->getMimeType());
	}

	public function newFromTextProvider() {
		return [
			// existing image from Poznań wiki
			[
				'row' => (object) [
					'img_width' => '600',
					'img_height' => '450',
					'img_major_mime' => 'image',
					'img_minor_mime' => 'jpeg',
					'img_timestamp' => '20111213221639',
				],
				'cityId' => self::POZNAN_CITY_ID,
				'path' => 'poznan/pl',
				'exists' => true,
				'width' => 600,
				'height' => 450,
				'mime' => 'image/jpeg',
			],
			// existing image from Muppet wiki
			[
				'row' => (object) [
					'img_width' => '300',
					'img_height' => '300',
					'img_major_mime' => 'image',
					'img_minor_mime' => 'png',
					'img_timestamp' => '20111213221639',
				],
				'cityId' => self::MUPPET_CITY_ID,
				'path' => 'muppet',
				'exists' => true,
				'width' => 300,
				'height' => 300,
				'mime' => 'image/png',
			],
			// not existing image from Poznań wiki
			[
				'row' => false,
				'cityId' => self::POZNAN_CITY_ID,
				'path' => 'poznan/pl',
				'exists' => false,
				'width' => null,
				'height' => null,
				'mime' => null,
			]
		];
	}
}
