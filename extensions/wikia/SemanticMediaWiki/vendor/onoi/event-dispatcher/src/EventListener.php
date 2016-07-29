<?php

namespace Onoi\EventDispatcher;

/**
 * Interface for objects that can be listen to
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
interface EventListener {

	/**
	 * Execute a registered listener action
	 *
	 * @since 1.0
	 *
	 * @param DispatchContext|null $dispatchContext
	 */
	public function execute( DispatchContext $dispatchContext = null );

	/**
	 * Whether propagation of the event to be stopped after the execution.
	 *
	 * It influences the dispatch persistence state for succeeding listeners
	 * to continue with the execution process for the same event.
	 *
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function isPropagationStopped();

}
