<?php
/**
 * @ingroup mwabstract
 */
class WikiaRequestTest extends PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider getBoolDataProvider
	 */
	public function testGetBool($testVal, $expected) {
		$request = new WikiaRequest(['test' => $testVal]);
		$result = $request->getBool('test');
		$this->assertEquals($expected, $result);
	}

	public function getBoolDataProvider() {
		return [
			[true, true],
			[false, false],
			[0, false],
			[1, true],
			['true', true],
			['false', true], // yep this is strange but it's from MW
			['1', true],
			['0', false],
		];
	}

	/**
	 * @dataProvider getFuzzyBoolDataProvider
	 */
	public function testGetFuzzyBool($testVal, $expected) {
		$request = new WikiaRequest(['test' => $testVal]);
		$result = $request->getFuzzyBool('test');
		$this->assertEquals($expected, $result);
	}

	public function getFuzzyBoolDataProvider() {
		return [
			[true, true],
			[false, false],
			[0, false],
			[1, true],
			['true', true],
			['false', false],
			['1', true],
			['0', false],
		];
	}
}
