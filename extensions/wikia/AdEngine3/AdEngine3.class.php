<?php

class AdEngine3
{
	const AD_ENGINE_3_ASSET_GROUP = 'adengine3_top_js';
	const AD_ENGINE_3_ASSET_DEV_GROUP = 'adengine3_dev_top_js';

	static $forceProductionAssets = false;

	public static function isEnabled() {
		$wg = F::app()->wg;

		return $wg->AdDriverAdEngine3Enabled;
	}

	public static function onWikiaSkinTopScripts(&$vars, &$scripts) {
		if (!self::isEnabled()) {
			return true;
		}

		$adContext = self::getContext();

		$vars['ads'] = [
			'context' => $adContext,
			'runtime' => [
				'disableBtf' => false,
			],
		];

		$vars['adslots2'] = [];

		return true;
	}

	public static function onAfterInitialize( $title, $article, $output, $user, WebRequest $request, $wiki ) {
		self::$forceProductionAssets = $request->getBool( 'ae3_prod' );

		$distDirectory = self::shouldUseProductionAssets() ? 'dist' : 'dist-dev';
		$assetsPath = 'extensions/wikia/AdEngine3/' . $distDirectory . '/ads.scss';

		$output->addExtensionStyle( AssetsManager::getInstance()->getSassCommonURL( $assetsPath ) );

		return true;
	}

	public static function onOasisSkinAssetGroupsBlocking(&$jsAssets) {
		if (!self::isEnabled()) {
			return true;
		}

		if (self::shouldUseProductionAssets()) {
			$jsAssets[] = static::AD_ENGINE_3_ASSET_GROUP;
		} else {
			$jsAssets[] = static::AD_ENGINE_3_ASSET_DEV_GROUP;
		}

		return true;
	}

	public static function getContext() {
		$wg = F::app()->wg;

		$title = $wg->Title;
		$articleId = $title->getArticleId();

		$adPageTypeService = new AdEngine3PageTypeService();
		$hubService = new HubService();
		$langCode = $title->getPageLanguage()->getCode();
		$wikiaPageType = new WikiaPageType();
		$pageType = $wikiaPageType->getPageType();
		$wikiFactoryHub = WikiFactoryHub::getInstance();

		$hasFeaturedVideo = ArticleVideoContext::isFeaturedVideoAvailable( $articleId );
		$featuredVideoData = ArticleVideoContext::getFeaturedVideoData( $articleId );

		// 1 of 3 verticals
		$oldWikiVertical = $hubService->getCategoryInfoForCity($wg->CityId)->cat_name;

		// 1 of 7 verticals
		$newWikiVertical = $wikiFactoryHub->getWikiVertical($wg->CityId);
		$newWikiVertical = !empty($newWikiVertical['short']) ? $newWikiVertical['short'] : 'error';

		$featuredVideoDetails = null;
		if (!empty($featuredVideoData)) {
			$featuredVideoDetails = [
				'mediaId' => $featuredVideoData['mediaId'] ?? null,
				'videoTags' => explode(',', $featuredVideoData['videoTags'] ?? '')
			];
		}

		return [
			'bidders' => [],
			'opts' => array_filter([
				'adsInContent' => $wg->EnableAdsInContent,
				'enableCheshireCat' => $wg->AdDriverEnableCheshireCat,
				'isAdTestWiki' => $wg->AdDriverIsAdTestWiki,
				'isIncontentPlayerDisabled' => $wg->DisableIncontentPlayer,
				'pageType' => $adPageTypeService->getPageType(),
				'showAds' => $adPageTypeService->areAdsShowableOnPage(),
			]),
			'targeting' => array_filter([
				'enableKruxTargeting' => AnalyticsProviderKrux::isEnabled(),
				'enablePageCategories' => array_search($langCode, $wg->AdPageLevelCategoryLangs) !== false,
				'esrbRating' => AdTargeting::getEsrbRating(),
				'mappedVerticalName' => AdEngine3WikiData::getVerticalName($oldWikiVertical, $newWikiVertical),
				'pageArticleId' => $articleId,
				'pageIsArticle' => !!$articleId,
				'pageIsHub' => $wikiaPageType->isWikiaHub(),
				'pageName' => $title->getPrefixedDBKey(),
				'pageType' => $pageType,
				'wikiCategory' => $wikiFactoryHub->getCategoryShort($wg->CityId),
				'wikiCustomKeyValues' => $wg->DartCustomKeyValues,
				'wikiDbName' => $wg->DBname,
				'wikiId' => $wg->CityId,
				'wikiIsCorporate' => $wikiaPageType->isCorporatePage(),
				'wikiIsTop1000' => $wg->AdDriverWikiIsTop1000,
				'wikiLanguage' => $langCode,
				'wikiVertical' => $newWikiVertical,
				'newWikiCategories' => AdEngine3WikiData::getWikiCategories($wikiFactoryHub, $wg->CityId),
				'hasPortableInfobox' => !empty(\Wikia::getProps($title->getArticleID(), PortableInfoboxDataService::INFOBOXES_PROPERTY_NAME)),
				'hasFeaturedVideo' => $hasFeaturedVideo,
				'featuredVideo' => $featuredVideoDetails,
				'testSrc' => $wg->AdDriverAdTestWikiSrc
			])
		];
	}

	private static function shouldUseProductionAssets() {
		global $IP;

		$wg = F::app()->wg;

		if (self::$forceProductionAssets || !$wg->AdDriverAdEngine3DevAssets) {
			return true;
		}
		$mainFile = $IP . '/extensions/wikia/AdEngine3/dist-dev/ads.js';

		return !file_exists( $mainFile );
	}
}
