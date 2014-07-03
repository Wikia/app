<?php

require_once __DIR__.'/../../../lib/composer/autoload.php';

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

trait IndexerWorkerBase {

	protected $city_id;
	private $host;
	private $port;
	private $user;
	private $password;
	private $vhost;
	private $connection;
	private $main_channel;
	private $anon_channel;
	private $exchange = 'test_ex';
	private $prefetch = 5;
	private $deadLetterExchange = 'dead_bodies';

	public function execute() {
		if (function_exists('xdebug_disable')) {
			xdebug_disable();
		}
		if ( !$this->getParamsFromEnv() ) {
			$this->output('Some params are not set in env, please check: RABBITMQ_HOST, RABBITMQ_PORT, RABBITMQ_USER, RABBITMQ_PASSWORD, RABBITMQ_VHOST.');
			die;
		}
		$this->preprocess();
		$routing = $this->getRoutingKey();
		if ( $routing ) {
			$this->main_channel = $this->connect( $this->getRoutingKey() );
			while( count( $this->main_channel->callbacks ) ) {
				$this->main_channel->wait();
			}
			$this->main_channel->close();
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
		$exchange = ($exchange !== null) ? $exchange : $this->exchange;
		$channel = $this->getAnonChannel();
		$channel->basic_publish( new AMQPMessage( json_encode( $data ) ), $exchange, $routing );
	}

	protected function close() {
		$connection = $this->getConnection();
		$this->getAnonChannel()->close();
		$this->main_channel->close();
		$connection->close();
		die();
	}

	protected function output($text) {
		print_r($text);
	}

	protected function process( $data ) {}
	protected function getRoutingKey() {
		return false;
	}
	protected function preprocess() {}
	protected function postprocess() {}

	private function getParamsFromEnv() {
		$this->host = $this->getFromEnv( 'RABBITMQ_HOST' );
		$this->port = $this->getFromEnv( 'RABBITMQ_PORT' );
		$this->user = $this->getFromEnv( 'RABBITMQ_USER' );
		$this->password = $this->getFromEnv( 'RABBITMQ_PASSWORD' );
		$this->vhost = $this->getFromEnv( 'RABBITMQ_VHOST' );
		$this->city_id = $this->getFromEnv( 'SERVER_ID' );
		return $this->host && $this->port && $this->user && $this->password && $this->vhost;
	}

	private function getFromEnv( $param ) {
		return getenv($param);
	}

	private function connect( $routing_key, $exchange = null ) {
		$exchange = $exchange !== null ? $exchange : $this->exchange;
		$queue = $this->getQueueName( $routing_key );
		$connection = $this->getConnection();
		$channel = $connection->channel();
		$channel->queue_declare( $queue, false, true, false, false, false,
			[ 'x-dead-letter-exchange' => [ 'S', $this->deadLetterExchange ] ] );
		$channel->queue_bind( $queue, $exchange, $routing_key );
		$channel->basic_qos( null, $this->prefetch, null );
		$channel->basic_consume( $queue, "", false, false, false, false, array( $this, 'route' ) );
		return $channel;
	}

	private function getQueueName($routing_key) {
		return implode('.', [get_class($this), $routing_key, 'queue']);
	}

	private function getAnonChannel() {
		if ( !isset( $this->anon_channel ) ) {
			$connection = $this->getConnection();
			$this->anon_channel = $connection->channel();
		}
		return $this->anon_channel;
	}

	private function getConnection() {
		if ( !isset( $this->connection ) ) {
			return new AMQPConnection($this->host, $this->port, $this->user, $this->password, $this->vhost);
		}
		return $this->connection;
	}
}