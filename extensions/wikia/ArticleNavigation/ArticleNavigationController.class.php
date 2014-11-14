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
		$this->services = $this->prepareShareServicesData();
	}

	/**
	 * Prepare and normalize data from $wgArticleNavigationShareServices
	 *
	 * @return Array
	 */
	private function prepareShareServicesData() {
		global $wgArticleNavigationShareServices;

		$protocol = ( !empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443 ) ? 'https://' : 'http://';
		$location = $protocol . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		$services = [];

		foreach ($wgArticleNavigationShareServices as $service ) {
			if ( array_key_exists( 'url', $service ) && array_key_exists( 'name', $service ) ) {
				$service['full_url'] = str_replace( '$1', urlencode( $location ), $service['url'] );
				$service['name_cased'] = ucfirst( $service['name'] );

				if ( !array_key_exists('title', $service ) ) {
					$service['title'] = $service['name_cased'];
				}

				$services[] = $service;
			}
		}

		return $services;
	}

	public function getUserTools() {
		global $wgUser;

		$anonListItems = [
			'SpecialPage:Mostpopularcategories',
			'SpecialPage:WikiActivity',
			'SpecialPage:NewFiles',
			'SpecialPage:Search'
		];

		$service = new SharedToolbarService();

		$data = [];

		if ( $wgUser->isAnon() ) {
			foreach ( $anonListItems as $listItem ) {
				$data[] = $service->buildListItem( $listItem );
			}
		} else {
			$data = $service->getVisibleList();
		}

		$this->response->setVal( 'data', $service->instanceToRenderData( $service->listToInstance( $data ) ) );
	}
}
