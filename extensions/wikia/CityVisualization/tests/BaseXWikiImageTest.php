<?php
include_once dirname( __FILE__ ) . '/../classes/BaseXWikiImage.class.php';

class TmpImageClass extends BaseXWikiImage {
	protected function getContainerDirectory() {
		return "/images/c/container/test";
	}

	protected function getSwiftContainer() {
		return "container";
	}

	protected function getSwiftPathPrefix() {
		return "/test";
	}
}

class BaseXWikiImageTest extends WikiaBaseTest {
	protected static function getFn( $obj, $name ) {
		$class = new ReflectionClass(get_class( $obj ));
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
		$t = new TmpImageClass("name");
		$this->assertEquals( $t->getFullPath(), '/images/c/container/test/4/40/name.png' );
	}

	public function testGetLocalPath_returnsCorrectValue() {
		$t = new TmpImageClass("name");
		$fn = self::getFn( $t, 'getLocalPath' );

		$this->assertEquals( $fn(), '4/40/name.png' );
	}

	public function testGetLocalThumbnailPath_returnsCorrectValue() {
		$t = new TmpImageClass("name");
		$fn = self::getFn( $t, 'getLocalThumbnailPath' );

		$this->assertEquals( $fn(), 'thumb/4/40/name.png' );
	}

	public function testUploadByUrl_uploadsImage() {
		$t = new TmpImageClass("name");
		$fn = self::getFn( $t, 'uploadByUrl' );
		$srcFile = GlobalFile::newFromText( "Wiki-wordmark.png", 831 );
		$this->assertEquals( $fn($srcFile->getUrl()), UPLOAD_ERR_OK );
	}
}
