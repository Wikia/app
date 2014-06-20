<?php

/**
 * @author macbre
 * @group Integration
 */
class ImageServingCroppingTest extends WikiaBaseTest {

	const FILE_NAME = 'Wiki-wordmark.png';

	private $tmpFile;

	public function setUp() {
		$this->setupFile = __DIR__ . '/../imageServing.setup.php';
		parent::setUp();
	}

	public function testCropping() {
		// requested crop size is 50 x 50
		$im = new ImageServing(null, 50);
		$file = wfFindFile( self::FILE_NAME );

		// pass dimensions of full size image
		$cropUrl = $im->getUrl( $file, $file->getWidth(), $file->getHeight() );

		$this->assertStringEndsWith( '/50px-94%2C160%2C0%2C65-Wiki-wordmark.png', $cropUrl );

		// verify crop response
		$res = Http::get( $cropUrl, 'default', [ 'noProxy' => true ] );
		$this->assertTrue( $res !== false, "<{$cropUrl}> should return HTTP 200" );

		// verify crop size
		$this->tmpFile = tempnam( wfTempDir(), 'img' );
		file_put_contents( $this->tmpFile, $res );

		list($tmpWidth, $tmpHeight) = getimagesize( $this->tmpFile );

		$this->assertEquals( 50, $tmpWidth, 'expected crop width not matched - ' . $cropUrl );
		$this->assertEquals( 49, $tmpHeight, 'expected crop height not matched - ' . $cropUrl );
	}

	//test 'all possible' combinations we output to thumbnailer
	private function helperCropImage( $targetWidth, $targetHeight, $srcWidth, $srcHeight ) {
		$im = new ImageServing(null, $targetWidth, $targetHeight);
		return $im->getUrl( self::FILE_NAME, $srcWidth, $srcHeight );
	}

	private function assertImageUrl( $targetWidth, $targetHeight, $srcWidth, $srcHeight, $urlFragment ) {
		$url = $this->helperCropImage( $targetWidth, $targetHeight, $srcWidth, $srcHeight );
		$url = urldecode( $url ); // make it more human friendly
		$fName = self::FILE_NAME;

		$this->assertStringEndsWith( "/{$urlFragment}-{$fName}", $url );
	}

