<?php

namespace Wikia\Tasks\Tasks\Image;

use Wikia\Factory\ServiceFactory;
use Wikia\Logger\WikiaLogger;
use Wikia\Purger\ThumblrSurrogateKey;
use Wikia\Tasks\Tasks\BaseTask;


class AsyncPurgeTask extends BaseTask {

	public function publish( FileInfo $fileId, array $thumbnailUrls ) {
		global $wgCityId;

		WikiaLogger::instance()->info(
			__METHOD__,
			[
				'file' => json_encode( $fileId ),
				'thumbnail_urls' => json_encode( $thumbnailUrls ),
			]
		);


		WikiaLogger::instance()->info(
			__METHOD__,
			[
				'file' => json_encode( $fileId ),
				'thumbnail_urls' => json_encode( $thumbnailUrls ),
			]
		);

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
		WikiaLogger::instance()->info(
			__METHOD__,
			[
				'file' => json_encode( $fileId ),
				'thumbnail_urls' => json_encode( $thumbnailUrls ),
			]
		);

		try {
			$fileInfo = FileInfo::deserializeFromTask( $fileId );
			$this->removeThumbnailsInThumblr( $fileInfo );
			$this->purgeSurrogateKey( $fileInfo );
		}
		catch ( \Exception $exception ) {
			WikiaLogger::instance()->error(
				__METHOD__,
				[
					'file' => json_encode( $fileId ),
					'thumbnail_urls' => $thumbnailUrls,
				]
			);
			throw $exception;
		}
	}

	private function removeThumbnailsInThumblr( FileInfo $fileId ) {
		global $wgThumblrUser, $wgThumblrPass;

		$url = $this->getRemoveThumbnailsUrl( $fileId );
		WikiaLogger::instance()->info(
			__METHOD__,
			[
				'file' => json_encode( $fileId ),
				'remove_thumbnails_url' => $url,
			]
		);
		$credentials = base64_encode( $wgThumblrUser . ':' . $wgThumblrPass );
		\Http::request(
			"DELETE",
			$url,
			[
				'headers' => [ 'Authorization' => 'Basic ' . $credentials ],
				'internalRequest' => true,
				'noProxy' => true,
			]
		);
	}

	private function getRemoveThumbnailsUrl( FileInfo $fileId ) {
		global $wgThumblrUrl;

		$thumblrUrl = rtrim( $wgThumblrUrl, '/' );
		$url =
			"{$thumblrUrl}/{$fileId->getBucket()}/images/{$fileId->getRelativePath()}/revision/{$fileId->getRevision()}/thumbnails";
		if ( $fileId->getPathPrefix() ) {
			$url = "{$url}?path-prefix={$fileId->getPathPrefix()}";
		}

		return $url;
	}

	private function purgeSurrogateKey( FileInfo $fileInfo ) {
		$key = new ThumblrSurrogateKey( $fileInfo );
		WikiaLogger::instance()->info(
			__METHOD__,
			[
				'file' => json_encode( $fileInfo ),
				'key' => $key->value(),
				'key_before_hashing' => $key->valueBeforeHashing(),
			]
		);
		ServiceFactory::instance()->purgerFactory()->purger()->addThumblrSurrogateKey( $key->value() );
	}
}
