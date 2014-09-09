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
	 * @param string $type
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
			register_shutdown_function( array( __CLASS__, 'send' ) );
		}
	}

	/**
	 * Sends all events via Scribe
	 */
	public static function send() {
		// Check dependencies (perform autoload if required)
		if ( !is_callable( 'Transaction::getAttributes' ) || !is_callable( 'WScribeClient::singleton' ) ) {
			return;
		}

		$data = array(
			'time' => microtime( true ),
			'app' => 'mediawiki',
			'context' => Transaction::getAttributes(),
			'events' => Transaction::getEvents(),
		);
		$data = json_encode( $data );

		try {
			WScribeClient::singleton( self::SCRIBE_KEY )->send( $data );
		} catch ( TException $e ) {
			if ( is_callable( 'Wikia::log' ) ) {
				Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
			}
		}

	}

}