	public function testCroppingCombinations() {
		$sampleData = [
			[ 100, 100, 100, 100, '100px-0,101,0,100' ], [ 100, 100, 100, 200, '100px-0,100,0,100' ],
			[ 100, 100, 100, 150, '100px-0,100,0,100' ], [ 100, 100, 200, 100, '100px-51,152,0,100' ],
			[ 100, 100, 200, 200, '100px-0,201,0,200' ], [ 100, 100, 200, 150, '100px-26,177,0,150' ],
			[ 100, 100, 150, 100, '100px-26,127,0,100' ], [ 100, 100, 150, 200, '100px-0,150,0,150' ],
			[ 100, 100, 150, 150, '100px-0,151,0,150' ], [ 100, 200, 100, 100, '100px-26,77,0,100' ],
			[ 100, 200, 100, 200, '100px-0,101,0,200' ], [ 100, 200, 100, 150, '100px-14,90,0,150' ],
			[ 100, 200, 200, 100, '100px-76,127,0,100' ], [ 100, 200, 200, 200, '100px-51,152,0,200' ],
			[ 100, 200, 200, 150, '100px-64,140,0,150' ], [ 100, 200, 150, 100, '100px-51,102,0,100' ],
			[ 100, 200, 150, 200, '100px-26,127,0,200' ], [ 100, 200, 150, 150, '100px-39,115,0,150' ],
			[ 100, 150, 100, 100, '100px-18,86,0,100' ], [ 100, 150, 100, 200, '100px-0,100,-7,143' ],
			[ 100, 150, 100, 150, '100px-0,101,0,150' ], [ 100, 150, 200, 100, '100px-68,136,0,100' ],
			[ 100, 150, 200, 200, '100px-35,169,0,200' ], [ 100, 150, 200, 150, '100px-51,152,0,150' ],
			[ 100, 150, 150, 100, '100px-43,111,0,100' ], [ 100, 150, 150, 200, '100px-10,144,0,200' ],
			[ 100, 150, 150, 150, '100px-26,127,0,150' ], [ 200, 100, 100, 100, '200px-0,100,10,60' ],
			[ 200, 100, 100, 200, '200px-0,100,20,70' ], [ 200, 100, 100, 150, '200px-0,100,15,65' ],
			[ 200, 100, 200, 100, '200px-0,201,0,100' ], [ 200, 100, 200, 200, '200px-0,200,20,120' ],
			[ 200, 100, 200, 150, '200px-0,200,15,115' ], [ 200, 100, 150, 100, '200px-0,150,10,85' ],
			[ 200, 100, 150, 200, '200px-0,150,20,95' ], [ 200, 100, 150, 150, '200px-0,150,15,90' ],
			[ 200, 200, 100, 100, '200px-0,101,0,100' ], [ 200, 200, 100, 200, '200px-0,100,0,100' ],
			[ 200, 200, 100, 150, '200px-0,100,0,100' ], [ 200, 200, 200, 100, '200px-51,152,0,100' ],
			[ 200, 200, 200, 200, '200px-0,201,0,200' ], [ 200, 200, 200, 150, '200px-26,177,0,150' ],
			[ 200, 200, 150, 100, '200px-26,127,0,100' ], [ 200, 200, 150, 200, '200px-0,150,0,150' ],
			[ 200, 200, 150, 150, '200px-0,151,0,150' ], [ 200, 150, 100, 100, '200px-0,100,3,78' ],
			[ 200, 150, 100, 200, '200px-0,100,7,82' ], [ 200, 150, 100, 150, '200px-0,100,5,80' ],
			[ 200, 150, 200, 100, '200px-35,169,0,100' ], [ 200, 150, 200, 200, '200px-0,200,7,157' ],
			[ 200, 150, 200, 150, '200px-0,201,0,150' ], [ 200, 150, 150, 100, '200px-10,144,0,100' ],
			[ 200, 150, 150, 200, '200px-0,150,7,120' ], [ 200, 150, 150, 150, '200px-0,150,5,118' ],
			[ 150, 100, 100, 100, '150px-0,100,5,72' ], [ 150, 100, 100, 200, '150px-0,100,10,77' ],
			[ 150, 100, 100, 150, '150px-0,100,8,75' ], [ 150, 100, 200, 100, '150px-26,177,0,100' ],
			[ 150, 100, 200, 200, '150px-0,200,10,143' ], [ 150, 100, 200, 150, '150px-0,200,8,141' ],
			[ 150, 100, 150, 100, '150px-0,151,0,100' ], [ 150, 100, 150, 200, '150px-0,150,10,110' ],
			[ 150, 100, 150, 150, '150px-0,150,8,108' ], [ 150, 200, 100, 100, '150px-14,90,0,100' ],
			[ 150, 200, 100, 200, '150px-0,100,-5,128' ], [ 150, 200, 100, 150, '150px-0,100,-4,129' ],
			[ 150, 200, 200, 100, '150px-64,140,0,100' ], [ 150, 200, 200, 200, '150px-26,177,0,200' ],
			[ 150, 200, 200, 150, '150px-45,159,0,150' ], [ 150, 200, 150, 100, '150px-39,115,0,100' ],
			[ 150, 200, 150, 200, '150px-0,151,0,200' ], [ 150, 200, 150, 150, '150px-20,134,0,150' ],
			[ 150, 150, 100, 100, '150px-0,101,0,100' ], [ 150, 150, 100, 200, '150px-0,100,0,100' ],
			[ 150, 150, 100, 150, '150px-0,100,0,100' ], [ 150, 150, 200, 100, '150px-51,152,0,100' ],
			[ 150, 150, 200, 200, '150px-0,201,0,200' ], [ 150, 150, 200, 150, '150px-26,177,0,150' ],
			[ 150, 150, 150, 100, '150px-26,127,0,100' ], [ 150, 150, 150, 200, '150px-0,150,0,150' ],
			[ 150, 150, 150, 150, '150px-0,151,0,150' ] ];

		foreach ( $sampleData as $data ) {
			$this->assertImageUrl( $data[0], $data[1], $data[2], $data[3], $data[4] );
		}
	}

	public function tearDown() {
		if ( !empty($this->tmpFile) ) {
			unlink( $this->tmpFile );
		}

		parent::tearDown();
	}

}
