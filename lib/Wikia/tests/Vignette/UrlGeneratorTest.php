<?php

use Wikia\Vignette\UrlGenerator;
use Wikia\Vignette\UrlConfig;

class UrlGeneratorTest extends PHPUnit_Framework_TestCase {
	public function testUrl() {
		$config = (new UrlConfig())
			->setRelativePath('a/ab/SomeFile.jpg')
			->setBaseUrl('http://images.vignette.com')
			->setTimestamp(12345)
			->setBucket('tests');

		$this->assertEquals(
			'http://images.vignette.com/tests/images/a/ab/SomeFile.jpg/revision/latest?cb=12345',
			(new UrlGenerator($config))->url());

		$this->assertEquals(
			'http://images.vignette.com/tests/images/a/ab/SomeFile.jpg/revision/latest/thumbnail/width/50/height/75?cb=12345&fill=%23ababab',
			(new UrlGenerator($config))->width(50)->height(75)->thumbnail()->backgroundFill('#ababab')->url());

		$this->assertEquals(
			'http://images.vignette.com/tests/images/a/ab/SomeFile.jpg/revision/latest/zoom-crop/width/50/height/75?cb=12345&fill=transparent',
			(new UrlGenerator($config))->width(50)->height(75)->zoomCrop()->backgroundFill('transparent')->url());

		$this->assertEquals(
			'http://images.vignette.com/tests/images/a/ab/SomeFile.jpg/revision/latest/scale-to-width/200?cb=12345',
			(new UrlGenerator($config))->scaleToWidth(200)->url());

		$this->assertEquals(
			'http://images.vignette.com/tests/images/a/ab/SomeFile.jpg/revision/latest/window-crop/width/200/height/100/x-offset/10/y-offset/0/window-width/200/window-height/100?cb=12345',
			(new UrlGenerator($config))->windowCropFixed()->width(200)->height(100)->xOffset(10)->windowWidth(200)->windowHeight(100)->url());

		$this->assertEquals(
			'http://images.vignette.com/tests/avatars/a/ab/SomeFile.jpg/revision/latest/scale-to-width/200?cb=12345',
			(new UrlGenerator($config))->avatar()->scaleToWidth(200)->url());

		$this->assertEquals(
			'http://images.vignette.com/tests/avatars/a/ab/SomeFile.jpg/revision/latest/scale-to-width/200?cb=12345&frame=3',
			(new UrlGenerator($config))->avatar()->scaleToWidth(200)->frame(3)->url());
	}

	public function testOldUrl() {
		$config = (new UrlConfig())
			->setRelativePath('a/ab/SomeFile.jpg')
			->setTimestamp(123456)
			->setIsArchive(true)
			->setBucket('tests');

		$this->assertEquals(
			'/tests/images/a/ab/SomeFile.jpg/revision/123456',
			(new UrlGenerator($config))->url());

		$this->assertEquals(
			'/tests/images/a/ab/SomeFile.jpg/revision/123456/thumbnail/width/50/height/75',
			(new UrlGenerator($config))->width(50)->height(75)->thumbnail()->url());
	}
}
