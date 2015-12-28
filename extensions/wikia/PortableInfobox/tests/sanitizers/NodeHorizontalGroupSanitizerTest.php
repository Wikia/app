<?php

class NodeHorizontalGroupSanitizerTest extends WikiaBaseTest {
	private $sanitizer;

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../PortableInfobox.setup.php';

		$this->sanitizer = SanitizerBuilder::createFromType('horizontal-group-content');
		parent::setUp();
	}

	/**
	 * @param $data
	 * @param $expected
	 * @dataProvider testSanitizeDataProvider
	 */
	function testSanitize( $data, $expected ) {
		$this->assertEquals(
			$expected,
			$this->sanitizer->sanitize( $data )
		);
	}

	function testSanitizeDataProvider() {
		return [
			[
				[
					'labels' => [
						0 => '<img src="money.jpg" class="test classes" width="20" />',
						1 => 'Label with <a>link</a>',
						2 => 'Label with <small>link</small>',
						3 => 'Money <img src="money.jpg" class="test classes" width="20" />'
					],
					'values' => [
						0 => 'Data <small>Value</small>',
						1 => 'Data <a>Value</a>',
						2 => '<img src="money.jpg" class="test classes" width="20" />',
						3 => '$50'
					]
				],
				[
					'labels' => [
						0 => '<img src="money.jpg" class="test classes" width="20" />',
						1 => 'Label with <a>link</a>',
						2 => 'Label with link',
						3 => 'Money',
					],
					'values' => [
						0 => 'Data <small>Value</small>',
						1 => 'Data <a>Value</a>',
						2 => '<img src="money.jpg" class="test classes" width="20" />',
						3 => '$50'
					]
				]
			]
		];
	}
}
