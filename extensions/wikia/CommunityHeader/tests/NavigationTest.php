<?php

use \Wikia\CommunityHeader\Label;
use \Wikia\CommunityHeader\Link;
use \Wikia\CommunityHeader\Navigation;

class NavigationTest extends WikiaBaseTest {
	const WIKI_ID = 165;
	const DOMAIN = "http://firefly.wikia.com";


	protected function setUp() {
		parent::setUp();
		$this->disableMemCache();
	}

	/**
	 * @dataProvider exploreItemsProvider
	 *
	 * @param $globals
	 * @param $expectedExploreItems
	 */
	public function testExploreItems( $globals, $expectedExploreItems ) {
		$this->mockStaticMethodWithCallBack( 'WikiFactory', 'getVarValueByName', function ( $variable/*, $id*/ ) use (
			$globals
		) {
			$globals[ 'wgServer' ] = self::DOMAIN;

			return $globals[ $variable ] ?? $GLOBALS[ $variable ] ?? false;
		} );

		$result = new Navigation( new DesignSystemCommunityHeaderModel( self::WIKI_ID, 'en' ) );

		// used `array_values` to reset keys of array
		$this->assertEquals( $expectedExploreItems, array_values( $result->exploreItems ) );
	}

	/**
	 * @dataProvider discussLinkProvider
	 *
	 * @param $globals
	 * @param $expected
	 */
	public function testDiscussLink( $globals, $expected ) {
		$this->mockStaticMethodWithCallBack( 'WikiFactory', 'getVarValueByName', function ( $variable/*, $id*/ ) use (
			$globals
		) {
			$globals[ 'wgServer' ] = self::DOMAIN;

			return $globals[ $variable ] ?? $GLOBALS[ $variable ] ?? false;
		} );

		$result = new Navigation( new DesignSystemCommunityHeaderModel( self::WIKI_ID, 'en' ) );

		$this->assertEquals( $expected, $result->discussLink );
	}

	private function prepareExploreItems( $raw ) {
		return array_map( function ( $rawItem ) {
			return new Link( new Label( $rawItem[ 'label' ][ 'key' ], $rawItem[ 'label' ][ 'type' ] ), $rawItem[ 'href' ], $rawItem[ 'tracking' ] );
		}, $raw );
	}

	public function exploreItemsProvider() {
		$host = wfProtocolUrlToRelative( WikiFactory::getLocalEnvURL( self::DOMAIN ) );

		return [
			[
				'globals' => [
					'wgEnableCommunityPageExt' => true,
					'wgEnableDiscussions' => true,
					'wgEnableForumExt' => true,
					'wgEnableSpecialVideosExt' => true,
				],
				'expectedExploreItems' => $this->prepareExploreItems( [
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-wiki-activity',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:WikiActivity',
							'tracking' => 'explore-activity',
						],
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-random-page',
								'iconKey' => null,

							],
							'href' => $host . '/wiki/Special:Random',
							'tracking' => 'explore-random',
						],
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-community',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:Community',
							'tracking' => 'explore-community',
						],
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-videos',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:Videos',
							'tracking' => 'explore-videos',
						],
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-images',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:Images',
							'tracking' => 'explore-images',
						],
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-forum',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:Forum',
							'tracking' => 'explore-forum',
						],
					] ),
			],
			[
				'globals' => [
					'wgEnableCommunityPageExt' => false,
					'wgEnableDiscussions' => true,
					'wgEnableForumExt' => true,
					'wgEnableSpecialVideosExt' => true,
				],
				'expectedExploreItems' => $this->prepareExploreItems( [
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-wiki-activity',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:WikiActivity',
							'tracking' => 'explore-activity',
						],
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-random-page',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:Random',
							'tracking' => 'explore-random',
						],
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-videos',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:Videos',
							'tracking' => 'explore-videos',
						],
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-images',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:Images',
							'tracking' => 'explore-images',
						],
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-forum',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:Forum',
							'tracking' => 'explore-forum',
						],
					] ),
			],
			[
				'globals' => [
					'wgEnableCommunityPageExt' => true,
					'wgEnableDiscussions' => false,
					'wgEnableForumExt' => true,
					'wgEnableSpecialVideosExt' => true,
				],
				'expectedExploreItems' => $this->prepareExploreItems( [
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-wiki-activity',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:WikiActivity',
							'tracking' => 'explore-activity',
						],
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-random-page',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:Random',
							'tracking' => 'explore-random',
						],
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-community',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:Community',
							'tracking' => 'explore-community',
						],
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-videos',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:Videos',
							'tracking' => 'explore-videos',
						],
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-images',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:Images',
							'tracking' => 'explore-images',
						],
					] ),
			],
			[
				'globals' => [
					'wgEnableCommunityPageExt' => true,
					'wgEnableDiscussions' => true,
					'wgEnableForumExt' => false,
					'wgEnableSpecialVideosExt' => true,
				],
				'expectedExploreItems' => $this->prepareExploreItems( [
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-wiki-activity',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:WikiActivity',
							'tracking' => 'explore-activity',
						],
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-random-page',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:Random',
							'tracking' => 'explore-random',
						],
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-community',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:Community',
							'tracking' => 'explore-community',
						],
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-videos',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:Videos',
							'tracking' => 'explore-videos',
						],
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-images',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:Images',
							'tracking' => 'explore-images',
						],
					] ),
			],
			[
				'globals' => [
					'wgEnableCommunityPageExt' => true,
					'wgEnableDiscussions' => false,
					'wgEnableForumExt' => false,
					'wgEnableSpecialVideosExt' => true,
				],
				'expectedExploreItems' => $this->prepareExploreItems( [
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-wiki-activity',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:WikiActivity',
							'tracking' => 'explore-activity',
						],
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-random-page',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:Random',
							'tracking' => 'explore-random',
						],
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-community',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:Community',
							'tracking' => 'explore-community',
						],
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-videos',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:Videos',
							'tracking' => 'explore-videos',
						],
						[
							'label' => [
								'type' => 'translatable-text',
								'key' => 'community-header-images',
								'iconKey' => null,
							],
							'href' => $host . '/wiki/Special:Images',
							'tracking' => 'explore-images',
						],
					] ),
			],
		];
	}

	private function prepareDiscussLink( $raw ) {
		return new Link( new Label( $raw[ 'label' ][ 'key' ], $raw[ 'label' ][ 'type' ], $raw[ 'label' ][ 'iconKey' ] ), $raw[ 'href' ], $raw[ 'tracking' ] );
	}

	public function discussLinkProvider() {
		$host = wfProtocolUrlToRelative( WikiFactory::getLocalEnvURL( self::DOMAIN ) );

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
							'iconKey' => 'wds-icons-reply-small',
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
							'iconKey' => 'wds-icons-reply-small',
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
							'iconKey' => 'wds-icons-reply-small',
						],
						'href' => $host . '/wiki/Special:Forum',
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
