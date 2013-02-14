<?php

class WAMServiceTest extends WikiaBaseTest {

	protected function getReflectionMethod ($name) {
		$class = new ReflectionClass('WAMService');
		$method = $class->getMethod($name);
		$method->setAccessible(true);
		return $method;
	}

	/**
	 * @dataProvider testGetWamIndexConditionsDataProvider
	 */
	public function testGetWamIndexConditions ($currentTimestamp, $previousTimestamp, $wikiId, $verticalId, $langCode, $wikiWord, $expConds) {
		$getWamIndexConditions = $this->getReflectionMethod('getWamIndexConditions');
		$dataMartService = new WAMService();
		$actConds = $getWamIndexConditions->invoke($dataMartService, $currentTimestamp, $previousTimestamp, $wikiId, $verticalId, $langCode, $wikiWord);
		$this->assertEquals($expConds, $actConds);
	}

	public function testGetWamIndexConditionsDataProvider () {
		return array(
			array(
				100000, 80000, null, null, null, null,
				array(
					'fw1.time_id = FROM_UNIXTIME(100000)',
					'fw2.time_id = FROM_UNIXTIME(80000)',
					'dw.hub_id' => array(2, 3, 9)
				)
			),
			array(
				1000000, 80000, null, null, null, null,
				array(
					'fw1.time_id = FROM_UNIXTIME(1000000)',
					'fw2.time_id = FROM_UNIXTIME(80000)',
					'dw.hub_id' => array(2, 3, 9)
				)
			),
			array(
				1000000, 80000, 2233, null, null, null,
				array(
					'fw1.time_id = FROM_UNIXTIME(1000000)',
					'fw2.time_id = FROM_UNIXTIME(80000)',
					'fw1.wiki_id' => 2233,
					'dw.hub_id' => array(2, 3, 9)
				)
			),
			array(
				1000000, 80000, 2233, 1, null, null,
				array(
					'fw1.time_id = FROM_UNIXTIME(1000000)',
					'fw2.time_id = FROM_UNIXTIME(80000)',
					'fw1.wiki_id' => 2233,
					'dw.hub_id' => 1
				)
			),
		);
	}
}
