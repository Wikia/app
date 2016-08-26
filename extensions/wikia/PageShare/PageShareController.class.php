<?php

class PageShareController extends WikiaController {

	public function index() {
		// SUS-936: Only load these assets for article related pages
		if ( $this->wg->Out->isArticleRelated() ) {
			Wikia::addAssetsToOutput( 'page_share_scss' );
			Wikia::addAssetsToOutput( 'page_share_js' );
		}

		$this->skipRendering();
	}

	public function getShareIcons() {
		$requestlang = $this->getVal( 'lang' );
		$title = $this->getVal( 'title' );
		$url = $this->getVal( 'url' );
		$lang = PageShareHelper::getLangForPageShare( $requestlang );

		$renderedSocialIcons = \MustacheService::getInstance()->render(
			__DIR__ . '/templates/PageShare_index.mustache',
			['services' => $this->prepareShareServicesData( $lang, $title, $url )]
		);

		$this->setVal( 'socialIcons', $renderedSocialIcons );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}

	/**
	 * Prepare and normalize data from $wgPageShareServices
	 *
	 * @param String $lang
	 * @return Array
	 */
	private function prepareShareServicesData( $lang ) {
		global $wgPageShareServices;
		$isTouchScreen = $this->getVal( 'isTouchScreen' );

		$services = [];

		foreach ( $wgPageShareServices as $service ) {
			if ( PageShareHelper::isValidShareService( $service, $lang, $isTouchScreen ) ) {
				$service['icon'] = PageShareHelper::getIcon( $service['name'] );
				$services[] = $service;
			}
		}
		return $services;
	}
}
