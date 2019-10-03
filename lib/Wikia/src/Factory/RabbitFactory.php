<?php
namespace Wikia\Factory;

use Wikia\CircuitBreaker\ServiceCircuitBreaker;
use Wikia\Rabbit\ConnectionManager;
use Wikia\Rabbit\DefaultTaskPublisher;
use Wikia\Rabbit\NullTaskPublisher;
use Wikia\Rabbit\TaskPublisher;

class RabbitFactory extends AbstractFactory {

	/** @var ConnectionManager $rabbitConnectionManager */
	private $rabbitConnectionManager;

	/** @var TaskPublisher $taskPublisher */
	private $taskPublisher;

	/** @var ServiceCircuitBreaker */
	private $circuitBreaker;

	public function __construct( ServiceFactory $factory ) {
		parent::__construct( $factory );
		$this->circuitBreaker = ServiceFactory::instance()->circuitBreakerFactory()->getCircuitBreaker( 'rabbitmq' );
	}

	/**
	 * @param ConnectionManager $rabbitConnectionManager
	 */
	public function setRabbitConnectionManager( ConnectionManager $rabbitConnectionManager ) {
		$this->rabbitConnectionManager = $rabbitConnectionManager;
	}

	/**
	 * @param TaskPublisher $taskPublisher
	 */
	public function setTaskPublisher( TaskPublisher $taskPublisher ) {
		$this->taskPublisher = $taskPublisher;
	}

	/**
	 * @return ConnectionManager
	 */
	public function connectionManager(): ConnectionManager {
		if ( !$this->rabbitConnectionManager ) {
			global $wgRabbitHost, $wgRabbitPort, $wgRabbitUser, $wgRabbitPass;

			$this->rabbitConnectionManager = new ConnectionManager(
				$wgRabbitHost,
				$wgRabbitPort,
				$wgRabbitUser,
				$wgRabbitPass,
				$this->circuitBreaker
			);
		}

		return $this->rabbitConnectionManager;
	}

	/**
	 * @return TaskPublisher
	 */
	public function taskPublisher(): TaskPublisher {
		if ( !$this->taskPublisher ) {
			$this->taskPublisher = $this->createTaskPublisher();
		}

		return $this->taskPublisher;
	}

	private function createTaskPublisher(): TaskPublisher {
		global $wgTaskBrokerDisabled;

		// PLATFORM-1740: Do not publish tasks if the broker is disabled
		if ( $wgTaskBrokerDisabled || !$this->circuitBreaker->operationAllowed() ) {
			return new NullTaskPublisher();
		}

		return new DefaultTaskPublisher( $this->connectionManager(), $this->circuitBreaker );
	}

	/**
	 * @return ServiceCircuitBreaker
	 */
	public function getCircuitBreaker(): ServiceCircuitBreaker {
		return $this->circuitBreaker;
	}
}
