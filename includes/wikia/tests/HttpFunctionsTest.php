<?php

class HttpFunctionsTest extends WikiaBaseTest {

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
	 */
	public function testGetHeaderListOriginalHost( $url, $expected ) {
		$this->mockGlobalVariable( 'wgKubernetesNamespace', 'foo' );

		$http = new MWHttpRequest( $url );
		$headers = $http->getHeaderList();

		$this->assertEquals( 'X-Original-Host: ' . $expected, $headers[0] );
	}

	public function getHeaderListOriginalHostDataProvider() {
		yield [ 'http://futurama.sandbox-s6.fandom.com/fr/wikia.php', 'futurama.fandom.com'] ;
		yield [ 'http://futurama.sandbox-s6.wikia.com/fr/wikia.php', 'futurama.wikia.com'] ;
		yield [ 'http://futurama.preview.fandom.com/fr/wikia.php', 'futurama.fandom.com'] ;
		yield [ 'http://futurama.preview.wikia.com/fr/wikia.php', 'futurama.wikia.com'] ;
		yield [ 'http://futurama.fandom.com/fr/wikia.php', 'futurama.fandom.com'] ;
		yield [ 'http://futurama.wikia.com/fr/wikia.php', 'futurama.wikia.com'] ;
	}
}
