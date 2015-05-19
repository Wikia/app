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
		$this->response->addAsset( 'sitemap_page_js' );
		$this->response->addAsset( 'sitemap_page_css' );

		$page = $this->getVal( 'page', 1 );

		$sitemapPage = new SitemapPageModel();

		list( $pagination, $headLinks ) = $sitemapPage->getPagination( $page );
		foreach ( $headLinks as $link ) {
			$this->wg->Out->addLink( $link );
		}

		$this->header = [
			'title' => wfMessage( 'sitemap-page-wiki-title' )->escaped(),
			'language' => wfMessage( 'sitemap-page-wiki-language' )->escaped(),
			'vertical' => wfMessage( 'sitemap-page-wiki-vertical' )->escaped(),
			'description' => wfMessage( 'sitemap-page-wiki-description' )->escaped(),
		];
		$this->wikis = $sitemapPage->getWikis( $page );
		$this->pagination = $pagination;
	}

}
