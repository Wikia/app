<?php

class MonetizationModuleController extends WikiaController {

	/**
	 * Monetization Module
	 * @responseParam array data - list of modules
	 */
	public function getModules() {
		$articleId = $this->request->getInt( 'articleId' );
		if ( empty( $articleId ) ) {
			$title = $this->wg->Title;
		} else {
			$title = Title::newFromID( $articleId );
			if ( !$title instanceof Title ) {
				$this->data = '';
				return true;
			}
		}

		if ( !MonetizationModuleHelper::canShowModule( $title ) ) {
			$this->data = '';
			return true;
		}

		$helper = new MonetizationModuleHelper();

		$params = [
			's_id' => $this->wg->CityId,
			'vertical' => $helper->getWikiVertical(),
			'cache' => $helper->getCacheVersion(),
		];

		$mcachePurge = $this->wg->request->getVal( 'mcache', false );
		if ( $mcachePurge ) {
			$params['mcache'] = $mcachePurge;
		}

		$adEngine = $this->request->getBool( 'adEngine', false );
		if ( $adEngine ) {
			$params['ad_engine'] = $adEngine;
			$params['geo'] = $helper->getCountryCode();
			$params['max'] = $this->request->getInt( 'max' );

			$fromSearch = $this->request->getBool( 'fromSearch', false );
			if ( $fromSearch ) {
				$params['from_search'] = $fromSearch;
			}
		} else {
			$params['max'] = MonetizationModuleHelper::calculateNumberOfAds( $title->mLength );
			$this->addAssets();
		}

		$this->data = $helper->getMonetizationUnits( $title, $params );

		// check if the article page is blocked
		if ( !empty( $this->data['blocked_pages'] ) && in_array( $title->getArticleID(), $this->data['blocked_pages'] ) ) {
			$this->data = '';
		}
	}

	/**
	 * Add assets
	 */
	protected function addAssets() {
		if ( empty( $this->wg->OasisBreakpoints ) ) {
			$this->response->addAsset( 'monetization_module_css_no_breakpoints' );
		} else {
			$this->response->addAsset( 'monetization_module_css' );
		}

		$this->response->addAsset( 'monetization_module_js' );
	}

}
