<?php

namespace Wikia\Purger;

use VignetteRequest;
use Wikia\Logger\Loggable;
use Wikia\Rabbit\TaskProducer;
use Wikia\Rabbit\TaskPublisher;
use Wikia\Tasks\AsyncCeleryTask;
use Wikia\Tasks\Queues\PurgeQueue;

/**
 * Use Celery / RabbitMQ queue to send purge requests to Fastly
 *
 * This class will enqueue all URLs and send list of unique URLs at the end of the request handling
 *
 * Each service has different options so it must be a different task for each one.
 * If there are going to be a lot of them, we should change the parameters to the celery worker
 *
 * @author Owen
 * @author macbre
 */

class CeleryPurger implements TaskProducer {

	use Loggable;

	// task to be run by Celery to actually perform the purge
	const TASK_NAME = 'celery_workers.purger.purge';

	/** @var array $buckets */
	private $buckets = [
		'mediawiki' => [
			'urls' => [],
			'keys' => [],
		],
		'mercury' => [
			'urls' => [],
			'keys' => [],
		],
		'vignette' => [
			'urls' => [],
			'keys' => [],
		],
	];

	public function __construct( TaskPublisher $taskPublisher ) {
		$taskPublisher->registerProducer( $this );
	}

	public function addUrls( array $urls ) {
		global $wgPurgeVignetteUsingSurrogateKeys;

		foreach ( $urls as $item ) {
			if ( isset( $wgPurgeVignetteUsingSurrogateKeys ) && VignetteRequest::isVignetteUrl( $item ) ) {
				$this->buckets['vignette']['urls'][] = $item;
			} elseif ( strstr( $item, 'MercuryApi' ) !== false ) {
				$this->buckets['mercury']['urls'][] = $item;
				// TODO: we can remove this when mercury is only using internal cache
				$this->buckets['mediawiki']['urls'][] = $item;
			} else {
				$this->buckets['mediawiki']['urls'][] = $item;
			}
		}
	}

	/**
	 * SUS-81: allow CDN purging by surrogate key
	 *
	 * Use Wikia::setSurrogateKeysHeaders helper to emit proper headers
	 *
	 * @param string $key surrogate key to purge
	 * @param string $service Fastly's service name (defaults to "mediawiki")
	 */
	public function addSurrogateKey( string $key, string $service = 'mediawiki' ) {
		$this->buckets[$service]['keys'][] = $key;

		$this->info( 'varnish.purge', [
			'key' => $key,
			'service' => $service
		] );
	}

	public function getTasks() {
		$urlsByService = [];

		foreach ( $this->buckets as $service => $data ) {
			if ( !empty( array_filter( $data ) ) ) {
				$task = new AsyncCeleryTask();

				$task->taskType( self::TASK_NAME );
				$task->setArgs( $data['urls'], $data['keys'], $service );
				$task->setQueue( PurgeQueue::NAME );

				yield $task;
			}

			$urlsByService[$service] = $data['urls'];
		}

		// log purges using Kibana (BAC-1317)
		$context = [
			'urls' => $urlsByService
		];

		$this->info( 'varnish.purge', $context );
	}
}
