<?php

class WikiaRequestTest extends WikiaBaseTest {

	public function testGetBool() {
		$testCases = [
			// params for request, expected value, default param to getBool
			[[], true, true],
			[[], false, false],
			[[], true, 1],
			[[], false, 0],
			[[], false, null],
			[[], false, ""],
			[[], true, "test"],
			[['param' => true], true, false],
			[['param' => false], false, true],
			[['param' => null], false, false],
			[['param' => "true"], true, false],
			[['param' => "false"], false, true],
			[['param' => "false"], false, false],
			[['param' => 0], false, true],
			[['param' => 1], true, false]
		];
		foreach ($testCases as $tc) {
			$r = new WikiaRequest($tc[0]);
			$this->assertEquals($tc[1], $r->getBool('param', $tc[2]),
					'Expected new WikiaRequest('.	var_export($tc[0], true).")->getBool(\"param\", ".
					var_export($tc[2], true).") to be ".var_export($tc[1], true)."\n");		
		}
	}
}
