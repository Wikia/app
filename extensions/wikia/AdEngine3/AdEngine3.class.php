<?php

class AdEngine3
{
	const AD_ENGINE_3_ASSET_GROUP = 'adengine3_top_js';

	public static function isEnabled()
	{
		$wg = F::app()->wg;

		$articleId = $wg->Title->getArticleID();
		$hasFeaturedVideo = ArticleVideoContext::isFeaturedVideoEmbedded($articleId);
		if ($hasFeaturedVideo) {
			return $wg->AdDriverAdEngine3EnabledOnFeaturedVideoPages;
		}

		$wikiaPageType = new WikiaPageType();
		$isSearch = $wikiaPageType->isSearch();
		if ($isSearch) {
			return $wg->AdDriverAdEngine3EnabledOnOasisSearchPages;
		}

		return false;
	}

	public static function onWikiaSkinTopScripts(&$vars, &$scripts)
	{
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

	public static function onOasisSkinAssetGroupsBlocking(&$jsAssets)
	{
		if (!self::isEnabled()) {
			return true;
		}

		$jsAssets[] = static::AD_ENGINE_3_ASSET_GROUP;

		return true;
	}

	public static function getContext()
	{
		$wg = F::app()->wg;

		$title = $wg->Title;
		$articleId = $title->getArticleId();

		$adPageTypeService = new AdEngine2PageTypeService();
		$hubService = new HubService();
		$langCode = $title->getPageLanguage()->getCode();
		$wikiaPageType = new WikiaPageType();
		$pageType = $wikiaPageType->getPageType();
		$wikiFactoryHub = WikiFactoryHub::getInstance();
		$hasFeaturedVideo = ArticleVideoContext::isFeaturedVideoEmbedded($articleId);
		$featuredVideoData = ArticleVideoContext::getFeaturedVideoData($articleId);

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
			'bidders' => array_filter([
				'audienceNetwork' => $wg->AdDriverUseAudienceNetworkBidder
			]),
			'opts' => array_filter([
				'adsInContent' => $wg->EnableAdsInContent,
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
}
