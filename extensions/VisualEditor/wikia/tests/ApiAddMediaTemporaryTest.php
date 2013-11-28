<?php
require_once __DIR__ . '/../ApiAddMedia.php';
require_once __DIR__ . '/../ApiAddMediaTemporary.php';

class ApiAddMediaTemporaryTest extends WikiaBaseTest {

	/* Tests */

	public function testImageDuplicate() {
		$request = $this->getMock(
			'FauxRequest',
			array( 'getFileTempName' ),
			array(
				array(),
				true
			)
		);
		$request
			->expects( $this->once() )
			->method( 'getFileTempName' )
			->will( $this->returnValue( '-FileTempName-' ) );

		$localFile = $this->getMockBuilder('LocalFile')->disableOriginalConstructor()->getMock();
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

}
