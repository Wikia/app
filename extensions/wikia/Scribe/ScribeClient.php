<?php

use \Wikia\Logger\Loggable;

$GLOBALS['THRIFT_ROOT'] = $IP . '/lib/vendor/scribe';

include_once $GLOBALS['THRIFT_ROOT'] . '/scribe.php';
include_once $GLOBALS['THRIFT_ROOT'] . '/transport/TSocket.php';
include_once $GLOBALS['THRIFT_ROOT'] . '/transport/TFramedTransport.php';
include_once $GLOBALS['THRIFT_ROOT'] . '/protocol/TBinaryProtocol.php';

class WScribeClient {

	use Loggable;

	protected $category, $connected = false;
	/* @var scribeClient $client */
	protected $host, $port, $socket, $client, $protocol;
	/* @var TFramedTransport $transport */
	protected $transport;

	const CATEGORY_KEY = 'category';
	const MESSAGE_KEY = 'message';

	const SCRIBE_RESULT_OK = 0; // taken from E_ResultCode['OK']

	/**
	 * @static
	 * @param $category
	 * @return WScribeClient
	 */
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
			$wgScribeSendTimeout = 60000;
		}

		if ( empty($wgScribeRecvTimeout) ) {
			$wgScribeRecvTimeout = 60000;
		}

		$this->connected = true;
		try {
			$this->socket = new TSocket($wgScribeHost, $wgScribePort, true);
			$this->socket->setSendTimeout($wgScribeSendTimeout);
			$this->socket->setRecvTimeout($wgScribeRecvTimeout);
			$this->transport = new TFramedTransport($this->socket);
			$this->protocol = new TBinaryProtocol($this->transport, false, false);
			$this->client = new scribeClient($this->protocol, $this->protocol);
		}
		catch( TException $e ) {
			$this->error( __METHOD__, [
				'exception' => $e
			] );
			$this->connected = false;
		}

		return $this->connected;
    }

    /**
     * Send a message to a destination
     *
     * @param string $message JSON encoded message
     * @throws TException
     */
    public function send($message) {
		$messages = array();

		if ( !is_array($message) ) {
			$message = array($message);
		}

		foreach ( $message as $msg ) {
			$__message = array(
				self::CATEGORY_KEY	=> $this->category,
				self::MESSAGE_KEY	=> $msg
			);

			$logEntry = new ScribeLogEntry($__message);

			$messages[] = $logEntry;
		}

		if ( !empty($messages) ) {
			try {
				$this->connect();

				$this->transport->open();
				$result = $this->client->Log($messages);
				$this->transport->close();

				if ( $result != self::SCRIBE_RESULT_OK ) {
					throw new TException( 'Scribe response is not ok', $result );
				}

				$this->info( 'Scribe', [
					'cmd' => 'send',
					'category' => $this->category,
					'caller' => wfGetCallerClassMethod( __CLASS__ )
				] );
			}
			catch( TException $e ) {
				$this->error( __METHOD__, [
					'exception' => $e
				] );
				$this->connected = false;

				// re-throw the exception
				throw $e;
			}
		}
    }
}
