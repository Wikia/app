<?php
class TagBuilderHelperTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../WeiboTag.setup.php';
		parent::setUp();
	}

	public function testBuildTagSourceQueryParams() {
		$tagBuilder = new TagBuilderHelper();
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
		$tagBuilder = new TagBuilderHelper();
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
