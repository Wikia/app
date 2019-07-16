<?php

namespace Wikia\Rabbit;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Exception\AMQPExceptionInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Wikia\CircuitBreaker\CircuitBreakerFactory;
use Wikia\Factory\ServiceFactory;
use Wikia\Logger\WikiaLogger;
use Wikia\Tracer\WikiaTracer;
use Wikia\Util\Statistics\BernoulliTrial;

class ConnectionBase {
	const DURABLE_MESSAGE = 2;
	const MESSAGE_TTL = 57600000; //16h
	const ACK_WAIT_TIMEOUT_SECONDS = 0.3;
	const RABBITMQ_CIRCUIT_BREAKER = "rabbitmq";

	protected $vhost;
	protected $exchange;
	protected $circuitBreaker;

	public function __construct( $wgConnectionCredentials ) {
		$this->vhost = $wgConnectionCredentials[ 'vhost' ];
		$this->exchange = $wgConnectionCredentials[ 'exchange' ];
		$this->circuitBreaker = CircuitBreakerFactory::GetCircuitBreaker( new BernoulliTrial(0.01) );
	}

	/**
	 * @param $routingKey
	 * @param $body
	 */
	public function publish( $routingKey, $body ) {
		if ( !$this->circuitBreaker->OperationAllowed( self::RABBITMQ_CIRCUIT_BREAKER ) ) {
			WikiaLogger::instance()->warning( __METHOD__ . ": circuit breaker open", [
				'routing_key' => $routingKey,
			]);

			return;
		}

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

			$channel->wait_for_pending_acks( self::ACK_WAIT_TIMEOUT_SECONDS );

			$this->circuitBreaker->SetOperationStatus( self::RABBITMQ_CIRCUIT_BREAKER, true );
		} catch ( AMQPExceptionInterface $e ) {
			$this->circuitBreaker->SetOperationStatus( self::RABBITMQ_CIRCUIT_BREAKER, false );

			WikiaLogger::instance()->error( __METHOD__, [
				'exception' => $e,
				'routing_key' => $routingKey,
			] );
		} catch ( \ErrorException $e ) {
			$this->circuitBreaker->SetOperationStatus( self::RABBITMQ_CIRCUIT_BREAKER, false );

			WikiaLogger::instance()->error( __METHOD__, [
				'exception' => $e,
				'routing_key' => $routingKey,
			] );
		}
	}

	protected function getChannel(): AMQPChannel {
		return ServiceFactory::instance()->rabbitFactory()->connectionManager()->getChannel( $this->vhost );
	}

}
