<?php

namespace Wikia\Rabbit;

use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPExceptionInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Wikia\Logger\WikiaLogger;
use Wikia\Tracer\WikiaTracer;

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

	/** @var  AbstractConnection Holds worker publish connection */
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
	 * @param $properties optional properties
	 */
	public function publish( $routingKey, $body ) {
		try {
			$channel = $this->getChannel();

			$channel->basic_publish(
				new AMQPMessage( json_encode( $body ), [
					'delivery_mode' => self::DURABLE_MESSAGE,
					'expiration' => self::MESSAGE_TTL,
					'app_id' => 'mediawiki',
					'timestamp' => time(),
					'correlation_id' => WikiaTracer::instance()->getTraceId(),
				] ),
				$this->exchange,
				$routingKey
			);
		} catch ( AMQPExceptionInterface $e ) {
			WikiaLogger::instance()->error( __METHOD__, [
				'exception' => $e,
				'routing_key' => $routingKey,
			] );
		}
	}

	protected function getChannel() {
		if ( !isset( $this->channel ) ) {
			$pubConn = $this->getConnection();
			$this->channel = $pubConn->channel();
		}

		return $this->channel;
	}

	protected function createConnection() {
		return new AMQPStreamConnection( $this->host, $this->port, $this->user, $this->pass, $this->vhost );
	}

	/** @return AMQPStreamConnection */
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
