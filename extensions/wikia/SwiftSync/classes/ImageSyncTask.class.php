<?php

namespace Wikia\SwiftSync;

use Wikia\Tasks\Tasks\BaseTask;

/**
 * A Celery task that is run to synchronize SJC and RES DFS storage
 *
 * @see SUS-3611
 */
class ImageSyncTask extends BaseTask {

	public static function newLocalTask(): self {
		global $wgCityId;
		return ( new self() )->wikiId( $wgCityId );
	}

	public function synchronize( array $params ) {
		$this->info( 'Task started' );
		$this->info( json_encode( $params ) );
	}
}
