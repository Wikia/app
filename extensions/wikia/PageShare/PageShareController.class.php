<?php

class PageShareController extends WikiaController {


	/**
	 * render index
	 */
	public function index() {
		Wikia::addAssetsToOutput( 'page_share_scss' );
		Wikia::addAssetsToOutput( 'page_share_js' );

		$this->skipRendering();
	}

	public function getShareIcons() {
		$browserLang = $this->getVal( 'browserLang' );
		$useLang = $this->getVal( 'useLang' );
		$shareLang = PageShareHelper::getLangForPageShare( $browserLang, $useLang );
		if ( empty( $wgEnablePageShareWorldwide ) && $shareLang !== PageShareHelper::SHARE_DEFAULT_LANGUAGE ) {
			$this->setVal( 'socialIcons', false );
		} else {
			$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
			$renderedSocialIcons = \MustacheService::getInstance()->render(
				__DIR__ . '/templates/PageShare_index.mustache',
				['services' => $this->prepareShareServicesData( $shareLang )]
			);
			$this->setVal( 'socialIcons', $renderedSocialIcons );
		}
	}

	/**
	 * Prepare and normalize data from $wgPageShareServices
	 *
	 * @param $shareLang
	 * @return Array
	 */
	private function prepareShareServicesData( $shareLang ) {
		global $wgPageShareServices;

		$protocol = ( !empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443 ) ? 'https://' : 'http://';
		$location = $protocol . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		$services = [];

		foreach ( $wgPageShareServices as $service ) {
			if ( PageShareHelper::isValidShareService( $service, $shareLang ) ) {
				$service['href'] = str_replace( '$1', urlencode( $location ), $service['url'] );
				$service['icon'] = PageShareHelper::getIcon( $service['name'] );
				$services[] = $service;
			}
		}
		return $services;
	}
}
