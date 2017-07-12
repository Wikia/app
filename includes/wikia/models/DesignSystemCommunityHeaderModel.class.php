<?php


class DesignSystemCommunityHeaderModel extends WikiaModel {
	const DEFAULT_LANG = 'en';
	const PRODUCT_WIKIS = 'wikis';

	const WORDMARK_TYPE_GRAPHIC = 'graphic';

	private $product;
	private $productInstanceId;
	private $lang;

	private $wordmarkData = null;
	private $sitenameData = null;
	private $bgImageUrl = null;
	private $exploreMenu = null;

	private $themeSettings;
	private $settings;
	private $mainPageUrl;

	public function __construct( $product, $productInstanceId, $lang = self::DEFAULT_LANG ) {
		parent::__construct();

		$this->product = $product;
		$this->productInstanceId = $productInstanceId;
		$this->lang = $lang;

		$this->themeSettings = new ThemeSettings();
		$this->settings = $this->themeSettings->getSettings();
		$this->mainPageUrl = GlobalTitle::newMainPage( $this->productInstanceId )->getFullURL();
	}

	public function getData(): array {
		$data = [
			"sitename" => $this->getSiteNameData(),
			"navigation" => $this->getNavigation()
		];

		if ( !empty( $this->getBackgroundImageUrl() ) ) {
			$data["background_image"] = $this->getBackgroundImageUrl();
		}

		if ( !empty( $this->getWordmarkData() ) ) {
			$data["wordmark"] = $this->getWordmarkData();
		}

		return $data;
	}

	public function getWordmarkData(): array {
		if ( $this->wordmarkData === null ) {
			$this->wordmarkData = [];

			if ( $this->settings['wordmark-type'] === self::WORDMARK_TYPE_GRAPHIC ) {
				$this->wordmarkData = [
					"type" => "link-image",
					"href" => $this->mainPageUrl,
					"image-data" => [
						"type" => "image-external",
						"url" => $this->themeSettings->getWordmarkUrl(),
					],
					"title" => [
						"type" => "text",
						"value" => $this->themeSettings->getSettings()['wordmark-text'],
					],
					"tracking_label" => "wordmark-image",
				];
			}
		}

		return $this->wordmarkData;
	}

	public function getSiteNameData(): array {
		if ( $this->sitenameData === null ) {
			$this->sitenameData = [
				"type" => "link-text",
				"title" => [
					"type" => "text",
					"value" => $this->themeSettings->getSettings()['wordmark-text']
				],
				"href" => $this->mainPageUrl,
				"tracking_label" => "sitename"
			];
		}

		return $this->sitenameData;
	}

	public function getBackgroundImageUrl(): string {
		if ( $this->bgImageUrl === null ) {
			$this->bgImageUrl = $this->themeSettings->getCommunityHeaderBackgroundUrl();
		}

		return $this->bgImageUrl;
	}

	public function getNavigation(): array {
		return array_merge(
			$this->getWikiLocalNavigation(),
			$this->getExploreMenu(),
			$this->getDiscussLink()
		);
	}

	public function getWikiLocalNavigation(): array {

		return [];
	}

	public function getExploreMenu(): array {
		global $wgEnableCommunityPageExt, $wgEnableForumExt, $wgEnableDiscussions, $wgEnableSpecialVideosExt;

		if ( $this->exploreMenu === null ) {
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

			$this->exploreMenu = [
				"type" => "dropdown",
				"title" => [
					"type" => "translatable-text",
					"key" => "community-header-explore",
				],
				"image-data" => [
					"type" => "wds-svg",
					"name" => "wds-icons-explore-tiny"
				],
				"items" => array_map(
					function ( $item ) {
						return [
							"type" => "link-text",
							"title" => [
								"type" => "translatable-text",
								"key" => $item['key'],
							],
							"href" => GlobalTitle::newFromText( $item['title'], NS_SPECIAL, $this->productInstanceId )
								->getFullURL(),
							"tracking_label" => $item['tracking']
						];
					},
					array_filter(
						$exploreItems,
						function ( $item ) {
							return $item['include'];
						}
					)
				)];
		}

		return $this->exploreMenu;
	}

	public function getDiscussLink(): array {
		return [];
	}
}