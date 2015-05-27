<?php

/**
 * Class SitemapPageArticle
 */
class SitemapPageArticle extends Article {

	/**
	 * @desc Render hubs page
	 */
	public function view() {
		$app = F::app();
		$app->wg->Out->clearHTML();

		$title = wfMessage( 'sitemap-page-html-title' )->inContentLanguage()->text();
		$app->wg->Out->setHTMLTitle( $title );

		$params = $app->wg->request->getValues();
		$html = $app->sendRequest( 'SitemapPageController', 'index', $params );
		$app->wg->Out->addHTML( $html );
	}

}
