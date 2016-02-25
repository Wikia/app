<?php

class TestResourceLoaderModule extends ResourceLoaderModule {

	const TIMESTAMP = 1452004000;

	public function getModifiedTime( ResourceLoaderContext $context ) {
		return self::TIMESTAMP;
	}
}

class ResourceLoaderTest extends WikiaBaseTest {

	private static $ttl = false;
	private $oldWgHooks;

	public function setUp() {
		global $wgHooks;
		$this->oldWgHooks = $wgHooks;

		parent::setUp();
	}

	public function tearDown() {
		global $wgHooks;
		$wgHooks = $this->oldWgHooks;

		parent::tearDown();
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.01651 ms
	 * @dataProvider resourceLoaderModifyMaxAgeDataProvider
	 *
	 * @param $timestamp int timestamp in URL
	 * @param $ttl int expected caching period
	 */
	public function testResourceLoaderModifyMaxAge($version, $ttl) {
		global $wgHooks;

		$resourceLoader = new ResourceLoader();
		$resourceLoader->register('WikiaTestModule', array(
			'class' => 'TestResourceLoaderModule'
		));

		$request = new WebRequest();
		$request->setVal('modules', 'WikiaTestModule');
		$request->setVal('version', join('-', $version));

		// set up hooks
		$wgHooks['ResourceLoaderCacheControlHeaders'][] = 'ResourceLoaderTest::onResourceLoaderCacheControlHeaders';

		ob_start();
		$resourceLoader->respond( new ResourceLoaderContext( $resourceLoader, $request ) );
		ob_end_clean();

		// hook ResourceLoaderHooks::onResourceLoaderModifyMaxAge was called
		// check modified caching period with expected one
		$this->assertEquals($ttl, self::$ttl, 'TTL should match expected value');
	}

	public function resourceLoaderModifyMaxAgeDataProvider() {
		global $wgResourceLoaderMaxage, $wgStyleVersion;

		$pastTimestamp = wfTimestamp( TS_ISO_8601_BASIC, TestResourceLoaderModule::TIMESTAMP - 1 );
		$currTimestamp = wfTimestamp( TS_ISO_8601_BASIC, TestResourceLoaderModule::TIMESTAMP );
		$futureTimestamp = wfTimestamp( TS_ISO_8601_BASIC, TestResourceLoaderModule::TIMESTAMP + 1 );

		return array(
			'timestamp - 1' => array(
				'version' => [$wgStyleVersion, $pastTimestamp],
				'ttl' => $wgResourceLoaderMaxage['versioned']['client']
			),
			'timestamp' => array(
				'version' => [$wgStyleVersion, $currTimestamp],
				'ttl' => $wgResourceLoaderMaxage['versioned']['client']
			),
			'timestamp + 1' => array(
				'version' => [$wgStyleVersion, $futureTimestamp],
				'ttl' => $wgResourceLoaderMaxage['unversioned']['client']
			)
		);
	}

	public static function onResourceLoaderCacheControlHeaders($context, $maxage, $smaxage, $exp) {
		self::$ttl = $maxage;
		return true;
	}
}
