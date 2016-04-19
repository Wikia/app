<?php

class ArticleAsJsonTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../ArticleAsJson.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider testUnwrapParsedTextFromParagraphDataProvider
	 * @param $text
	 * @param $expectedOutput
	 */
	public function testUnwrapParsedTextFromParagraph( $text, $expectedOutput ) {
		$method = new ReflectionMethod( 'ArticleAsJson', 'unwrapParsedTextFromParagraph' );
		$method->setAccessible( true );

		$unwrappedText = $method->invoke( new ArticleAsJson, $text );

		$this->assertEquals( $expectedOutput, $unwrappedText );
	}

	public function testUnwrapParsedTextFromParagraphDataProvider() {
		return [
			[
				'text' => '<p>Test</p>',
				'expectedOutput' => 'Test'
			],
			[
				'text' => 'Test',
				'expectedOutput' => 'Test'
			],
			[
				'text' => '<p style="color: black;">Test</p>',
				'expectedOutput' => '<p style="color: black;">Test</p>'
			],
			[
				'text' => '<a href="http://www.wikia.com">Test</a>',
				'expectedOutput' => '<a href="http://www.wikia.com">Test</a>'
			]
		];
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

	/**
	 * @dataProvider testScaleIconSizeDataProvider
	 * @param $originalHeight
	 * @param $originalWidth
	 * @param $expectedOutput
	 */
	public function testScaleIconSize( $originalHeight, $originalWidth, $expectedOutput ) {
		$method = new ReflectionMethod( 'ArticleAsJson', 'scaleIconSize' );
		$method->setAccessible( true );

		$output = $method->invoke( new ArticleAsJson, $originalHeight, $originalWidth );

		$this->assertEquals( $expectedOutput, $output );
	}

	public function testScaleIconSizeDataProvider() {
		return [
			[
				'originalHeight' => 100,
				'originalWidth' => 200,
				'expectedOutput' => [
					'height' => 20,
					'width' => 40
				]
			],
			[
				'originalHeight' => 10,
				'originalWidth' => 200,
				'expectedOutput' => [
					'height' => 10,
					'width' => 200
				]
			],
			[
				'originalHeight' => 100,
				'originalWidth' => 20,
				'expectedOutput' => [
					'height' => 20,
					'width' => 4
				]
			],
			[
				'originalHeight' => 130,
				'originalWidth' => 20,
				'expectedOutput' => [
					'height' => 20,
					'width' => 3
				]
			]
		];
	}
}
