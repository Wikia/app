<?php

class ArticleNavigationController extends WikiaController {

	public function index() {
		Wikia::addAssetsToOutput( 'article_navigation_scss' );
		Wikia::addAssetsToOutput( 'article_navigation_js' );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	public function getUserTools() {
		global $wgUser;

		$anonListItems = [
			'SpecialPage:Mostpopularcategories',
			'SpecialPage:WikiActivity',
			'SpecialPage:NewFiles',
			'SpecialPage:Search'
		];

		$service = new SharedToolbarService( 'venus' );

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
