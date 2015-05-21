<?php

/**
 * Class SitemapPageController
 */
class SitemapPageController extends WikiaController {

	public function init() {
		$this->response->addAsset( 'sitemap_page_js' );
		$this->response->addAsset( 'sitemap_page_css' );
	}

	/**
	 * Display sitemap page
	 */
	public function index() {
		$level = $this->request->getInt( 'level', 1 );
		if ( $level >= 3 ) {
			$this->forward( __CLASS__, 'showList' );
			return true;
		}

		$from = $this->getVal( 'from', '' );
		$to = $this->getVal( 'to', '' );

		$sitemapPage = new SitemapPageModel();
		$this->wikis = $sitemapPage->getWikiListTopLevel( $level, $from, $to );
		$this->level = $level + 1;
	}

	/**
	 * Show list of wikis
	 */
	public function showList() {
		$from = $this->getVal( 'from', '' );
		$to = $this->getVal( 'to', '' );

		$sitemapPage = new SitemapPageModel();
		$this->wikis = $sitemapPage->getWikiList( $from, $to );
	}


}
