<?php

namespace Onoi\CallbackContainer;

/**
 * @license GNU GPL v2+
 * @since 1.1
 *
 * @author mwjames
 */
interface CallbackInstantiator {

	/**
	 * @since 1.0
	 *
	 * @param string $handlerName
	 * @param Closure $callback
	 */
	public function registerCallback( $handlerName, \Closure $callback );

	/**
	 * @since 1.1
	 *
	 * @param CallbackContainer $callbackContainer
	 */
	public function registerCallbackContainer( CallbackContainer $callbackContainer );

	/**
	 * @since 1.0
	 *
	 * @param string $handlerName
	 * @param string $type
	 */
	public function registerExpectedReturnType( $handlerName, $type );

	/**
	 * @since 1.1
	 *
	 * @param string $handlerName
	 *
	 * @return mixed
	 * @throws RuntimeException
	 */
	public function create( $handlerName );

	/**
	 * @since 1.0
	 *
	 * @param string $handlerName
	 *
	 * @return mixed
	 * @throws RuntimeException
	 */
	public function singleton( $handlerName );

}
