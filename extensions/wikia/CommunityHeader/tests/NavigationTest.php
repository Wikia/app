<?php

namespace CommunityHeader;

use Wikia\Util\GlobalStateWrapper;

class NavigationTest extends \WikiaBaseTest {
	/**
	 * @dataProvider exploreItemsProviders
	 *
	 * @param $globals
	 * @param $expectedExploreItems
	 */
	public function testExploreItems( $globals, $expectedExploreItems ) {
		$globals = new GlobalStateWrapper( [
			'wgEnableCommunityPageExt' => $globals['wgEnableCommunityPageExt'],
			'wgEnableDiscussions' => $globals['wgEnableDiscussions'],
			'wgEnableForumExt' => $globals['wgEnableForumExt'],
		] );

		$result = $globals->wrap( function () {
			return new Navigation();
		} );

		// used `array_values` to reset keys of array
		$this->assertEquals( $expectedExploreItems, array_values( $result->exploreItems ) );
	}

	/**
	 * @dataProvider discussLinkProviders
	 *
	 * @param $globals
	 * @param $expected
	 */
	public function testDiscussLink( $globals, $expected ) {
		$globals = new GlobalStateWrapper( [
			'wgEnableDiscussions' => $globals['wgEnableDiscussions'],
			'wgEnableForumExt' => $globals['wgEnableForumExt'],
		] );

		$result = $globals->wrap( function () {
			return new Navigation();
		} );

		$this->assertEquals( $expected, $result->discussLink );
	}

	private function prepareExploreItems( $raw ) {
		return array_map( function ( $rawItem ) {
			return new Link(
				new Label( $rawItem['label']['key'], $rawItem['label']['type'] ),
				$rawItem['href'],
				$rawItem['tracking']
			);
		}, $raw );
	}

