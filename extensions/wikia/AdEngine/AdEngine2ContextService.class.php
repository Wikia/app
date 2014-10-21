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

			return [
				'opts' => $this->filterOutEmptyItems( [
					'adsInHead' => !!$wg->EnableAdsInContent,
					'disableLateQueue' => $wg->AdEngineDisableLateQueue,
					'lateAdsAfterPageLoad' => $adEngineService->areAdsAfterPageLoad(),
					'pageType' => $adPageTypeService->getPageType(),
					'showAds' => $adPageTypeService->areAdsShowableOnPage(),
					'useDartForSlotsBelowTheFold' => $wg->AdDriverUseDartForSlotsBelowTheFold,
					'usePostScribe' => $wg->Request->getBool( 'usepostscribe', false ),
					'trackSlotState' => $wg->AdDriverTrackState,
				] ),
				'targeting' => $this->filterOutEmptyItems( [
					'enableKruxTargeting' => $wg->EnableKruxTargeting,
					'kruxCategoryId' => $wikiFactoryHub->getKruxId( $wikiFactoryHub->getCategoryId( $wg->CityId ) ),
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
					'wikiLanguage' => $title->getPageLanguage()->getCode(),
					'wikiVertical' => $hubService->getCategoryInfoForCity( $wg->CityId )->cat_name,
				] ),
				'providers' => $this->filterOutEmptyItems( [
					'remnantGptMobile' => !!$wg->AdDriverEnableRemnantGptMobile,
					'sevenOneMedia' => !!$wg->AdDriverUseSevenOneMedia,
					'sevenOneMediaCombinedUrl' => $sevenOneMediaCombinedUrl,
					'taboola' => !!$wg->AdDriverUseTaboola,
				] ),
				'slots' => $this->filterOutEmptyItems( [
				] ),
				'forceProviders' => $this->filterOutEmptyItems( [
					'directGpt' => $wg->AdDriverForceDirectGptAd,
					'liftium' => $wg->AdDriverForceLiftiumAd,
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
