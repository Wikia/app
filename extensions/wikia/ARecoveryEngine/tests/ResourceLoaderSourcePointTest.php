<?php

class ResourceLoaderSourcePointTest extends WikiaBaseTest {

	private $resourceLoaderContext;
	const REMOTE_SCRIPT_MOCK_CONTENT = '[remote]';
	const LOCAL_SCRIPT_MOCK_CONTENT = '[mock]';
	const INLINE_SCRIPT_MOCK_CONTENT = '[inline]';
	const FALLBACK_DATA_MOCK_CONTENT = '[fallback]';
	const MEMCACHED_DATA_MOCK_CONTENT = '[memc]';

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/AdEngine/AdEngine2.setup.php";
		$this->resourceLoaderContext = new ResourceLoaderContext( new ResourceLoader(), new WebRequest() );
		parent::setUp();
	}

	public function testSourcePointModule() {
		$this->disableMemCache();

		$mock = $this->getMockBuilder('ResourceLoaderAdEngineSourcePointCSDelivery')
			->disableOriginalConstructor()
			->setMethods( [ 'fetchRemoteScript', 'fetchLocalScript', 'getInlineScript' ] )
			->getMock();
		ResourceLoaderAdEngineSourcePointCSDelivery::$localCache[get_class($mock)] = null;
		$mock->method( 'fetchRemoteScript' )->willReturn( self::REMOTE_SCRIPT_MOCK_CONTENT );
		$mock->method( 'fetchLocalScript' )->willReturn( self::LOCAL_SCRIPT_MOCK_CONTENT );
		$mock->method( 'getInlineScript' )->willReturn( self::INLINE_SCRIPT_MOCK_CONTENT );

		$script = $mock->getScript( $this->resourceLoaderContext );

		$sourcePointScripts = [
			self::REMOTE_SCRIPT_MOCK_CONTENT
		];

		$this->assertEquals( implode( PHP_EOL, $sourcePointScripts ), $script );
		$this->assertEquals( $mock->getModifiedTime( $this->resourceLoaderContext )
			+ ResourceLoaderAdEngineSourcePointCSDelivery::TTL_SCRIPTS, $mock->getTtl() );
	}

}
