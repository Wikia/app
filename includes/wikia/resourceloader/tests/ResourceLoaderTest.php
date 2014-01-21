<?php

class TestResourceLoaderModule extends ResourceLoaderModule {

	const TIMESTAMP = 1361547436;

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
	 * @dataProvider resourceLoaderModifyMaxAgeDataProvider
	 *
	 * @param $timestamp int timestamp in URL
	 * @param $ttl int expected caching period
	 */
	public function testResourceLoaderModifyMaxAge($timestamp, $ttl) {
		global $wgHooks, $wgStyleVersion;

		$resourceLoader = new ResourceLoader();
		$resourceLoader->register('WikiaTestModule', array(
			'class' => 'TestResourceLoaderModule'
		));

		$request = new WebRequest();
		$request->setVal('modules', 'WikiaTestModule');
		$request->setVal('version', $wgStyleVersion . '-' . wfTimestamp(TS_ISO_8601_BASIC, $timestamp));

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
		global $wgResourceLoaderMaxage;

		return array(
			array(
				'timestamp' => TestResourceLoaderModule::TIMESTAMP - 1,
				'ttl' => $wgResourceLoaderMaxage['versioned']['client']
			),
			array(
				'timestamp' => TestResourceLoaderModule::TIMESTAMP,
				'ttl' => $wgResourceLoaderMaxage['versioned']['client']
			),
			array(
				'timestamp' => TestResourceLoaderModule::TIMESTAMP + 1,
				'ttl' => $wgResourceLoaderMaxage['unversioned']['client']
			)
		);
	}

	public static function onResourceLoaderCacheControlHeaders($context, $maxage, $smaxage, $exp) {
		self::$ttl = $maxage;
		return true;
	}
}
