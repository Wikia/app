<?php

class ArticleNavigationController extends WikiaController {

	public function index() {
		Wikia::addAssetsToOutput( 'article_navigation_scss' );
		Wikia::addAssetsToOutput( 'article_navigation_js' );

		$this->shareData = self::shareData();
	}

	public static function shareData() {
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
