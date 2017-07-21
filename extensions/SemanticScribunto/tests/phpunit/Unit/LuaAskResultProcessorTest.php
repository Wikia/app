<?php

namespace SMW\Scribunto\Tests;

use \SMW\Scribunto\LuaAskResultProcessor;
use \SMWQueryResult;
use \SMW\Query\PrintRequest;
use \SMWResultArray;
use \SMWNumberValue;

/**
 * @covers \SMW\Scribunto\LuaAskResultProcessor
 * @group semantic-scribunto
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author Tobias Oetterer
 */
class LuaAskResultProcessorTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Holds a mock of a query result for this test
	 *
	 * @var \SMWQueryResult
	 */
	private $queryResult;

	/**
	 * Set-up method prepares a mock {@see \SMWQueryResult}
	 */
	protected function setUp() {

		parent::setUp();

		$this->queryResult = $this->getMockBuilder( SMWQueryResult::class )
			->disableOriginalConstructor()
			->getMock();

		$this->queryResult->expects( $this->any() )
			->method( 'getNext' )
			->will( $this->onConsecutiveCalls( [ $this->constructResultArray() ], false ) );

		$this->queryResult->expects( $this->any() )
			->method( 'getCount' )
			->will( $this->returnValue( 1 ) );

	}

	/**
	 * Test, if the constructor works
	 *
	 * @see \SMW\Scribunto\LuaAskResultProcessor::__construct
	 *
	 * @uses $queryResult
	 *
	 * @return void
	 */
	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\SMW\Scribunto\LuaAskResultProcessor',
			new LuaAskResultProcessor(
				$this->queryResult
			)
		);
	}

	/**
	 * Tests the conversion of a {@see \SMWQueryResult} in a lua table
	 *
	 * @see \SMW\Scribunto\LuaAskResultProcessor::getQueryResultAsTable
	 *
	 * @uses $queryResult, \SMW\Scribunto\LuaAskResultProcessor::getQueryResultAsTable
	 *
	 * @return void
	 */
	public function testGetQueryResultAsTable() {

		$instance = new LuaAskResultProcessor( $this->queryResult );

		$result = $instance->getQueryResultAsTable();

		$this->assertInternalType(
			'array',
			$result
		);

		$this->assertEquals(
			1,
			count( $result )
		);
	}

	/**
	 * Tests the data extraction from a result row
	 *
	 * @see \SMW\Scribunto\LuaAskResultProcessor::getDataFromQueryResultRow
	 *
	 * @uses $queryResult, constructResultArray, \SMW\Scribunto\LuaAskResultProcessor::getDataFromQueryResultRow
	 *
	 * @return void
	 */
	public function testGetDataFromQueryResultRow() {

		$instance = new LuaAskResultProcessor( $this->queryResult );

		$resultRow = [ $this->constructResultArray() ];

		$result = $instance->getDataFromQueryResultRow( $resultRow );

		$this->assertInternalType( 'array', $result );

		$this->assertEquals( 1, count( $result ) );
	}

	/**
	 * Tests the retrieval of a key (string label or numeric index) from
	 * a print request
	 *
	 * @see \SMW\Scribunto\LuaAskResultProcessor::getKeyFromPrintRequest
	 *
	 * @uses $queryResult
	 *
	 * @return void
	 */
	public function testGetKeyFromPrintRequest() {

		$instance = new LuaAskResultProcessor( $this->queryResult );

		$printRequest = $this->constructPrintRequest();

		$printRequest->expects( $this->any() )
			->method( 'getLabel' )
			->will( $this->returnValue( 'label' ) );

		$printRequest->expects( $this->any() )
			->method( 'getText' )
			->will( $this->returnValue( 'label' ) );

		$printRequest2 = $this->constructPrintRequest();

		$printRequest2->expects( $this->any() )
			->method( 'getLabel' )
			->will( $this->returnValue( '' ) );

		/** @noinspection PhpParamsInspection */
		$this->assertInternalType(
			'string',
			$instance->getKeyFromPrintRequest( $printRequest )
		);

		/** @noinspection PhpParamsInspection */
		$this->assertEquals(
			'label',
			$instance->getKeyFromPrintRequest( $printRequest )
		);

		/** @noinspection PhpParamsInspection */
		$this->assertInternalType(
			'integer',
			$instance->getKeyFromPrintRequest( $printRequest2 )
		);

		/** @noinspection PhpParamsInspection */
		$this->assertGreaterThan(
			0,
			$instance->getKeyFromPrintRequest( $printRequest2 )
		);
	}

	/**
	 * Tests the extraction of data from a SMWResultArray
	 *
	 * @see \SMW\Scribunto\LuaAskResultProcessor::getDataFromResultArray
	 *
	 * @uses $queryResult, constructResultArray, \SMW\Scribunto\LuaAskResultProcessor::getDataFromResultArray
	 *
	 * @return void
	 */
	public function testGetDataFromResultArray() {

		$instance = new LuaAskResultProcessor( $this->queryResult );

		$resultArray = $this->constructResultArray();

		/** @noinspection PhpParamsInspection */
		$this->assertInternalType(
			'array',
			$instance->getDataFromResultArray( $resultArray )
		);
	}

	/**
	 * Tests data value extraction. Uses data provider {@see dataProvidergetValueFromDataValueTest}
	 * @dataProvider dataProvidergetValueFromDataValueTest
	 *
	 * @param string $class name of data value class
	 * @param string $type data value type
	 * @param string $expects return value type
	 *
	 * @see \SMW\Scribunto\LuaAskResultProcessor::getValueFromDataValue
	 *
	 * @uses $queryResult, dataProvidergetValueFromDataValueTest
	 *
	 * @return void
	 */
	public function testgetValueFromDataValue( $class, $type, $expects ) {

		$instance = new LuaAskResultProcessor( $this->queryResult );

		$dataValue = $this->getMockBuilder( '\\' . $class )
			->setConstructorArgs( [ $type ] )
			->getMock();

		$dataValue->expects( $this->any() )
			->method( 'getTypeID' )
			->will( $this->returnValue( $type ) );


		/** @noinspection PhpParamsInspection */
		$this->assertInternalType(
			$expects,
			$instance->getValueFromDataValue( $dataValue )
		);
	}

	/**
	 * Tests the conversion of a list of result values into a value, usable in lua.
	 * Uses data provider {@see dataProviderExtractLuaDataFromDVData}
	 * @dataProvider dataProviderExtractLuaDataFromDVData
	 *
	 * @param mixed $expects expected return value
	 * @param array $input input for method
	 *
	 * @see \SMW\Scribunto\LuaAskResultProcessor::extractLuaDataFromDVData
	 *
	 * @uses $queryResult
	 *
	 * @return void
	 */
	public function testExtractLuaDataFromDVData( $expects, $input ) {

		$instance = new LuaAskResultProcessor( $this->queryResult );

		$this->assertEquals(
			$expects,
			$instance->extractLuaDataFromDVData( $input )
		);
	}

	/**
	 * Tests the generation of a numeric index key
	 *
	 * @see \SMW\Scribunto\LuaAskResultProcessor::getNumericIndex
	 *
	 * @uses $queryResult
	 *
	 * @return void
	 */
	public function testGetNumericIndex() {

		$instance = new LuaAskResultProcessor( $this->queryResult );

		$this->assertInternalType(
			'integer',
			$instance->getNumericIndex()
		);

		$this->assertGreaterThan(
			1,
			$instance->getNumericIndex()
		);
	}

	/**
	 * Data provider for {@see testgetValueFromDataValue}
	 *
	 * @see testgetValueFromDataValue
	 *
	 * @return array
	 */
	public function dataProvidergetValueFromDataValueTest() {

		return [
			[ 'SMWNumberValue', '_num', 'integer' ],
			[ 'SMWWikiPageValue', '_wpg', 'null' ],
			[ 'SMWStringValue', '_boo', 'boolean' ],
			[ 'SMWTimeValue', '_dat', 'null' ],
		];
	}

	/**
	 * Data provider for {@see testExtractLuaDataFromDVData}
	 *
	 * @see testExtractLuaDataFromDVData
	 *
	 * @return array
	 */
	public function dataProviderExtractLuaDataFromDVData() {
		return [
			[ null, [] ],
			[ 42, [ 42 ] ],
			[ [ 'foo', 'bar' ], [ 'foo', 'bar' ] ]
		];
	}

	/**
	 * Constructs a mock {@see \SMWResultArray}
	 *
	 * @return \PHPUnit_Framework_MockObject_MockObject
	 */
	private function constructResultArray() {

		$resultArray = $this->getMockBuilder( SMWResultArray::class )
			->disableOriginalConstructor()
			->getMock();

		$resultArray->expects( $this->any() )
			->method( 'getPrintRequest' )
			->will( $this->returnValue(
				$this->constructPrintRequest()
			) );

		$resultArray->expects( $this->any() )
			->method( 'getNextDataValue' )
			->will( $this->onConsecutiveCalls(
				$this->constructSMWNumberValue(),
				false
			) );

		return $resultArray;
	}

	/**
	 * Constructs a mock {@see \SMW\Query\PrintRequest}
	 *
	 * @return \PHPUnit_Framework_MockObject_MockObject
	 */
	private function constructPrintRequest() {

		$printRequest = $this->getMockBuilder( PrintRequest::class )
			->disableOriginalConstructor()
			->getMock();

		return $printRequest;
	}


	/**
	 * Constructs a mock {@see \SMWNumberValue}
	 *
	 * @return \PHPUnit_Framework_MockObject_MockObject
	 */
	private function constructSMWNumberValue() {

		$printRequest = $this->getMockBuilder( SMWNumberValue::class )
			->setConstructorArgs( [ '_num' ] )
			->getMock();

		return $printRequest;
	}
}
