<?php

/**
 * @group Integration
 */
class UpdateCityListTaskIntegrationTest extends WikiaDatabaseTest {
	const WIKI_ID = 1;

	/** @var UpdateCityListTask $updateCityListTask */
	private $updateCityListTask;

	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();
		require_once __DIR__ . '/../CityList.setup.php';

		static::loadSchemaFile( __DIR__ . '/fixtures/city-list.sql' );
	}

	protected function setUp() {
		parent::setUp();

		$this->updateCityListTask = new UpdateCityListTask();
	}

	public function testTimestampIsUpdated() {
		$this->updateCityListTask->wikiId( static::WIKI_ID )
			->updateLastTimestamp( '20171201000000' );

		$queryTable = $this->getConnection()->createQueryTable(
			'city_list', 'SELECT city_id, city_last_timestamp FROM city_list'
		);

		$expectedTable = $this->createYamlDataSet( __DIR__ . '/fixtures/state_updated_timestamp.yaml' )
			->getTable( 'city_list' );

		$this->assertTablesEqual( $expectedTable, $queryTable );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/state_initial.yaml' );
	}
}
