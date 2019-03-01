<?php

namespace Wikia\Tasks\Tasks\Image;

use SquidUpdate;
use Wikia\Factory\ServiceFactory;
use Wikia\Logger\WikiaLogger;
use Wikia\Tasks\Tasks\BaseTask;


class AsyncPurgeTask extends BaseTask {

	public function publish( FileInfo $fileId, array $thumbnailUrls ) {
		global $wgCityId;

		WikiaLogger::instance()->info( __METHOD__, [
			'file' => json_encode( $fileId ),
			'thumbnail_urls' => json_encode( $thumbnailUrls ),
		] );


		WikiaLogger::instance()->info( __METHOD__, [
			'file' => json_encode( $fileId ),
			'thumbnail_urls' => json_encode( $thumbnailUrls ),
		] );

		$task = new AsyncPurgeTask();
		$task->call( 'removeThumbnails', $fileId->serializeForTask(), $thumbnailUrls );
		$task->wikiId( $wgCityId );
		$task->queue();
	}

	/**
	 * @param string $fileId
	 * @param array $thumbnailUrls
	 * @throws \Exception
	 */
	public function removeThumbnails( array $fileId, array $thumbnailUrls ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'file' => json_encode( $fileId ),
			'thumbnail_urls' => json_encode( $thumbnailUrls ),
		] );

		try {
			$this->removeThumbnailsInThumblr( FileInfo::deserializeFromTask( $fileId ) );
			$this->purgerUrls( $thumbnailUrls );
		}
		catch ( \Exception $exception ) {
			WikiaLogger::instance()->error( __METHOD__, [
				'file' => json_encode( $fileId ),
				'thumbnail_urls' => $thumbnailUrls,
			] );
			throw $exception;
		}
	}

	private function purgerUrls( array $thumbnailUrls ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'thumbnail_urls' => json_encode( $thumbnailUrls ),
		] );
		SquidUpdate::purge( $thumbnailUrls );
	}

	private function removeThumbnailsInThumblr( FileInfo $fileId ) {
		global $wgThumblrUser;
		global $wgThumblrPass;

		$url = $this->getRemoveThumbnailsUrl( $fileId );
		WikiaLogger::instance()->info( __METHOD__, [
			'file' => json_encode( $fileId ),
			'remove_thumbnails_url' => $url,
		] );
		$credentials = base64_encode($wgThumblrUser.':'.$wgThumblrPass);
		\Http::request( "DELETE", $url, [
			'headers' => [ 'Authorization' => 'Basic '.$credentials ],
			'internalRequest' => true,
			'noProxy' => true,
		] );
	}

	private function getRemoveThumbnailsUrl( FileInfo $fileId ) {
		$urlProvider = ServiceFactory::instance()->providerFactory()->urlProvider();
		$thumblrUrl = $this->removeTrailingSlash( "https://{$urlProvider->getUrl( 'thumblr' )}" );
		$url =
			"{$thumblrUrl}/{$fileId->getBucket()}/images/{$fileId->getRelativePath()}/revision/{$fileId->getRevision()}/thumbnails";
		if ( $fileId->getPathPrefix() ) {
			$url = "{$url}?path-prefix={$fileId->getPathPrefix()}";
		}

		return $url;
	}

	private function removeTrailingSlash( string $text ) {
		if ( substr( $text, - 1 ) == '/' ) {
			return substr( $text, 0, - 1 );
		} else {
			return $text;
		}
	}

}
