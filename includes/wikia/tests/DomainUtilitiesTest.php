<?php

class DomainUtilitiesTest extends WikiaBaseTest {

	private $originallocalVHosts;

	public function setUp() {
		parent::setUp();

		global $wgConf;
		$this->originallocalVHosts = $wgConf->localVHosts;
		$wgConf->localVHosts = [
			'fandom.com',
			'wikia.com',
		];
	}

	public function tearDown() {
		parent::tearDown();

		global $wgConf;
		$wgConf->localVHosts = $this->originallocalVHosts;
	}

	/**
	 * @param string $url
	 * @param string|null $expected
	 *
	 * @dataProvider getHeaderListOriginalHostDataProvider
	 * @covers MWHttpRequest::getHeaderList
	 */
	public function testGetHeaderListOriginalHost( string $url, $expected ) {
		$this->mockGlobalVariable( 'wgKubernetesNamespace', 'foo' );

		$http = new MWHttpRequest( $url );
		$headers = $http->getHeaderList();

		if ( is_null( $expected ) ) {
			$this->assertEquals( [], $headers );
		}
		else {
			$this->assertEquals( 'X-Original-Host: ' . $expected, $headers[0] );
		}
	}

	public function getHeaderListOriginalHostDataProvider() {
		yield [ 'http://futurama.sandbox-s6.fandom.com/fr/wikia.php', 'futurama.fandom.com'] ;
		yield [ 'http://futurama.sandbox-s6.wikia.com/fr/wikia.php', 'futurama.wikia.com'] ;
		yield [ 'http://futurama.preview.fandom.com/fr/wikia.php', 'futurama.fandom.com'] ;
		yield [ 'http://futurama.preview.wikia.com/fr/wikia.php', 'futurama.wikia.com'] ;
		yield [ 'http://futurama.fandom.com/fr/wikia.php', 'futurama.fandom.com'] ;
		yield [ 'http://futurama.wikia.com/fr/wikia.php', 'futurama.wikia.com'] ;

		yield [ 'http://example.com/fr/wikia.php', null ] ;
		yield [ 'http://futurama.wikia.org/fr/wikia.php', null] ;
	}

	/**
	 * @param string $host
	 * @param string $expected
	 *
	 * @dataProvider wfNormalizeHostDataProvider
	 */
	public function testWfNormalizeHost( string $host, string $expected ) {
		$this->assertEquals( $expected, wfNormalizeHost( $host ) );
	}

	public function wfNormalizeHostDataProvider() {
		yield [ 'futurama.sandbox-s6.wikia.com', 'futurama.wikia.com' ];
		yield [ 'muppet.sandbox-qa06.wikia.com', 'muppet.wikia.com' ];
		yield [ 'futurama.verify.wikia.com', 'futurama.wikia.com' ];
		yield [ 'futurama.preview.wikia.com', 'futurama.wikia.com' ];
		yield [ 'futurama.preview.fandom.com', 'futurama.fandom.com' ];
		yield [ 'muppet.wikia.com', 'muppet.wikia.com' ];
		yield [ 'muppet.fandom.com', 'muppet.fandom.com' ];
		yield [ 'example.com', 'example.com' ];
	}
}
