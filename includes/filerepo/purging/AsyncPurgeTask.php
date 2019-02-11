<?php

use Wikia\Tasks\AsyncTaskList;
use Wikia\Tasks\Tasks\BaseTask;

class AsyncPurgeTask extends BaseTask {

	public function publish( $urls ) {
		global $wgCityId;

		$task = ( new AsyncPurgeTask() )->title( $this->title );
		$taskLists[] =
			( new AsyncTaskList() )->wikiId( $wgCityId )->add( $task->call( 'purgerUrls', $urls ) );

		return AsyncTaskList::batch( $taskLists );
	}

	public function purgerUrls( $urls ) {
		// TODO call thumblr to purge URLs in GCS

		// This is another async event but it cannot happen before we call thumblr to clear thumbs in GCS
		SquidUpdate::purge( $urls );
	}
}
