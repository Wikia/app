<?php

/**
 * @group Integration
 */
class UserStatsServiceIntegrationTest extends WikiaDatabaseTest {

	const USER_NO_EDITS_ID = 1;
	const USER_WITH_EDITS_ID = 2;

	public function testEditCountSetToOneOnFirstLocalEditOfUser() {
		$userStatsService = new UserStatsService( static::USER_NO_EDITS_ID );

		$stats = $userStatsService->getStats();

		$this->assertNull( $stats['firstContributionTimestamp'] );
		$this->assertNull( $stats['lastContributionTimestamp'] );
		$this->assertEquals( 0, $stats['editcount'] );
		$this->assertEquals( 0, $stats['editcountThisWeek'] );

		$userStatsService->increaseEditsCount();

		$stats = $userStatsService->getStats();

		$this->assertEquals( 1, $stats['editcount'] );
		$this->assertEquals( 1, $stats['editcountThisWeek'] );

		$now = ( new DateTime() )->format( 'Y-m-d H:i' );

		$firstContributionDate = new DateTime( $stats['firstContributionTimestamp'] );
		$lastContributionDate = new DateTime( $stats['lastContributionTimestamp'] );

		$this->assertEquals( $now, $firstContributionDate->format( 'Y-m-d H:i' ) );
		$this->assertEquals( $now, $lastContributionDate->format( 'Y-m-d H:i' ) );
	}

	public function testEditCountIncrementedWhenUserAlreadyHasLocalEdits() {
		$userStatsService = new UserStatsService( static::USER_WITH_EDITS_ID );

		$stats = $userStatsService->getStats();

		$this->assertEquals( '20110101000000', $stats['firstContributionTimestamp'] );
		$this->assertEquals( '20180501120000', $stats['lastContributionTimestamp'] );
		$this->assertEquals( 4, $stats['editcount'] );
		$this->assertEquals( 3, $stats['editcountThisWeek'] );

		$userStatsService->increaseEditsCount();

		$stats = $userStatsService->getStats();

		$this->assertEquals( 5, $stats['editcount'] );
		$this->assertEquals( 4, $stats['editcountThisWeek'] );

		$now = ( new DateTime() )->format( 'Y-m-d H:i' );

		$lastContributionDate = new DateTime( $stats['lastContributionTimestamp'] );

		$this->assertEquals( '20110101000000', $stats['firstContributionTimestamp'] );
		$this->assertEquals( $now, $lastContributionDate->format( 'Y-m-d H:i' ) );
	}

	public function testEditCountNotSetForAnonUser() {
		$userStatsService = new UserStatsService( 0 );

		$stats = $userStatsService->getStats();

		$this->assertNull( $stats['firstContributionTimestamp'] );
		$this->assertNull( $stats['lastContributionTimestamp'] );
		$this->assertEquals( 0, $stats['editcount'] );
		$this->assertEquals( 0, $stats['editcountThisWeek'] );

		$userStatsService->increaseEditsCount();

		$stats = $userStatsService->getStats();

		$this->assertNull( $stats['firstContributionTimestamp'] );
		$this->assertNull( $stats['lastContributionTimestamp'] );
		$this->assertEquals( 0, $stats['editcount'] );
		$this->assertEquals( 0, $stats['editcountThisWeek'] );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/_fixtures/user_stats_service.yaml' );
	}
}
