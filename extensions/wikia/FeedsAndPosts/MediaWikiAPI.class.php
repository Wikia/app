<?php

namespace Wikia\FeedsAndPosts;

class MediaWikiAPI {

	protected function requestAPI( $params ) {
		$api = new \ApiMain( new \FauxRequest( $params ) );
		$api->execute();

		return $api->GetResultData();
	}

	private function getThumbnailUrl( $url, $width, $ratio ) {
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

	protected function getImage( $title, $width, $ratio ) {
		$response = $this->requestAPI( [
			'action' => 'imageserving',
			'wisTitle' => $title,
		] );

		if ( isset( $response['image']['imageserving'] ) ) {
			return $this->getThumbnailUrl( $response['image']['imageserving'], $width, $ratio );
		}

		return null;
	}

}