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
	const KEYS = 'keys';
	const URLS = 'urls';

	/** @var array $buckets */
	private $buckets = [
		self::SERVICE_MEDIAWIKI => [
			self::URLS => [],
			self::KEYS => [],
		],
		self::SERVICE_THUMBLR => [
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
			if ( filter_var( $item, FILTER_VALIDATE_URL ) === false ) {
				$exceptionWithStackTrace = new \RuntimeException( 'Invalid URL ' . $item );
				$this->error(
					'The URL provided for purging is not valid',
					[ 'url' => $item, 'exception' => $exceptionWithStackTrace ]
				);
			}
			if ( $wgPurgeVignetteUsingSurrogateKeys === true && VignetteRequest::isVignetteUrl( $item ) ) {
				try {
					$key = ThumblrSurrogateKey::fromUrl( $item );
					$this->buckets[self::SERVICE_THUMBLR][self::KEYS][] = $key->value();
				}
				catch ( \Exception $e ) {
					$this->buckets[self::SERVICE_THUMBLR][self::URLS][] = $item;
					$this->error( 'Failed to add Vignette URL', [ 'exception' => $e ] );
				}
			} else {
				$this->buckets[self::SERVICE_MEDIAWIKI][self::URLS][] = $item;
			}
		}
	}

	public function addThumblrSurrogateKey( string $key ) {
		$this->buckets[self::SERVICE_THUMBLR][self::KEYS][] = $key;

		$this->info(
			'varnish.purge',
			[
				'key' => $key,
				'service' => self::SERVICE_THUMBLR,
			]
		);
	}

	/**
	 * SUS-81: allow CDN purging by surrogate key
	 * Use Wikia::setSurrogateKeysHeaders helper to emit proper headers
	 * @param string $key surrogate key to purge
	 */
	public function addSurrogateKey( string $key ) {
		$this->buckets[self::SERVICE_MEDIAWIKI][self::KEYS][] = $key;

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
		$keysByService = [];

		foreach ( $this->buckets as $service => $data ) {
			if ( !empty( $data ) && ( !empty( $data[self::URLS] ) || !empty( $data[self::KEYS] ) ) ) {
				yield new CdnPurgerTask( $service, $data[self::URLS], $data[self::KEYS] );
			}
			$urlsByService[$service] = $data[self::URLS];
			$keysByService[$service] = $data[self::KEYS];
		}

		// log purges using Kibana (BAC-1317)
		$this->info(
			'varnish.purge',
			[
				self::URLS => $urlsByService,
				self::KEYS => $urlsByService,
			]
		);
	}
}
