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
	 * @param $useYui
	 * @throws Exception
	 * @dataProvider minifyDataProvider
	 */
	public function testMinify($useYui) {
		$compressed = AssetsManagerBaseBuilder::minifyJS( self::JS_CODE, $useYui );

		$this->assertNotContains( 'Hello', $compressed );
		$this->assertNotContains( 'comment', $compressed );
		$this->assertContains( 'function foo', $compressed );
	}

	public function minifyDataProvider() {
		return [
			'jsmin' => [ false ],
			'yui' => [ true ],
		];
	}
}