<?php

class NodeDataSanitizerTest extends WikiaBaseTest {
	private $sanitizer;

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../PortableInfobox.setup.php';

		$this->sanitizer = SanitizerBuilder::createFromType('data');
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
					'label' => 'Data <a>Link</a>',
					'value' => 'Data <a>Value</a>' ],
				[
					'label' => 'Data <a>Link</a>',
					'value' => 'Data <a>Value</a>'
				]
			],
			[
				['label' => 'Test data label <img src=\'data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D\' class=\'article-media\' data-ref=\'1\' width=\'400\' height=\'100\' />with image'],
				['label' => 'Test data label with image']
			],
			[
				[
					'label' => 'Data <div class="some class">with <h2>div </h2>with <small>class</small></div> and other tags',
					'value' => 'Data <small>Value</small>'
				],
				[
					'label' => 'Data with div with class and other tags',
					'value' => 'Data <small>Value</small>'
				]
			],
			[
				[
					'label' => '<img src="money.jpg" class="test classes" width="20" />',
					'value' => 'Data <small>Value</small>'
				],
				[
					'label' => '<img src="money.jpg" class="test classes" width="20" />',
					'value' => 'Data <small>Value</small>'
				]
			],
		];
	}
}
