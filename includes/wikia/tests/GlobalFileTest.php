<?php

/**
 * Set of unit tests for GlobalFile class
 *
 * @author macbre
 */
class GlobalFileTest extends WikiaBaseTest {

	const MUPPET_CITY_ID = 831; # muppet.wikia.com
	const POZNAN_CITY_ID = 5915; # poznan.wikia.com

	const DEFAULT_CB = 123456789;
	const TIMESTAMP = '20111213221639';

	public function setUp() {
		parent::setUp();

		// assume we're in production environment
		$this->mockGlobalVariable('wgDevelEnvironment', false);
		$this->mockGlobalVariable('wgDevBoxImageServerOverride', false);
		$this->mockGlobalVariable('wgEnableVignette', false);

		$this->mockGlobalVariable('wgImagesDomainSharding', 'images%s.wikia.nocookie.net');
		$this->mockGlobalVariable('wgCdnStylePath', sprintf('http://slot1.images.wikia.nocookie.net/__cb%s/common', self::DEFAULT_CB));
	}

	private function getSelectRowMock() {
		return $this->getMethodMock( 'DatabaseBase', 'selectRow' );
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.04145 ms
	 * @dataProvider newFromTextProvider
	 */
	public function testNewFromText($row, $cityId, $path, $exists, $width, $height, $crop, $mime, $url) {
		$this->getSelectRowMock()
			->expects( $this->any() )
			->method( 'selectRow' )
			->will( $this->returnCallback( function( $table, $vars, $conds, $fname ) use ($row) {
				if ( $fname == 'GlobalFile::loadData' ) {
					return $row;
				} else { // don't mess with WikiFactory accessing database
					return $this->getCurrentInvocation()->callOriginal();
				}
			}));

		$file = GlobalFile::newFromText('Gzik.jpg', $cityId);
		$title = $file->getTitle();

		$this->assertInstanceOf('GlobalTitle', $title);
		$this->assertEquals($exists, $file->exists());

		// original image / crop
		$this->assertEquals($url, $file->getUrl());

		if ($file->exists()) {
			$this->assertContains("/{$path}/images/thumb/0/06/Gzik.jpg/{$crop}", $file->getCrop(200, 200));
		}

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
					'img_timestamp' => self::TIMESTAMP,
				],
				'cityId' => self::POZNAN_CITY_ID,
				'path' => 'poznan/pl',
				'exists' => true,
				'width' => 600,
				'height' => 450,
				'crop' => '200px-76%2C527%2C0%2C450-Gzik.jpg',
				'mime' => 'image/jpeg',
				'url' => 'http://images3.wikia.nocookie.net/__cb' . self::TIMESTAMP . '/poznan/pl/images/0/06/Gzik.jpg',
			],
			// existing image from Muppet wiki
			[
				'row' => (object) [
					'img_width' => '300',
					'img_height' => '300',
					'img_major_mime' => 'image',
					'img_minor_mime' => 'png',
					'img_timestamp' => self::TIMESTAMP,
				],
				'cityId' => self::MUPPET_CITY_ID,
				'path' => 'muppet',
				'exists' => true,
				'width' => 300,
				'height' => 300,
				'crop' => '200px-0%2C301%2C0%2C300-Gzik.jpg',
				'mime' => 'image/png',
				'url' => 'http://images4.wikia.nocookie.net/__cb' . self::TIMESTAMP . '/muppet/images/0/06/Gzik.jpg',
			],
			// not existing image from Poznań wiki
			[
				'row' => false,
				'cityId' => self::POZNAN_CITY_ID,
				'path' => 'poznan/pl',
				'exists' => false,
				'width' => null,
				'height' => null,
				'crop' => null,
				'mime' => null,
				'url' => 'http://images3.wikia.nocookie.net/__cb' . self::DEFAULT_CB . '/poznan/pl/images/0/06/Gzik.jpg', // contains default CB
			]
		];
	}

	/**
	 * @dataProvider testNewFromTextDbNameMatchProvider
	 * @group UsingDB
	 */
	public function testNewFromTextDbNameMatch($row, $cityId) {
		$this->getSelectRowMock()
			->expects( $this->any() )
			->method( 'selectRow' )
			->will( $this->returnCallback( function( $table, $vars, $conds, $fname ) use ($row) {
				if ( $fname == 'GlobalFile::loadData' ) {
					if ( $conds['img_name'] == $row->img_name ) {
						return $row;
					} else {
						return false;
					}
				} else { // don't mess with WikiFactory accessing database
					return $this->getCurrentInvocation()->callOriginal();
				}
			}));

		$dbName = $row->img_name;
		$name = str_replace("_", " ", $dbName);

		$file = GlobalFile::newFromText($dbName, $cityId);
		$file2 = GlobalFile::newFromText($name, $cityId);
		$file3 = GlobalFile::newFromText("Not-existing-Image.jpg", $cityId);

		$this->assertTrue( $file->exists() );
		$this->assertTrue( $file2->exists() );
		$this->assertFalse( $file3->exists() );
	}

	public function testNewFromTextDbNameMatchProvider() {
		return [
			[
				'row' => (object) [
						'img_name' => "Gzik.jpg",
						'img_width' => '600',
						'img_height' => '450',
						'img_major_mime' => 'image',
						'img_minor_mime' => 'jpeg',
						'img_timestamp' => '20111213221639',
					],
				'cityId' => self::POZNAN_CITY_ID,
			],
			[
				'row' => (object) [
						'img_name' => "Gzik_v2.jpg",
						'img_width' => '600',
						'img_height' => '450',
						'img_major_mime' => 'image',
						'img_minor_mime' => 'jpeg',
						'img_timestamp' => '20111213221639',
					],
				'cityId' => self::POZNAN_CITY_ID,
			]
		];
	}
}
