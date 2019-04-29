<?php

namespace Wikia\Search\Test;

/**
 * Tests for Config class
 */
class SearchResultViewTest extends BaseTest {

	/**
	 * @covers \Wikia\Search\Config::getTruncatedResultsNum
	 */
	public function testGetTruncatedResultsNum() {
		$view =
			$this->getMockBuilder( 'Wikia\\Search\\SearchResultView' )
				->setMethods( [ 'getResultsFound' ] )
				->getMock();

		$singleDigit = 9;

		$view->expects( $this->at( 0 ) )
			->method( 'getResultsFound' )
			->will( $this->returnValue( $singleDigit ) );


		$this->assertEquals( $singleDigit, $view->getTruncatedResultsNum(),
			"We should not truncate a single digit result number value." );

		$doubleDigit = 26;

		$view->expects( $this->at( 0 ) )
			->method( 'getResultsFound' )
			->will( $this->returnValue( $doubleDigit ) );

		$this->assertEquals( 30, $view->getTruncatedResultsNum(),
			"We should round only for double digits." );

		$tripleDigit = 492;

		$view->expects( $this->at( 0 ) )
			->method( 'getResultsFound' )
			->will( $this->returnValue( $tripleDigit ) );

		$this->assertEquals( 500, $view->getTruncatedResultsNum(),
			"We should round to hundreds for triple digits." );

		$bigDigit = 55555;

		$view->expects( $this->at( 0 ) )
			->method( 'getResultsFound' )
			->will( $this->returnValue( $bigDigit ) );

		$this->assertEquals( 56000, $view->getTruncatedResultsNum(),
			"Larger digits should round to the nearest n-1 radix." );
	}


	/**
	 * @covers \Wikia\Search\Config::getTruncatedResultsNum
	 */
	public function testGetTruncatedResultsNumWithFormatting() {
		$view =
			$this->getMockBuilder( 'Wikia\\Search\\SearchResultView' )
				->setMethods( [ 'getResultsFound', 'formatNumber' ] )
				->getMock();

		$bigDigit = 55555;

		$view->expects( $this->once() )
			->method( 'formatNumber' )
			->with( 56000 )
			->will( $this->returnValue( '56,000' ) );
		$view->expects( $this->once() )
			->method( 'getResultsFound' )
			->will( $this->returnValue( $bigDigit ) );
		$this->assertEquals( '56,000', $view->getTruncatedResultsNum( true ) );
	}

}
