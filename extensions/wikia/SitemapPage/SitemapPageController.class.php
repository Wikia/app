<?php

/**
 * Class SitemapPageController
 */
class SitemapPageController extends WikiaController {

	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/**
	 * Display sitemap page
	 */
	public function index() {
		$this->response->addAsset( 'sitemappage_js' );
		$this->response->addAsset( 'sitemappage_scss' );
	}

}
