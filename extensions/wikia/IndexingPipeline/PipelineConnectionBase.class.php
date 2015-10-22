<?php
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class PipelineConnectionBase {
	const DURABLE_MESSAGE = 2;
	const MESSAGE_TTL = 900000; //15m

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

	public function __construct() {
		global $wgIndexingPipeline;
		$this->host = $wgIndexingPipeline[ 'host' ];
		$this->port = $wgIndexingPipeline[ 'port' ];
		$this->user = $wgIndexingPipeline[ 'user' ];
		$this->pass = $wgIndexingPipeline[ 'pass' ];
		$this->vhost = $wgIndexingPipeline[ 'vhost' ];
		$this->exchange = $wgIndexingPipeline[ 'exchange' ];
		$this->deadExchange = $wgIndexingPipeline[ 'deadExchange' ];
	}

	public function publish( $routingKey, $body ) {
		$channel = $this->getChannel();
		$channel->basic_publish(
			new AMQPMessage( json_encode( $body ), [
				'delivery_mode' => self::DURABLE_MESSAGE,
				'expiration' => self::MESSAGE_TTL
			] ),
			$this->exchange,
			$routingKey
		);
	}

	/** @return \PhpAmqpLib\Channel\AMQPChannel */
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
