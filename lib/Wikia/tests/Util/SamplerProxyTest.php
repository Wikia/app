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