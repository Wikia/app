<?php

namespace Onoi\EventDispatcher\Listener;

use Onoi\EventDispatcher\EventListener;
use Onoi\EventDispatcher\DispatchContext;
use RuntimeException;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class GenericCallbackEventListener implements EventListener {

	/**
	 * @var array
	 */
	protected $callbacks = array();

	/**
	 * @var boolean
	 */
	private $propagationStopState = false;

	/**
	 * @since 1.0
	 *
	 * @param Closure|callable|null $callback
	 */
	public function __construct( $callback = null ) {
		if ( $callback !== null ) {
			$this->registerCallback( $callback );
		}
	}

	/**
	 * @since 1.0
	 *
	 * @param Closure|callable $callback
	 * @throws RuntimeException
	 */
	public function registerCallback( $callback ) {

		if ( !is_callable( $callback ) ) {
			throw new RuntimeException( "Invoked object is not a valid callback or Closure" );
		}

		// While this does not build a real dependency chain, it allows for atomic
		// event handling by following FIFO
		$this->callbacks[] = $callback;
	}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function execute( DispatchContext $dispatchContext = null ) {
		foreach ( $this->callbacks as $callback ) {
			call_user_func_array( $callback, array( $dispatchContext ) );
		}
	}

	/**
	 * @since 1.0
	 *
	 * @param boolean $propagationStopState
	 */
	public function setPropagationStopState( $propagationStopState ) {
		$this->propagationStopState = (bool)$propagationStopState;
	}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function isPropagationStopped() {
		return $this->propagationStopState;
	}

}
