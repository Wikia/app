<?php

use Wikia\Tasks\Tasks\RefreshLinksForTitleTask;

class RefreshLinksForTitleTaskTest extends PHPUnit_Framework_TestCase {

	public function testRefreshGetRevisionFromTitle() {
		$task = $this->getMock( 'Wikia\Tasks\Tasks\RefreshLinksForTitleTask', ['getRevisionFromTitle'], [], '', false );
		$title = $this->getMock( '\Title' );

		$task->setTitle( $title );

		$task->expects( $this->once() )
			->method( 'getRevisionFromTitle' )
			->will( $this->returnValue( null ) );

		$this->assertFalse( $task->refresh() );
	}

	public function testRefreshCallsMocked() {
		$task = $this->getMock( 'Wikia\Tasks\Tasks\RefreshLinksForTitleTask', ['getRevisionFromTitle', 'parseRevisionAndUpdateLinks'], [], '', false );
		$title = $this->getMock( '\Title' );
		$revision = $this->getMock( '\Revision', [], [], '', false );

		$task->setTitle( $title );

		$task->expects( $this->once() )
			->method( 'getRevisionFromTitle' )
			->will( $this->returnValue( $revision ) );

		$task->expects( $this->once() )
			->method( 'parseRevisionAndUpdateLinks' )
			->with( $revision )
			->will( $this->returnValue( true ) );

		$this->assertTrue( $task->refresh() );
	}

	public function testParseRevisionAndUpdateLinks() {
		$task = $this->getMock( 'Wikia\Tasks\Tasks\RefreshLinksForTitleTask', ['getParserOptions', 'getParser', 'updateLinks'], [], '', false );
		$title = $this->getMock( '\Title' );
		$parser = $this->getMock( '\Parser' );
		$parserOptions = $this->getMock( '\ParserOptions', [], [], '', false );
		$revision = $this->getMock( '\Revision', [], [], '', false );

		$revisionText = 'foobar-in';
		$revisionId = 1;
		$revision->expects( $this->once() )
			->method( 'getText' )
			->will( $this->returnValue( $revisionText ) );
		$revision->expects( $this->exactly( 2 ) )
			->method( 'getId' )
			->will( $this->returnValue( $revisionId ) );

		$parserOutput = 'foobar';
		$parser->expects( $this->once() )
			->method( 'parse' )
			->with( $revisionText, $title, $parserOptions, true, true, $revisionId )
			->will( $this->returnValue( $parserOutput ) );

		$task->expects( $this->once() )
			->method( 'getParser' )
			->will( $this->returnValue( $parser ) );

		$task->expects( $this->once() )
			->method( 'getParserOptions' )
			->will( $this->returnValue( $parserOptions ) );

		$task->expects( $this->once() )
			->method( 'updateLinks' )
			->with( $parserOutput );

		$task->setTitle( $title );

		$task->parseRevisionAndUpdateLinks( $revision );
	}


}
