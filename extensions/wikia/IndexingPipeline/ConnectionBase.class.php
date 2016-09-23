<?php

namespace Wikia\IndexingPipeline;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Exception\AMQPExceptionInterface;
use PhpAmqpLib\Message\AMQPMessage;
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
		try {
			$channel = $this->getChannel();

			$channel->basic_publish(
				new AMQPMessage( json_encode( $body ), [
					'delivery_mode' => self::DURABLE_MESSAGE,
					'expiration' => self::MESSAGE_TTL,
					'app_id' => 'mediawiki',
					'correlation_id' => WikiaTracer::instance()->getTraceId(),
				] ),
				$this->exchange,
				$routingKey
			);
		} catch ( AMQPExceptionInterface $e ) {
			\Wikia\Logger\WikiaLogger::instance()->error( __METHOD__, [
				'exception' => $e,
				'routing_key' => $routingKey,
			] );
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
