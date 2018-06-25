<?php

/**
 * @group Integration
 */
class HubServiceIntegrationTest extends WikiaDatabaseTest {

	const LIFESTYLE_VERTICAL_WIKI_ID = 1;
	const OTHER_VERTICAL_WIKI_ID = 2;

	/**
	 * @dataProvider getVerticalNameForComscoreDataProvider
	 *
	 * @param integer $cityId
	 * @param string $expectedVerticalName
	 */
	public function testGetVerticalNameForComscore( $cityId, $expectedVerticalName ) {
		$this->assertEquals( $expectedVerticalName, HubService::getVerticalNameForComscore( $cityId ) );
	}

	public function getVerticalNameForComscoreDataProvider() {
		yield 'comscore mapping — vertical: lifestyle' => [ static::LIFESTYLE_VERTICAL_WIKI_ID, 'lifestyle' ];
		yield 'comscore mapping — vertical: other' => [ static::OTHER_VERTICAL_WIKI_ID, 'lifestyle' ];
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/hub_service.yaml' );
	}
}
