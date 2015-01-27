<?php

use Wikia\Tasks\Tasks\BatchRefreshLinksForTemplate;

class BatchRefreshLinksForTemplateTest extends PHPUnit_Framework_TestCase {

	public function testIsValidTask() {
		$start = 1;
		$end   = 2;

		$task = new BatchRefreshLinksForTemplate();
		$task->setStartAndEndBoundaries( null, null );
		$this->assertFalse( $task->isValidTask() );

		$task = new BatchRefreshLinksForTemplate();
		$task->setStartAndEndBoundaries( $start, $start );
		$this->assertTrue( $task->isValidTask() );
	}

	public function testGetTitlesWithBackLinks() {
		$start = 1;
		$end   = 10;
		$result = array( 'foo' );

		$task = new BatchRefreshLinksForTemplate();
		$task->setStartAndEndBoundaries( $start, $end );

		$title = $this->getMock( '\Title', ['getLinksFromBacklinkCache'] );
		$title->expects( $this->once() )
			->method( 'getLinksFromBacklinkCache' )
			->with( BatchRefreshLinksForTemplate::BACKLINK_CACHE_TABLE, $start, $end )
			->will( $this->returnValue( $result ) );

		$task->setTitle( $title );

		$this->assertEquals( $result, $task->getTitlesWithBackLinks() );
	}

	public function testEnqueueRefreshLinksForTitles() {
		$start = 1;
		$end   = 2;
		$task = $this->getMock( 'Wikia\Tasks\Tasks\BatchRefreshLinksForTemplate', [
			'enqueueRefreshLinksForTitleTask',
			'readyRefreshLinksForTitleTask',
			'batchEnqueue'
			], [], '', false );
		$task->setStartAndEndBoundaries( $start, $end );

		$times = 3;
		$titles = array();
		$fakeBatchJobs = array();
		for ( $i = 0; $i < $times; $i++ ) {
			$fakeBatchJobs[] = $times;
			$titles[] = $this->getMock( '\Title' );
		}

		$task->expects( $this->exactly( $times ) )
			->method( 'readyRefreshLinksForTitleTask' )
			->with( $this->logicalOr( $titles[0], $titles[1], $titles[2] ) )
			->will( $this->returnValue( $times ) );

		$task->expects( $this->once() )
			->method( 'batchEnqueue' )
			->with( $fakeBatchJobs )
			->will( $this->returnValue( true ) );

		$task->enqueueRefreshLinksTasksForTitles( $titles );
	}

	public function testReadyRefreshLinksForTitleTask() {
		$batch = $this->getMock( 'Wikia\Tasks\Tasks\BatchRefreshLinksForTemplate', ['getWikiId'] );
		$title = $this->getMock( '\Title', ['getText'] );

		$wikiId = 5;

		$batch->expects( $this->once() )
			->method( 'getWikiId' )
			->will( $this->returnValue( $wikiId ) );

		$enqueued = $batch->readyRefreshLinksForTitleTask( $title );

		$this->assertEquals( $wikiId, $enqueued->getWikiId() );
	}

	public function testRefreshTemplateLinks() {
		$start = 1;
		$end   = 2;
		$title = $this->getMock( '\Title', ['getLinksFromBacklinkCache'] );
		$titles = [$title];
		$task = $this->getMock( 'Wikia\Tasks\Tasks\BatchRefreshLinksForTemplate', [
			'clearLinkCache',
			'enqueueRefreshLinksTasksForTitles'
			], [], '', false );

		$title->expects( $this->once() )
			->method( 'getLinksFromBacklinkCache' )
			->with( BatchRefreshLinksForTemplate::BACKLINK_CACHE_TABLE, $start, $end )
			->will( $this->returnValue( $titles ) );

		$task->expects( $this->once() )
			->method( 'clearLinkCache' )
			->will( $this->returnValue( true ) );

		$task->expects( $this->once() )
			->method( 'enqueueRefreshLinksTasksForTitles' )
			->with( $titles )
			->will( $this->returnValue( true ) );

		$task->setTitle( $title );

		$this->assertTrue( $task->refreshTemplateLinks( $start, $end ) );
	}
}
