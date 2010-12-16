<?php

class PoolCounter_ConnectionManager {
	var $hostNames;
	var $conns = array();
	var $refCounts = array();

	function __construct( $conf ) {
		$this->hostNames = $conf['servers'];
		$this->timeout = isset( $conf['timeout'] ) ? $conf['timeout'] : 0.1;
		if ( !count( $this->hostNames ) ) {
			throw new MWException( __METHOD__ . ': no servers configured' );
		}
	}

	function get( $key ) {
		$hashes = array();
		foreach ( $this->hostNames as $hostName ) {
			$hashes[$hostName] = md5( $hostName . $key );
		}
		asort( $hashes );
		$errno = $errstr = '';
		foreach ( $hashes as $hostName => $hash ) {
			if ( isset( $this->conns[$hostName] ) ) {
				$this->refCounts[$hostName]++;
				return Status::newGood( $this->conns[$hostName] );
			}
			$parts = explode( ':', $hostName, 2 );
			if ( count( $parts ) < 2 ) {
				$parts[] = 7531;
			}
			$conn = fsockopen( $parts[0], $parts[1], $errno, $errstr, $this->timeout );
			if ( $conn ) {
				break;
			}
		}
		if ( !$conn ) {
			return Status::newFatal( 'poolcounter-connection-error', $errstr );
		}
		wfDebug( "Connected to pool counter server: $hostName\n" );
		$this->conns[$hostName] = $conn;
		$this->refCounts[$hostName] = 1;
		return Status::newGood( $conn );
	}

	function close( $conn ) {
		foreach ( $this->conns as $hostName => $otherConn ) {
			if ( $conn === $otherConn ) {
				if ( $this->refCounts[$hostName] ) {
					$this->refCounts[$hostName]--;
				}
				if ( !$this->refCounts[$hostName] ) {
					fclose( $conn );
					unset( $this->conns[$hostName] );
				}
			}
		}
	}
}

class PoolCounter_Client extends PoolCounter {
	var $maxThreads, $waitTimeout, $type, $key, $conn;
	var $isAcquired = false;

	static $manager;

	function __construct( $conf, $type, $key ) {
		$this->waitTimeout = isset( $conf['waitTimeout'] ) ? $conf['waitTimeout'] : 15;
		$this->maxThreads = isset( $conf['maxThreads'] ) ? $conf['maxThreads'] : 5;
		$this->type = $type;
		$this->key = $key;
		if ( !self::$manager ) {
			global $wgPoolCountClientConf;
			self::$manager = new PoolCounter_ConnectionManager( $wgPoolCountClientConf );
		}
	}

	function getConn() {
		if ( !isset( $this->conn ) ) {
			$status = self::$manager->get( $this->key );
			if ( !$status->isOK() ) {
				return $status;
			}
			$this->conn = $status->value;
		}
		return Status::newGood( $this->conn );
	}

	function sendCommand( /*, ...*/ ) {
		$args = func_get_args();
		$args = str_replace( ' ', '%20', $args );
		$cmd = implode( ' ', $args );
		$status = $this->getConn();
		if ( !$status->isOK() ) {
			return $status;
		}
		$conn = $status->value;
		wfDebug( "Sending pool counter command: $cmd\n" );
		if ( fwrite( $conn, "$cmd\r\n" ) === false ) {
			return Status::newFatal( 'poolcounter-write-error' );
		}
		$response = fgets( $conn );
		if ( $response === false ) {
			return Status::newFatal( 'poolcounter-read-error' );
		}
		$response = rtrim( $response, "\r\n" );
		wfDebug( "Got pool counter response: $response\n" );
		$parts = explode( ' ', $response, 2 );
		$responseType = $parts[0];
		switch ( $responseType ) {
			case 'ERROR':
				$parts = explode( ' ', $parts[1], 2 );
				$errorMsg = isset( $parts[1] ) ? $parts[1] : '(no message given)';
				return Status::newFatal( 'poolcounter-remote-error', $errorMsg );
			case 'ACK':
			case 'RELEASED':
			case 'COUNT':
				$parts = explode( ' ', $parts[1] );
				$key = array_shift( $parts );
				$attribs = $this->colonsToAssoc( $parts );
				$attribs['responseType'] = $responseType;
				return Status::newGood( $attribs );
		}
	}

	function colonsToAssoc( $items ) {
		$assoc = array();
		foreach ( $items as $item ) {
			$parts = explode( ':', $item, 2 );
			if ( count( $parts ) !== 2 ) {
				continue;
			}
			$assoc[$parts[0]] = $parts[1];
		}
		return $assoc;
	}

	function acquire() {
		$status = $this->sendCommand( 'acquire', $this->key, "max:{$this->maxThreads}" );
		if ( !$status->isOK() ) {
			return $status;
		}
		$response = $status->value;
		$count = isset( $response['count'] ) ? $response['count'] : 0;
		$this->isAcquired = true;
		if ( $count > $this->maxThreads ) {
			$response['overload'] = true;
			$this->release();
		}
		return Status::newGood( $response );
	}

	function release() {
		if ( $this->isAcquired ) {
			$status = $this->sendCommand( 'release', $this->key );
			$this->isAcquired = false;
		} else {
			$status = Status::newGood();
		}
		if ( $this->conn ) {
			self::$manager->close( $this->conn );
			$this->conn = null;
		}
		return $status;
	}

	function wait() {
		$status = $this->sendCommand( 'wait', $this->key, "timeout:{$this->waitTimeout}" );
		if ( !$status->isOK() ) {
			return $status;
		}
		$this->isAcquired = true;
		return $status;
	}
}
