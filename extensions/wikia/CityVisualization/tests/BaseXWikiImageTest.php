<?php

class TmpImageClass extends BaseXWikiImage {
	protected function getContainerDirectory() {
		return "/images/p/promote/images";
	}

	protected function getSwiftContainer() {
		return "promote";
	}

	protected function getSwiftPathPrefix() {
		return "/images";
	}
}

class BaseXWikiImageTest extends WikiaBaseTest {
	protected static function getFn( $obj, $name ) {
		$class = new ReflectionClass( get_class( $obj ) );
		$method = $class->getMethod( $name );
		$method->setAccessible( true );

		return function () use ( $obj, $method ) {
			$args = func_get_args();
			return $method->invokeArgs( $obj, $args );
		};
	}

	public function setUp() {
		parent::setUp();
	}

	public function tearDown() {
		parent::tearDown();
	}

	public function testGetFullPath_returnsCorrectValue() {
		$t = new TmpImageClass( "name" );
		$this->assertEquals( $t->getFullPath(), '/images/p/promote/images/4/40/name.png' );
	}

	public function testGetLocalPath_returnsCorrectValue() {
		$t = new TmpImageClass( "name" );
		$fn = self::getFn( $t, 'getLocalPath' );

		$this->assertEquals( $fn(), '4/40/name.png' );
	}

	public function testGetLocalThumbnailPath_returnsCorrectValue() {
		$t = new TmpImageClass( "name" );
		$fn = self::getFn( $t, 'getLocalThumbnailPath' );

		$this->assertEquals( $fn(), 'thumb/4/40/name.png' );
	}

	public function testUploadByUrl_uploadsImage() {
		$t = new TmpImageClass( "name" );

		$srcFile = GlobalFile::newFromText( "Wiki-wordmark.png", 831 );
		$this->assertEquals( $t->uploadByUrl( $srcFile->getUrl() ), UPLOAD_ERR_OK );

		// check uploaded file
		$this->assertEquals( $t->uploadByUrl( $t->getUrl() ), UPLOAD_ERR_OK );
	}

	public function testUploadByUrl_uploadedImageCroppedUrl() {
		$t = new TmpImageClass( "name" );

		$targetWidth = 10;
		$targetHeight = 10;

		$srcFile = GlobalFile::newFromText( "Wiki-wordmark.png", 831 );
		$this->assertEquals( $t->uploadByUrl( $srcFile->getUrl() ), UPLOAD_ERR_OK );
		$url = $t->getCroppedThumbnailUrl( $targetWidth, $targetHeight, ImagesService::EXT_JPEG );

		$this->assertEquals( $t->uploadByUrl( $url ), UPLOAD_ERR_OK );

		$this->assertEquals( $t->getImageDimensions()['width'], $targetWidth );
		$this->assertEquals( $t->getImageDimensions()['height'], $targetHeight );


		//test image dimensions
	}

	public function testUploadByUrl_nonExistingImageThumbnailUrlHandling() {
		$t = new TmpImageClass( "non-existing-image-name" );

		$targetWidth = 10;
		$targetHeight = 10;

		$url = $t->getCroppedThumbnailUrl( $targetWidth, $targetHeight, ImagesService::EXT_JPEG );

		$this->assertEquals( $url, null );
	}

	public function testUploadByUrl_checksThumbnailAccessibility() {
		$t = new TmpImageClass( "name" );
		$srcFile = GlobalFile::newFromText( "Wiki-wordmark.png", 831 );
		$this->assertEquals( $t->uploadByUrl( $srcFile->getUrl() ), UPLOAD_ERR_OK );
		// check uploaded file
		$this->assertEquals( $t->uploadByUrl( $t->getThumbnailUrl( 10 ) ), UPLOAD_ERR_OK );
	}
}
