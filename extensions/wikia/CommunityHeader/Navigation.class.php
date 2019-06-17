<?php

namespace Wikia\CommunityHeader;

use DesignSystemCommunityHeaderModel;

class Navigation {
	public $discussLink;
	public $exploreItems;
	public $exploreLabel;
	public $localNavigation;

	private $model;

	public function __construct( DesignSystemCommunityHeaderModel $model, $wikiText = null ) {
		$this->model = $model;
		$this->localNavigation = $model->getWikiLocalNavigation( $wikiText );
		$exploreMenu = $model->getExploreMenu();

		$this->exploreLabel = new Label(
			$exploreMenu['title']['key'], Label::TYPE_TRANSLATABLE_TEXT, $exploreMenu['image-data']['name']
		);
		$this->exploreItems = $this->getExploreItems();
		$this->discussLink = $this->getDiscussLink();
		$this->mainPageLink = $this->getMainPageLink();
	}

	private function getExploreItems(): array {
		$exploreItems = $this->model->getExploreMenu()['items'];

		return array_map(
			function ( $item ) {
				return new Link(
					new Label( $item['title']['key'], Label::TYPE_TRANSLATABLE_TEXT ),
					$item['href'],
					$item['tracking_label']
				);
			},
			$exploreItems
		);
	}

	private function mapLinkDataToLink($linkData) {
		return new Link(
			new Label(
				$linkData['title']['key'],
				Label::TYPE_TRANSLATABLE_TEXT,
				$linkData['image-data']['name']
			),
			$linkData['href'],
			$linkData['tracking_label']
		);
	}

	private function getDiscussLink() {
		$discussData = $this->model->getDiscussLinkData();
		$discussLink = null;

		if ( !empty( $discussData ) ) {
			$discussLink = $this->mapLinkDataToLink( $discussData );
		}

		return $discussLink;
	}

	private function getMainPageLink() {
		$mainPageLinkData = $this->model->getMainPageLinkData();
		$mainPageLink = null;

		if ( !empty( $mainPageLinkData ) ) {
			$mainPageLink = $this->mapLinkDataToLink( $mainPageLinkData );
		}

		return $mainPageLink;
	}
}
