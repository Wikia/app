<?php

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class PipelineConnectionBase {
	const DURABLE_MESSAGE = 2;
	const NO_REQUEUE = false;
	const MESSAGE_TTL = 900000; //15m
	/** @var Array Should be one element array with ['routing_key' => callable [callback]] schema */
	public static $binding;
	/** @var int Sets prefetched messages number */
	public static $prefetch = 5;

	protected $host;
	protected $port;
	protected $user;
	protected $pass;
	protected $vhost;
	protected $exchange;

	/** @var AMQPConnection Holds worker main rabbitmq connection */
	protected $connection;
	/** @var  \PhpAmqpLib\Channel\AMQPChannel Holds worker main channel */
	protected $mainChannel;
	/** @var  AMQPConnection Holds worker publish connection */
	protected $publishConnection;
	/** @var  \PhpAmqpLib\Channel\AMQPChannel Holds anon channel for publishing */
	protected $publishChannel;

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

	public function run() {
		$channel = $this->setUpMainChannel();
		while ( count( $channel->callbacks ) ) {
			$channel->wait();
		}
		$this->closeMainChannel();
		$this->closeMainConnection();
	}

	public function publish( String $routingKey, Mixed $body ) {
		$channel = $this->getAnonChannel();
		return $channel->basic_publish(
			new AMQPMessage( json_encode( $body ), [
				'delivery_mode' => self::DURABLE_MESSAGE,
				'expiration' => self::MESSAGE_TTL
			] ),
			$this->exchange,
			$routingKey
		);
	}

	/**
	 * Will ack on all true and null results, on false no action, on error no_ack
	 * @param AMQPMessage $msg
	 */
	protected function route( AMQPMessage $msg ) {
		try {
			$result = call_user_func( self::$binding[ 0 ], json_decode( $msg->body ) );
		} catch ( Exception $e ) {
			$msg->delivery_info[ 'channel' ]->basic_reject( $msg->delivery_info[ 'delivery_tag' ], self::NO_REQUEUE );
		}
		if ( !isset( $result ) || $result ) {
			$msg->delivery_info[ 'channel' ]->basic_ack( $msg->delivery_info[ 'delivery_tag' ] );
		}
	}

	/** @return \PhpAmqpLib\Channel\AMQPChannel */
	protected function getAnonChannel() {
		if ( !isset( $this->publishChannel ) || !$this->publishChannel->isConnected() ) {
			$connection = $this->getPublishConnection();
			$this->publishChannel = $connection->channel();
			$this->publishChannel->exchange_declare( $this->exchange, 'topic', false, true );
		}
		return $this->publishChannel;
	}

	/** @return \PhpAmqpLib\Channel\AMQPChannel */
	protected function setUpMainChannel() {
		// check if binding was set
		if ( is_array( self::$binding ) && is_callable( self::$binding[ 0 ] ) ) {
			if ( !isset( $this->mainChannel ) ) {
				$connection = $this->getMainConnection();
				$this->mainChannel = $connection->channel();
				$qName = $this->getQueueName();
				$this->mainChannel->queue_declare( $qName, false, true, false, true, false, [
					'x-dead-letter-exchange' => [ 'S', $this->deadExchange ]
				] );
				$this->mainChannel->queue_bind( $qName, $this->exchange, key( self::$binding ) );
				$this->mainChannel->basic_qos( self::$prefetch );
				$this->mainChannel->basic_consume( $qName, '', false, false, false, fales, [ $this, 'route' ] );
			}
			return $this->mainChannel;
		}
		throw new WikiaException( 'Binding must be set in child class' );
	}

	protected function closeMainChannel() {
		if ( isset( $this->mainChannel ) ) {
			$this->mainChannel->close();
			unset( $this->mainChannel );
		}
	}

	protected function getQueueName() {
		return get_class( $this ) . '.queue';
	}

	protected function setConnection( &$connection ) {
		if ( isset( $connection ) ) {
			/** @var AMQPConnection $connection */
			$reconnect = !$connection->isConnected();
		}
		if ( !isset( $connection ) || $reconnect ) {
			return new AMQPConnection( $this->host, $this->port, $this->user, $this->pass );
		}
		return $connection;
	}

	protected static function closeConnection( &$connection ) {
		if ( isset( $connection ) ) {
			$connection->close();
			unset( $connection );
		}
	}

	/** @return AMQPConnection */
	protected function getMainConnection() {
		return $this->setConnection( $this->connection );
	}

	protected function closeMainConnection() {
		$this->closeConnection( $this->connection );
	}

	/** @return AMQPConnection */
	protected function getPublishConnection() {
		return $this->setConnection( $this->publishConnection );
	}

	protected function closePublishConnection() {
		$this->closeConnection( $this->publishConnection );
	}
}