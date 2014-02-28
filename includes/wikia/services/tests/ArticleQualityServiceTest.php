<?php

class ArticleQualityServiceTest extends WikiaBaseTest {

	/**
	 * @covers ArticleQualityService::searchPercentile
	 */
	public function testSearchPercentile() {
		$mock = $this->getMockBuilder( "\ArticleQualityService" )
			->disableOriginalConstructor()
			->setMethods( [ '__construct' ] )
			->getMock();

		$refl = new \ReflectionMethod( $mock, 'searchPercentile' );

		$refl->setAccessible( true );

		$prop = new \ReflectionProperty( $mock, 'percentiles' );
		$prop->setAccessible( true );
		$prop->setValue( $mock, [ 1 => 0.1, 2 => 0.2, 3 => 0.3, 4 => 0.4 ] );

		$this->assertEquals( 2, $refl->invoke( $mock, 0.25 ) );
		$this->assertEquals( 4, $refl->invoke( $mock, 0.5 ) );
		$this->assertEquals( 1, $refl->invoke( $mock, 0.05 ) );

		$prop->setValue( $mock, [ -1 => -0.1, 0 => 0.05, 1 => 0.8 ] );
		$this->assertEquals( -1, $refl->invoke( $mock, -2 ) );
		$this->assertEquals( 0, $refl->invoke( $mock, 0.4 ) );
		$this->assertEquals( 1, $refl->invoke( $mock, 1 ) );
	}

} 