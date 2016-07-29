<?php

namespace Onoi\CallbackContainer;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
interface CallbackLoader {

	/**
	 * @since 1.0
	 *
	 * @param string $handlerName
	 * @param Closure $callback
	 */
	public function registerCallback( $handlerName, \Closure $callback );

	/**
	 * @since 1.0
	 *
	 * @param string $handlerName
	 * @param string $type
	 */
	public function registerExpectedReturnType( $handlerName, $type );

	/**
	 * @since 1.0
	 *
	 * @param string $handlerName
	 *
	 * @return mixed
	 * @throws RuntimeException
	 */
	public function load( $handlerName );

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
