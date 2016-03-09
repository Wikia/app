<?php
class WikiaTagBuilderHelperTest extends WikiaBaseTest {

	public function setUp() {
		require_once( __DIR__ . '/../WikiaTagBuilderHelper.class.php' );
		parent::setUp();
	}

	/**
	 * @dataProvider buildTagSourceQueryParamsDataProvider
	 */
	public function testBuildTagSourceQueryParams( $allowedParams, $passedParams, $overrideParams, $expectedResult ) {
		$tagBuilder = new WikiaTagBuilderHelper();

		$this->assertEquals(
			$tagBuilder->buildTagSourceQueryParams( $allowedParams, $passedParams, $overrideParams ),
			$expectedResult
		);
	}

	public function buildTagSourceQueryParamsDataProvider() {
		return [
			[
				[
					'foo' => 'before',
					'allowedParam' => 'value',
					'bar' => '',
					'allowedParam2' => 'valueSet',
				],
				[
					'fizz' => 'value',
					'buzz' => 'value2',
					'foo' => 'after',
					'allowedParam2' => '',
				],
				[],
				'foo=after&allowedParam=value&allowedParam2=valueSet'
			],
			[
				[
					'foo' => 'default',
					'bar' => 'default'
				],
				[
					'foo' => 'new',
					'bar' => 'new'
				],
				[
					'bar' => 'override'
				],
				'foo=new&bar=override'
			]
		];
	}

	/**
	 * @dataProvider buildTagAttributesDataProvider
	 * @param array $passedAttrs
	 * @param string $prefix
	 * @param array $expectedResult
	 */
	public function testBuildTagAttributes($passedAttrs, $prefix = '' ,$expectedResult) {
		$tagBuilder = new WikiaTagBuilderHelper();
		$this->getStaticMethodMock( 'Sanitizer', 'checkCss' )
			->expects( $this->any() )
			->method( 'checkCss' )
			->will( $this->returnValue( 'sanitized' ) );

		$allowedAttrs = [
			'foo',
			'bar',
			'style',
		];

		$this->assertSame( $tagBuilder->buildTagAttributes( $allowedAttrs, $passedAttrs, $prefix ), $expectedResult );
	}

	public function buildTagAttributesDataProvider() {
		return [
			[
				[
					'foo' => 'someValue1',
					'buzz' => 'someValue2',
					'style' => 'beforeSanitize',
				],
				null,
				[
					'foo' => 'someValue1',
					'style' => 'sanitized',
				]
			], [
				[
					'foo' => 'someValue1',
					'buzz' => 'someValue2',
					'style' => 'beforeSanitize',
				],
				'wikia',
				[
					'wikia-foo' => 'someValue1',
					'style' => 'sanitized',
				]
			]
		];
	}
}
