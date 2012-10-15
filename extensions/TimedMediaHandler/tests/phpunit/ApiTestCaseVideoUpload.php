<?php
/**
 * Abstract test class to support Video Tests with video uploads  
 * @author dale
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

// Include core class ApiTestCaseUpload ( not part of base autoLoader )
global $IP;
require_once( "$IP/tests/phpunit/includes/api/ApiTestCaseUpload.php" );

abstract class ApiTestCaseVideoUpload extends ApiTestCaseUpload {
	/**
	 * @return Array set of test files with associated metadata
	 */
	static function mediaFilesProvider(){
		return array( 
			array(
				// Double wrap the file array to match phpunit data provider conventions 
				array( 
					'mime' => 'application/ogg',
					'filePath' => dirname( __FILE__ ) . '/media/test5seconds.electricsheep.300x400.ogv',
					"size" => 301477,
					"width"  => 400,
					"height" => 300,
					"mediatype" => "VIDEO",
					"bandwidth" => 452216,
					"framerate" => 30
				)
			),
			array(
				array(
					'mime' => 'video/webm',
					'filePath' => dirname( __FILE__ ) . '/media/shuttle10seconds.1080x608.webm',
					"size" => 699018,
					"width" => 1080,
					"height" => 608,
					"mediatype" => "VIDEO",
					"bandwidth" => 522142,
					"framerate" => 29.97
				)		
			)
		);
	}
	/**
	 * Fixture -- run after every test
	 * Clean up temporary files etc.
	 * 
	*/ 
	function tearDown() {
		$testMediaFiles = $this->mediaFilesProvider();
		foreach( $testMediaFiles as $file ){
			$file = $file[0];
			// Clean up and delete all files
			$this->deleteFileByFilename( $file['filePath'] );
		}
	}
	/**
	 * Do login
	 */
	function doLogin() {
		$user = self::$users['uploader'];

		$params = array(
			'action' => 'login',
			'lgname' => $user->username,
			'lgpassword' => $user->password
		);
		list( $result, , $session ) = $this->doApiRequest( $params );
		$token = $result['login']['token'];

		$params = array(
			'action' => 'login',
			'lgtoken' => $token,
			'lgname' => $user->username,
			'lgpassword' => $user->password
		);
		list( $result, , $session ) = $this->doApiRequest( $params, $session );
		return $session;
	}
	
	/**
	 * uploads a file:
	 */
	function uploadFile( $file ){
		global $wgUser;
		// get a session object
		$session = $this->doLogin();
		// Update the global user: 
		$wgUser = self::$users['uploader']->user;
		
		// Upload the media file:
		$fileName = basename( $file['filePath'] );
	
		// remove if already in thd db:
		$this->deleteFileByFileName( $fileName );
		$this->deleteFileByContent( $file['filePath'] );

		if (! $this->fakeUploadFile( 'file', $fileName, $file['mime'], $file['filePath'] ) ) {
			$this->markTestIncomplete( "Couldn't upload file!\n" );
		}

		$params = array(
			'action' => 'upload',
			'filename' => $fileName,
			'file' => 'dummy content',
			'comment' => 'dummy comment',
			'text'	=> "This is the page text for $fileName",
			// This uploadFile function supports video tests not a test upload warnings 
			'ignorewarnings' => true
		);
		
		try{		
			list( $result, , ) = $this->doApiRequestWithToken( $params, $session );
		} catch( Exception $e ) {
			// Could not upload mark test that called uploadFile as incomplete
			$this->markTestIncomplete( $e->getMessage() );
		}
		 
		return $result;
				
	}
	
}
