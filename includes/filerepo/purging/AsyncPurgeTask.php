<?php

use Wikia\Tasks\AsyncTaskList;
use Wikia\Tasks\Tasks\BaseTask;

class AsyncPurgeTask extends BaseTask {

	public function publish( $originalUrl, $thumbnailUrls ) {
		global $wgCityId;

		$task = ( new AsyncPurgeTask() )->title( $this->title );
		$taskLists[] =
			( new AsyncTaskList() )->wikiId( $wgCityId )
				->add( $task->call( 'removeThumbnailsInThumblr', $originalUrl ) )
				->add( $task->call( 'purgerUrls', $thumbnailUrls ) );

		return AsyncTaskList::batch( $taskLists );
	}

	public function removeThumbnailsInThumblr( $originalUrl ) {
		global $wgThumblrUrl, $wgVignetteUrl;

		// replace base URL - we need to call Thumblr internally
		$removeThumbnailsUrl = str_replace( $wgVignetteUrl, $wgThumblrUrl, $originalUrl );

		if ( substr( $removeThumbnailsUrl, - 1 ) != '/' ) {
			$removeThumbnailsUrl = $removeThumbnailsUrl . '/';
		}
		$removeThumbnailsUrl = $removeThumbnailsUrl . "thumbnails";

		Wikia\Logger\WikiaLogger::instance()->debug( __METHOD__ . ' - Remove thumbnails URL', [
			'remove_thumbnails_url' => $removeThumbnailsUrl,
		] );

		\Http::request( "DELETE", $removeThumbnailsUrl );
	}

	public function purgerUrls( $thumbnailUrls ) {
		// This is another async event but it cannot happen before we call Thumblr to clear thumbs in GCS
		SquidUpdate::purge( $thumbnailUrls );
	}
}
