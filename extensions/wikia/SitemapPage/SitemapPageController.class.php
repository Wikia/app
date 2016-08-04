<?php

/**
 * Class SitemapPageController
 */
class SitemapPageController extends WikiaController {

	public function init() {
		$this->response->addAsset( 'sitemap_page_css' );
		$this->wg->Out->setRobotPolicy( 'noindex, follow' );
	}

	/**
	 * Display sitemap page
	 */
	public function index() {
		$level = $this->request->getInt( 'level', 1 );
		if ( !SitemapPageModel::isTopLevel( $level ) ) {
			$this->forward( __CLASS__, 'showList' );
			return true;
		}

		$from = $this->getVal( 'dbfrom', '' );
		$to = $this->getVal( 'dbto', '' );

		$sitemapPage = new SitemapPageModel();
		$this->wikis = $sitemapPage->getWikiListTopLevel( $level, $from, $to );
		$this->level = $level + 1;

		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}

	/**
	 * Show list of wikis
	 */
	public function showList() {
		$from = $this->getVal( 'dbfrom', '' );
		$to = $this->getVal( 'dbto', '' );

		$sitemapPage = new SitemapPageModel();
		$this->wikis = $sitemapPage->getWikiList( $from, $to );

		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}

}
