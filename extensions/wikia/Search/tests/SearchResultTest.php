<?php

namespace Wikia\Search\Test;

/**
 * Tests for Config class
 */
class SearchResultTest extends BaseTest {

	/**
	 * @covers \Wikia\Search\Config::getTruncatedResultsNum
	 */
	public function testGetTruncatedResultsNum() {
		$searchResult =
			$this->getMockBuilder( 'Wikia\\Search\\SearchResult' )
				->setMethods( [ 'getResultsFound' ] )
				->getMock();

		$singleDigit = 9;

		$searchResult->expects( $this->at( 0 ) )
			->method( 'getResultsFound' )
			->will( $this->returnValue( $singleDigit ) );


		$this->assertEquals( $singleDigit, $searchResult->getTruncatedResultsNum(),
			"We should not truncate a single digit result number value." );

		$doubleDigit = 26;

		$searchResult->expects( $this->at( 0 ) )
			->method( 'getResultsFound' )
			->will( $this->returnValue( $doubleDigit ) );

		$this->assertEquals( 30, $searchResult->getTruncatedResultsNum(),
			"We should round only for double digits." );

		$tripleDigit = 492;

		$searchResult->expects( $this->at( 0 ) )
			->method( 'getResultsFound' )
			->will( $this->returnValue( $tripleDigit ) );

		$this->assertEquals( 500, $searchResult->getTruncatedResultsNum(),
			"We should round to hundreds for triple digits." );

		$bigDigit = 55555;

		$searchResult->expects( $this->at( 0 ) )
			->method( 'getResultsFound' )
			->will( $this->returnValue( $bigDigit ) );

		$this->assertEquals( 56000, $searchResult->getTruncatedResultsNum(),
			"Larger digits should round to the nearest n-1 radix." );
	}


	/**
	 * @covers \Wikia\Search\Config::getTruncatedResultsNum
	 */
	public function testGetTruncatedResultsNumWithFormatting() {
		$searchResult =
			$this->getMockBuilder( 'Wikia\\Search\\SearchResult' )
				->setMethods( [ 'getResultsFound', 'formatNumber' ] )
				->getMock();

		$bigDigit = 55555;

		$searchResult->expects( $this->once() )
			->method( 'formatNumber' )
			->with( 56000 )
			->will( $this->returnValue( '56,000' ) );
		$searchResult->expects( $this->once() )
			->method( 'getResultsFound' )
			->will( $this->returnValue( $bigDigit ) );
		$this->assertEquals( '56,000', $searchResult->getTruncatedResultsNum( true ) );
	}
}
