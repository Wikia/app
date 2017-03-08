<?php

class UserStatsTest extends PHPUnit_Framework_TestCase {
	const TEST_USER_ID = 1683;

	/** @var UserStats $userStats */
	private $userStats;

	protected function setUp() {
		parent::setUp();
		$this->userStats = new UserStats( static::TEST_USER_ID );
	}

	public function testLoadsStatPropertiesFromDB() {
		$testData = $this->getTestStats();
		/** @var PHPUnit_Framework_MockObject_MockObject|DatabaseMysqli $dbMock */
		$dbMock = $this->getMockBuilder( DatabaseMysqli::class )->getMock();

		$dbMock->expects( $this->once() )
			->method( 'select' )
			->willReturn( new FakeResultWrapper( $testData ) );

		$this->userStats->load( $dbMock );

		foreach ( UserStats::USER_STATS_PROPERTIES as $statName ) {
			$this->assertArrayHasKey( $statName, $this->userStats );
			$this->assertEquals( 123, $this->userStats[$statName] );
		}
	}

	public function testSavesStatPropertiesToDB() {
		$expectedSQL = 'UPDATE `wikia_user_properties` SET wup_value = CASE WHEN `test` THEN 123 ELSE wup_value END WHERE wup_property IN (test) AND wup_user = ' . static::TEST_USER_ID . ';';
		/** @var PHPUnit_Framework_MockObject_MockObject|DatabaseMysqli $dbMock */
		$dbMock = $this->getMockBuilder( DatabaseMysqli::class )->getMock();

		$dbMock->expects( $this->once() )
			->method( 'query' )
			->with( $expectedSQL, $this->anything() );

		$this->userStats['test'] = 123;

		$this->assertTrue( $this->userStats->needsUpdate() );

		$this->userStats->persist( $dbMock );
	}

	/**
	 * @return stdClass[]
	 */
	private function getTestStats(): array {
		$data = [];

		foreach ( UserStats::USER_STATS_PROPERTIES as $propName ) {
			$fakeRow = new stdClass();

			$fakeRow->wup_property = $propName;
			$fakeRow->wup_value = 123;

			$data[] = $fakeRow;
		}

		return $data;
	}
}
