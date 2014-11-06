<?php

class ArticleNavigationController extends WikiaController {

	public function index() {
		$app = F::app();

		Wikia::addAssetsToOutput( 'article_navigation_scss' );
		Wikia::addAssetsToOutput( 'article_navigation_js' );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$this->setVal('share_type', 'multiple');
		$this->setVal('share', $app->renderView('ArticleNavigationController', 'share'));
	}

	public function share() {
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
		$this->services = self::prepareShareServicesData();
	}

	/**
	 * Prepare and normalize data from $wgArticleNavigationShareServices
	 *
	 * @return Array
	 */
	private static function prepareShareServicesData() {
		global $wgArticleNavigationShareServices;

		$services = $wgArticleNavigationShareServices;
		$location = 'http://' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];

		for ($i = sizeof( $services ) - 1; $i >= 0 ; $i--) {
			$services[$i]['full_url'] = str_replace( '$1', urlencode( $location ), $services[$i]['url'] );
			$services[$i]['name_cased'] = ucfirst( $services[$i]['name'] );
			if ( !array_key_exists( 'title', $services[$i] ) ) {
				$services[$i]['title'] = $services[$i]['name_cased'];
			}
		}

		return $services;
	}
}
