<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

global $IP;
require_once( "$IP/maintenance/tests/ApiSetup.php" );
require_once( "$IP/maintenance/deleteArchivedFiles.inc" );
require_once( "$IP/maintenance/deleteArchivedRevisions.inc" );
require_once( dirname( dirname( __FILE__ ) ) . '/ResumableUpload.php' );

class nullClass {
	public function handleOutput(){}
	public function purgeRedundantText(){}
}

class UploadFromChunksTest extends ApiSetup {

	// a base64 encoded image;
	private $pngimg = "iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAMAAAAp4XiDAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAASUExURf///8zMzJmZmWZmZjMzMwAAAPOPemkAAAM1SURBVHjaYmBgYGBkYQUBFkYWFiCPCchixQAMCCZAACF0MAMVM4K4TFh0IGsBCCAkOxhYmBnAAKaHhZkZmxaAAGJgYIbpYGBihGgBWsTMzMwE4jIhaWGAYoAAYmCECDExYAcwGxkg5oNIgABigDqLARdgZmGB2wICrKwAAcSA3xKgIxlZ0PwCEEAMBCxhgHoWSQtAADFAAxgfYEJ1GEAAQbQw4tUCsocBYQVAADEgu4uRkREeUCwszEwwLhOKLQABhNDCBA4aSDgwwhIAJKqYUPwCEEAMUK/AUwnc9aywJMCI7DAgAAggBohZ8JTBhGIJzCoWZL8ABBCYidAB8RUjWppkYUG2BSCAGMDqEMZiswUtXgACiAHsFYixTMywGGLGpgUWYgABxAA2mQkWCMyMqFoYmdD8ACQAAogBHJHMrCxg1cyIiICmCkYWDFsAAgiihYmZCewFFpR0BfI3LLch+QUggBiQ0iQjEyMDmh54qCBlUIAAYsCRJsElADQvgWKTlRGeKwECiAF3XgGmMEYQYADZzcoA9z5AAMG9RQCAtEC9DxBADFiyFyMjVi0wABBAWLQwQdIiuhYGWJIACCBg+KKUJ9BoBRdS2LQALQMIIGDQIEmwAO1kYcVWHCDZAhBAqFqYmOAxj2YNtAwDAYAAYmDEiBYWzHKKkRERYiwAAYSphZEZwxZGZiZQVEJTJkAAMTCyokc7M5oORlC5wcoEjxeAAAJqQXU0UB6W5WFmABMtEzMi1wEEEFAbE0YyAUuzMMEsYQalMkQSBQggUDmNPU3C9IA4LCxI+QUggEBiKOU8yExgqccCL3chnkPKlQABhGo6ejHBDKmdUHMlQAAhhQvQaGZGkBIkjcAMywLmI+VKgABCSowsTJhZkhlWXiBpAQggYBqBZl9GVOdBcz0LZqEEEEAMqLULMBLg1THWog9IAwQQA0qiZcRW5aPbAhBADCg1El4tMAAQQAxoiZYZXnTh1AIQQAzo2QlYpDDjcBgrxGEAAcSAJTthswmiBUwDBBC2GpkZJTaRvQ+mAQKIAUuuxdZWQvILQABBmSxMjBj5EpcWgACCMoFOYYSpZyHQHgMIMACt2hmoVEikCQAAAABJRU5ErkJggg==";

	function setUp() {
		global $wgEnableUploads, $wgLocalFileRepo;

		$wgEnableUploads = true;
		parent::setup();
		$wgLocalFileRepo = array(
			'class' => 'LocalRepo',
			'name' => 'local',
			'directory' => 'test-repo',
			'url' => 'http://example.com/images',
			'hashLevels' => 2,
			'transformVia404' => false,
		);

		ini_set( 'log_errors', 1 );
		ini_set( 'error_reporting', 1 );
		ini_set( 'display_errors', 1 );
	}

	function makeChunk( $content ) {
		$file = tempnam( wfTempDir(), "" );
		$fh = fopen( $file, "wb" );
		if ( $fh == false ) {
			$this->markTestIncomplete( "Couldn't open $file!\n" );
			return;
		}
		fwrite( $fh, $content );
		fclose( $fh );

		$_FILES['chunk']['tmp_name'] = $file;
		$_FILES['chunk']['size'] = 3;
		$_FILES['chunk']['error'] = null;
		$_FILES['chunk']['name'] = "test.txt";
	}

	function cleanChunk() {
		if ( file_exists( $_FILES['chunk']['tmp_name'] ) )
		   unlink( $_FILES['chunk']['tmp_name'] );
	}

	function doApiRequest( $params, $data = null ) {
		$session = isset( $data[2] ) ? $data[2] : array();
		$_SESSION = $session;

		$req = new FauxRequest( $params, true, $session );
		$module = new ApiMain( $req, true );
		$module->execute();

		return array( $module->getResultData(), $req, $_SESSION );
	}

	/* function testGetTitle() { */
	/* 	$filename = tempnam( wfTempDir(), "" ); */
	/* 	$c = new ApiResumableUpload; */
	/* 	$c->initialize( false, "temp.txt", null, $filename, 0, null ); */
	/* 	$this->assertEquals( null, $c->getUpload()->getTitle() ); */

