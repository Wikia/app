<?php

use Wikia\Factory\ServiceFactory;
use Wikia\Tasks\AsyncTaskList;
use Wikia\Tasks\Tasks\BaseTask;

class AsyncPurgeTask extends BaseTask {

	public function publish( $originalUrl, $thumbnailUrls ) {
		global $wgCityId;

		$task = ( new AsyncPurgeTask() )->title( $this->title );
		$taskLists[] =
			( new AsyncTaskList() )->wikiId( $wgCityId )->add( $task->call( 'removeThumbnails',
				$originalUrl, $thumbnailUrls ) );

		return AsyncTaskList::batch( $taskLists );
	}

	public function removeThumbnails( $originalUrl, $thumbnailUrls ) {
		$this->removeThumbnailsInThumblr( $originalUrl );
		$this->purgerUrls( $thumbnailUrls );
	}

	private function removeThumbnailsInThumblr( $originalUrl ) {
		global $wgVignetteUrl;

		$urlProvider = ServiceFactory::instance()->providerFactory()->urlProvider();
		$thumblrUrl = "http://{$urlProvider->getUrl( 'thumblr' )}/";

		// replace base URL - we need to call Thumblr internally
		$removeThumbnailsUrl = str_replace( $wgVignetteUrl, $thumblrUrl, $originalUrl );

		if ( substr( $removeThumbnailsUrl, - 1 ) != '/' ) {
			$removeThumbnailsUrl = $removeThumbnailsUrl . '/';
		}
		$removeThumbnailsUrl = $removeThumbnailsUrl . "thumbnails";

		Wikia\Logger\WikiaLogger::instance()->debug( __METHOD__ . ' - Remove thumbnails URL', [
			'remove_thumbnails_url' => $removeThumbnailsUrl,
		] );

		\Http::request( "DELETE", $removeThumbnailsUrl,
			[ 'headers' => [ 'X-Wikia-Internal-Request' => '1' ] ] );
	}

	private function purgerUrls( $thumbnailUrls ) {
		// This is another async event but it cannot happen before we call Thumblr to clear thumbs in GCS
		SquidUpdate::purge( $thumbnailUrls );
	}
}
