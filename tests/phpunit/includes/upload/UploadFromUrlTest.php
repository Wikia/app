<?php

/**
 * @group Broken
 * @group Upload
 */
class UploadFromUrlTest extends ApiTestCase {

	public function setUp() {
		global $wgEnableUploads, $wgAllowCopyUploads;
		parent::setUp();

		$wgEnableUploads = true;
		$wgAllowCopyUploads = true;
		wfSetupSession();

		if ( wfLocalFile( 'UploadFromUrlTest.png' )->exists() ) {
			$this->deleteFile( 'UploadFromUrlTest.png' );
		}
	}

	protected function doApiRequest( $params, $unused = null, $appendModule = false, $user = null ) {
		$sessionId = session_id();
		session_write_close();

		$req = new FauxRequest( $params, true, $_SESSION );
		$module = new ApiMain( $req, true );
		$module->execute();

		wfSetupSession( $sessionId );
		return array( $module->getResultData(), $req );
	}

	/**
	 * @todo Document why we test login, since the $wgUser hack used doesn't
	 * require login
	 */
	public function testLogin() {
		$data = $this->doApiRequest( array(
			'action' => 'login',
			'lgname' => $this->user->userName,
			'lgpassword' => $this->user->passWord ) );
		$this->assertArrayHasKey( "login", $data[0] );
		$this->assertArrayHasKey( "result", $data[0]['login'] );
		$this->assertEquals( "NeedToken", $data[0]['login']['result'] );
		$token = $data[0]['login']['token'];

		$data = $this->doApiRequest( array(
			'action' => 'login',
			"lgtoken" => $token,
			'lgname' => $this->user->userName,
			'lgpassword' => $this->user->passWord ) );

		$this->assertArrayHasKey( "login", $data[0] );
		$this->assertArrayHasKey( "result", $data[0]['login'] );
		$this->assertEquals( "Success", $data[0]['login']['result'] );
		$this->assertArrayHasKey( 'lgtoken', $data[0]['login'] );

		return $data;
	}

	/**
	 * @depends testLogin
	 */
	public function testSetupUrlDownload( $data ) {
		$token = $this->user->getEditToken();
		$exception = false;

		try {
			$this->doApiRequest( array(
				'action' => 'upload',
			) );
		} catch ( UsageException $e ) {
			$exception = true;
			$this->assertEquals( "The token parameter must be set", $e->getMessage() );
		}
		$this->assertTrue( $exception, "Got exception" );

		$exception = false;
		try {
			$this->doApiRequest( array(
				'action' => 'upload',
				'token' => $token,
			), $data );
		} catch ( UsageException $e ) {
			$exception = true;
			$this->assertEquals( "One of the parameters sessionkey, file, url, statuskey is required",
				$e->getMessage() );
		}
		$this->assertTrue( $exception, "Got exception" );

		$exception = false;
		try {
			$this->doApiRequest( array(
				'action' => 'upload',
				'url' => 'http://www.example.com/test.png',
				'token' => $token,
			), $data );
		} catch ( UsageException $e ) {
			$exception = true;
			$this->assertEquals( "The filename parameter must be set", $e->getMessage() );
		}
		$this->assertTrue( $exception, "Got exception" );

		$this->user->removeGroup( 'sysop' );
		$exception = false;
		try {
			$this->doApiRequest( array(
				'action' => 'upload',
				'url' => 'http://www.example.com/test.png',
				'filename' => 'UploadFromUrlTest.png',
				'token' => $token,
			), $data );
		} catch ( UsageException $e ) {
			$exception = true;
			$this->assertEquals( "Permission denied", $e->getMessage() );
		}
		$this->assertTrue( $exception, "Got exception" );
	}

	/**
	 * @depends testLogin
	 */
	public function testSyncDownload( $data ) {
		$token = $this->user->getEditToken();

		$this->user->addGroup( 'users' );
		$data = $this->doApiRequest( array(
			'action' => 'upload',
			'filename' => 'UploadFromUrlTest.png',
			'url' => 'http://bits.wikimedia.org/skins-1.5/common/images/poweredby_mediawiki_88x31.png',
			'ignorewarnings' => true,
			'token' => $token,
		), $data );

		$this->assertEquals( 'Success', $data[0]['upload']['result'] );
		$this->deleteFile( 'UploadFromUrlTest.png' );

		return $data;
	}

	/**
	 *
	 */
	protected function deleteFile( $name ) {
		$t = Title::newFromText( $name, NS_FILE );
		$this->assertTrue($t->exists(), "File '$name' exists");

		if ( $t->exists() ) {
			$file = wfFindFile( $name, array( 'ignoreRedirect' => true ) );
			$empty = "";
			FileDeleteForm::doDelete( $t, $file, $empty, "none", true );
			$a = new Article ( $t );
			$a->doDeleteArticle( "testing" );
		}
		$t = Title::newFromText( $name, NS_FILE );

		$this->assertFalse($t->exists(), "File '$name' was deleted");
	}
 }