	/* 	$c = new ApiResumableUpload; */
	/* 	$c->initialize( false, "Temp.png", null, $filename, 0, null ); */
	/* 	$this->assertEquals( Title::makeTitleSafe( NS_FILE, "Temp.png" ), $c->getUpload()->getTitle() ); */
	/* } */

	function testLogin() {
		$data = $this->doApiRequest( array(
			'action' => 'login',
			'lgname' => self::$userName,
			'lgpassword' => self::$passWord ) );
		$this->assertArrayHasKey( "login", $data[0] );
		$this->assertArrayHasKey( "result", $data[0]['login'] );
		$this->assertEquals( "NeedToken", $data[0]['login']['result'] );
		$token = $data[0]['login']['token'];

		$data = $this->doApiRequest( array(
			'action' => 'login',
			"lgtoken" => $token,
			"lgname" => self::$userName,
			"lgpassword" => self::$passWord ) );

		$this->assertArrayHasKey( "login", $data[0] );
		$this->assertArrayHasKey( "result", $data[0]['login'] );
		$this->assertEquals( "Success", $data[0]['login']['result'] );
		$this->assertArrayHasKey( 'lgtoken', $data[0]['login'] );

		return $data;
	}

	/**
	 * @depends testLogin
	 */
	function testSetupChunkBannedFileType( $data ) {
		global $wgUser;
		$wgUser = User::newFromName( self::$userName );
		$wgUser->load();
		$data[2]['wsEditToken'] = $data[2]['wsToken'];
		$token = md5( $data[2]['wsToken'] ) . EDIT_TOKEN_SUFFIX;
		$exception = false;

		try {
			$this->doApiRequest( array(
				'action' => 'resumableupload',
				'comment' => 'test',
				'watchlist' => 'watch',
				'filename' => 'tmp.txt',
				'token' => $token ), $data );
		} catch ( UsageException $e ) {
			$exception = true;
			$this->assertEquals( "This type of file is banned", $e->getMessage() );
		}

		$this->assertTrue( $exception, "Got exception" );
	}

	/**
	 * @depends testLogin
	 */
	function testSetupChunkSession( $data ) {
		global $wgUser;
		$wgUser = User::newFromName( self::$userName );
		$wgUser->load();
		$data[2]['wsEditToken'] = $data[2]['wsToken'];
		$token = md5( $data[2]['wsToken'] ) . EDIT_TOKEN_SUFFIX;

		$data = $this->doApiRequest( array(
			'action' => 'resumableupload',
			'comment' => 'test',
			'watchlist' => 'watch',
			'filename' => 'TestPic.png',
			'token' => $token ), $data );

		$this->assertArrayHasKey( 'uploadUrl', $data[0] );
		$this->assertRegexp( '/action=resumableupload/', $data[0]['uploadUrl'] );
		$this->assertRegexp( '/chunksession=/', $data[0]['uploadUrl'] );
		$this->assertRegexp( '/token=/', $data[0]['uploadUrl'] );

		return $data;
	}

	/**
	 * @depends testLogin
	 */
	function testInvalidSessionKey( $data ) {
		global $wgUser;
		$wgUser = User::newFromName( self::$userName );
		$wgUser->load();
		$data[2]['wsEditToken'] = $data[2]['wsToken'];
		$token = md5( $data[2]['wsToken'] ) . EDIT_TOKEN_SUFFIX;
		$exception = false;

		try {
			$this->doApiRequest( array(
				'action' => 'resumableupload',
				'enablechunks' => true,
				'token' => $token,
				'chunksession' => 'bogus' ), $data );
		} catch ( UsageException $e ) {
			$exception = true;
			$this->assertEquals( "Not a valid session key", $e->getMessage() );
		}

		$this->assertTrue( $exception, "Got exception" );
	}

	function testPerformUploadInitError() {
		global $wgUser;
		$wgUser = User::newFromId( 1 );

		$req = new FauxRequest(
			array(
				'action' => 'resumableupload',
				'sessionkey' => '1',
				'filename' => 'test.png',
			) );
		$module = new ApiMain( $req, true );
		$gotException = false;
		try {
			$module->execute();
		} catch ( UsageException $e ) {
			$this->assertEquals( "The token parameter must be set", $e->getMessage() );
			$gotException = true;
		}

		$this->assertTrue( $gotException );
	}


	/**
	 * @depends testLogin
	 */
	function testSetupChunkForBannedContent( $data ) {
		global $wgUser;
		$wgUser = User::newFromName( self::$userName );
		$wgUser->load();
		$data[2]['wsEditToken'] = $data[2]['wsToken'];
		$token = md5( $data[2]['wsToken'] ) . EDIT_TOKEN_SUFFIX;
		$exception = false;

		$this->makeChunk( "123" );
		$data = $this->doApiRequest( array(
			'action' => 'resumableupload',
			'comment' => 'test',
			'watchlist' => 'watch',
			'filename' => 'tmp.png',
			'token' => $token ), $data );
		return $data;
	}

