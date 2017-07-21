<?php

namespace SMW\Scribunto\Tests;

use SMW\Scribunto\LibraryFactory;

/**
 * @covers \SMW\Scribunto\LibraryFactory
 * @group semantic-scribunto
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class LibraryFactoryTest extends \PHPUnit_Framework_TestCase {

	private $store;
	private $parser;

	protected function setUp() {

		$language = $this->getMockBuilder( '\Language' )
			->disableOriginalConstructor()
			->getMock();

		$queryResult = $this->getMockBuilder( '\SMWQueryResult' )
			->disableOriginalConstructor()
			->getMock();

		$this->store = $this->getMockBuilder( '\SMW\Store' )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$this->store->expects( $this->any() )
			->method( 'getQueryResult' )
			->will( $this->returnValue( $queryResult ) );

		$this->parser = $this->getMockBuilder( '\Parser' )
			->disableOriginalConstructor()
			->getMock();

		$this->parser->expects( $this->any() )
			->method( 'getTitle' )
			->will( $this->returnValue( \Title::newFromText( 'Foo' ) ) );

		$this->parser->expects( $this->any() )
			->method( 'getOutput' )
			->will( $this->returnValue( new \ParserOutput() ) );

		$this->parser->expects( $this->any() )
			->method( 'getTargetLanguage' )
			->will( $this->returnValue( $language ) );
	}

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\SMW\Scribunto\LibraryFactory',
			new LibraryFactory( $this->store )
		);
	}

	public function testCanConstructQueryResult() {

		$instance = new LibraryFactory(
			$this->store
		);

		$this->assertInstanceOf(
			'\SMWQueryResult',
			$instance->newQueryResultFrom( [ '[[Foo::Bar]]' ] )
		);
	}

	public function testCanConstructParserParameterProcessor() {

		$instance = new LibraryFactory(
			$this->store
		);

		$this->assertInstanceOf(
			'\SMW\ParserParameterProcessor',
			$instance->newParserParameterProcessorFrom( [ '' ] )
		);
	}

	public function testCanConstructSetParserFunction() {

		$instance = new LibraryFactory(
			$this->store
		);

		$this->assertInstanceOf(
			'\SMW\ParserFunctions\SetParserFunction',
			$instance->newSetParserFunction( $this->parser )
		);
	}

	public function testCanConstructSubobjectParserFunction() {

		$instance = new LibraryFactory(
			$this->store
		);

		$this->assertInstanceOf(
			'\SMW\ParserFunctions\SubobjectParserFunction',
			$instance->newSubobjectParserFunction( $this->parser )
		);
	}

	public function testCanConstructLuaAskResultProcessor() {

		$queryResult = $this->getMockBuilder( '\SMWQueryResult' )
			->disableOriginalConstructor()
			->getMock();

		$instance = new LibraryFactory(
			$this->store
		);

		$this->assertInstanceOf(
			'\SMW\Scribunto\LuaAskResultProcessor',
			$instance->newLuaAskResultProcessor( $queryResult )
		);
	}

}
