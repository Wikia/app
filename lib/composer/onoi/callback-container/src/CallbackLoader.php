<?php

namespace Onoi\CallbackContainer;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
interface CallbackLoader extends CallbackInstantiator {

	/**
	 * @since 1.0
	 * @deprecated since 1.1, use CallbackInstantiator::create
	 *
	 * @param string $handlerName
	 *
	 * @return mixed
	 * @throws RuntimeException
	 */
	public function load( $handlerName );

}
