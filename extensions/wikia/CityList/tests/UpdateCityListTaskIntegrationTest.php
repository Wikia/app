<?php

/**
 * @group Integration
 */
class UpdateCityListTaskIntegrationTest extends WikiaDatabaseTest {

	const WIKI_ID = 1;
	const OTHER_WIKI_ID = 2;

	/** @var UpdateCityListTask $updateCityListTask */
	private $updateCityListTask;

	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();
		require_once __DIR__ . '/../CityList.setup.php';
	}

	protected function setUp() {
		parent::setUp();

		$this->updateCityListTask = new UpdateCityListTask();
	}

	public function testTimestampIsUpdated() {
		$ts = '20171201000000';
		$this->updateCityListTask->wikiId( static::WIKI_ID )
			->updateLastTimestamp( $ts );

		$thisWiki = WikiFactory::getWikiByID( static::WIKI_ID );
		$thatWiki = WikiFactory::getWikiByID( static::OTHER_WIKI_ID );

		$this->assertEquals( $ts, wfTimestamp( TS_MW, $thisWiki->city_last_timestamp ) );
		$this->assertNotEquals( $ts, wfTimestamp( TS_MW, $thatWiki->city_last_timestamp ) );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/update_city_list.yaml' );
	}
}
