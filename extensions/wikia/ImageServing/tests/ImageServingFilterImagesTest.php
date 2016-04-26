<?php

/**
 * Test ImageServingDriverMainNS::filterImages
 * @group MediaFeatures
 */

// proxy class to allow unit testing of ImageServingDriverMainNS class
class ImageServingDriverMainNSProxy extends ImageServingDriverMainNS {

	protected function getImagesPopularity($images) {
		$res = [];

		foreach($images as $image) {
			$res[$image] = false;
		}

		return $res;
	}

	public function loadImageDetails( $imageNames = []) {
		parent::loadImageDetails( $imageNames );
	}

	public function getFilteredOut() {
		return $this->filteredImages;
	}

}

class ImageServingFilterImagesTest extends WikiaBaseTest {

	const FAKE_NAME = 'Foo.png';

	private $im;

	public function setUp() {
		parent::setUp();

		$this->im = new ImageServing(50, 50);
	}

	/**
	 * @dataProvider filterImagesByMimeTypeDataProvider
	 */
	public function testFilterImagesByMimeType($mime, $shouldBeFilteredOut = false) {
		// mock database results
		$row = (object) [
			'img_name' => self::FAKE_NAME,
			'img_height' => 100,
			'img_width' => 100,
			'img_minor_mime' => $mime
		];
		$db = $this->mockClassWithMethods('DatabaseMysqli', [
			'select' => new FakeResultWrapper([$row])
		]);

		// run ImageServing
		$driver = new ImageServingDriverMainNSProxy($db, $this->im, null);
		$driver->loadImageDetails([self::FAKE_NAME]);

		// filter images out
		$list = $driver->getFilteredOut();
		$this->assertEquals($shouldBeFilteredOut, !isset($list[self::FAKE_NAME]));
	}

	public function filterImagesByMimeTypeDataProvider() {
		return [
			[
				'mime' => 'png',
			],
			[
				'mime' => 'jpeg',
			],
			[
				'mime' => 'svg',
				'shouldBeFilteredOut' => true
			],
			[
				'mime' => 'ogg',
				'shouldBeFilteredOut' => true
			]
		];
	}
}
