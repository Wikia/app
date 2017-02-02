<?php

namespace Onoi\EventDispatcher;

/**
 * Dispatches events to registered listeners
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
interface EventDispatcher {

	/**
	 * Registers a collection of listeners
	 *
	 * @since 1.0
	 *
	 * @param EventListenerCollection $listenerCollection
	 */
	public function addListenerCollection( EventListenerCollection $listenerCollection );

	/**
	 * Registers a listener to a specific event identifier
	 *
	 * @since 1.0
	 *
	 * @param string $event
	 * @param EventListener|null $listener
	 */
	public function addListener( $event, EventListener $listener );

	/**
	 * Removes all or a specific listener that matches the event identifier
	 *
	 * @since 1.0
	 *
	 * @param string $event
	 * @param EventListener|null $listener
	 */
	public function removeListener( $event, EventListener $listener = null );

	/**
	 * Whether an event identifier has been registered listeners or not
	 *
	 * @since 1.0
	 *
	 * @param string $event
	 *
	 * @return boolean
	 */
	public function hasEvent( $event );

	/**
	 * Notifies all listeners registered to an event identifier
	 *
	 * @since 1.0
	 *
	 * @param string $event
	 * @param DispatchContext|null $dispatchContext
	 */
	public function dispatch( $event, DispatchContext $dispatchContext = null );

}
