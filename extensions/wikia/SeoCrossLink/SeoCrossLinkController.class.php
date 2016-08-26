<?php

class SeoCrossLinkController extends WikiaController {

	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/**
	 * Crosslink Module
	 * @responseParam string title - title of the module
	 * @responseParam array articles - list of articles
	 */
	public function index() {
		$helper = new SeoCrossLinkHelper();
		if ( !$helper->canShowModule() ) {
			$this->articles = [];
			return true;
		}

		$articles = $helper->getArticles( $this->wg->Title->getArticleID() );

		$this->response->addAsset( 'seo_crosslink_scss' );

		$this->title = wfMessage( 'seo-crosslink-module-title' )->escaped();
		$this->articles = $articles;
	}

}
