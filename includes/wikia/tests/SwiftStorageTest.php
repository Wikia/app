<?php

/**
 * Set of unit tests for SwiftStorage class
 *
 * @author macbre
 *
 * @category Wikia
 * @group Integration
 * @group Swift
 */
class SwiftStorageTest extends WikiaBaseTest {

	const CITY_ID = 123;
	const CONTAINER = '123test123';

	public function setUp() {
		parent::setUp();
		$this->mockStaticMethod( 'WikiFactory', 'getVarValueByName', 'http://images.wikia.com/poznan/pl/images' );
	}

	public function testNewFromWikiGetUrl() {
		$swift = \Wikia\SwiftStorage::newFromWiki( self::CITY_ID );
		$this->assertStringEndsWith( '/poznan/pl/images/foo.jpg', $swift->getUrl( 'foo.jpg' ) );
	}

	public function testNewFromContainerGetUrl() {
		$swift = \Wikia\SwiftStorage::newFromContainer( self::CONTAINER );
		$this->assertStringEndsWith( '/' . self::CONTAINER . '/foo.jpg', $swift->getUrl( 'foo.jpg' ) );

		$swift = \Wikia\SwiftStorage::newFromContainer( self::CONTAINER, '/foo/bar/test/' );
		$this->assertStringEndsWith( '/' . self::CONTAINER . '/foo/bar/test/foo.jpg', $swift->getUrl( 'foo.jpg' ) );
	}

	public function testStoreAndRemove() {
		global $IP;
		$swift = \Wikia\SwiftStorage::newFromContainer( self::CONTAINER );

		// upload the file
		$localFile = "{$IP}/skins/shared/images/sprite.png";
		$remoteFile = sprintf( 'Test_%s.png', time() );

		$this->assertFalse( $swift->exists( $remoteFile ), 'File should not exist before the upload' );
		$res = $swift->store( $localFile, $remoteFile, [], 'image/png' );

		$this->assertTrue( $res->isOK(), 'Upload should be done' );

		// check the uploaded file
		$url = $swift->getUrl( $remoteFile );
		$this->assertStringEndsWith( '/' . self::CONTAINER . '/' . $remoteFile, $url );

		$this->assertTrue( Http::get( $url, 'default', ['noProxy' => true] ) !== false, 'Uploaded image should return HTTP 200 - ' . $url );
		$this->assertTrue( $swift->exists( $remoteFile ), 'File should exist' );

		// npw remove the file
		$res = $swift->remove( $remoteFile );
		$this->assertTrue( $res->isOK(), 'Delete should be done' );

		$this->assertTrue( Http::get( $url, 'default', ['noProxy' => true] ) === false, 'Removed image should return HTTP 404 - ' . $url );
		$this->assertFalse( $swift->exists( $remoteFile ), 'File should not exist after the delete' );
	}

	public function testStream() {
		$swift = \Wikia\SwiftStorage::newFromContainer( self::CONTAINER );
		$remoteFile = sprintf( 'Test_%s.txt', time() );

		// set up the temporary file
		$content = md5( time() );
		$tmpfname = tempnam( wfTempDir() , "swift" );
		file_put_contents( $tmpfname, $content );

		// stream a file to Ceph
		$fp = fopen( $tmpfname, 'r' );
		$this->assertTrue( is_resource( $fp ), 'Temp file created' );

		$res = $swift->store( $fp, $remoteFile ); # will call fclose($fp)
		$this->assertTrue( $res->isOK(), 'Upload should be done' );

		// now get the file using a stream
		$fp = fopen( $tmpfname, 'a' );

		$res = $swift->read( $remoteFile, $fp );
		$this->assertTrue( $res, 'Read should be completed' );

		fclose( $fp );

		// check the temp file
		$this->assertEquals( $content . $content, file_get_contents( $tmpfname ) );

		// cleanup
		$res = $swift->remove( $remoteFile );
		$this->assertTrue( $res->isOK(), 'Delete should be done' );

		unlink( $tmpfname );
	}
}
