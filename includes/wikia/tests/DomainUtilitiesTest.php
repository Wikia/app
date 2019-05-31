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
	 * @param string $envName
	 * @param string $url
	 * @param string|null $expected
	 *
	 * @dataProvider getHeaderListOriginalHostDataProvider
	 * @covers       MWHttpRequest::getHeaderList
	 */
	public function testGetHeaderListOriginalHost( string $envName, string $url, $expected ) {
		$this->mockEnvironment( $envName );
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
		yield [ WIKIA_ENV_SANDBOX, 'http://futurama.sandbox-s1.fandom.com/fr/wikia.php', 'futurama.fandom.com'] ;
		yield [ WIKIA_ENV_SANDBOX, 'http://futurama.sandbox-s1.wikia.com/fr/wikia.php', 'futurama.wikia.com'] ;
		yield [ WIKIA_ENV_PREVIEW, 'http://futurama.preview.fandom.com/fr/wikia.php', 'futurama.fandom.com'] ;
		yield [ WIKIA_ENV_PREVIEW, 'http://futurama.preview.wikia.com/fr/wikia.php', 'futurama.wikia.com'] ;
		yield [ WIKIA_ENV_PROD, 'http://futurama.fandom.com/fr/wikia.php', 'futurama.fandom.com'] ;
		yield [ WIKIA_ENV_PROD, 'http://futurama.wikia.com/fr/wikia.php', 'futurama.wikia.com'] ;

		yield [ WIKIA_ENV_PROD, 'http://example.com/fr/wikia.php', null ] ;
		yield [ WIKIA_ENV_PROD, 'http://futurama.wikia.org/fr/wikia.php', null] ;
	}

	/**
	 * @param string $envName
	 * @param string $host
	 * @param string $expected
	 *
	 * @dataProvider wfNormalizeHostDataProvider
	 */
	public function testWfNormalizeHost( string $envName, string $host, string $expected ) {
		$this->mockEnvironment( $envName );
		$this->assertEquals( $expected, wfNormalizeHost( $host ) );
	}

	public function wfNormalizeHostDataProvider() {
		yield [ WIKIA_ENV_SANDBOX, 'futurama.sandbox-s1.wikia.com', 'futurama.wikia.com' ];
		yield [ WIKIA_ENV_SANDBOX, 'muppet.sandbox-s1.wikia.com', 'muppet.wikia.com' ];
		yield [ WIKIA_ENV_VERIFY, 'futurama.verify.wikia.com', 'futurama.wikia.com' ];
		yield [ WIKIA_ENV_PREVIEW, 'futurama.preview.wikia.com', 'futurama.wikia.com' ];
		yield [ WIKIA_ENV_PREVIEW, 'futurama.preview.fandom.com', 'futurama.fandom.com' ];
		yield [ WIKIA_ENV_PROD, 'muppet.wikia.com', 'muppet.wikia.com' ];
		yield [ WIKIA_ENV_PROD, 'muppet.fandom.com', 'muppet.fandom.com' ];
		yield [ WIKIA_ENV_PROD, 'example.com', 'example.com' ];
	}
}
