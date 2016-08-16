<?php

namespace Onoi\CallbackContainer\Tests;

use Onoi\CallbackContainer\CallbackContainer;
use Onoi\CallbackContainer\CallbackLoader;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class FooCallbackContainer implements CallbackContainer {

	public function register( CallbackLoader $callbackLoader ) {
		$this->addCallbackHandlers( $callbackLoader);
	}

	private function addCallbackHandlers( $callbackLoader ) {

		$callbackLoader->registerCallback( 'Foo', function() {
			return new \stdClass;
		} );

		$callbackLoader->registerExpectedReturnType( 'Foo', '\stdClass' );

		$callbackLoader->registerCallback( 'FooWithArgument', function( $argument ) use( $callbackLoader ) {
			$callbackLoader->registerExpectedReturnType( 'FooWithArgument', '\stdClass' );

			$stdClass = new \stdClass;
			$stdClass->argument = $argument;

			return $stdClass;
		} );

		$callbackLoader->registerCallback( 'FooWithNullArgument', function( $argument = null ) use( $callbackLoader ) {
			$callbackLoader->registerExpectedReturnType( 'FooWithNullArgument', '\stdClass' );

			$stdClass = new \stdClass;
			$stdClass->argument = $argument;

			return $stdClass;
		} );
	}

}
