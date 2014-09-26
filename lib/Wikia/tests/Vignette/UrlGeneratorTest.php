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
			->method('getHashPath')
			->will($this->returnValue('a/ab/'));
		$file->expects($this->any())
			->method('getName')
			->will($this->returnValue('SomeFile.jpg'));
		$file->expects($this->any())
			->method('isOld')
			->will($this->returnValue(false));
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

	public function testOldUrl() {
		$file = $this->getMock('\Wikia\Vignette\FileInterface');
		$file->expects($this->any())
			->method('getHashPath')
			->will($this->returnValue('a/ab/'));
		$file->expects($this->any())
			->method('getName')
			->will($this->returnValue('SomeFile.jpg'));
		$file->expects($this->any())
			->method('isOld')
			->will($this->returnValue(true));
		$file->expects($this->any())
			->method('getArchiveTimestamp')
			->will($this->returnValue('123456'));

		$this->assertEquals(
			'/tests/a/ab/SomeFile.jpg/revision/123456',
			(new UrlGenerator($file))->url()
		);

		$this->assertEquals(
			'/tests/a/ab/SomeFile.jpg/revision/123456/thumbnail/width/50/height/75',
			(new UrlGenerator($file))->width(50)->height(75)->thumbnail()->revision('09876')->url()
		);
	}
}
