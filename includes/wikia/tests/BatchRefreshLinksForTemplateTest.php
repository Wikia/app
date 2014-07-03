<?php

use Wikia\Tasks\Tasks\BatchRefreshLinksForTemplate;

class BatchRefreshLinksForTemplateTest extends PHPUnit_Framework_TestCase {

	public function testIsValidTask() {
		$title = $this->getMock( '\Title' );
		$start = 1;
		$end   = 2;

		$task = new BatchRefreshLinksForTemplate();
		$task->setStartAndEndBoundaries( null, null );
		$this->assertFalse( $task->isValidTask() );

		$task = new BatchRefreshLinksForTemplate();
		$task->setStartAndEndBoundaries( $start, $start );
		$this->assertFalse( $task->isValidTask() );

		$task = new BatchRefreshLinksForTemplate();
		$task->setStartAndEndBoundaries( $start, $start );
		$task->setTitle( $title );
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
		$task = $this->getMock( 'Wikia\Tasks\Tasks\BatchRefreshLinksForTemplate', ['enqueueRefreshLinksForTitleTask'], [], '', false );
		$task->setStartAndEndBoundaries( $start, $end );

		$times = 3;
		$titles = array();
		for ( $i = 0; $i < 3; $i++ ) {
			$titles[] = $this->getMock( '\Title' );
		}

		$task->expects( $this->exactly( $times ) )
			->method( 'enqueueRefreshLinksForTitleTask' )
			->with( $this->logicalOr( $titles[0], $titles[2], $titles[3] ) );

		$task->enqueueRefreshLinksTasksForTitles( $titles );
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
