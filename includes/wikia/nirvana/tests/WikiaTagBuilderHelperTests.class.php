<?php
class WikiaTagBuilderHelperTests extends WikiaBaseTest {

	public function setUp() {
		parent::setUp();
	}

	public function testBuildTagSourceQueryParams() {
		$tagBuilder = new WikiaTagBuilderHelper();
		$allowedParams = [
			'foo' => 'before',
			'bar' => '',
		];

		$passedParams = [
			'fizz' => 'value',
			'buzz' => 'value2',
			'foo' => 'after',
		];

		$expectedResult = 'foo=after&bar=';

		$this->assertEquals( $tagBuilder->buildTagSourceQueryParams($allowedParams, $passedParams), $expectedResult );
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

		$this->assertSame( $tagBuilder->buildTagAttributes($allowedAttrs, $passedAttrs), $expectedResult );
	}
}
