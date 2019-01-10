<?php

class RailContentService extends WikiaService {

	public function renderRailModule() {
		$popularPagesService = new PopularPagesService();
		$articles = $popularPagesService->getPopularPages( 5, 80, 50 );

		$this->response->addAsset( 'extensions/wikia/Recirculation/styles/premium-rail.scss' );
		$this->setVal( 'popularPages', $articles );
	}
}
