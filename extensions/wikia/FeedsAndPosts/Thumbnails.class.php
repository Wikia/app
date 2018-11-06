<?php

namespace Wikia\FeedsAndPosts;

class Thumbnails {
	public static function getThumbnailUrl( $url, $width, $ratio ) {
		try {
			return \VignetteRequest::fromUrl( $url )
				->zoomCrop()
				->width( $width )
				->height( floor( $width / $ratio ) )
				->url();
		}
		catch ( \Exception $exception ) {
			\Wikia\Logger\WikiaLogger::instance()
				->warning( "Invalid thumbnail url provided for feeds and posts module", [
					'thumbnailUrl' => $url,
					'message' => $exception->getMessage(),
				] );

			return $url;
		}
	}
}