	public function exploreItemsProviders() {
		return [
			[
				'globals' => [
					'wgEnableCommunityPageExt' => true,
					'wgEnableDiscussions' => true,
					'wgEnableForumExt' => true,
				],
				'expectedExploreItems' => $this->prepareExploreItems( [
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-wiki-activity',
						],
						'href' => '/wiki/Special:WikiActivity',
						'tracking' => 'explore-activity',
					],
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-random-page',
						],
						'href' => '/wiki/Special:Random',
						'tracking' => 'explore-random',
					],
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-community',
						],
						'href' => '/wiki/Special:Community',
						'tracking' => 'explore-community',
					],
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-videos',
						],
						'href' => '/wiki/Special:Videos',
						'tracking' => 'explore-videos',
					],
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-images',
						],
						'href' => '/wiki/Special:Images',
						'tracking' => 'explore-images',
					],
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-forum',
						],
						'href' => '/wiki/Special:Forum',
						'tracking' => 'explore-forum',
					],
				] ),
			],
			[
				'globals' => [
					'wgEnableCommunityPageExt' => false,
					'wgEnableDiscussions' => true,
					'wgEnableForumExt' => true,
				],
				'expectedExploreItems' => $this->prepareExploreItems( [
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-wiki-activity',
						],
						'href' => '/wiki/Special:WikiActivity',
						'tracking' => 'explore-activity',
					],
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-random-page',
						],
						'href' => '/wiki/Special:Random',
						'tracking' => 'explore-random',
					],
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-videos',
						],
						'href' => '/wiki/Special:Videos',
						'tracking' => 'explore-videos',
					],
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-images',
						],
						'href' => '/wiki/Special:Images',
						'tracking' => 'explore-images',
					],
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-forum',
						],
						'href' => '/wiki/Special:Forum',
						'tracking' => 'explore-forum',
					],
				] ),
			],
			[
				'globals' => [
					'wgEnableCommunityPageExt' => true,
					'wgEnableDiscussions' => false,
					'wgEnableForumExt' => true,
				],
				'expectedExploreItems' => $this->prepareExploreItems( [
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-wiki-activity',
						],
						'href' => '/wiki/Special:WikiActivity',
						'tracking' => 'explore-activity',
					],
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-random-page',
						],
						'href' => '/wiki/Special:Random',
						'tracking' => 'explore-random',
					],
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-community',
						],
						'href' => '/wiki/Special:Community',
						'tracking' => 'explore-community',
					],
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-videos',
						],
						'href' => '/wiki/Special:Videos',
						'tracking' => 'explore-videos',
					],
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-images',
						],
						'href' => '/wiki/Special:Images',
						'tracking' => 'explore-images',
					],
				] ),
			],
			[
				'globals' => [
					'wgEnableCommunityPageExt' => true,
					'wgEnableDiscussions' => true,
					'wgEnableForumExt' => false,
				],
				'expectedExploreItems' => $this->prepareExploreItems( [
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-wiki-activity',
						],
						'href' => '/wiki/Special:WikiActivity',
						'tracking' => 'explore-activity',
					],
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-random-page',
						],
						'href' => '/wiki/Special:Random',
						'tracking' => 'explore-random',
					],
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-community',
						],
						'href' => '/wiki/Special:Community',
						'tracking' => 'explore-community',
					],
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-videos',
						],
						'href' => '/wiki/Special:Videos',
						'tracking' => 'explore-videos',
					],
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-images',
						],
						'href' => '/wiki/Special:Images',
						'tracking' => 'explore-images',
					],
				] ),
			],
			[
				'globals' => [
					'wgEnableCommunityPageExt' => true,
					'wgEnableDiscussions' => false,
					'wgEnableForumExt' => false,
				],
				'expectedExploreItems' => $this->prepareExploreItems( [
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-wiki-activity',
						],
						'href' => '/wiki/Special:WikiActivity',
						'tracking' => 'explore-activity',
					],
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-random-page',
						],
						'href' => '/wiki/Special:Random',
						'tracking' => 'explore-random',
					],
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-community',
						],
						'href' => '/wiki/Special:Community',
						'tracking' => 'explore-community',
					],
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-videos',
						],
						'href' => '/wiki/Special:Videos',
						'tracking' => 'explore-videos',
					],
					[
						'label' => [
							'type' => 'translatable-text',
							'key' => 'community-header-images',
						],
						'href' => '/wiki/Special:Images',
						'tracking' => 'explore-images',
					],
				] ),
			],
		];
	}

	private function prepareDiscussLink( $raw ) {
		return new Link(
			new Label( $raw['label']['key'], $raw['label']['type'] ),
			$raw['href'],
			$raw['tracking']
		);
	}

	public function discussLinkProviders() {
		return [
			[
				'globals' => [
					'wgEnableDiscussions' => true,
					'wgEnableForumExt' => true,
				],
				'expected' => $this->prepareDiscussLink( [
					'label' => [
						'type' => 'translatable-text',
						'key' => 'community-header-discuss',
					],
					'href' => '/d/f',
					'tracking' => 'discuss',
				] ),
			],
			[
				'globals' => [
					'wgEnableDiscussions' => true,
					'wgEnableForumExt' => false,
				],
				'expected' => $this->prepareDiscussLink( [
					'label' => [
						'type' => 'translatable-text',
						'key' => 'community-header-discuss',
					],
					'href' => '/d/f',
					'tracking' => 'discuss',
				] ),
			],
			[
				'globals' => [
					'wgEnableDiscussions' => false,
					'wgEnableForumExt' => true,
				],
				'expected' => $this->prepareDiscussLink( [
					'label' => [
						'type' => 'translatable-text',
						'key' => 'community-header-forum',
					],
					'href' => '/wiki/Special:Forum',
					'tracking' => 'forum',
				] ),
			],
			[
				'globals' => [
					'wgEnableDiscussions' => false,
					'wgEnableForumExt' => false,
				],
				'expected' => null,
			],
		];
	}
}
