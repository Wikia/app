<?php

class LyricFindTrackingTest extends WikiaBaseTest {

	const TEST_NAMESPACE_TRACKED = 666;
	const TEST_NAMESPACE_NOT_TRACKED = NS_MAIN;

	public function setUp() {
		$this->setupFile = __DIR__ . '/../LyricFind.setup.php';
		parent::setUp();

		$this->mockGlobalVariable('wgLyricFindTrackingNamespaces', array(self::TEST_NAMESPACE_TRACKED));
		$this->mockApp();
	}

	/**
	 * @dataProvider pageIsTrackableProvider
	 * @param $ns int namespace
	 * @param $exists bool does the page exist?
	 * @param $expectedResult bool expected result
	 */
	public function testPageIsTrackable($ns, $exists, $expectedResult) {
		$title = $this->mockClassWithMethods('Title', array(
			'getNamespace' => $ns,
			'exists' => $exists
		));

		$this->assertEquals($expectedResult, LyricFindHooks::pageIsTrackable($title));
	}

	public function pageIsTrackableProvider() {
		return array(
			array(
				'ns' => self::TEST_NAMESPACE_TRACKED,
				'exists' => true,
				'trackable' => true
			),
			array(
				'ns' => self::TEST_NAMESPACE_TRACKED,
				'exists' => false,
				'trackable' => false
			),
			array(
				'ns' => self::TEST_NAMESPACE_NOT_TRACKED,
				'exists' => true,
				'trackable' => false
			),
			array(
				'ns' => self::TEST_NAMESPACE_NOT_TRACKED,
				'exists' => false,
				'trackable' => false
			),
		);
	}
}
