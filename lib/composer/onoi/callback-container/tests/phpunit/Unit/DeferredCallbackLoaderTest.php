<?php

namespace Onoi\CallbackContainer\Tests;

use Onoi\CallbackContainer\DeferredCallbackLoader;

/**
 * @covers \Onoi\CallbackContainer\DeferredCallbackLoader
 * @group onoi-callback-container
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class DeferredCallbackLoaderTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Onoi\CallbackContainer\DeferredCallbackLoader',
			new DeferredCallbackLoader()
		);
	}

	public function testCanConstructWithCallbackContainer() {

		$callbackContainer = $this->getMockBuilder( '\Onoi\CallbackContainer\CallbackContainer' )
			->disableOriginalConstructor()
			->getMock();

		$callbackContainer->expects( $this->once() )
			->method( 'register' );

		$this->assertInstanceOf(
			'\Onoi\CallbackContainer\DeferredCallbackLoader',
			new DeferredCallbackLoader( $callbackContainer )
		);
	}

	public function testRegisterCallback() {

		$instance = new DeferredCallbackLoader();

		$instance->registerCallback( 'Foo', function() {
			return new \stdClass;
		} );

		$this->assertEquals(
			new \stdClass,
			$instance->create( 'Foo' )
		);

		$this->assertEquals(
			new \stdClass,
			$instance->singleton( 'Foo' )
		);
	}

	public function testDeregisterCallback() {

		$instance = new DeferredCallbackLoader();

		$instance->registerCallback( 'Foo', function() {
			return 'abc';
		} );

		$this->assertEquals(
			'abc',
			$instance->create( 'Foo' )
		);

		$instance->deregister( 'Foo' );

		$this->assertNull(
			$instance->singleton( 'Foo' )
		);
	}

	public function testLoadCallbackHandlerWithExpectedReturnType() {

		$instance = new DeferredCallbackLoader();

		$instance->registerCallback( 'Foo', function() {
			return new \stdClass;
		} );

		$instance->registerExpectedReturnType( 'Foo', '\stdClass' );

		$this->assertEquals(
			new \stdClass,
			$instance->create( 'Foo' )
		);
	}

	public function testLoadCallbackHandlerWithoutExpectedReturnType() {

		$instance = new DeferredCallbackLoader();

		$instance->registerCallback( 'Foo', function() {
			return 'abc';
		} );

		$this->assertEquals(
			'abc',
			$instance->create( 'Foo' )
		);

		$this->assertEquals(
			'abc',
			$instance->load( 'Foo' )
		);
	}

	public function testRegisterCallbackContainer() {

		$instance = new DeferredCallbackLoader();
		$instance->registerCallbackContainer( new FooCallbackContainer() );

		$this->assertEquals(
			new \stdClass,
			$instance->create( 'Foo' )
		);

		$this->assertEquals(
			new \stdClass,
			$instance->singleton( 'Foo' )
		);
	}

	public function testRegisterObject() {

		$expected = new \stdClass;

		$instance = new DeferredCallbackLoader();

		$instance->registerExpectedReturnType( 'Foo', '\stdClass' );
		$instance->registerObject( 'Foo', $expected );

		$this->assertEquals(
			$expected,
			$instance->create( 'Foo' )
		);

		$this->assertEquals(
			$expected,
			$instance->singleton( 'Foo' )
		);
	}

	public function testInjectInstanceForExistingRegisteredCallbackHandler() {

		$stdClass = $this->getMockBuilder( '\stdClass' )
			->disableOriginalConstructor()
			->getMock();

		$instance = new DeferredCallbackLoader( new FooCallbackContainer() );
		$instance->singleton( 'Foo' );

		$instance->registerObject( 'Foo', $stdClass );

		$this->assertSame(
			$stdClass,
			$instance->create( 'Foo' )
		);

		$this->assertSame(
			$stdClass,
			$instance->singleton( 'Foo' )
		);
	}

	public function testOverrideSingletonInstanceOnRegisteredCallbackHandlerWithArguments() {

		$argument = $this->getMockBuilder( '\stdClass' )
			->disableOriginalConstructor()
			->getMock();

		$instance = new DeferredCallbackLoader(
			new FooCallbackContainer()
		);

		$instance->singleton( 'FooWithNullArgument', $argument );
		$override = $instance->singleton( 'FooWithNullArgument', null );

		$this->assertNotSame(
			$override,
			$instance->singleton( 'FooWithNullArgument', $argument )
		);

		$instance->registerObject( 'FooWithNullArgument', $override );

		$this->assertSame(
			$override,
			$instance->singleton( 'FooWithNullArgument', $argument )
		);

		$this->assertSame(
			$override,
			$instance->singleton( 'FooWithNullArgument', null )
		);
	}

	public function testLoadParameterizedCallbackHandler() {

		$instance = new DeferredCallbackLoader();

		$instance->registerCallback( 'Foo', function( $a, $b, $c ) {
			$stdClass = new \stdClass;
			$stdClass->a = $a;
			$stdClass->b = $b;
			$stdClass->c = $c;

			return $stdClass;
		} );

		$instance->registerExpectedReturnType( 'Foo', '\stdClass' );

		$object = new \stdClass;
		$object->extra = 123;

		$this->assertEquals(
			'abc',
			$instance->create( 'Foo', 'abc', 123, $object )->a
		);

		$this->assertEquals(
			$object,
			$instance->create( 'Foo', 'abc', 123, $object )->c
		);
	}

	public function testRecursiveBuildToLoadParameterizedCallbackHandler() {

		$instance = new DeferredCallbackLoader();

		$instance->registerCallback( 'Foo', function( $a, $b = null, $c ) {
			$stdClass = new \stdClass;
			$stdClass->a = $a;
			$stdClass->c = $c;

			return $stdClass;
		} );

		$instance->registerExpectedReturnType( 'Foo', '\stdClass' );

		$instance->registerCallback( 'Bar', function( $a, $b, $c ) use( $instance ) {
			return $instance->create( 'Foo', $a, $b, $c );
		} );

		$instance->registerExpectedReturnType( 'Bar', '\stdClass' );

		$object = new \stdClass;
		$object->extra = 123;

		$this->assertSame(
			$object,
			$instance->create( 'Bar', 'abc', null, $object )->c
		);
	}

	public function testSingleton() {

		$instance = new DeferredCallbackLoader();

		$instance->registerCallback( 'Foo', function() {
			return new \stdClass;
		} );

		$instance->registerExpectedReturnType( 'Foo', '\stdClass' );

		$singleton = $instance->singleton( 'Foo' );

		$this->assertSame(
			$singleton,
			$instance->singleton( 'Foo' )
		);
	}

	public function testFingerprintedParameterizedSingletonCallbackHandler() {

		$instance = new DeferredCallbackLoader();

		$instance->registerCallback( 'Foo', function( $a, array $b ) {
			$stdClass = new \stdClass;
			$stdClass->a = $a;
			$stdClass->b = $b;

			return $stdClass;
		} );

		$instance->registerExpectedReturnType( 'Foo', '\stdClass' );

		$this->assertSame(
			$instance->singleton( 'Foo', 'abc', array( 'def' ) ),
			$instance->singleton( 'Foo', 'abc', array( 'def' ) )
		);

		$this->assertNotSame(
			$instance->singleton( 'Foo', 'abc', array( '123' ) ),
			$instance->singleton( 'Foo', 'abc', array( 'def' ) )
		);
	}

	public function testUnregisteredCallbackHandlerIsToReturnNull() {

		$instance = new DeferredCallbackLoader();

		$this->assertNull(
			$instance->create( 'Foo' )
		);
	}

	public function testUnregisteredCallbackHandlerForSingletonIsToReturnNull() {

		$instance = new DeferredCallbackLoader();

		$this->assertNull(
			$instance->singleton( 'Foo' )
		);
	}

	public function testTryToLoadCallbackHandlerWithTypeMismatchThrowsException() {

		$instance = new DeferredCallbackLoader();

		$instance->registerCallback( 'Foo', function() {
			return new \stdClass;
		} );

		$instance->registerExpectedReturnType( 'Foo', 'Bar' );

		$this->setExpectedException( 'RuntimeException' );
		$instance->create( 'Foo' );
	}

	public function testTryToUseInvalidNameForCallbackHandlerOnLoadThrowsException() {

		$instance = new DeferredCallbackLoader();

		$this->setExpectedException( 'InvalidArgumentException' );
		$instance->create( new \stdClass );
	}

	public function testTryToUseInvalidNameForCallbackHandlerOnSingletonThrowsException() {

		$instance = new DeferredCallbackLoader();

		$this->setExpectedException( 'InvalidArgumentException' );
		$instance->singleton( new \stdClass );
	}

	public function testTryToLoadCallbackHandlerWithCircularReferenceThrowsException() {

		$instance = new DeferredCallbackLoader();

		$this->setExpectedException( 'RuntimeException' );

		$instance->registerCallback( 'Foo', function() use ( $instance ) {
			return $instance->create( 'Foo' );
		} );

		$instance->registerExpectedReturnType( 'Foo', '\stdClass' );
		$instance->create( 'Foo' );
	}

	public function testTryToLoadSingletonCallbackHandlerWithCircularReferenceThrowsException() {

		$instance = new DeferredCallbackLoader();

		$this->setExpectedException( 'RuntimeException' );

		$instance->registerCallback( '\stdClass', function() use ( $instance ) {
			return $instance->singleton( 'Foo' );
		} );

		$instance->registerExpectedReturnType( 'Foo', '\stdClass' );
		$instance->singleton( 'Foo' );
	}

	public function testTryToUseInvalidNameOnCallbackHandlerRegistrationThrowsException() {

		$instance = new DeferredCallbackLoader();

		$this->setExpectedException( 'InvalidArgumentException' );
		$instance->registerCallback( new \stdClass, function() {
			return new \stdClass;
		} );
	}

	public function testTryToUseInvalidNameOnObjectRegistrationThrowsException() {

		$instance = new DeferredCallbackLoader();

		$this->setExpectedException( 'InvalidArgumentException' );
		$instance->registerObject( new \stdClass, new \stdClass );
	}

	public function testTryToUseInvalidNameOnTypeRegistrationThrowsException() {

		$instance = new DeferredCallbackLoader();

		$this->setExpectedException( 'InvalidArgumentException' );
		$instance->registerExpectedReturnType( new \stdClass, 'Bar' );
	}

}
