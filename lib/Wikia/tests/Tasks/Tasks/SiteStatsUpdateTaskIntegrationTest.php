<?php

namespace Wikia\Tasks\Tasks;

/**
 * @group Integration
 */
class SiteStatsUpdateTaskIntegrationTest extends \WikiaDatabaseTest {

	/** @var SiteStatsUpdateTask $task */
	private $task;

	protected function setUp() {
		parent::setUp();

		$this->task = new SiteStatsUpdateTask();
	}

	public function testShouldUpdateEditCountAndTotalPageCountForNewNonContentPage() {
		$title = \Title::makeTitle( NS_TALK, 'I am the talk page' );

		$this->task->setTitle( $title );
		$this->task->onArticleEdit( true, false );

		\SiteStats::load( true );

		$this->assertEquals( 1, \SiteStats::pages(), 'Total page count should be updated' );
		$this->assertEquals( 1, \SiteStats::edits(), 'Edit count should be updated' );
		$this->assertEquals( 0, \SiteStats::articles(), 'Content page count should stay the same' );
	}

	public function testShouldUpdateEditCountContentPageCountAndTotalPageCountForNewContentPage() {
		$title = \Title::makeTitle( NS_MAIN, 'I am the content page' );

		$this->task->setTitle( $title );
		$this->task->onArticleEdit( true, true );

		\SiteStats::load( true );

		$this->assertEquals( 1, \SiteStats::pages(), 'Total page count should be updated' );
		$this->assertEquals( 1, \SiteStats::edits(), 'Edit count should be updated' );
		$this->assertEquals( 1, \SiteStats::articles(), 'Content page count should be updated' );
	}

	/**
	 * @dataProvider provideTitles
	 * @param \Title $title
	 * @param bool $wasContentPage
	 */
	public function testShouldOnlyUpdateEditCountWhenPageAlreadyExisted( \Title $title, bool $wasContentPage ) {
		$this->task->setTitle( $title );
		$this->task->onArticleEdit( false, $wasContentPage );

		\SiteStats::load( true );

		$this->assertEquals( 0, \SiteStats::pages(), 'Total page count should not be updated' );
		$this->assertEquals( 1, \SiteStats::edits(), 'Edit count should be updated' );
		$this->assertEquals( 0, \SiteStats::articles(), 'Content page count should be updated' );
	}

	public function provideTitles() {
		yield [ \Title::makeTitle( NS_TALK, 'I am the talk page' ), false ];
		yield [ \Title::makeTitle( NS_MAIN, 'I am the content page' ), true ];
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/site_stats_update.yaml' );
	}
}
