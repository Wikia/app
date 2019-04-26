<?php
namespace Wikia\Search\Test;
use \Wikia\Search\Config, \Solarium_Query_Select, \ReflectionProperty, \ReflectionMethod;
use Wikia\Search\MediaWikiService;
use Wikia\Search\Query\Select;

/**
 * Tests for Config class
 */
class SearchResultViewTest extends BaseTest {

	protected function setUp() {
		parent::setUp();
	}

//	/**
//	 * @group Slow
//	 * @slowExecutionTime 0.07596 ms
//	 * @covers \Wikia\Search\Config::getTruncatedResultsNum
//	 */
//	public function testGetTruncatedResultsNum() {
//		$config = $this->getMock( 'Wikia\\Search\\Config', [ 'getResultsFound', 'getService' ] );
//
//		$singleDigit = 9;
//
//		$config
//			->expects( $this->at( 0 ) )
//			->method ( 'getResultsFound' )
//			->will   ( $this->returnValue( $singleDigit ) )
//		;
//
//
//		$this->assertEquals(
//			$singleDigit,
//			$config->getTruncatedResultsNum(),
//			"We should not truncate a single digit result number value."
//		);
//
//		$doubleDigit = 26;
//
//		$config
//			->expects( $this->at( 0 ) )
//			->method ( 'getResultsFound' )
//			->will   ( $this->returnValue( $doubleDigit ) )
//		;
//
//		$this->assertEquals(
//			30,
//			$config->getTruncatedResultsNum(),
//			"We should round only for double digits."
//		);
//
//		$tripleDigit = 492;
//
//		$config
//			->expects( $this->at( 0 ) )
//			->method ( 'getResultsFound' )
//			->will   ( $this->returnValue( $tripleDigit ) )
//		;
//
//		$this->assertEquals(
//			500,
//			$config->getTruncatedResultsNum(),
//			"We should round to hundreds for triple digits."
//		);
//
//		$bigDigit = 55555;
//
//		$config
//			->expects( $this->at( 0 ) )
//			->method ( 'getResultsFound' )
//			->will   ( $this->returnValue( $bigDigit ) )
//		;
//
//		$this->assertEquals(
//			56000,
//			$config->getTruncatedResultsNum(),
//			"Larger digits should round to the nearest n-1 radix."
//		);
//
//		$service = $this->service->setMethods( array( 'formatNumber' ) )->getMock();
//		$service
//			->expects( $this->once() )
//			->method ( 'formatNumber' )
//			->with   (56000)
//			->will   ( $this->returnValue( '56,000' ) )
//		;
//		$config
//			->expects( $this->at( 0 ) )
//			->method ( 'getResultsFound' )
//			->will   ( $this->returnValue( $bigDigit ) )
//		;
//		$config
//			->expects( $this->at( 1 ) )
//			->method ( 'getService' )
//			->will   ( $this->returnValue( $service ) )
//		;
//		$this->assertEquals(
//			'56,000',
//			$config->getTruncatedResultsNum( true )
//		);
//
//	}
//
//	/**
//	 * @group Slow
//	 * @slowExecutionTime 0.07473 ms
//	 * @covers \Wikia\Search\Config::getNumPages
//	 */
//	public function testGetNumPagesNoResults() {
//		$config = $this->getMock( '\\Wikia\\Search\\Config', [ 'getResultsFound', 'getLimit' ] );
//		$config
//			->expects( $this->any() )
//			->method ( 'getResultsFound' )
//			->will   ( $this->returnValue( 0 ) )
//		;
//		$this->assertEquals(
//			0,
//			$config->getNumPages(),
//			'Number of pages should default to zero.'
//		);
//	}
//
//	/**
//	 * @group Slow
//	 * @slowExecutionTime 0.07363 ms
//	 * @covers \Wikia\Search\Config::getNumPages
//	 */
//	public function testGetNumPagesWithResults() {
//		$config = $this->getMock( '\\Wikia\\Search\\Config', [ 'getResultsFound', 'getLimit' ] );
//		$numFound = 50;
//		$config
//			->expects( $this->any() )
//			->method ( 'getResultsFound' )
//			->will   ( $this->returnValue( $numFound ) )
//		;
//		$config
//			->expects( $this->once() )
//			->method ( 'getLimit' )
//			->will   ( $this->returnValue( Config::RESULTS_PER_PAGE ) )
//		;
//		$this->assertEquals(
//			ceil( $numFound / \Wikia\Search\Config::RESULTS_PER_PAGE ),
//			$config->getNumPages(),
//			'Number of pages should be divided by default number of results per page by if no limit is set.'
//		);
//	}

}
