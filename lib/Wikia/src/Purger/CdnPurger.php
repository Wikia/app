<?php

namespace Wikia\Purger;

use VignetteRequest;
use Wikia\Logger\Loggable;
use Wikia\Rabbit\TaskProducer;
use Wikia\Rabbit\TaskPublisher;

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
class CdnPurger implements TaskProducer, Purger {

	use Loggable;

	const SERVICE_MEDIAWIKI = 'mediawiki';
	const SERVICE_THUMBLR = 'thumblr.mediawiki';

	/** @var array $buckets */
	private $buckets = [
		self::SERVICE_MEDIAWIKI => [
			'urls' => [],
			'keys' => [],
		],
		self::SERVICE_THUMBLR => [
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
				$this->buckets[self::SERVICE_THUMBLR]['urls'][] = $item;
			} else {
				$this->buckets[self::SERVICE_MEDIAWIKI]['urls'][] = $item;
			}
		}
	}

	/**
	 * SUS-81: allow CDN purging by surrogate key
	 * Use Wikia::setSurrogateKeysHeaders helper to emit proper headers
	 * @param string $key surrogate key to purge
	 */
	public function addSurrogateKey( string $key ) {
		$this->buckets[self::SERVICE_MEDIAWIKI]['keys'][] = $key;

		$this->info(
			'varnish.purge',
			[
				'key' => $key,
				'service' => self::SERVICE_MEDIAWIKI,
			]
		);
	}

	public function getTasks() {
		$urlsByService = [];

		foreach ( $this->buckets as $service => $data ) {
			if ( !empty( array_filter( $data ) ) ) {
				yield new CdnPurgerTask( $service, $data['urls'], $data['keys'] );
			}

			$urlsByService[$service] = $data['urls'];
		}

		// log purges using Kibana (BAC-1317)
		$context = [
			'urls' => $urlsByService,
		];

		$this->info( 'varnish.purge', $context );
	}
}
