<?php

/**
 * @group Integration
 */
class UpdateCityListTaskIntegrationTest extends WikiaDatabaseTest {
	const ADOPTABLE_WIKI_ID = 1;
	const NON_ADOPTABLE_WIKI_ID = 2;

	const ADMIN_USER_ID = 1;
	const NOT_ADMIN_USER_ID = 2;

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
		$this->updateCityListTask->wikiId( static::ADOPTABLE_WIKI_ID )
			->updateLastTimestamp( '20171201000000' );

		$queryTable = $this->getConnection()->createQueryTable(
			'city_list', 'SELECT city_id, city_last_timestamp FROM city_list'
		);

		$expectedTable = $this->createYamlDataSet( __DIR__ . '/fixtures/state_updated_timestamp.yaml' )
			->getTable( 'city_list' );

		$this->assertTablesEqual( $expectedTable, $queryTable );
	}

	/**
	 * @dataProvider provideUserIds
	 * @param int $userId
	 */
	public function testWikiIsNotAdoptableWhenItHasOverThousandEdits( int $userId ) {
		$this->updateCityListTask->wikiId( static::ADOPTABLE_WIKI_ID )
			->checkIfWikiIsStillAdoptable( $userId );

		$queryTable = $this->getConnection()->createQueryTable(
			'city_list', 'SELECT city_id, city_flags FROM city_list'
		);

		$expectedTable = $this->createYamlDataSet( __DIR__ . '/fixtures/state_no_wiki_is_adoptable.yaml' )
			->getTable( 'city_list' );

		$this->assertTablesEqual( $expectedTable, $queryTable );
	}

	public function provideUserIds(): Generator {
		yield [ static::ADMIN_USER_ID ];
		yield [ static::NOT_ADMIN_USER_ID ];
		yield [ 0 ];
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/state_initial.yaml' );
	}
}
