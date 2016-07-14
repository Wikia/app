<?php

namespace Onoi\CallbackContainer;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class NullCallbackLoader implements CallbackLoader {

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function registerCallback( $name, \Closure $callback ) {}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function registerExpectedReturnType( $handlerName, $type ) {}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function load( $name ) {}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function singleton( $name ) {}

}
