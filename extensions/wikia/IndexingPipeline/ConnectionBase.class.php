<?php

namespace Wikia\IndexingPipeline;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class ConnectionBase {
	const DURABLE_MESSAGE = 2;
	const MESSAGE_TTL = 57600000; //16h

	protected $host;
	protected $port;
	protected $user;
	protected $pass;
	protected $vhost;
	protected $exchange;
	protected $deadExchange;

	/** @var  AMQPConnection Holds worker publish connection */
	protected $connection;
	/** @var  \PhpAmqpLib\Channel\AMQPChannel Holds anon channel for publishing */
	protected $channel;

	public function __construct( $wgConnectionCredentials ) {
		$this->host = $wgConnectionCredentials[ 'host' ];
		$this->port = $wgConnectionCredentials[ 'port' ];
		$this->user = $wgConnectionCredentials[ 'user' ];
		$this->pass = $wgConnectionCredentials[ 'pass' ];
		$this->vhost = $wgConnectionCredentials[ 'vhost' ];
		$this->exchange = $wgConnectionCredentials[ 'exchange' ];
		$this->deadExchange = $wgConnectionCredentials[ 'deadExchange' ];
	}

	/**
	 * @param $routingKey
	 * @param $body
	 */
	public function publish( $routingKey, $body ) {
		$channel = $this->getChannel();
		try {
			$channel->basic_publish(
				new AMQPMessage( json_encode( $body ), [
					'delivery_mode' => self::DURABLE_MESSAGE,
					'expiration' => self::MESSAGE_TTL
				] ),
				$this->exchange,
				$routingKey
			);
		} catch ( \Exception $e ) {
			\Wikia\Logger\WikiaLogger::instance()->error( $e->getMessage() );
		}
	}

	protected function getChannel() {
		if ( !isset( $this->channel ) || !$this->channel->is_open ) {
			$pubConn = $this->getConnection();
			$this->channel = $pubConn->channel();
		}

		return $this->channel;
	}

	protected function createConnection() {
		return new AMQPConnection( $this->host, $this->port, $this->user, $this->pass, $this->vhost );
	}

	/** @return AMQPConnection */
	protected function getConnection() {
		if ( !isset( $this->connection ) ) {
			$this->connection = $this->createConnection();
		}

		return $this->connection;
	}

	protected function closeConnection() {
		if ( isset( $this->connection ) ) {
			$this->connection->close();
			unset( $this->connection );
		}
	}
}
