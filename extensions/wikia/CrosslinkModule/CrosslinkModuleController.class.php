<?php

class CrosslinkModuleController extends WikiaController {

	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/**
	 * Crosslink Module
	 * @responseParam string title - title of the module
	 * @responseParam array articles - list of articles
	 */
	public function index() {
		$helper = new CrosslinkModuleHelper();
		if ( !$helper->canShowModule() ) {
			$this->articles = [];
			return true;
		}

		$articles = $helper->getArticles( $this->wg->Title->getArticleID() );
		$this->response->addAsset( 'crosslink_module_scss' );
		$this->title = wfMessage( 'crosslink-module-title' )->escaped();
		$this->articles = $articles;
	}

}
