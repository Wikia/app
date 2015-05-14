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

		$params = $app->wg->request->getValues();
		$html = $app->sendRequest( 'SitemapPageController', 'index', $params );
		$app->wg->Out->addHTML( $html );
	}

}
