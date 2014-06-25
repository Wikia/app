<?php

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class IndexerWorkerBase extends Maintenance {

	const DEFAULT_EXCHANGE = 'test_ex';
	const PREFETCH_SIZE = 5;
	const DEADS = 'dead_bodies';
	protected $city_id;
	private $host;
	private $port;
	private $user;
	private $password;
	private $vhost;
	private $connection;
	private $anon_channel;

	public function execute() {
		if (function_exists('xdebug_disable')) {
			xdebug_disable();
		}
		if ( !$this->get_params_from_env() ) {
			$this->output('Some params are not set in env, please check: RABBITMQ_HOST, RABBITMQ_PORT, RABBITMQ_USER, RABBITMQ_PASSWORD, RABBITMQ_VHOST.');
			die;
		}
		$this->preprocess();
		$routing = $this->getRoutingKey();
		if ( $routing ) {
			$connection = $this->connect( $this->getRoutingKey() );
			while( count( $connection->callbacks ) ) {
				$connection->wait();
			}
			$connection->close();
		}
		$this->postprocess();
	}

	public function route( $req ) {
		$data = json_decode( $req->body );
		try {
			$res = $this->process( $data );
			if ( !isset( $res ) || $res ) {
				$req->delivery_info['channel']->basic_ack($req->delivery_info['delivery_tag']);
			} else {
				$req->delivery_info['channel']->basic_nack($req->delivery_info['delivery_tag']);
			}
		} catch (Exception $e) {
			$req->delivery_info['channel']->basic_nack($req->delivery_info['delivery_tag']);
		}
	}

	protected function publish( $routing, $data, $exchange = null ) {
		$exchange = ($exchange !== null) ? $exchange : static::DEFAULT_EXCHANGE;
		$channel = $this->get_anon_channel();
		$channel->basic_publish( new AMQPMessage( json_encode( $data ) ), $exchange, $routing );
	}

	protected function process( $data ) {}
	protected function getRoutingKey() {
		return false;
	}
	protected function preprocess() {}
	protected function postprocess() {}

	private function get_params_from_env() {
		$this->host = $this->get_from_env( 'RABBITMQ_HOST' );
		$this->port = $this->get_from_env( 'RABBITMQ_PORT' );
		$this->user = $this->get_from_env( 'RABBITMQ_USER' );
		$this->password = $this->get_from_env( 'RABBITMQ_PASSWORD' );
		$this->vhost = $this->get_from_env( 'RABBITMQ_VHOST' );
		$this->city_id = $this->get_from_env( 'SERVER_ID' );
		return $this->host && $this->port && $this->user && $this->password && $this->vhost;
	}

	private function get_from_env( $param ) {
		return getenv($param);
	}

	private function connect( $routing_key, $exchange = null ) {
		$exchange = $exchange !== null ? $exchange : static::DEFAULT_EXCHANGE;
		$queue = $this->get_queue_name( $routing_key );
		$connection = $this->get_connection();
		$channel = $connection->channel();
		$channel->queue_declare( $queue, false, true, false, false, false,
			[ 'x-dead-letter-exchange' => [ 'S', static::DEADS ] ] );
		$channel->queue_bind( $queue, $exchange, $routing_key );
		$channel->basic_qos( null, static::PREFETCH_SIZE, null );
		$channel->basic_consume( $queue, "", false, false, false, false, array( $this, 'route' ) );
		return $channel;
	}

	private function get_queue_name($routing_key) {
		return implode('.', [get_class($this), $routing_key, 'queue']);
	}

	private function get_anon_channel() {
		if ( !isset( $this->anon_channel ) ) {
			$connection = $this->get_connection();
			$this->anon_channel = $connection->channel();
		}
		return $this->anon_channel;
	}

	private function get_connection() {
		if ( !isset( $this->connection ) ) {
			return new AMQPConnection($this->host, $this->port, $this->user, $this->password, $this->vhost);
		}
		return $this->connection;
	}
}