<?php

class PageShareController extends WikiaController {

	public function index() {
		Wikia::addAssetsToOutput( 'page_share_scss' );
		Wikia::addAssetsToOutput( 'page_share_js' );

		$this->skipRendering();
	}

	public function getShareIcons() {
		$requestShareLang = $this->getVal( 'shareLang' );
		$title = $this->getVal( 'title' );
		$url = $this->getVal( 'url' );
		$shareLang = PageShareHelper::getLangForPageShare( $requestShareLang );

		$renderedSocialIcons = \MustacheService::getInstance()->render(
			__DIR__ . '/templates/PageShare_index.mustache',
			['services' => $this->prepareShareServicesData( $shareLang, $title, $url )]
		);

		$this->setVal( 'socialIcons', $renderedSocialIcons );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}

	/**
	 * Prepare and normalize data from $wgPageShareServices
	 *
	 * @param String $shareLang
	 * @return Array
	 */
	private function prepareShareServicesData( $shareLang ) {
		global $wgPageShareServices;
		$isTouchScreen = $this->getVal( 'isTouchScreen' );

		$services = [];

		foreach ( $wgPageShareServices as $service ) {
			if ( PageShareHelper::isValidShareService( $service, $shareLang, $isTouchScreen ) ) {
				$service['icon'] = PageShareHelper::getIcon( $service['name'] );
				$services[] = $service;
			}
		}
		return $services;
	}
}
