<?php

namespace Onoi\EventDispatcher\Listener;

use Onoi\EventDispatcher\EventListener;
use Onoi\EventDispatcher\DispatchContext;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class NullEventListener implements EventListener {

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function execute( DispatchContext $dispatchContext = null ) {}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function isPropagationStopped() {
		return false;
	}

}
