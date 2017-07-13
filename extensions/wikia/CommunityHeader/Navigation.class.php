<?php

namespace Wikia\CommunityHeader;

use DesignSystemCommunityHeaderModel;
use NavigationModel;
use Title;

class Navigation {
	public $discussLink;
	public $exploreItems;
	public $exploreLabel;
	public $localNavigation;

	private $model;

	public function __construct( DesignSystemCommunityHeaderModel $model, $wikiText = null ) {
		$this->model = $model;

		$navigationModel = new NavigationModel();
		if ( empty( $wikiText ) ) {
			$this->localNavigation = $navigationModel->getLocalNavigationTree( NavigationModel::WIKI_LOCAL_MESSAGE );
		} else {
			$this->localNavigation = $navigationModel->getTreeFromText( $wikiText );
		}

		$this->exploreLabel = new Label( 'community-header-explore', Label::TYPE_TRANSLATABLE_TEXT );
		$this->exploreItems = $this->getExploreItems();
		$this->discussLink = $this->getDiscussLink();
	}

	private function getExploreItems(): array {
		global $wgEnableCommunityPageExt, $wgEnableForumExt, $wgEnableDiscussions, $wgEnableSpecialVideosExt;

		$exploreItems = [
			[
				'title' => 'WikiActivity',
				'key' => 'community-header-wiki-activity',
				'tracking' => 'explore-activity',
				'include' => true,
			],
			[
				'title' => 'Random',
				'key' => 'community-header-random-page',
				'tracking' => 'explore-random',
				'include' => true,
			],
			[
				'title' => 'Community',
				'key' => 'community-header-community',
				'tracking' => 'explore-community',
				'include' => !empty( $wgEnableCommunityPageExt ),
			],
			[
				'title' => 'Videos',
				'key' => 'community-header-videos',
				'tracking' => 'explore-videos',
				'include' => !empty( $wgEnableSpecialVideosExt ),
			],
			[
				'title' => 'Images',
				'key' => 'community-header-images',
				'tracking' => 'explore-images',
				'include' => true,
			],
			[
				'title' => 'Forum',
				'key' => 'community-header-forum',
				'tracking' => 'explore-forum',
				'include' => !empty( $wgEnableForumExt ) && !empty( $wgEnableDiscussions ),
			],
		];

		return array_map(
			function ( $item ) {
				return new Link(
					new Label( $item['key'], Label::TYPE_TRANSLATABLE_TEXT ),
					Title::newFromText( $item['title'], NS_SPECIAL )->getLocalURL(),
					$item['tracking']
				);
			},
			array_filter(
				$exploreItems,
				function ( $item ) {
					return $item['include'];
				}
			)
		);
	}

	private function getDiscussLink() {
		$discussData = $this->model->getDiscussLinkData();
		$discussLink = null;

		if (!empty($discussData)) {
			$discussLink = new Link(
				//TODO: handle icon
				new Label( $discussData['title']['key'], Label::TYPE_TRANSLATABLE_TEXT ), $discussData['href'], $discussData['tracking_label']
			);
		}

		return $discussLink;
	}
}
