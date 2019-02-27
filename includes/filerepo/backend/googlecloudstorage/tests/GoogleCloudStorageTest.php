<?php
//

class GoogleCloudStorageTest extends WikiaBaseTest {


	/** @var PHPUnit\Framework\MockObject\MockObject */
	private $client;
	/** @var GoogleCloudStorage */
	private $sut;

	protected function setUp() {
		parent::setUp();
		$this->client = $this->createMock( Google\Cloud\Storage\StorageClient::class );
		$this->sut =
			new GoogleCloudStorage( $this->client, "originals", "temporary", "mediawiki/" );
	}

	public function testFail() {
		self::fail( "verify this fails" );
	}

	public function test_get_object_name() {
		$this->assertThat( $this->sut->getObjectName( [ "fallout", "images/a/ac/image.png" ] )
			->value(), $this->equalTo( "mediawiki/fallout/images/a/ac/image.png" ) );
	}

	public function test_get_thumbnail_prefix_with_language_path() {
		$this->assertThat( $this->sut->getThumbnailPathPrefix( "fallout",
			"pt_br/images/thumb/e/ef/Screenshot_2019-02-05_at_12.14.36.png" ),
			$this->equalTo( "mediawiki/ef/fallout/pt_br/Screenshot_2019-02-05_at_12.14.36.png" ) );
	}

	public function test_get_thumbnail_prefix() {
		$this->assertThat( $this->sut->getThumbnailPathPrefix( "fallout",
			"images/thumb/e/ef/Screenshot_2019-02-05_at_12.14.36.png" ),
			$this->equalTo( "mediawiki/ef/fallout/default/Screenshot_2019-02-05_at_12.14.36.png" ) );
	}

	public function test_get_path_prefix() {
		$this->assertThat( $this->sut->getPathPrefix( "fallout",
			"images/thumb/e/ef/Screenshot_2019-02-05_at_12.14.36.png" ),
			$this->equalTo( "mediawiki/fallout/images/thumb/e/ef/Screenshot_2019-02-05_at_12.14.36.png" ) );
	}
}
