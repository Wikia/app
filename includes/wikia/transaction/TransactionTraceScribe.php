<?php

/**
 * TransactionTraceScribe implements the TransactionTrace plugin interface and sends all recorded events via Scribe
 * at the end of request.
 */
class TransactionTraceScribe {

	const SCRIBE_KEY = 'app_custom_events';
	protected static $installed = false;

	/**
	 * Installs request shutdown handler to send all events via Scribe
	 *
	 * @param string $event
	 */
	public function onEvent( $event ) {
		self::install();
	}

	/**
	 * Installs itself using register_shutdown_function()
	 */
	public static function install() {
		if ( !self::$installed ) {
			self::$installed = true;
			register_shutdown_function( array( __CLASS__, 'onShutdown' ) );
		}
	}

	/**
	 * Send a set of events with a provided context
	 *
	 * @param array $events set of events to be sent
	 * @param array $context request context to be attached to each event (can be empty)
	 */
	private static function send(Array $events, Array $context = array()) {
		// no data to send
		if (empty($events)) {
			return;
		}

		$data = [
			'time' => microtime( true ),
			'app' => Transaction::APP_NAME,
			'context' => $context,
			'events' => $events,
		];

		$data = json_encode( $data );

		try {
			WScribeClient::singleton( self::SCRIBE_KEY )->send( $data );
		} catch ( TException $e ) {
			if ( is_callable( 'Wikia::log' ) ) {
				Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
			}
		}
	}

	/**
	 * Sends all events via Scribe
	 */
	public static function onShutdown() {
		// Check dependencies (perform autoload if required)
		if ( !is_callable( 'Transaction::getAttributes' ) || !is_callable( 'WScribeClient::singleton' ) ) {
			return;
		}

		// send events with full context data
		self::send(Transaction::getEvents(), Transaction::getAttributes());

		// send raw events with the minimal context
		self::send(Transaction::getRawEvents(), [
			Transaction::PSEUDO_PARAM_TYPE => Transaction::getType(),
			Transaction::PARAM_ENVIRONMENT => Transaction::getAttribute(Transaction::PARAM_ENVIRONMENT),
		]);
	}

}
