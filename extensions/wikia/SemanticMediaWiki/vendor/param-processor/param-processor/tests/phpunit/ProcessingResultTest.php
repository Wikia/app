<?php

namespace ParamProcessor\Tests;

use ParamProcessor\ProcessingError;
use ParamProcessor\ProcessingResult;

/**
 * @covers ParamProcessor\ProcessingResult
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ProcessingResultTest extends \PHPUnit_Framework_TestCase {

	public function testGetParameters() {
		$processedParams = array(
			$this->newMockParam()
		);

		$result = new ProcessingResult( $processedParams );

		$this->assertEquals( $processedParams, $result->getParameters() );
	}

	private function newMockParam() {
		return $this->getMockBuilder( 'ParamProcessor\ProcessedParam' )
			->disableOriginalConstructor()->getMock();
	}

	public function testGetErrors() {
		$errors = array(
			$this->newMockError()
		);

		$result = new ProcessingResult( array(), $errors );

		$this->assertEquals( $errors, $result->getErrors() );
	}

	private function newMockError() {
		return $this->getMockBuilder( 'ParamProcessor\ProcessingError' )
			->disableOriginalConstructor()->getMock();
	}

	public function testGivenNoErrors_HasNoFatal() {
		$this->assertNoFatalForErrors( array() );
	}

	private function assertNoFatalForErrors( array $errors ) {
		$result = new ProcessingResult( array(), $errors );

		$this->assertFalse( $result->hasFatal() );
	}

	public function testGivenNonfatalErrors_HasNoFatal() {
		$this->assertNoFatalForErrors( array(
			new ProcessingError( '', ProcessingError::SEVERITY_HIGH ),
			new ProcessingError( '', ProcessingError::SEVERITY_LOW ),
			new ProcessingError( '', ProcessingError::SEVERITY_MINOR ),
			new ProcessingError( '', ProcessingError::SEVERITY_NORMAL ),
		) );
	}

	public function testGivenFatalError_HasFatal() {
		$result = new ProcessingResult( array(), array(
			new ProcessingError( '', ProcessingError::SEVERITY_HIGH ),
			new ProcessingError( '', ProcessingError::SEVERITY_LOW ),
			new ProcessingError( '', ProcessingError::SEVERITY_FATAL ),
			new ProcessingError( '', ProcessingError::SEVERITY_MINOR ),
			new ProcessingError( '', ProcessingError::SEVERITY_NORMAL ),
		) );

		$this->assertTrue( $result->hasFatal() );
	}

}