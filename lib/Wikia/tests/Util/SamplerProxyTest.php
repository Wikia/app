<?php

use Wikia\Util\SamplerProxy;

class SamplerProxyTest extends \WikiaBaseTest {

	/** @var \PHPUnit_Framework_MockObject_MockObject */
	private $originalMock;

	/** @var \PHPUnit_Framework_MockObject_MockObject */
	private $alternateMock;

	private $enableShadowing = true;
	private $methodSamplingRate = 50;

	private $originalMethodToSample = 'methodToSample';
	private $originalMethodNotToSample = 'methodNotToSample';
	private $alternateMethod = 'alternateMethod';
	private $compareResultsMethod = 'compareResults';

	function setUp() {
		parent::setUp();

		$this->originalMock = $this->getMockBuilder( OriginalPopo::class )->setMethods( [
			$this->originalMethodToSample,
			$this->originalMethodNotToSample,
		] )->disableOriginalConstructor()->getMock();

		$this->alternateMock = $this->getMockBuilder( AlternatePopo::class )->setMethods( [
			$this->alternateMethod,
			$this->compareResultsMethod,
		] )->disableOriginalConstructor()->getMock();
	}

	function testProxyBuilderSuccess() {
		$this->doTestProxyBuilder( $this->enableShadowing, $this->methodSamplingRate,
			[ $this->originalMock, $this->originalMethodToSample ], [ $this->alternateMock, $this->alternateMethod ],
			[ $this->alternateMock, $this->compareResultsMethod ] );
	}

	function testProxyBuilderNullShadowVariable() {
		$this->doTestProxyBuilder( null, null,
			[ $this->originalMock, $this->originalMethodToSample ], [ $this->alternateMock, $this->alternateMethod ],
			[ $this->alternateMock, $this->compareResultsMethod ] );
	}

	function doTestProxyBuilder(
		$testShadowing, $testMethodSamplingRate, $testOriginalCallable,
		$testAlternateCallable, $testResultsCallable
	) {

		$builder = SamplerProxy::createBuilder();
		$samplerProxy =
			$builder->setEnableShadowing( $testShadowing )
				->setMethodSamplingRate( $testMethodSamplingRate )
				->setOriginalCallable( $testOriginalCallable )
				->setAlternateCallable( $testAlternateCallable )
				->setResultsCallable( $testResultsCallable )
				->build();

		$this->assertEquals( $testShadowing,
			$samplerProxy->getEnableShadowing() );
		$this->assertEquals( $testMethodSamplingRate,
			$samplerProxy->getMethodSamplingRate() );
		$this->assertEquals( $testOriginalCallable, $samplerProxy->getOriginalCallable() );
		$this->assertEquals( $testAlternateCallable, $samplerProxy->getAlternateCallable() );
		$this->assertEquals( $testResultsCallable, $samplerProxy->getResultsCallable() );
	}

	function testUnsampledMethod() {
		$testShadowing = true;
		$testMethodSamplingRate = 15;

		$testOriginalCallable = [ $this->originalMock, $this->originalMethodToSample ];
		$testAlternateCallable = [ $this->alternateMock, $this->alternateMethod ];

		$testArg1 = 1;
		$testArg2 = array( 4, 5, 6 );
		$testResult = 'success';

		$builder = SamplerProxy::createBuilder();
		$samplerProxy =
			$builder->setEnableShadowing( $testShadowing )
				->setMethodSamplingRate( $testMethodSamplingRate )
				->setOriginalCallable( $testOriginalCallable )
				->setAlternateCallable( $testAlternateCallable )
				->build();

		$this->originalMock->expects( $this->once() )
			->method( $this->originalMethodNotToSample )
			->with( $testArg1, $testArg2 )
			->willReturn( $testResult );

		$result = $samplerProxy->methodNotToSample( $testArg1, $testArg2 );

		$this->assertEquals( $testResult, $result );
	}


	function testSampling100Percent() {
		$this->doSamplingTest( 100, false, 0.0 );
	}

	function testSampling75Percent() {
		$this->doSamplingTest( 75, false, 0.1 );
	}

	function testSampling50Percent() {
		$this->doSamplingTest( 50, false, 0.1 );
	}

