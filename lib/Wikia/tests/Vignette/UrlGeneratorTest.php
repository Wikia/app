<?php

use Wikia\Vignette\UrlGenerator;

class UrlGeneratorTest extends PHPUnit_Framework_TestCase {
	public static function setUpBeforeClass() {
		global $wgUploadPath;
		$wgUploadPath = 'http://images.wikia.com/tests/images';
	}

	public static function tearDownAfterClass() {
		global $wgUploadPath;
		unset($wgUploadPath);
	}

	public function testUrl() {
		$file = $this->getMock('\Wikia\Vignette\FileInterface');
		$file->expects($this->any())
			->method('getRel')
			->will($this->returnValue('a/ab/SomeFile.jpg'));
		$file->expects($this->any())
			->method('getTimestamp')
			->will($this->returnValue('12345'));

		$this->assertEquals(
			'/tests/a/ab/SomeFile.jpg/revision/latest?cb=12345',
			(new UrlGenerator($file))->url()
		);

		$this->assertEquals(
			'/tests/a/ab/SomeFile.jpg/revision/09876/thumbnail/width/50/height/75?fill=%23ababab',
			(new UrlGenerator($file))->width(50)->height(75)->thumbnail()->revision('09876')->backgroundFill('#ababab')->url()
		);

		$this->assertEquals(
			'/tests/a/ab/SomeFile.jpg/revision/latest/zoom-crop/width/50/height/75?fill=transparent&cb=12345',
			(new UrlGenerator($file))->width(50)->height(75)->zoomCrop()->backgroundFill('transparent')->url()
		);
	}
}
