<?php

namespace CommunityHeader;

use NavigationModel;
use Title;

class Navigation {
	public function __construct() {
		global $wgEnableCommunityPageExt, $wgEnableForumExt, $wgEnableDiscussions;

		$this->localNavigation =
			( new NavigationModel() )->getLocalNavigationTree( NavigationModel::WIKI_LOCAL_MESSAGE );

		$exploreItems = [
			[ 'title' => 'WikiActivity', 'key' => 'community-header-wiki-activity', 'include' => true ],
			[ 'title' => 'Random', 'key' => 'community-header-random-page', 'include' => true ],
			[ 'title' => 'Community', 'key' => 'community-header-community', 'include' => $wgEnableCommunityPageExt ],
			[ 'title' => 'Videos', 'key' => 'community-header-videos', 'include' => true ],
			[ 'title' => 'Images', 'key' => 'community-header-images', 'include' => true ],
			[
				'title' => 'Forum',
				'key' => 'community-header-forum',
				'include' => !empty( $wgEnableForumExt ) && !empty( $wgEnableDiscussions )
			],
		];

		$this->exploreLabel = new Label( 'community-header-explore', Label::TYPE_TRANSLATABLE_TEXT );
		$this->exploreItems = array_map(
			function ($item) {
				return new Link(
					new Label($item['key'], Label::TYPE_TRANSLATABLE_TEXT),
					Title::newFromText($item['title'], NS_SPECIAL)->getLocalURL()
				);
			},
			array_filter(
				$exploreItems,
				function ( $item ) {
					return $item['include'];
				}
			)
		);

		$this->discussLink = null;
		if ( !empty( $wgEnableDiscussions ) ) {
			$this->discussLink = new Link(
				new Label('community-header-discuss', Label::TYPE_TRANSLATABLE_TEXT),
				'/d/f'
			);
		} elseif ( !empty( $wgEnableForumExt ) ) {
			$this->discussLink = new Link(
				new Label('community-header-forum', Label::TYPE_TRANSLATABLE_TEXT),
				Title::newFromText( 'Forum', NS_SPECIAL )->getLocalURL()
			);
		}
	}
}