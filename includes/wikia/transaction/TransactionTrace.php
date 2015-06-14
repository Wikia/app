<?php

/**
 * Class TransactionTrace keeps track of all the transaction attributes and allows plugins
 * to react when any change happens
 */
class TransactionTrace {

	protected $type = null;
	protected $attributes = array();

	protected $events = array();
	protected $rawEvents = array();

	protected $plugins = array();
	protected $classifier;

	/**
	 * Creates a new instance of TransactionTrace class
	 *
	 * @param array $plugins Array of plugins
	 */
	public function __construct( $plugins = array() ) {
		$this->plugins = $plugins;
		$this->classifier = new TransactionClassifier();
	}

	/**
	 * Sets the specified attribute
	 *
	 * @param string $key Attribute key
	 * @param mixed $value Attribute value
	 */
	public function set( $key, $value ) {
		if ( $value === null ) {
			return;
		}
		$this->attributes[$key] = $value;
		$this->notify( 'onAttributeChange', $key, $value );
		$type = $this->classifier->update( $key, $value );
		if ( $type !== $this->type ) {
			$this->type = $type;
			$this->notify( 'onTypeChange', $type );
		}
	}

	private function formatEvent( $eventName, $data ) {
		return [
			'time' => microtime( true ),
			'event' => $eventName,
			'data' => $data,
		];
	}

	/**
	 * Records an event
	 *
	 * @param string $eventName Event name
	 * @param array $data Event data
	 */
	public function addEvent( $eventName, $data ) {
		$event = self::formatEvent( $eventName, $data );
		$this->events[] = $event;
		$this->notify( 'onEvent', $event );
	}

	/**
	 * Records a raw event
	 *
	 * Raw means that an event will be reported without any context data
	 *
	 * @param string $eventName Event name
	 * @param array $data Event data
	 */
	public function addRawEvent( $eventName, $data ) {
		$event = self::formatEvent( $eventName, $data );
		$this->rawEvents[] = $event;
		$this->notify( 'onEvent', $event );
	}

	/**
	 * Returns the automatically generated transaction type name
	 *
	 * @return string|null
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Returns array with all recorded attributes
	 *
	 * @return array
	 */
	public function getAttributes() {
		$all = $this->type !== null ? array( Transaction::PSEUDO_PARAM_TYPE => $this->type ) : array();
		$all += $this->attributes;
		return $all;
	}

	/**
	 * Returns array with all recorded events
	 *
	 * @return array
	 */
	public function getEvents() {
		return $this->events;
	}

	/**
	 * Returns array with all recorded raw events
	 *
	 * @return array
	 */
	public function getRawEvents() {
		return $this->rawEvents;
	}

	/**
	 * Sends notification to all plugins
	 *
	 * @param string $methodName Method name to be looked for
	 * @param mixed $arg1, $argN Arguments to all handlers with
	 */
	protected function notify( $methodName, $arg1 = null, $argN = null ) {
		wfDebug( __CLASS__ . ": notification: " . json_encode( func_get_args() ) . "\n" );
		$args = func_get_args();
		array_shift( $args );
		foreach ( $this->plugins as $plugin ) {
			$callback = array( $plugin, $methodName );
			if ( is_callable( $callback ) ) {
				call_user_func_array( $callback, $args );
			}
		}
	}
}