	/**
	 * @depends testSetupChunkForBannedContent
	 */
	function testChunkUploadBannedContent ( $data ) {
		global $wgUser;
		$wgUser = User::newFromName( self::$userName );
		$wgUser->load();
		$data[2]['wsEditToken'] = $data[2]['wsToken'];
		$token = md5( $data[2]['wsToken'] ) . EDIT_TOKEN_SUFFIX;
		$exception = false;
		$url = $data[0]['uploadUrl'];
		$params = wfCgiToArray( substr( $url, strpos( $url, "?" ) ) );
		$params['done'] = true;

		$this->makeChunk( "123" );
		$gotException = false;
		try {
			$data = $this->doApiRequest( $params, $data );
		} catch ( UsageException $e ) {
			$this->assertEquals( "This file did not pass file verification",
				$e->getMessage() );
			$gotException = true;
		}
		$this->cleanChunk();
		$this->assertTrue( $gotException );
	}

	/**
	 * @depends testLogin
	 */
	function testUploadChunkDoneGood( $data ) {
		global $wgUser, $wgVerifyMimeType;
		$wgVerifyMimeType = false;

		$this->markTestIncomplete("Not working yet ... fails every other time b/c we're not dealing with a temporary db");

		DeleteArchivedFilesImplementation::doDelete(new nullClass, true);
		DeleteArchivedRevisionsImplementation::doDelete(new nullClass);

		$id = Title::newFromText( "Twar.png", NS_FILE )->getArticleID();
		$oldFile = Article::newFromID( $id );
		if ( $oldFile ) {
			$oldFile->doDeleteArticle();
			$oldFile->doPurge();
		}

		$oldFile = wfFindFile( "Twar.png" );
		if ( $oldFile ) {
			$oldFile->delete();
		}
		$id = Title::newFromText( "Twar.png", NS_FILE )->getArticleID();
		$this->assertEquals(0, $id);

		$oldFile = Article::newFromID( $id );
		$this->assertEquals(null, $oldFile);

		$wgUser = User::newFromName( self::$userName );
		$data[2]['wsEditToken'] = $data[2]['wsToken'];
		$token = md5( $data[2]['wsToken'] ) . EDIT_TOKEN_SUFFIX;
		$data = $this->doApiRequest( array(
			'action' => 'resumableupload',
			'comment' => 'test',
			'watchlist' => 'watch',
			'filename' => 'twar.png',
			'token' => $token ), $data );

		$url = $data[0]['uploadUrl'];
		$params = wfCgiToArray( substr( $url, strpos( $url, "?" ) ) );
		$size = 0;
		for ( $i = 0; $i < 5; $i++ ) {
			$this->makeChunk( "123" );
			$size += $_FILES['chunk']['size'];

			$data = $this->doApiRequest( $params, $data );
			$this->assertArrayHasKey( "result", $data[0] );
			$this->assertTrue( (bool)$data[0]["result"] );

			$this->assertArrayHasKey( "filesize", $data[0] );
			$this->assertEquals( $size, $data[0]['filesize'] );

			$this->cleanChunk();
		}

		$params['done'] = true;

		$this->makeChunk( "456" );
		$data = $this->doApiRequest( $params, $data );

		$this->cleanChunk();
		$this->assertArrayHasKey( 'result', $data[0] );

		$this->assertEquals( 1, $data[0]['result'] );

		$this->assertArrayHasKey( 'done', $data[0] );
		$this->assertEquals( 1, $data[0]['done'] );

		$this->assertArrayHasKey( 'resultUrl', $data[0] );
		$this->assertRegExp( '/File:Twar.png/', $data[0]['resultUrl'] );
	}

	/**
	 * @depends testLogin
	 */
	function testUploadChunkDoneDuplicate( $data ) {
		global $wgUser, $wgVerifyMimeType;

		$this->markTestIncomplete("Not working yet");

		$wgVerifyMimeType = false;
		$wgUser = User::newFromName( self::$userName );
		$data[2]['wsEditToken'] = $data[2]['wsToken'];
		$token = md5( $data[2]['wsToken'] ) . EDIT_TOKEN_SUFFIX;
		$data = $this->doApiRequest( array(
			'filename' => 'twar.png',
			'action' => 'resumableupload',
			'token' => $token ), $data );

		$url = $data[0]['uploadUrl'];
		$params = wfCgiToArray( substr( $url, strpos( $url, "?" ) ) );
		$size = 0;
		$gotException = false;
		for ( $i = 0; $i < 30; $i++ ) {
			$this->makeChunk( "123" );
			$size += $_FILES['chunk']['size'];
			try {
				$data = $this->doApiRequest( $params, $data );
			} catch (UsageException $e) {
				$arr = $e->getMessageArray();
				$this->assertArrayHasKey( "code", $arr );
				$this->assertEquals( "internal-error", $arr['code'] );

				$this->assertEquals( "fileexistserror", $arr[0][0] );
				$gotException = true;
			}
		}
		$this->cleanChunk();
		$this->assertTrue($gotException);
	}

	function testCleanup() {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		$dbw->delete("image", array('img_user_text' => self::$userName ));
		$dbw->commit();
		$this->assertTrue(true);
	}
}
