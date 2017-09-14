<?php
/**
 * Integration test for file uploads and removals
 *
 * @group Broken
 * @author macbre
 */
class ImagesServiceUploadTest extends WikiaBaseTest {

	const URL = 'http://upload.wikimedia.org/wikipedia/commons/d/d9/Eldfell%2C_Helgafell_and_the_fissure.jpg';
	const REUPLOAD_URL = 'http://upload.wikimedia.org/wikipedia/commons/thumb/b/b7/Atlantic_Puffin.jpg/320px-Atlantic_Puffin.jpg';
	const PREFIX = 'QAImage';
	#const FILENAME = 'Test-$1.jpg';
	const FILENAME = 'Test%?ąę!-$1.jpg';

	private $origUser;
	private $fileName;
	private $fileHash;
	private $reuploadedFileHash;

	protected function setUp() {
		global $wgUser;
		parent::setUp();

		$this->origUser = $wgUser;
		$wgUser = User::newFromName( Wikia::BOT_USER );

		$this->fileName = self::PREFIX . str_replace( '$1', time(), self::FILENAME );

		// get a hash of both external file
		$this->fileHash = md5( Http::get( self::URL, 'default', ['noProxy' => true] ) );
		$this->reuploadedFileHash = md5( Http::get( self::REUPLOAD_URL, 'default', ['noProxy' => true] ) );

		// debug
		global $wgLocalFileRepo;
		echo "Files repository in use: '{$wgLocalFileRepo['backend']}'\n"; // local-backend / swift-backend
	}

	// check the path - /firefly/images/9/93/Test-1378975563.jpg
	private function checkImage( LocalFile $image, $fileHash ) {
		$hash = md5( $image->getName() );
		$url = $image->getUrl();

		$this->assertStringEndsWith(
			sprintf( '/%s/images/%s/%s/%s', $this->app->wg->DBname, $hash { 0 } , $hash { 0 } . $hash { 1 } , urlencode($image->getName()) ),
			$url,
			'Path should contain a valid hash'
		);

		// verify that it's accessible via HTTP
		$req = MWHttpRequest::factory( $url, ['noProxy' => true] );
		$req->execute();

		$this->assertEquals( 200, $req->getStatus(), 'Uploaded image should return HTTP 200 - ' . $url );
		$this->assertEquals( $fileHash, md5( $req->getContent() ), 'Uploaded image hash should match - ' . $url );
		$this->assertEquals( 'image/jpeg', $req->getResponseHeader( 'Content-Type' ), 'Uploaded image should be JPEG' );
	}

	// check the path - /firefly/images/thumb/5/53/Test-1378979336.jpg/120px-0%2C451%2C0%2C294-Test-1378979336.jpg
	private function checkThumbnail( LocalFile $image ) {
		$hash = md5( $image->getName() );
		$thumb = $image->createThumb( 120 );

		$this->assertContains(
			sprintf( '/%s/images/thumb/%s/%s/%s/120px-', $this->app->wg->DBname, $hash { 0 } , $hash { 0 } . $hash { 1 } , urlencode($image->getName()) ),
			$thumb,
			'Path should contain a valid hash'
		);

		$this->assertStringEndsWith(
			urlencode($image->getName()),
			$thumb,
			'Path should end with file name'
		);

		$this->assertTrue( Http::get( $thumb, 'default', ['noProxy' => true] ) !== false, 'Thumbnail should return HTTP 200 - ' . $thumb );
	}

	// check cropped file (provided by ImageServing)
	private function checkCrop( LocalFile $image ) {
		$im = new ImageServing( null, 150 );
		$crop = $im->getUrl( $image, 250, 250 ); // take 250x250 square from original image and scale it down to 150px (width)

		$this->assertContains(
			'150px-0%2C251%2C0%2C250-',
			$crop,
			'Cropped URL is correct'
		);

		$this->assertTrue( Http::get( $crop, 'default', ['noProxy' => true] ) !== false, 'Crop should return HTTP 200 - ' . $crop );
	}

