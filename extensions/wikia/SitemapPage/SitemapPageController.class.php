<?php

/**
 * Class SitemapPageController
 */
class SitemapPageController extends WikiaController {

	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/**
	 * Display sitemap page
	 * @responseParam array wikis - list of wikis
	 * @responseParam string pagination
	 */
	public function index() {
		$this->response->addAsset( 'sitemappage_js' );
		$this->response->addAsset( 'sitemappage_scss' );

		$page = $this->getVal( 'page', 1 );

		$sitemapPage = new SitemapPage();
		$totalWikis = $sitemapPage->getTotalWikis();
		$this->wikis = $sitemapPage->getWikis( $page );

		// add pagination
		$this->pagination = '';
		$limitPerPage = SitemapPage::WIKI_LIMIT_PER_PAGE;
		if ( $totalWikis > $limitPerPage ) {
			$pages = Paginator::newFromArray( array_fill( 0, $totalWikis, '' ), $limitPerPage );
			$pages->setActivePage( $page - 1 );
			$this->pagination = $pages->getBarHTML( $this->wg->Title->getLocalURL( 'page=%s' ) );
		}
	}

}
