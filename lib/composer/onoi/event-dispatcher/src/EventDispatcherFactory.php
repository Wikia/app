<?php

namespace Onoi\EventDispatcher;

use Onoi\EventDispatcher\Dispatcher\GenericEventDispatcher;
use Onoi\EventDispatcher\Listener\NullEventListener;
use Onoi\EventDispatcher\Listener\GenericCallbackEventListener;
use Onoi\EventDispatcher\Listener\GenericEventListenerCollection;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class EventDispatcherFactory {

	/**
	 * @var EventDispatcherFactory
	 */
	private static $instance = null;

	/**
	 * @since 1.0
	 *
	 * @return EventDispatcherFactory
	 */
	public static function getInstance() {

		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * @since 1.0
	 */
	public static function clear() {
		self::$instance = null;
	}

	/**
	 * @since 1.0
	 *
	 * @return GenericEventDispatcher
	 */
	public function newGenericEventDispatcher() {
		return new GenericEventDispatcher();
	}

	/**
	 * @since 1.0
	 *
	 * @return DispatchContext
	 */
	public function newDispatchContext() {
		return new DispatchContext();
	}

	/**
	 * @since 1.0
	 *
	 * @return NullEventListener
	 */
	public function newNullEventListener() {
		return new NullEventListener();
	}

	/**
	 * @since 1.0
	 *
	 * @return GenericCallbackEventListener
	 */
	public function newGenericCallbackEventListener() {
		return new GenericCallbackEventListener();
	}

	/**
	 * @since 1.0
	 *
	 * @return GenericEventListenerCollection
	 */
	public function newGenericEventListenerCollection() {
		return new GenericEventListenerCollection();
	}

}
