<?php

use Wikia\Util\SamplerProxy;

class SamplerProxyTest extends \PHPUnit_Framework_TestCase {

	/** @var \PHPUnit_Framework_MockObject_MockObject */
	private $originalMock;

	/** @var \PHPUnit_Framework_MockObject_MockObject */
	private $alternateMock;

	function setUp() {
		parent::setUp();

		$this->originalMock = $this->getMockBuilder( OriginalPopo::class )->setMethods( [
			'methodToSample',
			'methodNotToSample',
		] )->disableOriginalConstructor()->getMock();

		$this->alternateMock = $this->getMockBuilder( AlternatePopo::class )->setMethods( [
			'alternateMethod',
			'compareResults',
		] )->disableOriginalConstructor()->getMock();
	}

	function testProxyBuilderSuccess() {
		$this->doTestProxyBuilder( 'wgEnableShadowing', 'wgMethodSamplingRate',
			[ $this->originalMock, 'methodToSample' ], [ $this->alternateMock, 'alternateMethod' ],
			[ $this->alternateMock, "compareResults" ] );
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	function testProxyBuilderNullShadowVariable() {
		$this->doTestProxyBuilder( null, 'wgMethodSamplingRate',
			[ $this->originalMock, 'methodToSample' ], [ $this->alternateMock, 'alternateMethod' ],
			[ $this->alternateMock, "compareResults" ] );
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	function testProxyBuilderNullSampleVariable() {
		$this->doTestProxyBuilder( 'wgEnableShadowing', null,
			[ $this->originalMock, 'methodToSample' ], [ $this->alternateMock, 'alternateMethod' ],
			[ $this->alternateMock, "compareResults" ] );
	}

	function doTestProxyBuilder(
		$testShadowVariableName, $testMethodSamplingRateVariableName, $testOriginalCallable,
		$testAlternateCallable, $testResultsCallable
	) {

		$builder = SamplerProxy::createBuilder();
		$samplerProxy =
			$builder->enableShadowingVariableName( $testShadowVariableName )
				->methodSamplingRateVariableName( $testMethodSamplingRateVariableName )
				->originalCallable( $testOriginalCallable )
				->alternateCallable( $testAlternateCallable )
				->resultsCallable( $testResultsCallable )
				->build();

		$this->assertEquals( $testShadowVariableName,
			$samplerProxy->getEnableShadowingVariableName() );
		$this->assertEquals( $testMethodSamplingRateVariableName,
			$samplerProxy->getMethodSamplingRateVariableName() );
		$this->assertEquals( $testOriginalCallable, $samplerProxy->getOriginalCallable() );
		$this->assertEquals( $testAlternateCallable, $samplerProxy->getAlternateCallable() );
		$this->assertEquals( $testResultsCallable, $samplerProxy->getResultsCallable() );
	}

	function testUnsampledMethod() {
		$testShadowVariableName = 'wgEnableShadowing';
		$GLOBALS[$testShadowVariableName] = 0;
		$testMethodSamplingRateVariableName = 'wgMethodSamplingRate';
		$GLOBALS[$testMethodSamplingRateVariableName] = 100;

		$testOriginalCallable = [ $this->originalMock, 'methodToSample' ];
		$testAlternateCallable = [ $this->alternateMock, 'alternateMethod' ];

		$testArg1 = 1;
		$testArg2 = array( 4, 5, 6 );
		$testResult = 'success';

		$builder = SamplerProxy::createBuilder();
		$samplerProxy =
			$builder->enableShadowingVariableName( $testShadowVariableName )
				->methodSamplingRateVariableName( $testMethodSamplingRateVariableName )
				->originalCallable( $testOriginalCallable )
				->alternateCallable( $testAlternateCallable )
				->build();

		$this->originalMock->expects( $this->once() )
			->method( 'methodNotToSample' )
			->with( $testArg1, $testArg2 )
			->willReturn( $testResult );

		$result = $samplerProxy->methodNotToSample( $testArg1, $testArg2 );

		$this->assertEquals( $testResult, $result );
	}

	function testSampling100Percent() {
		$this->doSamplingTest( 100, false, 200, 0.0 );
	}

	function testSampling75Percent() {
		$this->doSamplingTest( 75, false, 200, 0.1 );
	}

	function testSampling50Percent() {
		$this->doSamplingTest( 50, false, 200, 0.1 );
	}

	function testSampling25Percent() {
		$this->doSamplingTest( 25, false, 200, 0.1 );
	}

	function testSampling0Percent() {
		$this->doSamplingTest( 0, false, 200, 0 );
	}

	function testShadowing100Percent() {
		$this->doSamplingTest( 100, true, 200, 0.0 );
	}

	function testShadowing75Percent() {
		$this->doSamplingTest( 75, true, 200, 0.1 );
	}

	function testShadowing50Percent() {
		$this->doSamplingTest( 50, true, 200, 0.1 );
	}

	function testShadowing25Percent() {
		$this->doSamplingTest( 25, true, 200, 0.1 );
	}

	function testShadowing0Percent() {
		$this->doSamplingTest( 0, true, 200, 0 );
	}

	function doSamplingTest(
		$samplingRate, $enableShadowing, $count, $deviation
	) {

		$testShadowVariableName = 'wgEnableShadowing';
		$GLOBALS[$testShadowVariableName] = $enableShadowing;
		$testMethodSamplingRateVariableName = 'wgMethodSamplingRate';
		$GLOBALS[$testMethodSamplingRateVariableName] = $samplingRate;

		$testOriginalCallable = [ $this->originalMock, 'methodToSample' ];
		$testAlternateCallable = [ $this->alternateMock, 'alternateMethod' ];

		$testArg1 = 1;
		$testArg2 = 'two';
		$testArg3 = array( 4, 5, 6 );
		$originalTestResult = 'original';
		$alternateTestResult = 'alternate';

		$builder = SamplerProxy::createBuilder();
		$samplerProxy =
			$builder->enableShadowingVariableName( $testShadowVariableName )
				->methodSamplingRateVariableName( $testMethodSamplingRateVariableName )
				->originalCallable( $testOriginalCallable )
				->alternateCallable( $testAlternateCallable )
				->build();

		$originalCallableRecorder =
			( $samplingRate < 100 || $enableShadowing ) ? $this->atLeastOnce() : $this->never();
		$this->originalMock->expects( $originalCallableRecorder )
			->method( 'methodToSample' )
			->with( $testArg1, $testArg2, $testArg3 )
			->willReturn( $originalTestResult );

		$alternateCallableRecorder = $samplingRate > 0 ? $this->atLeastOnce() : $this->never();
		$this->alternateMock->expects( $alternateCallableRecorder )
			->method( 'alternateMethod' )
			->with( $testArg1, $testArg2, $testArg3 )
			->willReturn( $alternateTestResult );

		for ( $i = 0; $i < $count; $i ++ ) {
			$samplerProxy->methodToSample( $testArg1, $testArg2, $testArg3 );
		}

		if ( $samplingRate == 100 ) {
			// we should see $count calls to alternate
			$this->assertEquals( $count, $alternateCallableRecorder->getInvocationCount() );
		} elseif ( $samplingRate > 0 ) {
			// we should see $samplingRate percent (+- $deviation) calls to alternate
			$this->assertLessThanOrEqual( $count * $deviation, abs( $count * $samplingRate / 100 -
			                                                        $alternateCallableRecorder->getInvocationCount() ) );
			if ( $enableShadowing ) {
				// when shadowing, we should see $count calls to original
				$this->assertEquals( $count, $originalCallableRecorder->getInvocationCount() );
			} else {
				// when sampling without shadowing, original sees the calls that didn't go to
				// alternate
				$this->assertLessThanOrEqual( $count * $deviation,
					abs( $count * ( 100 - $samplingRate ) / 100 -
					     $originalCallableRecorder->getInvocationCount() ) );
			}
		}
	}

	function testResultsCallable() {
		$testShadowVariableName = 'wgEnableShadowing';
		$GLOBALS[$testShadowVariableName] = 1;
		$testMethodSamplingRateVariableName = 'wgMethodSamplingRate';
		$GLOBALS[$testMethodSamplingRateVariableName] = 100;

		$testOriginalCallable = [ $this->originalMock, 'methodToSample' ];
		$testAlternateCallable = [ $this->alternateMock, 'alternateMethod' ];
		$resultsCallable = [ $this->alternateMock, 'compareResults' ];

		$testArg1 = 1;
		$testArg2 = 'two';
		$testArg3 = array( 4, 5, 6 );
		$originalTestResult = 'original';
		$alternateTestResult = 'alternate';

		$builder = SamplerProxy::createBuilder();
		$samplerProxy =
			$builder->enableShadowingVariableName( $testShadowVariableName )
				->methodSamplingRateVariableName( $testMethodSamplingRateVariableName )
				->originalCallable( $testOriginalCallable )
				->alternateCallable( $testAlternateCallable )
				->resultsCallable( $resultsCallable )
				->build();

		$this->originalMock->expects( $this->once() )
			->method( 'methodToSample' )
			->with( $testArg1, $testArg2, $testArg3 )
			->willReturn( $originalTestResult );

		$this->alternateMock->expects( $this->once() )
			->method( 'alternateMethod' )
			->with( $testArg1, $testArg2, $testArg3 )
			->willReturn( $alternateTestResult );

		$this->alternateMock->expects( $this->once() )
			->method( 'compareResults' )
			->with( $originalTestResult, $alternateTestResult )
			->willReturn( $alternateTestResult );

		$result = $samplerProxy->methodToSample( $testArg1, $testArg2, $testArg3 );

		$this->assertEquals( $alternateTestResult, $result );
	}

	function testExceptionFallbackFromShadow() {
		$testShadowVariableName = 'wgEnableShadowing';
		$GLOBALS[$testShadowVariableName] = 0;
		$testMethodSamplingRateVariableName = 'wgMethodSamplingRate';
		$GLOBALS[$testMethodSamplingRateVariableName] = 100;

		$testOriginalCallable = [ $this->originalMock, 'methodToSample' ];
		$testAlternateCallable = [ $this->alternateMock, 'alternateMethod' ];

		$testArg1 = 1;
		$testArg2 = 'two';
		$testArg3 = array( 4, 5, 6 );
		$originalTestResult = 'original';

		$builder = SamplerProxy::createBuilder();
		$samplerProxy =
			$builder->enableShadowingVariableName( $testShadowVariableName )
				->methodSamplingRateVariableName( $testMethodSamplingRateVariableName )
				->originalCallable( $testOriginalCallable )
				->alternateCallable( $testAlternateCallable )
				->build();

		$this->alternateMock->expects( $this->once() )
			->method( 'alternateMethod' )
			->with( $testArg1, $testArg2, $testArg3 )
			->willThrowException( new \Exception( 'test exception' ) );

		$this->originalMock->expects( $this->once() )
			->method( 'methodToSample' )
			->with( $testArg1, $testArg2, $testArg3 )
			->willReturn( $originalTestResult );


		$result = $samplerProxy->methodToSample( $testArg1, $testArg2, $testArg3 );

		$this->assertEquals( $originalTestResult, $result );
	}

}

class OriginalPopo {

	function methodToSample( $arg1, $arg2, $arg3 ) {
		return 'original';
	}

	function methodNotToSample( $arg1, $arg2 ) {

	}
}

class AlternatePopo {
	function alternateMethod( $arg1, $arg2, $arg3 ) {
		return 'alternate';
	}

	function compareResults( $originalResults, $alternateResults ) {
		return $originalResults;
	}
}