<?php

class RailContentService extends WikiaService {

	const RAIL_THUMBNAIL_WIDTH = 94;
	const RAIL_THUMBNAIL_HEIGHT = 53;

	public function renderRailModule() {
		$popularPagesService = new PopularPagesService();
		$articles = $popularPagesService->getPopularPages(
			5,
			static::RAIL_THUMBNAIL_WIDTH,
			static::RAIL_THUMBNAIL_HEIGHT
		);

		foreach ( $articles as $pageId => $article ) {
			try {
				$articles[$pageId]['thumbnail'] =
					VignetteRequest::fromUrl( $article['thumbnail'] )
						->zoomCrop()
						->width( static::RAIL_THUMBNAIL_WIDTH )
						->height( static::RAIL_THUMBNAIL_HEIGHT )
						->url();
			} catch ( Exception $ignored ) {
				// just use the original thumbnail
			}
		}

		$this->response->addAsset( 'extensions/wikia/Recirculation/styles/premium-rail.scss' );
		$this->setVal( 'popularPages', $articles );
	}
}
