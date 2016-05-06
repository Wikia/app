<?php

use Wikia\Util\GlobalStateWrapper;

class AdEngine2ContextService {
	public function getContext( Title $title, $skinName ) {

		$wrapper = new GlobalStateWrapper( [
			'wgTitle' => $title,
		] );

		$wg = F::app()->wg;

		return $wrapper->wrap( function () use ( $title, $wg, $skinName ) {
			$wikiFactoryHub = WikiFactoryHub::getInstance();
			$hubService = new HubService();
			$adPageTypeService = new AdEngine2PageTypeService();
			$wikiaPageType = new WikiaPageType();
			$pageType = $wikiaPageType->getPageType();

			$monetizationServiceAds = null;
			if ( !empty( $wg->AdDriverUseMonetizationService ) && !empty( $wg->EnableMonetizationModuleExt ) ) {
				$monetizationServiceAds = F::app()->sendRequest( 'MonetizationModule', 'index' )->getData()['data'];
			}

			$sourcePointDetectionUrl = ResourceLoader::makeCustomURL( $wg->Out, ['wikia.ext.adengine.sp.detection'], 'scripts' );

			$langCode = $title->getPageLanguage()->getCode();

			// 1 of 3 verticals
			$oldWikiVertical = $hubService->getCategoryInfoForCity( $wg->CityId )->cat_name;

			// 1 of 7 verticals
			$newWikiVertical = $wikiFactoryHub->getWikiVertical( $wg->CityId );
			$newWikiVertical = !empty($newWikiVertical['short']) ? $newWikiVertical['short'] : 'error';

			$yavliUrl = ResourceLoader::makeCustomURL( $wg->Out, ['wikia.ext.adengine.yavli'], 'scripts' );
			return [
				'opts' => $this->filterOutEmptyItems( [
					'adsInContent' => $wg->EnableAdsInContent,
					'delayBtf' => $wg->AdDriverDelayBelowTheFold,
					'enableAdsInMaps' => $wg->AdDriverEnableAdsInMaps,
					'pageType' => $adPageTypeService->getPageType(),
					'paidAssetDropConfig' => $wg->PaidAssetDropConfig, // @see extensions/wikia/PaidAssetDrop
					'showAds' => $adPageTypeService->areAdsShowableOnPage(),
					'trackSlotState' => $wg->AdDriverTrackState,
					'sourcePointDetectionUrl' => $sourcePointDetectionUrl,
					'sourcePointRecovery' => ARecoveryModule::isEnabled(),
					'yavliUrl' => $yavliUrl,
				] ),
				'targeting' => $this->filterOutEmptyItems( [
					'enableKruxTargeting' => AnalyticsProviderKrux::isEnabled(),
					'enablePageCategories' => array_search( $langCode, $wg->AdPageLevelCategoryLangs ) !== false,
					'esrbRating' => AdTargeting::getEsrbRating(),
					'mappedVerticalName' => $this->getMappedVerticalName( $oldWikiVertical, $newWikiVertical ), //wikiCategory replacement for AdLogicPageParams.js::getPageLevelParams
					'pageArticleId' => $title->getArticleId(),
					'pageIsArticle' => !!$title->getArticleId(),
					'pageIsHub' => $wikiaPageType->isWikiaHub(),
					'pageName' => $title->getPrefixedDBKey(),
					'pageType' => $pageType,
					'skin' => $skinName,
					'wikiCategory' => $wikiFactoryHub->getCategoryShort( $wg->CityId ),
					'wikiCustomKeyValues' => $wg->DartCustomKeyValues,
					'wikiDbName' => $wg->DBname,
					'wikiIsCorporate' => $wikiaPageType->isCorporatePage(),
					'wikiIsTop1000' => $wg->AdDriverWikiIsTop1000,
					'wikiLanguage' => $langCode,
					'wikiVertical' => $newWikiVertical,
					'newWikiCategories' => $this->getNewWikiCategories($wikiFactoryHub, $wg->CityId),
				] ),
				'providers' => $this->filterOutEmptyItems( [
					'evolve2' => $wg->AdDriverUseEvolve2,
					'monetizationService' => $wg->AdDriverUseMonetizationService,
					'monetizationServiceAds' => $monetizationServiceAds,
					'taboola' => $wg->AdDriverUseTaboola && $pageType === 'article',
					'revcontent' => $wg->AdDriverUseRevcontent,
				] ),
				'slots' => $this->filterOutEmptyItems( [
					'exitstitial' => $wg->EnableOutboundScreenExt,
					'exitstitialRedirectDelay' => $wg->OutboundScreenRedirectDelay,
					'invisibleHighImpact' => $wg->AdDriverEnableInvisibleHighImpactSlot,
				] ),
				'forcedProvider' => $wg->AdDriverForcedProvider
			];
		} );
	}

	private function getMappedVerticalName( $oldWikiVertical, $newWikiVertical ) {
		if ($oldWikiVertical === 'Wikia') {
			return 'wikia';
		}

		$mapping = [
			'other' => 'life',
			'tv' => 'ent',
			'games' => 'gaming',
			'books' => 'ent',
			'comics' => 'ent',
			'lifestyle' => 'life',
			'music' => 'ent',
			'movies' => 'ent'
		];

		$newVerticalName = strtolower( $newWikiVertical );
		if ( !empty( $mapping[$newVerticalName] ) ) {
			return $mapping[$newVerticalName];
		}

		return 'error';
	}

	private function getNewWikiCategories(WikiFactoryHub $wikiFactoryHub, $cityId) {
		$oldWikiCategories = $wikiFactoryHub->getWikiCategoryNames( $cityId, false );
		$newWikiCategories = $wikiFactoryHub->getWikiCategoryNames( $cityId, true );

		if( is_array($oldWikiCategories) && is_array($newWikiCategories) ) {
			$wikiCategories = array_merge($oldWikiCategories, $newWikiCategories);
		} else if ( is_array($oldWikiCategories) ) {
			$wikiCategories = $oldWikiCategories;
		} else if ( is_array($newWikiCategories) ) {
			$wikiCategories = $newWikiCategories;
		} else {
			$wikiCategories = [];
		}

		return array_unique($wikiCategories);
	}

	private function filterOutEmptyItems( $input ) {
		$output = [];
		foreach ( $input as $varName => $varValue ) {
			if ( (bool) $varValue === true ) {
				$output[$varName] = $varValue;
			}
		}
		return $output;
	}
}
