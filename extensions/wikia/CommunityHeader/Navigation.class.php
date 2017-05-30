<?php

namespace CommunityHeader;

use NavigationModel;
use Title;

class Navigation {
	public function __construct() {
		$this->localNavigation =
			( new NavigationModel() )->getLocalNavigationTree( NavigationModel::WIKI_LOCAL_MESSAGE );
		$this->exploreLabel =
			new Label( 'community-header-explore', Label::TYPE_TRANSLATABLE_TEXT );
		$this->exploreItems = $this->getExploreItems();
		$this->discussLink = $this->getDiscussLink();
	}

	private function getExploreItems(): array {
		global $wgEnableCommunityPageExt, $wgEnableForumExt, $wgEnableDiscussions;

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
				'include' => true,
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

		return array_map( function ( $item ) {
			return new Link( new Label( $item['key'], Label::TYPE_TRANSLATABLE_TEXT ),
				Title::newFromText( $item['title'], NS_SPECIAL )->getLocalURL(),
				$item['tracking'] );
		}, array_filter( $exploreItems, function ( $item ) {
			return $item['include'];
		} ) );
	}

	private function getDiscussLink() {
		global $wgEnableForumExt, $wgEnableDiscussions;

		$discussLink = null;
		if ( !empty( $wgEnableDiscussions ) ) {
			$discussLink =
				new Link( new Label( 'community-header-discuss', Label::TYPE_TRANSLATABLE_TEXT ),
					'/d/f', 'discuss' );
		} elseif ( !empty( $wgEnableForumExt ) ) {
			$discussLink =
				new Link( new Label( 'community-header-forum', Label::TYPE_TRANSLATABLE_TEXT ),
					Title::newFromText( 'Forum', NS_SPECIAL )->getLocalURL(), 'forum' );
		}

		return $discussLink;
	}
}
