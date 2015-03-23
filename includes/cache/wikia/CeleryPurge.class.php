<?php
/**
 * Use Celery / RabbitMQ queue to send purge requests to Fastly
 *
 * This class will enqueue all URLs and send list of unique URLs at the end of the request handling
 *
 * Each service has different options so it must be a different task for each one.
 * If there are going to be a lot of them, we should change the parameters to the celery worker
 *
 * @author Owen
 */

use Wikia\Logger\WikiaLogger;
use Wikia\Tasks\AsyncCeleryTask;
use Wikia\Tasks\Queues\PurgeQueue;


class CeleryPurge {

	private static $buckets;

	// Add some urls to the Task
	static function purge( $urlArr ) {
		global $wgPurgeVignetteUsingSurrogateKeys;

		// Filter urls into buckets based on service backend
		$buckets = array_reduce($urlArr, function($carry, $item) {
			if ( isset($wgPurgeVignetteUsingSurrogateKeys) && VignetteRequest::isVignetteUrl($item) ) {
				$carry['vignette'][] = $item;
			} elseif ( strstr($item, 'MercuryApi') !== false ) {
				$carry['mercury'][] = $item;
			} else {
				$carry['mediawiki'][] = $item;
			}
			return $carry;
		}, array('mediawiki' => [], 'vignette' => [], 'mercury' => []));

		if (empty(CeleryPurge::$buckets)) {
			CeleryPurge::$buckets = $buckets;
		} else {
			CeleryPurge::$buckets = array_merge_recursive(CeleryPurge::$buckets, $buckets);
		}
	}

	static function onRestInPeace() {
		global $wgCityId;

		if (empty(CeleryPurge::$buckets)) return true;

		// log purges using Kibana (BAC-1317)
		$context = [
			'city' => $wgCityId,
			'urls' => CeleryPurge::$buckets
		];
		WikiaLogger::instance()->info( 'varnish.purge', $context );

		// Queue the tasks
		foreach ( CeleryPurge::$buckets as $service => $urls) {
			if ( empty($urls) ) continue;
			( new AsyncCeleryTask() )
					->taskType('celery_workers.purger.purge')
					->setArgs( $urls, [], $service )
					->setPriority( PurgeQueue::NAME )
					->queue();
		}
		return true;
	}
}