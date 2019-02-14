<?php

use Wikia\Factory\ServiceFactory;
use Wikia\Tasks\Tasks\BaseTask;

class AsyncPurgeTask extends BaseTask {

	public function publish( FileId $fileId, array $thumbnailUrls ) {
		global $wgCityId;

		Wikia\Logger\WikiaLogger::instance()->info( __METHOD__, [
			'file' => json_encode( $fileId ),
			'thumbnail_urls' => json_encode( $thumbnailUrls ),
		] );

		$task = new AsyncPurgeTask();
		$task->call( 'removeThumbnails', $fileId, $thumbnailUrls );
		$task->wikiId( $wgCityId );
		$task->queue();
	}

	/**
	 * @param string $fileId
	 * @param array $thumbnailUrls
	 * @throws Exception
	 */
	public function removeThumbnails( FileId $fileId, array $thumbnailUrls ) {
		Wikia\Logger\WikiaLogger::instance()->info( __METHOD__, [
			'file' => json_encode( $fileId ),
			'thumbnail_urls' => json_encode( $thumbnailUrls ),
		] );

		try {
			$this->removeThumbnailsInThumblr( $fileId->serializeForTask() );
			$this->purgerUrls( $thumbnailUrls );
		}
		catch ( \Exception $exception ) {
			Wikia\Logger\WikiaLogger::instance()->info( __METHOD__, [
				'file' => json_encode( $fileId ),
				'thumbnail_urls' => $thumbnailUrls,
			] );
			throw $exception;
		}
	}

	private function purgerUrls( array $thumbnailUrls ) {
		Wikia\Logger\WikiaLogger::instance()->info( __METHOD__, [
			'thumbnail_urls' => json_encode( $thumbnailUrls ),
		] );
		SquidUpdate::purge( $thumbnailUrls );
	}

	private function removeThumbnailsInThumblr( array $fileId ) {
		$url = $this->getRemoveThumbnailsUrl( FileId::deserializeFromTask( $fileId ) );
		Wikia\Logger\WikiaLogger::instance()->info( __METHOD__, [
			'file' => json_encode( $fileId ),
			'remove_thumbnails_url' => $url,
		] );
		\Http::request( "DELETE", $url, [ 'headers' => [ 'X-Wikia-Internal-Request' => '1' ] ] );
	}

	private function getRemoveThumbnailsUrl( FileId $fileId ) {
		$urlProvider = ServiceFactory::instance()->providerFactory()->urlProvider();
		$thumblrUrl = $this->removeTrailingSlash( "http://{$urlProvider->getUrl( 'thumblr' )}" );
		$url = "{$thumblrUrl}/{$fileId->getBucket()}/{$fileId->getRelativePath()}/thumbnails";
		if ( $fileId->getPathPrefix() ) {
			$url = "{$url}?path-prefix={$fileId->getPathPrefix()}";
		}

		return $url;
	}

	private function removeTrailingSlash( string $text ) {
		if ( substr( $text, - 1 ) != '/' ) {
			return substr( $text, 0, - 1 );
		} else {
			return $text;
		}
	}

}
