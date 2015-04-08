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
			$adEngineService = new AdEngine2Service();

			$sevenOneMediaCombinedUrl = null;
			if ( !empty( $wg->AdDriverUseSevenOneMedia ) ) {
				// TODO: implicitly gets the skin from the context!
				$sevenOneMediaCombinedUrl = ResourceLoader::makeCustomURL( $wg->Out, ['wikia.ext.adengine.sevenonemedia'], 'scripts' );
			}

			$langCode = $title->getPageLanguage()->getCode();

			return [
				'opts' => $this->filterOutEmptyItems( [
					'adsInContent' => $wg->EnableAdsInContent,
					'adsInHead' => $wg->LoadAdsInHead,
					'alwaysCallDart' => $wg->AdDriverAlwaysCallDart,
					'disableLateQueue' => $wg->AdEngineDisableLateQueue,
					'enableAdsInMaps' => $wg->AdDriverEnableAdsInMaps,
					'lateAdsAfterPageLoad' => $adEngineService->areAdsAfterPageLoad(),
					'pageType' => $adPageTypeService->getPageType(),
					'showAds' => $adPageTypeService->areAdsShowableOnPage(),
					'usePostScribe' => $wg->Request->getBool( 'usepostscribe', false ),
					'trackSlotState' => $wg->AdDriverTrackState,
				] ),
				'targeting' => $this->filterOutEmptyItems( [
					'enableKruxTargeting' => $wg->EnableKruxTargeting,
					'enablePageCategories' => array_search($langCode, $wg->AdPageLevelCategoryLangs) !== false,
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
					'remnantGptMobile' => $wg->AdDriverEnableRemnantGptMobile,
					'sevenOneMedia' => $wg->AdDriverUseSevenOneMedia,
					'sevenOneMediaCombinedUrl' => $sevenOneMediaCombinedUrl,
					'taboola' => $wg->AdDriverUseTaboola,
				] ),
				'slots' => $this->filterOutEmptyItems( [
				] ),
				// TODO: make it like forceadprovider=liftium
				'forceProviders' => $this->filterOutEmptyItems( [
					'directGpt' => $wg->AdDriverForceDirectGptAd,
					'liftium' => $wg->AdDriverForceLiftiumAd,
					'szymon' => $wg->AdDriverForceSzymonAd,
					'turtle' => $wg->AdDriverForceTurtleAd,
				] ),
			];
		} );
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
