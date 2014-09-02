<?php

/**
 * TransactionTraceScribe implements the TransactionTrace plugin interface and installs Scribe sink
 * when event is recorded.
 */
class TransactionTraceScribe {

	const SCRIBE_KEY = 'app_custom_events';
	protected static $installed = false;

	/**
	 * Installs Scribe sink for transaction events whenever an event is recorded
	 *
	 * @param string $type
	 */
	public function onEvent( $event ) {
		wfDebug( __CLASS__ . ": event received\n" );
		self::install();
	}

	/**
	 * Installs itself using register_shutdown_function()
	 */
	public static function install() {
		if ( !self::$installed ) {
			self::$installed = true;
			register_shutdown_function( array( __CLASS__, 'send' ) );
			wfDebug( __CLASS__ . ": installing shutdown handler\n" );
		}
	}

	/**
	 * Sends all events via Scribe
	 */
	public static function send() {
		wfDebug( __CLASS__ . ": send() executed\n" );
		// Check dependencies (perform autoload if required)
		if ( !is_callable( 'Transaction::getAttributes' ) || !is_callable( 'WScribeClient::singleton' ) ) {
			wfDebug( __CLASS__ . ": checks failed\n" );
			return;
		}

		$data = array(
			'time' => microtime( true ),
			'app' => 'mediawiki',
			'context' => Transaction::getAttributes(),
			'events' => Transaction::getEvents(),
		);
		$data = json_encode( $data );

		wfDebug( __CLASS__ . ": sending: " . $data . "\n" );
		try {
			WScribeClient::singleton( self::SCRIBE_KEY )->send( $data );
		} catch ( TException $e ) {
			wfDebug( __CLASS__ . ": error sending Scribe message\n" );
			if ( is_callable( 'Wikia::log' ) ) {
				Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
			}
		}

	}

}
