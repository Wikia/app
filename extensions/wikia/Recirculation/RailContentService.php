<?php

class RailContentService extends WikiaService {

	public function renderRailModule() {
		$popularPagesService = new PopularPagesService();
		$articles = $popularPagesService->getPopularPages( 5 );

		if ( empty( $articles ) ) {
			$this->skipRendering();
			return false;
		}

		$this->response->addAsset( 'extensions/wikia/Recirculation/styles/premium-rail.scss' );
		$this->setVal( 'popularPages', $popularPagesService->getPopularPages( 5 ) );
	}
}
