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

class CeleryPurgerQueue implements TaskProducer, PurgerQueue {

	use Loggable;

	// task to be run by Celery to actually perform the purge
	const TASK_NAME = 'celery_workers.purger.purge';
	const SERVICE_MEDIAWIKI = 'mediawiki';
	const SERVICE_VIGNETTE = 'vignette';
	const KEYS = 'keys';
	const URLS = 'urls';

	/** @var array $buckets */
	private $buckets = [
		self::SERVICE_MEDIAWIKI => [
			self::URLS => [],
			self::KEYS => [],
		],
		self::SERVICE_VIGNETTE => [
			self::URLS => [],
			self::KEYS => [],
		],
	];

	public function __construct( TaskPublisher $taskPublisher ) {
		$taskPublisher->registerProducer( $this );
	}

	public function addUrls( array $urls ) {
		global $wgPurgeVignetteUsingSurrogateKeys;

		foreach ( $urls as $item ) {
			if ( $wgPurgeVignetteUsingSurrogateKeys === true && VignetteRequest::isVignetteUrl( $item ) ) {
				$this->buckets[self::SERVICE_VIGNETTE][self::URLS][] = $item;
			} else {
				$this->buckets[self::SERVICE_MEDIAWIKI][self::URLS][] = $item;
			}
		}
	}

	public function addThumblrSurrogateKey( string $key ) {
		$this->buckets[self::SERVICE_VIGNETTE][self::KEYS][] = $key;
		$this->info(
			'varnish.purge',
			[
				'key' => $key,
				'service' => self::SERVICE_VIGNETTE,
			]
		);
	}

	/**
	 * SUS-81: allow CDN purging by surrogate key
	 *
	 * Use Wikia::setSurrogateKeysHeaders helper to emit proper headers
	 *
	 * @param string $key surrogate key to purge
	 */
	public function addSurrogateKey( string $key ) {
		$this->buckets[self::SERVICE_MEDIAWIKI][self::KEYS][] = $key;

		$this->info( 'varnish.purge', [
			'key' => $key,
			'service' => self::SERVICE_MEDIAWIKI
		] );
	}

	public function getTasks() {
		$urlsByService = [];

		foreach ( $this->buckets as $service => $data ) {
			if ( !empty( array_filter( $data ) ) ) {
				$task = new AsyncCeleryTask();

				$task->taskType( self::TASK_NAME );
				$task->setArgs( $data[self::URLS], $data[self::KEYS], $service );
				$task->setQueue( PurgeQueue::NAME );

				yield $task;
			}

			$urlsByService[$service] = $data[self::URLS];
		}

		// log purges using Kibana (BAC-1317)
		$context = [
			self::URLS => $urlsByService
		];

		$this->info( 'varnish.purge', $context );
	}
}
