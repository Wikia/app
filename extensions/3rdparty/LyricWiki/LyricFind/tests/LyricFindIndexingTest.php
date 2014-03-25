<?php

class LyricFindIndexingTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../LyricFind.setup.php';
		parent::setUp();
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.1191 ms
	 * @dataProvider indexPolicyProvider
	 * @param $ns int namespace
	 * @param $text string page title
	 * @param $inMainNS bool is page in the main NS as well?
	 * @param $expectedResult bool is page not permitted to be indexed?
	 */
	public function testIndexPolicy($ns, $inMainNS, $expectedResult) {
		$title = $this->mockClassWithMethods('Title', [
			'getNamespace' => $ns,
			'getText' => 'Foo'
		]);

		$this->mockClassWithMethods('Title', [
			'exists' => $inMainNS
		], 'newFromText');

		$this->assertEquals($expectedResult, LyricFindHooks::pageIsIndexable($title));
	}

	public function indexPolicyProvider() {
		return [
			[
				'ns' => 222, // NS_LYRICFIND
				'inMainNS' => true,
				'expectedResult' => false
			],
			[
				'ns' => 222, // NS_LYRICFIND
				'inMainNS' => false,
				'expectedResult' => true
			],
			[
				'ns' => NS_MAIN,
				'inMainNS' => true,
				'expectedResult' => true
			],
		];
	}
}
