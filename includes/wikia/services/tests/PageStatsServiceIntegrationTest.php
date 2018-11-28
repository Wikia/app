<?php

/**
 * @group Integration
 */
class PageStatsServiceIntegrationTest extends WikiaDatabaseTest {

	const TEST_ARTICLE_ID = 1;

	public function testGetFirstRevisionTimestamp() {
		$pageStatsService = new PageStatsService( Title::newFromID( static::TEST_ARTICLE_ID ) );

		$this->assertEquals( '20110101000000', $pageStatsService->getFirstRevisionTimestamp() );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/page_stats_service.yaml' );
	}
}
