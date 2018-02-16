<?php

/**
 * EdgeCachePurger - purge CDN cache using either URL or surrogate keys
 *
 * This task is a little bit customized when compared with the rest of BaseTask.
 * It does not run a PHP-powered task, but "celery_workers.purger.purge" Python task that sends PURGE requests to our CDN.
 *
 * @author macbre
 */

namespace Wikia\Tasks\Tasks;

use Wikia\Tasks\AsyncCeleryTask;
use Wikia\Tasks\Queues\PurgeQueue;

class EdgeCachePurger extends BaseTask {

	// task to be run by Celery to actually perform the purge
	const TASK_NAME = 'celery_workers.purger.purge';

	// list services registered in our CDN
	// refer to celeryd.conf.erb in "amqp" Chef cookbook ([purger.*] sections)
	const MEDIAWIKI_SERVICE = 'mediawiki';
	const VIGNETTE_SERVICE = 'vignette';
	const MERCURY_SERVICE = 'mercury';

	private $urls, $keys, $service;

	/**
	 * @param array $urls list of URLs to purge
	 * @param array $keys list of surrogate keys to purge
	 * @param $service Fastly service name
	 */
	public function __construct( Array $urls, Array $keys, $service ) {
		$this->urls = $urls;
		$this->keys = $keys;
		$this->service = $service;
	}

	public function queue() {
		( new AsyncCeleryTask() )
			->taskType( self::TASK_NAME )
			->setArgs( $this->urls, $this->keys, $this->service )
			->setPriority( PurgeQueue::NAME ) // use PurgeQueue queue
			->queue();
	}
}
