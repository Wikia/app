<?php

use Wikia\Tasks\Tasks\BatchRefreshLinksForTemplate;

class BatchRefreshLinksForTemplateTest extends PHPUnit_Framework_TestCase {

	public function testBatchRefreshLinksForTemplateSerialize() {
		$start = 1;
		$end   = 10;

		$task = new BatchRefreshLinksForTemplate( $start, $end );
		$serializedTask = serialize( $task );

		$unserializedTask = unserialize( $serializedTask );
		$this->assertEquals( $start, $unserializedTask->getStart() );
		$this->assertEquals( $end, $unserializedTask->getEnd() );
	}

	public function testIsValidTask() {
		$title = $this->getMock( '\Title' );
		$start = 1;
		$end   = 2;

		$task = new BatchRefreshLinksForTemplate( null, null );
		$this->assertFalse( $task->isValidTask() );

		$task = new BatchRefreshLinksForTemplate( $start, $end );
		$this->assertFalse( $task->isValidTask() );

		$task = new BatchRefreshLinksForTemplate( $start, $end );
		$task->setTitle( $title );
		$this->assertTrue( $task->isValidTask() );
	}

	public function testGetTitlesWithBackLinks() {
		$start = 1;
		$end   = 10;
		$result = array( 'foo' );

		$task = new BatchRefreshLinksForTemplate( $start, $end );

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
		$task = $this->getMock( 'Wikia\Tasks\Tasks\BatchRefreshLinksForTemplate', ['enqueueRefreshLinksForTitleTask'], [$start, $end], '', true );
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
		$titles = [$this->getMock( '\Title' )];
		$task = $this->getMock( 'Wikia\Tasks\Tasks\BatchRefreshLinksForTemplate', [
			'isValidTask',
			'clearLinkCache',
			'getTitlesWithBackLinks',
			'enqueueRefreshLinksTasksForTitles'
			], [$start, $end], '', true );

		$task->expects($this->once())
			->method('isValidTask')
			->will($this->returnValue(true));

		$task->expects($this->once())
			->method('clearLinkCache')
			->will($this->returnValue(true));

		$task->expects($this->once())
			->method('getTitlesWithBackLinks')
			->will($this->returnValue($titles));

		$task->expects($this->once())
			->method('enqueueRefreshLinksTasksForTitles')
			->with($titles)
			->will($this->returnValue(true));

		$task->refreshTemplateLinks();

	}
}
