<?php
/**
 * Integration test for file uploads and removals
 *
 * @group Broken
 * @author macbre
 */
class ImagesServiceUploadTest extends WikiaBaseTest {

	const URL = 'http://upload.wikimedia.org/wikipedia/commons/d/d9/Eldfell%2C_Helgafell_and_the_fissure.jpg';
	const PREFIX = 'QAImage';
	const FILENAME = 'Test-$1.jpg';

	private $origUser;
	private $fileName;
	private $fileHash;

	protected function setUp() {
		global $wgUser;
		parent::setUp();

		$this->origUser = $wgUser;
		$wgUser = User::newFromName( 'WikiaBot' );

		$this->fileName = self::PREFIX . str_replace( '$1', time(), self::FILENAME );

		// get a hash of external file
		$this->fileHash = md5( Http::get( self::URL, 'default', ['noProxy' => true] ) );

		// use Swift domain
		global $wgDevelEnvironmentName;
		$this->mockGlobalVariable('wgDevBoxImageServerOverride', "d.{$wgDevelEnvironmentName}.wikia-dev.com");

		// debug
		global $wgLocalFileRepo;
		echo "Files repository in use: '{$wgLocalFileRepo['backend']}'\n"; // local-backend / swift-backend
	}

	// check the path - /firefly/images/9/93/Test-1378975563.jpg
	private function checkImage( LocalFile $image ) {
		$hash = md5( $image->getName() );
		$url = $image->getUrl();

		$this->assertStringEndsWith(
			sprintf( '/%s/images/%s/%s/%s', $this->app->wg->DBname, $hash { 0 } , $hash { 0 } . $hash { 1 } , $image->getName() ),
			$url,
			'Path should contain a valid hash'
		);

		// verify that it's accessible via HTTP
		$res = Http::get( $url, 'default', ['noProxy' => true] );

		$this->assertTrue( $res !== false, 'Uploaded image should return HTTP 200 - ' . $url );
		$this->assertEquals( $this->fileHash, md5($res), 'Uploaded image hash should match - ' . $url );
	}

	// check the path - /firefly/images/thumb/5/53/Test-1378979336.jpg/120px-0%2C451%2C0%2C294-Test-1378979336.jpg
	private function checkThumbnail( LocalFile $image ) {
		$hash = md5( $image->getName() );
		$thumb = $image->createThumb( 120 );

		$this->assertContains(
			sprintf( '/%s/images/thumb/%s/%s/%s/120px-', $this->app->wg->DBname, $hash { 0 } , $hash { 0 } . $hash { 1 } , $image->getName() ),
			$thumb,
			'Path should contain a valid hash'
		);

		$this->assertStringEndsWith(
			$image->getName(),
			$thumb,
			'Path should end with file name'
		);

		$this->assertTrue(Http::get($thumb, 'default', ['noProxy' => true]) !== false, 'Thumbnail should return HTTP 200 - ' . $thumb);
	}

	// check cropped file (provided by ImageServing)
	private function checkCrop( LocalFile $image ) {
		$im = new ImageServing(null, 150);
		$crop = $im->getUrl($image, 250, 250); // take 250x250 square from original image and scale it down to 150px (width)

		$this->assertContains(
			'150px-0%2C251%2C0%2C250-',
			$crop,
			'Cropped URL is correct'
		);

		$this->assertTrue(Http::get($crop, 'default', ['noProxy' => true]) !== false, 'Crop should return HTTP 200 - ' . $crop);
	}

	private function assertReturns404( $url, $msg ) {
		$req = MWHttpRequest::factory( $url, ['noProxy' => true] );
		$req->execute();

		$this->assertEquals( 404, $req->getStatus(), "{$msg} - {$url}" );
	}

	function testUploadAndRemove() {
		$time = microtime( true );

		// (A) upload an image
		$res = ImagesService::uploadImageFromUrl( self::URL, (object) [
			'name' => $this->fileName,
			'comment' => __CLASS__,
			'description' => __CLASS__
		] );

		Wikia::log( __METHOD__ , 'upload', sprintf( 'took %.4f sec', microtime( true ) - $time ) );

		$this->assertTrue( $res['status'], 'Upload should end up successfully' );
		$this->assertInternalType( 'integer', $res['page_id'], 'Page ID should be returned' );

		/* @var LocalFile $file */
		$file = wfFindFile( $this->fileName );
		$this->assertInstanceOf( 'LocalFile', $file );

		$this->checkImage( $file );
		$this->checkThumbnail( $file );

		// (B) move it...
		$time = microtime( true );
		$oldUrl = $file->getUrl();

		$target = Title::newFromText( 'New' . $this->fileName, NS_FILE );
		$status = $file->move( $target );

		Wikia::log( __METHOD__ , 'move', sprintf( 'took %.4f sec', microtime( true ) - $time ) );

		$this->assertTrue( $status->isOK(), 'Move failed' );
		$this->assertReturns404( $oldUrl, 'Old image (before move) should return HTTP 404' );

		$this->checkImage( $file );
		$this->checkThumbnail( $file );
		$this->checkCrop( $file );

		// (C) remove it...
		$time = microtime( true );
		$oldUrl = $file->getUrl();
		$status = $file->delete( 'Test cleanup' );
		$this->assertTrue( $status->isOK(), 'Deleting failed' );

		Wikia::log( __METHOD__ , 'delete', sprintf( 'took %.4f sec', microtime( true ) - $time ) );

		// verify that removed image is not accessible via HTTP
		$this->assertReturns404( $oldUrl, 'Removed image should return HTTP 404' );

		// (D) restore it
		$time = microtime( true );
		$file->restore([], true ); // $unsuppress = true - remove file from /deleted directory
		$this->assertTrue( $status->isOK(), 'Restoring failed' );

		Wikia::log( __METHOD__ , 'restore', sprintf( 'took %.4f sec', microtime( true ) - $time ) );

		$this->checkImage( $file );
		$this->checkThumbnail( $file );
		$this->checkCrop( $file );
	}

	protected function tearDown() {
		global $wgUser;
		parent::tearDown();

		// restore $wgUser
		$wgUser = $this->origUser;
	}
}
