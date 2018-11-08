<?php

namespace Wikia\Rabbit;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPExceptionInterface;
use Wikia\Logger\Loggable;

/**
 * Provides access to managed RabbitMQ channels
 */
class ConnectionManager {

	use Loggable;

	/** @var string $host */
	private $host;
	/** @var int $port */
	private $port;
	/** @var string $user */
	private $user;
	/** @var string $pass */
	private $pass;

	/** @var AbstractConnection[] $connections */
	private $connections = [];
	/** @var AMQPChannel[] $channels */
	private $channels = [];

	public function __construct( string $host, int $port, string $user, string $pass ) {
		$this->host = $host;
		$this->port = $port;
		$this->user = $user;
		$this->pass = $pass;

		// free resources on request shutdown
		register_shutdown_function( [ $this, 'close' ] );
	}

	/**
	 * Return the Rabbit channel opened for the specified virtual host.
	 * If there is no open channel or connection yet, one will be created.
	 * The returned channel will be in confirm mode.
	 *
	 * @see https://www.rabbitmq.com/confirms.html
	 *
	 * @param string $vHost
	 * @return AMQPChannel
	 */
	public function getChannel( string $vHost ): AMQPChannel {
		if ( !isset( $this->channels[$vHost] ) ) {
			$this->channels[$vHost] = $this->getConnection( $vHost )->channel();

			// Allow basic_publish to fail in case the connection is blocked by rabbit, due to insufficient resources.
			// https://www.rabbitmq.com/alarms.html
			$this->channels[$vHost]->confirm_select();
		}

		return $this->channels[$vHost];
	}

	private function getConnection( string $vHost ): AbstractConnection {
		if ( !isset( $this->connections[$vHost] ) ) {
			$this->connections[$vHost] = new AMQPStreamConnection(
				$this->host,
				$this->port,
				$this->user,
				$this->pass,
				$vHost
			);
		}

		return $this->connections[$vHost];
	}

	/**
	 * Close all RabbitMQ connections (and their channels) managed by this instance.
	 * Called at the end of the request lifecycle.
	 */
	public function close() {
		foreach ( $this->connections as $vHost => $connection ) {
			try {
				$connection->close();
			} catch ( AMQPExceptionInterface $e ) {
				$this->error( "Failed to close Rabbit connection for vHost: $vHost", [ 'exception' => $e ] );
			}
		}

		$this->channels = [];
		$this->connections = [];
	}
}
