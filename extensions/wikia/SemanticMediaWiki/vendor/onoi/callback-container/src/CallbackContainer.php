<?php

namespace Onoi\CallbackContainer;

/**
 * Interface describing a container to be registered with a CallbackLoader.
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
interface CallbackContainer {

	/**
	 * @since 1.0
	 *
	 * @param CallbackLoader $callbackLoader
	 */
	public function register( CallbackLoader $callbackLoader );

}
