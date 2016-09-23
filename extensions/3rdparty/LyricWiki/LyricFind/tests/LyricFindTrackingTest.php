<?php

/**
 * @group LyricFindTracking
 */
class LyricFindTrackingTest extends WikiaBaseTest {

	const TEST_NAMESPACE_TRACKED = 666;
	const TEST_NAMESPACE_NOT_TRACKED = NS_MAIN;

	public function setUp() {
		$this->setupFile = __DIR__ . '/../LyricFind.setup.php';
		parent::setUp();

		$this->mockGlobalVariable('wgLyricFindTrackingNamespaces', [self::TEST_NAMESPACE_TRACKED]);
	}

	/**
	 * @dataProvider pageIsTrackableProvider
	 * @param $ns int namespace
	 * @param $action string action=... value
	 * @param $exists bool does the page exist?
	 * @param $expectedResult bool expected result
	 */
	public function testPageIsTrackable($ns, $action, $exists, $expectedResult) {
		$title = $this->mockClassWithMethods('Title', [
			'getNamespace' => $ns,
			'exists' => $exists
		]);

		$request = new WebRequest();
		$request->setVal('action', $action);
		$this->mockGlobalVariable('wgRequest', $request);

		$this->assertEquals($expectedResult, LyricFindHooks::pageIsTrackable($title));
	}

	public function pageIsTrackableProvider() {
		return [
			[
				'ns' => self::TEST_NAMESPACE_TRACKED,
				'action' => null,
				'exists' => true,
				'trackable' => true
			],
			[
				'ns' => self::TEST_NAMESPACE_TRACKED,
				'action' => 'view',
				'exists' => true,
				'trackable' => true
			],
			// don't track on edit pages
			[
				'ns' => self::TEST_NAMESPACE_TRACKED,
				'action' => 'edit',
				'exists' => true,
				'trackable' => false
			],
			[
				'ns' => self::TEST_NAMESPACE_TRACKED,
				'action' => 'view',
				'exists' => false,
				'trackable' => false
			],
			[
				'ns' => self::TEST_NAMESPACE_NOT_TRACKED,
				'action' => 'view',
				'exists' => true,
				'trackable' => false
			],
			[
				'ns' => self::TEST_NAMESPACE_NOT_TRACKED,
				'action' => 'view',
				'exists' => false,
				'trackable' => false
			],
		];
	}
}
