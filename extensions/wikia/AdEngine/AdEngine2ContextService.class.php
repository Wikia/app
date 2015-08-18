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

			$sevenOneMediaCombinedUrl = null;
			if ( !empty( $wg->AdDriverUseSevenOneMedia ) ) {
				// TODO: implicitly gets the skin from the context!
				$sevenOneMediaCombinedUrl = ResourceLoader::makeCustomURL( $wg->Out, ['wikia.ext.adengine.sevenonemedia'], 'scripts' );
			}

			$monetizationServiceAds = null;
			if ( !empty( $wg->AdDriverUseMonetizationService ) && !empty( $wg->EnableMonetizationModuleExt ) ) {
				$monetizationServiceAds = F::app()->sendRequest( 'MonetizationModule', 'index' )->getData()['data'];
			}

			$sourcePointUrl = null;
			if ( $skinName === 'oasis' ) {
				$sourcePointUrl = ResourceLoader::makeCustomURL( $wg->Out, ['wikia.ext.adengine.sourcepoint'], 'scripts' );
			}

			$langCode = $title->getPageLanguage()->getCode();
			return [
				'opts' => $this->filterOutEmptyItems( [
					'adsInContent' => $wg->EnableAdsInContent,
					'delayBtf' => $wg->AdDriverDelayBelowTheFold,
					'enableAdsInMaps' => $wg->AdDriverEnableAdsInMaps,
					'pageType' => $adPageTypeService->getPageType(),
					'paidAssetDropConfig' => $wg->PaidAssetDropConfig, // @see extensions/wikia/PaidAssetDrop
					'showAds' => $adPageTypeService->areAdsShowableOnPage(),
					'trackSlotState' => $wg->AdDriverTrackState,
					'usePostScribe' => $wg->Request->getBool( 'usepostscribe', false ),
					'sourcePointUrl' => $sourcePointUrl,
				] ),
				'targeting' => $this->filterOutEmptyItems( [
					'enableKruxTargeting' => $wg->EnableKruxTargeting,
					'enablePageCategories' => array_search( $langCode, $wg->AdPageLevelCategoryLangs ) !== false,
					'mappedVerticalName' => $this->getMappedVerticalName( $wg->CityId ), //wikiCategory replacement for AdLogicPageParams.js::getPageLevelParams
					'pageArticleId' => $title->getArticleId(),
					'pageIsArticle' => !!$title->getArticleId(),
					'pageIsHub' => $wikiaPageType->isWikiaHub(),
					'pageName' => $title->getPrefixedDBKey(),
					'pageType' => $wikiaPageType->getPageType(),
					'sevenOneMediaSub2Site' => $wg->AdDriverSevenOneMediaOverrideSub2Site,
					'skin' => $skinName,
					'wikiCategory' => $wikiFactoryHub->getCategoryShort( $wg->CityId ),
					'wikiCustomKeyValues' => $wg->DartCustomKeyValues,
					'wikiDbName' => $wg->DBname,
					'wikiDirectedAtChildren' => $wg->WikiDirectedAtChildrenByFounder || $wg->WikiDirectedAtChildrenByStaff,
					'wikiIsCorporate' => $wikiaPageType->isCorporatePage(),
					'wikiIsTop1000' => $wg->AdDriverWikiIsTop1000,
					'wikiLanguage' => $langCode,
					'wikiVertical' => $hubService->getCategoryInfoForCity( $wg->CityId )->cat_name,
				] ),
				'providers' => $this->filterOutEmptyItems( [
					'monetizationService' => $wg->AdDriverUseMonetizationService,
					'monetizationServiceAds' => $monetizationServiceAds,
					'sevenOneMedia' => $wg->AdDriverUseSevenOneMedia,
					'sevenOneMediaCombinedUrl' => $sevenOneMediaCombinedUrl,
					'taboola' => $wg->AdDriverUseTaboola,
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

	private function getMappedVerticalName( $cityId ) {
		$wikiVertical = WikiFactoryHub::getInstance()->getWikiVertical( $cityId );
		if ( !empty( $wikiVertical['short'] ) ) {
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
			$newVerticalName = strtolower( $wikiVertical['short'] );
			if ( !empty( $mapping[$newVerticalName] ) ) {
				return $mapping[$newVerticalName];
			}
		}
		return 'error';
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
