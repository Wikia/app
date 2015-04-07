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
		$caller = self::getPurgeCaller();
		wfDebug( "Purging backtrace: " . wfGetAllCallers( false ) . "\n" );

		// Filter urls into buckets based on service backend
		$buckets = array_reduce($urlArr, function($carry, $item) use ( $caller ){
			global $wgPurgeVignetteUsingSurrogateKeys;

			wfDebug( "Purging URL $item from $caller via Celery\n" );

			if ( isset($wgPurgeVignetteUsingSurrogateKeys) && VignetteRequest::isVignetteUrl($item) ) {
				$carry['vignette'][] = $item;
			} elseif ( strstr($item, 'MercuryApi') !== false ) {
				$carry['mercury'][] = $item;
				$carry['mediawiki'][] = $item;  // TODO: we can remove this when mercury is only using internal cache
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

		if (empty(CeleryPurge::$buckets)) return true;

		// log purges using Kibana (BAC-1317)
		$context = [
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

	/**
	 * Return the name of the method (outside of the internal code) that triggered purge request
	 *
	 * @return string method name
	 */
	private static function getPurgeCaller() {
		return wfGetCallerClassMethod( [ __CLASS__, 'SquidUpdate', 'WikiPage', 'Article', 'Title', 'WikiaDispatchableObject' ] );
	}
}