<?php
require_once __DIR__ . '/../ApiAddMedia.php';
require_once __DIR__ . '/../ApiAddMediaTemporary.php';

class ApiAddMediaTemporaryTest extends WikiaBaseTest {

	/* Tests */

	public function testImageDuplicate() {
		$request = new FauxRequest( array(), true );

		$localFile = $this->getMockBuilder( 'LocalFile' )->disableOriginalConstructor()->getMock();
		$localFile
			->expects( $this->once() )
			->method( 'getTitle' )
			->will( $this->returnValue( Title::newFromText( 'LoremIpsum', 6 ) ) );
		$localFile
			->expects( $this->once() )
			->method( 'getUrl' )
			->will( $this->returnValue( 'http://Lorem/Ipsum.png' ) );

		$repoGroup = $this->getMockBuilder('RepoGroup')->disableOriginalConstructor()->getMock();
		$repoGroup
			->expects( $this->once() )
			->method( 'findBySha1' )
			->will( $this->returnValue( array( $localFile ) ) );
		$this->mockClass( 'RepoGroup', $repoGroup );

		$api = new ApiAddMediaTemporary(
			new ApiMain( $request ), 'addmediatemporary'
		);
		$api->execute();
		$data = $api->getResult()->getData();

		$this->assertEquals(
			array(
				'addmediatemporary' => array(
					'title' => 'LoremIpsum',
					'url' => 'http://Lorem/Ipsum.png'
				)
			),
			$data
		);
	}

	/**
     * @expectedException UsageException
     * @expectedExceptionMessage An unknown error occurred
     */
	public function testImageNewLoggedOut() {
		$request = new FauxRequest( array(), true );
		$api = new ApiAddMediaTemporary(
			new ApiMain( $request ), 'addmediatemporary'
		);
		$api->execute();
	}

	public function testImageNewLoggedIn() {
		$request = new FauxRequest( array(), true );

		$uploadFromFile = $this->getMock( 'UploadFromFile' );
		$uploadFromFile
			->expects( $this->once() )
			->method( 'verifyUpload' )
			->will( $this->returnValue( array( 'status' => UploadBase::OK ) ) );
		$uploadFromFile
			->expects( $this->once() )
			->method( 'getTitle' )
			->will( $this->returnValue( Title::newFromText( 'LoremIpsum', 6 ) ) );
		$uploadFromFile
			->expects( $this->once() )
			->method( 'verifyTitlePermissions' )
			->will( $this->returnValue( true ) );
		$this->mockClass( 'UploadFromFile', $uploadFromFile );

		$fakeLocalFile = $this->getMockBuilder( 'FakeLocalFile' )->disableOriginalConstructor()->getMock();
		$fakeLocalFile
			->expects( $this->once() )
			->method( 'upload' );
		$fakeLocalFile
			->expects( $this->once() )
			->method( 'getUrl' )
			->will( $this->returnValue( 'http://Lorem/Ipsum.png' ) );
		$fakeLocalFile
			->expects( $this->once() )
			->method( 'getName' )
			->will( $this->returnValue( '0123456789' ) );
		$this->mockClass( 'FakeLocalFile', $fakeLocalFile );

		$api = new ApiAddMediaTemporary(
			new ApiMain( $request ), 'addmediatemporary'
		);
		$api->execute();
		$data = $api->getResult()->getData();

		$this->assertEquals(
			array(
				'addmediatemporary' => array(
					'title' => 'LoremIpsum',
					'tempUrl' => 'http://Lorem/Ipsum.png',
					'tempName' => '0123456789'
				)
			),
			$data
		);
	}

}