	function testSampling25Percent() {
		$this->doSamplingTest( 25, false, 0.1 );
	}

	function testSampling0Percent() {
		$this->doSamplingTest( 0, false, 0 );
	}

	function testShadowing100Percent() {
		$this->doSamplingTest( 100, true, 0.0 );
	}

	function testShadowing75Percent() {
		$this->doSamplingTest( 75, true, 0.1 );
	}

	function testShadowing50Percent() {
		$this->doSamplingTest( 50, true, 0.1 );
	}

	function testShadowing25Percent() {
		$this->doSamplingTest( 25, true, 0.1 );
	}

	function testShadowing0Percent() {
		$this->doSamplingTest( 0, true, 0 );
	}

	function doSamplingTest( $samplingRate, $enableShadowing, $deviation ) {

		$testOriginalCallable = [ $this->originalMock, $this->originalMethodToSample ];
		$testAlternateCallable = [ $this->alternateMock, $this->alternateMethod ];

		$testArg1 = 1;
		$testArg2 = 'two';
		$testArg3 = array( 4, 5, 6 );
		$originalTestResult = 'original';
		$alternateTestResult = 'alternate';
		$callCount = 200;

		$samplerProxy =	$this->getMockBuilder( SamplerProxy::class )->setMethods(
			[ 'getRandomInt' ] )->disableOriginalConstructor()->getMock();
		$samplerProxy->setEnableShadowing( $enableShadowing );
		$samplerProxy->setMethodSamplingRate( $samplingRate );
		$samplerProxy->setOriginalCallable( $testOriginalCallable );
		$samplerProxy->setAlternateCallable( $testAlternateCallable );

		if ( $samplingRate > 0 ) {
			$samplerProxy->expects( $this->exactly( $callCount ) )
				->method( 'getRandomInt' )
				->with( 0, 100 )
				->willReturnCallback( [ $this, 'getMockRandomInt' ] );
		} else {
			$samplerProxy->expects( $this->never() )
				->method( 'getRandomInt' )
				->with( 0, 100 );
		}

		$originalCallableRecorder =
			( $samplingRate < 100 || $enableShadowing ) ? $this->atLeastOnce() : $this->never();
		$this->originalMock->expects( $originalCallableRecorder )
			->method( $this->originalMethodToSample )
			->with( $testArg1, $testArg2, $testArg3 )
			->willReturn( $originalTestResult );

		$alternateCallableRecorder = $samplingRate > 0 ? $this->atLeastOnce() : $this->never();
		$this->alternateMock->expects( $alternateCallableRecorder )
			->method( $this->alternateMethod )
			->with( $testArg1, $testArg2, $testArg3 )
			->willReturn( $alternateTestResult );

		for ( $i = 0; $i < $callCount; $i ++ ) {
			$samplerProxy->methodToSample( $testArg1, $testArg2, $testArg3 );
		}

		if ( $samplingRate == 100 ) {
			// we should see $callCount calls to alternate
			$this->assertEquals( $callCount, $alternateCallableRecorder->getInvocationCount() );
			$this->assertEquals( $enableShadowing ? $callCount : 0,
				$originalCallableRecorder->getInvocationCount() );
		} elseif ( $samplingRate > 0 ) {
			// we should see $samplingRate percent (+- $deviation) calls to alternate
			$this->assertLessThanOrEqual( $callCount * $deviation,
				abs( $callCount * $samplingRate / 100 - $alternateCallableRecorder->getInvocationCount() ) );
			if ( $enableShadowing ) {
				// when shadowing, we should see $callCount calls to original
				$this->assertEquals( $callCount, $originalCallableRecorder->getInvocationCount() );
			} else {
				// when sampling without shadowing, original sees the calls that didn't go to
				// alternate
				$this->assertLessThanOrEqual( $callCount * $deviation,
					abs( $callCount * ( 100 - $samplingRate ) / 100 -
					     $originalCallableRecorder->getInvocationCount() ) );
			}
		} else {
			$this->assertEquals( 0, $alternateCallableRecorder->getInvocationCount() );
			$this->assertEquals( $callCount, $originalCallableRecorder->getInvocationCount() );
		}
	}

