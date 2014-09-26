<?php
namespace Wikia\Search\Test\Services\Helpers;

use Wikia\Search\Test\BaseTest;
use Wikia\Search\Services\Helpers\OutputFormatter;

class OutputFormatterTest extends BaseTest {

	/** @test */
	public function shouldDoCorrectReplaceOnStaging() {
		$this->getStaticMethodMock( '\WikiFactory', 'getCurrentStagingHost' )
			->expects( $this->any() )
			->method( 'getCurrentStagingHost' )
			->will( $this->returnCallback( [ $this, 'mock_getCurrentStagingHost' ] ) );

		$formatter = new OutputFormatter();
		$res = $formatter->replaceHostUrl('http://bigbangtheory.wikia.com/api/v1/Articles/AsSimpleJson?id=1880');
		$this->assertEquals('http://newhost/api/v1/Articles/AsSimpleJson?id=1880', $res);
	}

	/** @test */
	public function shouldDoCorrectReplaceOnStagingOnDifferentLanguage() {
		$this->getStaticMethodMock( '\WikiFactory', 'getCurrentStagingHost' )
			->expects( $this->any() )
			->method( 'getCurrentStagingHost' )
			->will( $this->returnCallback( [ $this, 'mock_getCurrentStagingHost' ] ) );

		$formatter = new OutputFormatter();
		$res = $formatter->replaceHostUrl('http://de.bigbangtheory.wikia.com/api/v1/Articles/AsSimpleJson?id=1880');
		$this->assertEquals('http://newhost/api/v1/Articles/AsSimpleJson?id=1880', $res);
	}

	public function mock_getCurrentStagingHost( $arg1, $arg2 ) {
		return 'newhost';
	}

}