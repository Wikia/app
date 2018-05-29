<?php

trait UopzTrait {

	private $uopzMockedClasses = [];
	private $uopzMockedMethods = [];

	protected function setUp() {
		$this->uopzMockedClasses = [];
		$this->uopzMockedMethods = [];

		parent::setUp();
	}

	protected function mockClass( string $className, $mockObject, string $staticConstructorMethod = null ) {
		if ( $staticConstructorMethod ) {
			$this->mockStaticMethod( $className, $staticConstructorMethod, $mockObject );
			return;
		}

		$this->uopzMockedClasses[$className] = true;
		uopz_unset_mock( $className );
		uopz_set_mock( $className, $mockObject );
	}

	protected function mockStaticMethod( string $className, string $methodName, $returnValue ) {
		$this->uopzMockedMethods["$className::$methodName"] = true;
		uopz_set_return( $className, $methodName, $returnValue );
	}

	protected function tearDown() {
		foreach ( array_keys( $this->uopzMockedClasses ) as $className ) {
			uopz_unset_mock( $className );
		}

		foreach ( array_keys( $this->uopzMockedMethods ) as $definition ) {
			list( $className, $methodName ) = explode( '::', $definition );

			uopz_unset_return( $className, $methodName );
		}

		parent::tearDown();
	}
}
