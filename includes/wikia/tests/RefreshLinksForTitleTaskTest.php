<?php

use Wikia\Tasks\Tasks\RefreshLinksForTitleTask;
use PHPUnit\Framework\TestCase;

class RefreshLinksForTitleTaskTest extends TestCase {

	public function testRefreshGetRevisionFromTitle() {
		$task = $this->getMockBuilder( RefreshLinksForTitleTask::class )
			->setMethods( [ 'getRevisionFromTitle' ] )
			->getMock();
		$title = $this->createMock( Title::class );

		$task->setTitle( $title );

		$task->expects( $this->once() )
			->method( 'getRevisionFromTitle' )
			->will( $this->returnValue( null ) );

		$this->assertFalse( $task->refresh() );
	}

	public function testRefreshCallsMocked() {
		$task = $this->getMockBuilder( RefreshLinksForTitleTask::class )
			->setMethods( [ 'getRevisionFromTitle', 'parseRevisionAndUpdateLinks' ] )
			->getMock();
		$title = $this->createMock( Title::class );
		$revision = $this->createMock( Revision::class );

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
		$task = $this->getMockBuilder( RefreshLinksForTitleTask::class )
			->setMethods( [ 'getParser', 'getParserOptions', 'updateLinks' ] )
			->getMock();
		$title = $this->createMock( Title::class );
		$parser = $this->createMock( Parser::class );
		$parserOptions = $this->createMock( ParserOptions::class );
		$revision = $this->createMock( Revision::class );

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
