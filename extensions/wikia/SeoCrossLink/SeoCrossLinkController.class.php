<?php

class SeoCrossLinkController extends WikiaController {

	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/**
	 * Cross Link Module
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

		$this->response->addAsset( 'seo_cross_link_css' );

		$this->title = wfMessage( 'seocrosslink-module-title' )->escaped();
		$this->articles = $articles;
	}

}
