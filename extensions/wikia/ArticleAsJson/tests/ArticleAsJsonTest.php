<?php

class ArticleAsJsonTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../ArticleAsJson.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider testIsIconImageDataProvider
	 * @param $details
	 * @param $expectedOutput
	 * @param $message info about the test case
	 * @internal param $handlerParams
	 */
	public function testIsIconImage( $details, $handlerParams, $expectedOutput, $message ) {

		$method = new ReflectionMethod('ArticleAsJson', 'isIconImage');
		$method->setAccessible(true);

		$this->assertEquals( $expectedOutput, $method->invoke(new ArticleAsJson, $details, $handlerParams), $message);
	}

	public function testIsIconImageDataProvider() {
		return [
			[
				'details' => [
					'height' => '155',
					'width' => '4'
				],
				'handlerParams' => [],
				'expectedOutput' => true,
				'message' => 'small width, big height'
			],
			[
				'details' => [
					'height' => '5',
					'width' => '444'
				],
				'handlerParams' => [],
				'expectedOutput' => true,
				'message' => 'big width, small height'
			],
			[
				'details' => [
					'height' => '47',
					'width' => '4'
				],
				'handlerParams' => [],
				'expectedOutput' => true,
				'message' => 'small width, small height'
			],
			[
				'details' => [
					'height' => '4'
				],
				'handlerParams' => [],
				'expectedOutput' => true,
				'message' => 'width not set, small height'
			],
			[
				'details' => [
					'width' => '4544'
				],
				'handlerParams' => [],
				'expectedOutput' => false,
				'message' => 'big width, height not set'
			],
			[
				'details' => [
					'height' => '49',
					'width' => '49'
				],
				'handlerParams' => [],
				'expectedOutput' => false,
				'message' => 'big width, big height'
			],
			[
				'details' => [],
				'handlerParams' => [],
				'expectedOutput' => false,
				'message' => 'sizes not set'
			],
			[
				'details' => [],
				'handlerParams' => [
					'height' => '49',
					'width' => '49'
				],
				'expectedOutput' => false,
				'message' => 'big width, big height'
			],
			[
				'details' => [
					'height' => '555',
					'width' => '555'
				],
				'handlerParams' => [
					'height' => '444',
					'width' => '444'
				],
				'expectedOutput' => false,
				'message' => 'big width, big height'
			],
			[
				'details' => [
					'height' => '555',
					'width' => '555'
				],
				'handlerParams' => [
					'height' => '48',
					'width' => '48'
				],
				'expectedOutput' => true,
				'message' => 'small width, small height'
			]
		];
	}
}