	private function assertReturns404( $url, $msg ) {
		$req = MWHttpRequest::factory( $url, ['noProxy' => true] );
		$req->execute();

		$this->assertEquals( 404, $req->getStatus(), "{$msg} - {$url}" );
	}

	/**
	 * @param LocalFile $file
	 * @param string $url
	 * @param string $comment
	 * @return FileRepoStatus
	 */
	private function uploadFromUrl( $file, $url, $comment ) {
		$tmpFile = tempnam( wfTempDir(), 'upload' );

		// fetch an asset
		$res = Http::get( $url, 'default', ['noProxy' => true] );
		$this->assertTrue($res !== false, 'File from <' . $url . '> should be uploaded');

		file_put_contents( $tmpFile, $res );
		$this->assertTrue( is_readable( $tmpFile ), 'Temp file for HTTP upload should be created and readable' );

		Wikia::log(__METHOD__, false, sprintf('uploading %s (%.2f kB) as %s', $tmpFile, filesize($tmpFile) / 1024, $file->getName()), true);
		$res = $file->upload( $tmpFile, $comment, '' );

		#unlink( $tmpFile );
		return $res;
	}

	function testUploadAndRemove() {
		// create a file
		$file = new WikiaLocalFile( Title::newFromText( $this->fileName, NS_FILE ), RepoGroup::singleton()->getLocalRepo() );

		// (A) upload an image
		$time = microtime( true );

		$res = $this->uploadFromUrl( $file, self::URL, __CLASS__ );
		Wikia::log( __METHOD__ , 'upload', sprintf( 'took %.4f sec', microtime( true ) - $time ) );

		$this->assertTrue( $res->isOK(), 'Upload should end up successfully - ' .json_encode($res->getErrorsArray()) );

		/* @var LocalFile $file */
		$this->assertInstanceOf( 'LocalFile', $file );

		$this->checkImage( $file, $this->fileHash );
		$this->checkThumbnail( $file );

		// (B) move it...
		$time = microtime( true );
		$oldUrl = $file->getUrl();

		$this->fileName = 'New' . $this->fileName;

		$target = Title::newFromText( $this->fileName, NS_FILE );
		$status = $file->move( $target );

		Wikia::log( __METHOD__ , 'move', sprintf( 'took %.4f sec', microtime( true ) - $time ) );

		$this->assertTrue( $status->isOK(), 'Move failed' );
		$this->assertReturns404( $oldUrl, 'Old image (before move) should return HTTP 404' );

		$this->checkImage( $file, $this->fileHash );
		$this->checkThumbnail( $file );
		$this->checkCrop( $file );

		// (C) re-upload...
		$file = new WikiaLocalFile( $target, RepoGroup::singleton()->getLocalRepo() );

		$time = microtime( true );

		$res = $this->uploadFromUrl( $file, self::REUPLOAD_URL, 'Reupload' );
		Wikia::log( __METHOD__ , 'reupload', sprintf( 'took %.4f sec', microtime( true ) - $time ) );

		$this->assertTrue( $res->isOK(), 'Re-upload should end up successfully - ' .json_encode($res->getErrorsArray()) );

		// (D) remove it...
		$time = microtime( true );
		$oldUrl = $file->getUrl();
		$status = $file->delete( 'Deleting an image' );
		$this->assertTrue( $status->isOK(), 'Deleting failed' );

		Wikia::log( __METHOD__ , 'delete', sprintf( 'took %.4f sec', microtime( true ) - $time ) );

		// verify that removed image is not accessible via HTTP
		$this->assertReturns404( $oldUrl, 'Removed image should return HTTP 404' );

		// (E) restore it
		$time = microtime( true );
		$file->restore( [], true ); // $unsuppress = true - remove file from /deleted directory
		$this->assertTrue( $status->isOK(), 'Restoring failed' );

		Wikia::log( __METHOD__ , 'restore', sprintf( 'took %.4f sec', microtime( true ) - $time ) );

		$this->checkImage( $file, $this->reuploadedFileHash );
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
