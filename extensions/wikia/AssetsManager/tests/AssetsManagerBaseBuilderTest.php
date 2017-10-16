<?php

/**
 * @group Infrastructure
 */
class AssetsManagerBaseBuilderTest extends WikiaBaseTest {

	const JS_CODE = <<<JS
/**
 * Hello
 * @returns {string}
 */
function foo() {
	// comment
	return 'bar';
}
JS;

	/**
	 * @throws Exception
	 */
	public function testMinify() {
		$compressed = AssetsManagerBaseBuilder::minifyJS( self::JS_CODE );

		$this->assertNotContains( 'Hello', $compressed );
		$this->assertNotContains( 'comment', $compressed );
		$this->assertContains( 'function foo', $compressed );
	}
}
