<?php
class WikiaTagBuilderHelperTests extends WikiaBaseTest {

	public function setUp() {
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

	public function testBuildTagAttributes() {
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

		$passedAttrs = [
			'foo' => 'someValue1',
			'buzz' => 'someValue2',
			'style' => 'beforeSanitize',
		];

		$expectedResult = [
			'foo' => 'someValue1',
			'style' => 'sanitized',
		];

		$this->assertSame( $tagBuilder->buildTagAttributes( $allowedAttrs, $passedAttrs ), $expectedResult );
	}
}
