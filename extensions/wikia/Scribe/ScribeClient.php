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
		global $wgScribeHost, $wgScribePort;
		
		if ( $this->connected ) { 
			return true;
		} else {
		}
		
		$this->connected = true;
		try {
			$this->socket = new TSocket($wgScribeHost, $wgScribePort, true);
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
		try {
			$this->connect();
			if ( !empty($messages) ) { 
				$this->transport->open();
				$result = $this->client->Log($messages);
				$this->transport->close();
			}
		}
		catch( TException $e ) {
			// socket error 
			Wikia::log( __METHOD__, 'scribeClient log', $e->getMessage() );
			$this->connected = false;
		}
		return $result;
    }
}
