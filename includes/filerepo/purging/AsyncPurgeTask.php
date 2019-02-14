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
		$url = $this->getRemoveThumbnailsUrl( $originalUrl );
		Wikia\Logger\WikiaLogger::instance()->info( __METHOD__ . ' - Remove thumbnails URL', [
			'remove_thumbnails_url' => $url,
		] );
		\Http::request( "DELETE", $url, [ 'headers' => [ 'X-Wikia-Internal-Request' => '1' ] ] );
	}

	private function getRemoveThumbnailsUrl( $originalUrl ) {
		global $wgVignetteUrl;

		$urlProvider = ServiceFactory::instance()->providerFactory()->urlProvider();
		$thumblrUrl = "http://{$urlProvider->getUrl( 'thumblr' )}/";

		// replace base URL - we need to call Thumblr internally
		$url = str_replace( $wgVignetteUrl, $thumblrUrl, $originalUrl );

		// remove the query parameters if provided
		if ( strpos( $url, '?' ) !== false ) {
			$url = substr( $url, 0, strpos( $url, "?" ) );
		}

		if ( substr( $url, - 1 ) != '/' ) {
			$url = $url . '/';
		}

		return $url . "thumbnails";
	}

	private function purgerUrls( $thumbnailUrls ) {
		// This is another async event but it cannot happen before we call Thumblr to clear thumbs in GCS
		SquidUpdate::purge( $thumbnailUrls );
	}
}
