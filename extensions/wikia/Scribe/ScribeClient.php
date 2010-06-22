<?php

$GLOBALS['THRIFT_ROOT'] = $IP . '/lib/scribe';

include_once $GLOBALS['THRIFT_ROOT'] . '/scribe.php';
include_once $GLOBALS['THRIFT_ROOT'] . '/transport/TSocket.php';
include_once $GLOBALS['THRIFT_ROOT'] . '/transport/TFramedTransport.php';
include_once $GLOBALS['THRIFT_ROOT'] . '/protocol/TBinaryProtocol.php';

class WScribeClient {
	protected $category, $connected = false;
	protected $host, $port, $socket, $client, $protocol, $transport;

	const CATEGORY_KEY = 'category';
	const MESSAGE_KEY = 'message';

	public static function singleton( $category ) {
		static $instances = array();
		if ( !isset( $instances[$category] ) ) {
			$instances[$category] = new self( $category );
		}
		return $instances[$category];
	}
	
	/**
	 * Constructor
	 */
	protected function __construct ($category) {
		$this->category = $category;
	}
	
	/**
	 * Initialize socket connection
	 */
	protected function connect () {
		global $wgScribeHost, $wgScribePort, $wgScribeSendTimeout;
		
		if ( $this->connected ) { 
			return true;
		} 
		
		if ( empty($wgScribeHost) ) {
			$wgScribeHost = '127.0.0.1';
		}
		
		if ( empty($wgScribePort) ) {
			$wgScribePort = 1463;
		}
		
		if ( empty($wgScribeSendTimeout) ) {
			$wgScribeSendTimeout = 5000;
		}
		
		$this->connected = true;
		try {
			$this->socket = new TSocket($wgScribeHost, $wgScribePort, true);
			$this->socket->setSendTimeout($wgScribeSendTimeout);
			$this->transport = new TFramedTransport($this->socket);
			$this->protocol = new TBinaryProtocol($this->transport, false, false);
			$this->client = new scribeClient($this->protocol, $this->protocol);
		}
		catch( TException $e ) {
			Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
			$this->connected = false;
		}
		
		return $this->connected;
    }
    
    /**
     * Send a message to a destination
     *
     * @param string $message
     * @return boolean
     */
    public function send ($message) {
		$messages = array();
		
		if ( !is_array($message) ) {
			$message = array($message);
		}
		
		foreach ( $message as $msg ) {
			$__message = array(
				self::CATEGORY_KEY	=> $this->category,
				self::MESSAGE_KEY	=> $msg
			);
			
			$logEntry = new LogEntry($__message);
			
			$messages[] = $logEntry;
		}
		
		$result = false;
		if ( !empty($messages) ) { 
			try {
				$this->connect();

				$this->transport->open();
				$result = $this->client->Log($messages);
				
				if ( $result == $GLOBALS['E_ResultCode']['TRY_LATER'] ) {
					Wikia::log( __METHOD__, "scribe", "Returned 'TRY_LATER' value" );
				}
				
				if ( $result != $GLOBALS['E_ResultCode']['OK'] ) {
					Wikia::log( __METHOD__, "scribe", "Unknown result ($result)" );
				}

				$this->transport->close();
			}
			catch( TException $e ) {
				// socket error 
				Wikia::log( __METHOD__, 'scribeClient log', $e->getMessage() );
				$this->connected = false;
			}
		}
		return $result;
    }
}
