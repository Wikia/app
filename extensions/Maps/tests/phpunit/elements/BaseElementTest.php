<?php

namespace Maps\Tests\Elements;

use Maps\Element;

/**
 * Base class for unit tests classes for the Maps\BaseElement deriving objects.
 *
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class BaseElementTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Returns the name of the concrete class tested by this test.
	 *
	 * @since 3.0
	 *
	 * @return string
	 */
	public abstract function getClass();

	public abstract function validConstructorProvider();

	public function invalidConstructorProvider() {
		return array();
	}

	/**
	 * Creates and returns a new instance of the concrete class.
	 *
	 * @since 3.0
	 *
	 * @return mixed
	 */
	public function newInstance() {
		$reflector = new \ReflectionClass( $this->getClass() );
		$args = func_get_args();
		$instance = $reflector->newInstanceArgs( $args );
		return $instance;
	}

	/**
	 * @since 3.0
	 *
	 * @return array [instance, constructor args]
	 */
	public function instanceProvider() {
		$phpFails = array( $this, 'newInstance' );

		return array_map(
			function( array $args ) use ( $phpFails ) {
				return array( call_user_func_array( $phpFails, $args ), $args );
			},
			$this->validConstructorProvider()
		);
	}

	/**
	 * @dataProvider validConstructorProvider
	 *
	 * @since 3.0
	 */
	public function testGivenValidArguments_constructorDoesNotThrowException() {
		$instance = call_user_func_array( array( $this, 'newInstance' ), func_get_args() );
		$this->assertInstanceOf( $this->getClass(), $instance );
	}

	/**
	 * @dataProvider invalidConstructorProvider
	 *
	 * @since 3.0
	 */
	public function testGivenInvalidArguments_constructorThrowsException() {
		$this->setExpectedException( 'InvalidArgumentException' );
		call_user_func_array( array( $this, 'newInstance' ), func_get_args() );
	}

	/**
	 * @dataProvider instanceProvider
	 * @param Element $element
	 */
	public function testGetOptions( Element $element ) {
		$this->assertInstanceOf( '\Maps\ElementOptions', $element->getOptions() );
	}

}
