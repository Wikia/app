<?php

use Wikia\Vignette\UrlGenerator;

class UrlGeneratorTest extends PHPUnit_Framework_TestCase {
	public static function setUpBeforeClass() {
		global $wgUploadPath;
		$wgUploadPath = 'http://images.wikia.com/tests/images';
	}

	public static function tearDownAfterClass() {
		global $wgUploadPath;
		unset( $wgUploadPath );
	}

	public function testUrl() {
		$file = $this->getMock( '\Wikia\Vignette\FileInterface' );
		$file->expects( $this->any() )
			->method( 'getHashPath' )
			->will( $this->returnValue( 'a/ab/' ) );
		$file->expects( $this->any() )
			->method( 'getName' )
			->will( $this->returnValue( 'SomeFile.jpg' ) );
		$file->expects( $this->any() )
			->method( 'isOld' )
			->will( $this->returnValue( false ) );
		$file->expects( $this->any() )
			->method( 'getTimestamp' )
			->will( $this->returnValue( '12345' ) );

		$this->assertEquals(
			'/tests/images/a/ab/SomeFile.jpg/revision/latest?cb=12345',
			( new UrlGenerator( $file ) )->url()
		);

		$this->assertEquals(
			'/tests/images/a/ab/SomeFile.jpg/revision/latest/thumbnail/width/50/height/75?cb=12345&fill=%23ababab',
			( new UrlGenerator( $file ) )->width( 50 )->height( 75 )->thumbnail()->backgroundFill( '#ababab' )->url()
		);

		$this->assertEquals(
			'/tests/images/a/ab/SomeFile.jpg/revision/latest/zoom-crop/width/50/height/75?cb=12345&fill=transparent',
			( new UrlGenerator( $file ) )->width( 50 )->height( 75 )->zoomCrop()->backgroundFill( 'transparent' )->url()
		);

		$this->assertEquals(
			'/tests/images/a/ab/SomeFile.jpg/revision/latest/scale-to-width/200?cb=12345',
			( new UrlGenerator( $file ) )->scaleToWidth( 200 )->url()
		);

		$this->assertEquals(
			'/tests/images/a/ab/SomeFile.jpg/revision/latest/window-crop/width/200/height/100/x-offset/10/y-offset/0/window-width/200/window-height/100?cb=12345',
			( new UrlGenerator( $file ) )->windowCropFixed()->width(200)->height(100)->xOffset(10)->windowWidth(200)->windowHeight(100)->url()
		);

		$this->assertEquals(
			'/tests/avatars/a/ab/SomeFile.jpg/revision/latest/scale-to-width/200?cb=12345',
			( new UrlGenerator( $file ) )->avatar()->scaleToWidth( 200 )->url()
		);
	}

	public function testOldUrl() {
		$file = $this->getMock( '\Wikia\Vignette\FileInterface' );
		$file->expects( $this->any() )
			->method( 'getHashPath' )
			->will( $this->returnValue( 'a/ab/' ) );
		$file->expects( $this->any() )
			->method( 'getName' )
			->will( $this->returnValue( 'SomeFile.jpg' ) );
		$file->expects( $this->any() )
			->method( 'isOld' )
			->will( $this->returnValue( true ) );
		$file->expects( $this->any() )
			->method( 'getArchiveTimestamp' )
			->will( $this->returnValue( '123456' ) );

		$this->assertEquals(
			'/tests/images/a/ab/SomeFile.jpg/revision/123456',
			( new UrlGenerator( $file ) )->url()
		);

		$this->assertEquals(
			'/tests/images/a/ab/SomeFile.jpg/revision/123456/thumbnail/width/50/height/75',
			( new UrlGenerator( $file ) )->width( 50 )->height( 75 )->thumbnail()->url()
		);
	}
}
