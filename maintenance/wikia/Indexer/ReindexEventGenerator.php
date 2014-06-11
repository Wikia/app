<?php

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class ReindexEventGenerator extends Maintenance {

	const WG_CONTENT_NAMESPACES_KEY = 'wgContentNamespaces';
	const DEFAULT_EXCHANGE = 'test_ex';
	protected $host;
	protected $port;
	protected $user;
	protected $password;
	protected $vhost;
	protected $city_id;

	protected $connections = [];
	/**
	 * Do the actual work. All child classes will need to implement this
	 */
	public function execute() {
		if ( !$this->get_params_from_env() ) {
			die;
		}
		$db = wfGetDB( DB_SLAVE );
		$namespaces = WikiFactory::getVarValueByName( self::WG_CONTENT_NAMESPACES_KEY, $this->city_id );
		( new WikiaSQL() )->SELECT('page_id')->FROM('page')->WHERE('page_namespace')->IN($namespaces)
			->runLoop($db, function (&$d, $row) {
			$msg = new stdClass();
			$msg->cityId = $this->city_id;
			$msg->pageId = $row->page_id;
			$this->publish('article.index', $msg);
		});
	}

	protected function get_params_from_env() {
		$this->host = $this->get_from_env( 'RABBITMQ_HOST' );
		$this->port = $this->get_from_env( 'RABBITMQ_PORT' );
		$this->user = $this->get_from_env( 'RABBITMQ_USER' );
		$this->password = $this->get_from_env( 'RABBITMQ_PASSWORD' );
		$this->vhost = $this->get_from_env( 'RABBITMQ_VHOST' );
		$this->city_id = $this->get_from_env( 'SERVER_ID' );
		return $this->host && $this->port && $this->user && $this->password && $this->vhost;
	}

	protected function get_from_env( $param ) {
		return isset( $_ENV[ $param ] ) ? $_ENV[ $param ] : false;
	}

	protected function publish( $routing, $data, $exchange = null ) {
		$exchange = $exchange != null ? $exchange : static::DEFAULT_EXCHANGE;
		$channel = $this->get_channel($exchange);
		$channel->basic_publish( new AMQPMessage( json_encode( $data ) ), $exchange, $routing );
	}

	protected function get_connection() {
		return new AMQPConnection($this->host, $this->port, $this->user, $this->password, $this->vhost);
	}

	/** @return PhpAmqpLib\Channel\AMQPChannel */
	protected function get_channel($exchange=null) {
		$exchange = $exchange != null ? $exchange : static::DEFAULT_EXCHANGE;
		if ( !isset( $this->connections[ $exchange ] ) ) {
			$connection = $this->get_connection();
			$channel = $connection->channel();
			$channel->exchange_declare( $exchange, 'topic', false, true, false, false );
			$this->connections[ $exchange ] = $channel;
		}
		return $this->connections[ $exchange ];
	}
}

$maintClass = 'ReindexEventGenerator';
require( RUN_MAINTENANCE_IF_MAIN );
