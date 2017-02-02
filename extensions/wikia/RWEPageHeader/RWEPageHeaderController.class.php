<?php

class RWEPageHeaderController extends WikiaController {

	public function index() {
		OasisController::addBodyClass( 'rwe-page-header-experiment' );

		$this->searchModel = $this->getSearchData();
		$this->discussTabLink = $this->getDiscussTabLink();
	}

	private function getDiscussTabLink() {
		global $wgEnableDiscussionsNavigation, $wgEnableDiscussions, $wgEnableForumExt;

		if ( !empty( $wgEnableDiscussionsNavigation ) && !empty( $wgEnableDiscussions ) && empty( $wgEnableForumExt ) ) {
			return '/d';
		} else {
			return '/wiki/Special:Forum';
		}
	}

	private function getSearchData() {
		global $wgCityId;

		$search = [
			'type' => 'search',
			'results' => [
				'url' => GlobalTitle::newFromText( 'Search', NS_SPECIAL, $wgCityId )->getFullURL( [ 'fulltext' => 'Search' ] ),
				'param-name' => 'query',
				'tracking_label' => 'search',
			],
			'placeholder-inactive' => [
				'type' => 'translatable-text',
				'key' => 'global-navigation-search-placeholder-inactive'
			],
			'placeholder-active' => [
				'type' => 'translatable-text',
				'key' => 'global-navigation-search-placeholder-in-wiki'
			]
		];

		$search['suggestions'] = [
			'url' => WikiFactory::getHostById( $wgCityId ) . '/index.php?action=ajax&rs=getLinkSuggest&format=json',
			'param-name' => 'query',
			'tracking_label' => 'search-suggestion',
		];
		$search['placeholder-active']['params'] = [
			'sitename' => $this->getSitenameData(),
		];

		return $search;
	}

	private function getSitenameData() {
		global $wgCityId;

		return WikiFactory::getVarValueByName( 'wgSitename', $wgCityId, false, $this->wg->Sitename );
	}

	public function readTab() {
		$model = new NavigationModel();

		$data = $model->getWiki( NavigationModel::WIKI_LOCAL_MESSAGE );

		$this->menuNodes = $data[ 'wiki' ];
	}

	public function createTab() {
		$order = [
			'communitypage',
			'chat',
			'wikiactivity',
			'edit',
			'createpage',
			'photos',
			'upload',
			'videos',
			'wikiavideoadd',
			'wikinavedit'
		];

		$createList = [
			'communitypage' => [
				'text' => 'Community Page',
				'href' => '/wiki/Special:Community'
			],
			'chat' => [
				'text' => 'Chat',
				'href' => '/wiki/Special:Chat',
				'class' => 'rwe-chat'
			],
			'photos' => [
				'text' => 'Photos',
				'href' => '/wiki/Special:NewFiles'
			],
			'videos' => [
				'text' => 'Videos',
				'href' => '/wiki/Special:Videos'
			]
		];



		$contributeMenu = new RWEContributeMenu();
		$createList = array_merge( $createList, $contributeMenu->getContributeList() );

		$orderedList = [];

		foreach ( $order as $orderKey ) {
			if ( !empty( $createList[$orderKey] ) ) {
				$orderedList[$orderKey] = $createList[$orderKey];
			}
		}

		$this->createList = $orderedList;
	}
}
