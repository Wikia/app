<?php

class MonetizationModuleController extends WikiaController {

	/**
	 * Monetization Module
	 * @responseParam array data - list of modules
	 */
	public function getModules() {
		wfProfileIn( __METHOD__ );

		if ( !MonetizationModuleHelper::canShowModule() ) {
			$this->data = '';
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( empty( $this->wg->AdDriverUseMonetizationService ) ) {
			if ( empty( $this->wg->OasisBreakpoints ) ) {
				$this->response->addAsset( 'monetization_module_css_no_breakpoints' );
			} else {
				$this->response->addAsset( 'monetization_module_css' );
			}
		}

		$this->response->addAsset( 'monetization_module_js' );

		$helper = new MonetizationModuleHelper();

		$params = [
			's_id' => $this->wg->CityId,
			'max' => MonetizationModuleHelper::calculateNumberOfAds( $this->wg->Title->mLength ),
			'vertical' => $helper->getWikiVertical(),
			'cache' => $helper->getCacheVersion(),
		];

		$mcachePurge = $this->wg->request->getVal( 'mcache', false );
		if ( $mcachePurge ) {
			$params['mcache'] = $mcachePurge;
		}

		$adEngine = $this->request->getVal( 'adEngine', false );
		$fromSearch = $this->request->getVal( 'from_search', false );
		if ( $adEngine ) {
			$params['ad_engine'] = $adEngine;
			$params['geo'] = $helper->getCountryCode();
			if ( $fromSearch ) {
				$params['from_search'] = $fromSearch;
			}
		}

		$this->data = $helper->getMonetizationUnits( $params );

		// check if the article page is blocked
		if ( !empty( $this->data['blocked_pages'] ) && in_array( $this->wg->title->getArticleID(), $this->data['blocked_pages'] ) ) {
			$this->data = '';
		}

		wfProfileOut( __METHOD__ );
	}

}
