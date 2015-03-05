<?php

class PageShareController extends WikiaController {

	/**
	 * @var ArticleNavigationHelper
	 */
	private $helper;

	public function __construct() {
		parent::__construct();
		$this->helper = new PageShareHelper();
	}

	/**
	 * render index
	 */
	public function index() {
		Wikia::addAssetsToOutput( 'page_share_scss' );
		Wikia::addAssetsToOutput( 'page_share_js' );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
		$this->setVal( 'services', $this->prepareShareServicesData() );
	}

	/**
	 * Prepare and normalize data from $wgArticleNavigationShareServices
	 *
	 * @return Array
	 */
	private function prepareShareServicesData() {
		global $wgPageShareServices;

		$protocol = ( !empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443 ) ? 'https://' : 'http://';
		$location = $protocol . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		$services = [];
		$lang = $this->helper->getUserLanguageCode( $this->request );

		foreach ( $wgPageShareServices as $service ) {
			if ( $this->helper->isValidShareService( $service, $lang ) ) {
				$service['href'] = str_replace( '$1', urlencode( $location ), $service['url'] );
				$service['icon'] = $this->helper->getIcon( $service['name'] );
				$services[] = $service;
			}
		}

		return $services;
	}
}
