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
		$task->setStartAndEndBoundaries( false, false );
		$this->assertTrue( $task->isValidTask() );

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
}
