<?php

namespace Onoi\EventDispatcher\Listener;

use Onoi\EventDispatcher\EventListener;
use Onoi\EventDispatcher\EventListenerCollection;
use RuntimeException;
use InvalidArgumentException;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class GenericEventListenerCollection implements EventListenerCollection {

	/**
	 * @var array
	 */
	private $collection = array();

	/**
	 * @since 1.0
	 *
	 * @param string $event
	 * @param EventListener $listener
	 *
	 * @throws InvalidArgumentException
	 */
	public function registerListener( $event, EventListener $listener ) {

		if ( !is_string( $event ) ) {
			throw new InvalidArgumentException( "Event is not a string" );
		}

		$this->addToCollection( $event, $listener );
	}

	/**
	 * @since 1.0
	 *
	 * @param string $event
	 * @param Closure|callable $callback
	 *
	 * @throws InvalidArgumentException
	 * @throws RuntimeException
	 */
	public function registerCallback( $event, $callback ) {

		if ( !is_string( $event ) ) {
			throw new InvalidArgumentException( "Event is not a string" );
		}

		if ( !is_callable( $callback ) ) {
			throw new RuntimeException( "Invoked object is not a valid callback or Closure" );
		}

		$this->addToCollection( $event, new GenericCallbackEventListener( $callback ) );
	}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function getCollection() {
		return $this->collection;
	}

	private function addToCollection( $event, EventListener $listener ) {

		$event = strtolower( $event );

		if ( !isset( $this->collection[$event] ) ) {
			$this->collection[$event] = array();
		}

		$this->collection[$event][] = $listener;
	}

}
