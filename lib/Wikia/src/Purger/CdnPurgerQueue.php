<?php

namespace Wikia\Purger;

use VignetteRequest;
use Wikia\Logger\Loggable;
use Wikia\Rabbit\TaskProducer;
use Wikia\Rabbit\TaskPublisher;

/**
 * Use cdn-purger service / RabbitMQ queue to send purge requests to Fastly and Wikia CDN.
 *
 * This class will enqueue all URLs and send list of unique URLs at the end of the request handling.
 */
class CdnPurgerQueue implements TaskProducer, PurgerQueue {

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
			if ( $wgPurgeVignetteUsingSurrogateKeys === true && VignetteRequest::isVignetteUrl( $item ) ) {
				try {
					$key = ThumblrSurrogateKey::fromUrl( $item );
					$this->buckets[self::SERVICE_THUMBLR]['key'][] = $key->value();
				}
				catch ( \Exception $e ) {
					$this->buckets[self::SERVICE_MEDIAWIKI]['urls'][] = $item;
					$this->error( 'Failed to add Vignette URL', [ 'exception' => $e ] );
				}
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
