<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "XMLRC extension";
	exit( 1 );
}

/**
 * Implementation if XMLRC_Transport that sends messages via UDP.
 */
class XMLRC_UDP extends XMLRC_Transport {

	/**
	 * Creates a new instance of XMLRC_UDP. $config['address'] and $config['port'] determine
	 * where to send the UDP packets to.
	 *
	 * @param $config Array: the configuration array.
	 */
	function __construct( $config ) {
		$this->socket = null;

		$this->address = isset( $config['address'] ) ? $config['address'] : '127.0.0.1';
		$this->port = isset( $config['port'] ) ? $config['port'] : 4455;
	}

	/**
	 * Opens a UDP socket for sending data.
	 */
	public function connect() {
		if ( $this->socket ) {
			return;
		}

		$this->socket = socket_create( AF_INET, SOCK_DGRAM, SOL_UDP );
		if ( !$this->socket ) {
			wfDebugLog( 'XMLRC', "failed to create UDP socket\n" );
		} else {
			wfDebugLog( 'XMLRC', "created UDP socket\n" );
		}
	}

	/**
	 * Closes the underlying UDP socket.
	 */
	public function disconnect() {
		if ( !$this->socket ) {
			return;
		}

		socket_close( $this->socket );
		$this->socket = null;
		wfDebugLog( 'XMLRC', "closed UDP socket\n" );
	}

	/**
	 * Sends $xml via the underlying socket, to the address specified in the
	 * constructor by $config['address'] and $config['port'].
	 * The socket is automatically opened if necessary.
	 */
	public function send( $xml ) {
		$do_disconnect = !$this->socket;
		$this->connect();

		$ok = socket_sendto(
			$this->socket, $xml, strlen( $xml ), 0, $this->address, $this->port
		);
		if ( $ok ) {
			wfDebugLog( 'XMLRC', "sent UDP packet to {$this->address}:{$this->port}\n" );
		} else {
			wfDebugLog( 'XMLRC', "failed to send UDP packet to {$this->address}:{$this->port}\n" );
		}

		if ( $do_disconnect ) {
			$this->disconnect();
		}
	}
}