	function testResultsCallable() {
		$testShadowing = true;
		$testMethodSamplingRate = 100;

		$testOriginalCallable = [ $this->originalMock, $this->originalMethodToSample ];
		$testAlternateCallable = [ $this->alternateMock, $this->alternateMethod ];
		$resultsCallable = [ $this->alternateMock, $this->compareResultsMethod ];

		$testArg1 = 1;
		$testArg2 = 'two';
		$testArg3 = array( 4, 5, 6 );
		$originalTestResult = 'original results';
		$alternateTestResult = 'alternate results';

		$builder = SamplerProxy::createBuilder();
		$samplerProxy =
			$builder->setEnableShadowing( $testShadowing )
				->setMethodSamplingRate( $testMethodSamplingRate )
				->setOriginalCallable( $testOriginalCallable )
				->setAlternateCallable( $testAlternateCallable )
				->setResultsCallable( $resultsCallable )
				->build();

		$this->originalMock->expects( $this->once() )
			->method( $this->originalMethodToSample )
			->with( $testArg1, $testArg2, $testArg3 )
			->willReturn( $originalTestResult );

		$this->alternateMock->expects( $this->once() )
			->method( $this->alternateMethod )
			->with( $testArg1, $testArg2, $testArg3 )
			->willReturn( $alternateTestResult );

		$this->alternateMock->expects( $this->once() )
			->method( $this->compareResultsMethod )
			->with( $originalTestResult, $alternateTestResult )
			->willReturn( $alternateTestResult );

		$result = $samplerProxy->methodToSample( $testArg1, $testArg2, $testArg3 );

		$this->assertEquals( $alternateTestResult, $result );
	}

	function testExceptionFallbackFromShadow() {
		$testShadow = false;
		$testMethodSamplingRate = 100;

		$testOriginalCallable = [ $this->originalMock, $this->originalMethodToSample ];
		$testAlternateCallable = [ $this->alternateMock, $this->alternateMethod ];

		$testArg1 = 1;
		$testArg2 = 'two';
		$testArg3 = array( 4, 5, 6 );
		$originalTestResult = 'original test result';

		$builder = SamplerProxy::createBuilder();
		$samplerProxy =
			$builder->setEnableShadowing( $testShadow )
				->setMethodSamplingRate( $testMethodSamplingRate )
				->setOriginalCallable( $testOriginalCallable )
				->setAlternateCallable( $testAlternateCallable )
				->build();

		$this->alternateMock->expects( $this->once() )
			->method( $this->alternateMethod )
			->with( $testArg1, $testArg2, $testArg3 )
			->willThrowException( new \Exception( 'test exception' ) );

		$this->originalMock->expects( $this->once() )
			->method( $this->originalMethodToSample )
			->with( $testArg1, $testArg2, $testArg3 )
			->willReturn( $originalTestResult );


		$result = $samplerProxy->methodToSample( $testArg1, $testArg2, $testArg3 );

		$this->assertEquals( $originalTestResult, $result );
	}

	/**
	 * This method is used to mock rand() in sampling tests.
	 * It creates a shuffled array of all ints between 1 and 100 and
	 * simply iterates through the array to return "pseudo-random" ints.
	 * As long as sampling tests that mock rand() use a loop count
	 * that is a multiple of 100 they are guaranteed a uniform distribution
	 * of "random" ints.
	 *
	 * @return int
	 */
	function getMockRandomInt() {
		static $intArray;
		static $index = 1;

		if ( !isset( $intArray ) ) {
			$intArray = range( 1, 100 );
			shuffle( $intArray );
		}
		$value = $intArray[$index];
		$index = ++$index % 100;
		return $value;
	}
}

class OriginalPopo {

	function methodToSample( $arg1, $arg2, $arg3 ) {
		return 'original result';
	}

	function methodNotToSample( $arg1, $arg2 ) {

	}
}

class AlternatePopo {
	function alternateMethod( $arg1, $arg2, $arg3 ) {
		return 'alternate result';
	}

	function compareResults( $originalResults, $alternateResults ) {
		return $originalResults;
	}
}