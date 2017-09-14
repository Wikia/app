<?php

use Wikia\Util\GlobalStateWrapper;
use PHPUnit\Framework\TestCase;

class GlobalStateWrapperTest extends TestCase {

	private $scalarValue = "a-scalar-value";
	private $arrayValue = array( 'foo' => 'bar' );


	public function testWrapOveride() {
		$GLOBALS['scalarGlobalState'] = $this->scalarValue;
		$GLOBALS['arrayGlobalState'] = $this->arrayValue;

		$newScalar = 'new-scalar';
		$newArray  = array( 'fizz' => 'buzz' );
		$wrapper = new GlobalStateWrapper( array(
			'scalarGlobalState' => $newScalar,
			'arrayGlobalState'  => $newArray
		) );

		$result = $wrapper->wrap( function() {
			global $scalarGlobalState, $arrayGlobalState;
			return array( $scalarGlobalState, $arrayGlobalState );
		} );

		$this->assertEquals( array( $newScalar, $newArray ), $result );
		$this->assertEquals( $this->scalarValue, $GLOBALS['scalarGlobalState'] );
		$this->assertEquals( $this->arrayValue, $GLOBALS['arrayGlobalState'] );
	}

	public function testWrapException() {
		$GLOBALS['scalarGlobalState'] = $this->scalarValue;
		$GLOBALS['arrayGlobalState'] = $this->arrayValue;

		$newScalar = 'new-scalar';
		$newArray  = array( 'fizz' => 'buzz' );
		$wrapper = new GlobalStateWrapper( array(
			'scalarGlobalState' => $newScalar,
			'arrayGlobalState'  => $newArray
		) );

		$exceptionWasThrown = false;
		$result = null;
		try {
			$result = $wrapper->wrap( function () {
				throw new Exception( 'foo' );
			} );
		} catch ( Exception $e ) {
			$exceptionWasThrown = true;
		}

		$this->assertNull( $result );
		$this->assertTrue( $exceptionWasThrown );

		// make sure they are restored after the exception
		$this->assertEquals( $this->scalarValue, $GLOBALS['scalarGlobalState'] );
		$this->assertEquals( $this->arrayValue, $GLOBALS['arrayGlobalState'] );
	}

	public function testWrapOverrideAndSet() {
		global $scalarGlobalState, $arrayGlobalState;
		$GLOBALS['scalarGlobalState'] = $this->scalarValue;
		$GLOBALS['arrayGlobalState'] = $this->arrayValue;

		$newScalar = 'new-scalar';
		$newArray  = array( 'fizz' => 'buzz' );
		$wrapper = new GlobalStateWrapper( array(
			'scalarGlobalState' => $newScalar,
			'arrayGlobalState'  => $newArray
		) );

		$result = $wrapper->wrap( function() use ( $newScalar, $newArray ) {
			global $scalarGlobalState, $arrayGlobalState;
			assert( $scalarGlobalState == $newScalar );
			assert( $arrayGlobalState == $newArray );
			$scalarGlobalState = 'a';
			$arrayGlobalState = 'b';
			return array( $scalarGlobalState, $arrayGlobalState );
		} );

		$this->assertEquals( array( 'a', 'b' ), $result );
		$this->assertEquals( $this->scalarValue, $scalarGlobalState );
		$this->assertEquals( $this->arrayValue, $arrayGlobalState );
	}

	/**
	 * @expectedException     InvalidArgumentException
	 */
	public function testWrapWithNotCallable() {
		$wrapper = new GlobalStateWrapper( array() );
		$wrapper->wrap( 'foo' );
	}

}
