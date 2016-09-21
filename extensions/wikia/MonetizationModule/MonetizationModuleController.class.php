<?php

class MonetizationModuleController extends WikiaController {

	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/**
	 * Monetization Module
	 * @responseParam array data - list of modules
	 */
	public function index() {
		wfProfileIn( __METHOD__ );

		$helper = new MonetizationModuleHelper();

		if ( !$helper->canShowModule() ) {
			$this->data = '';
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( empty( $this->wg->OasisBreakpoints ) ) {
			$this->response->addAsset( 'monetization_module_css_no_breakpoints' );
		} else {
			$this->response->addAsset( 'monetization_module_css' );
		}

		$this->response->addAsset( 'monetization_module_js' );

		$params = [
			's_id' => $this->wg->CityId,
			'max' => $helper->calculateNumberOfAds( $this->wg->Title->mLength ),
			'vertical' => $helper->getWikiVertical(),
			'cache' => $helper->getCacheVersion(),
		];

		$mcachePurge = $this->wg->request->getVal( 'mcache', false );
		if ( $mcachePurge ) {
			$params['mcache'] = $mcachePurge;
		}

		$this->data = $helper->getMonetizationUnits( $params );

		// check if the article page is blocked
		if ( !empty( $this->data['blocked_pages'] ) && in_array( $this->wg->title->getArticleID(), $this->data['blocked_pages'] ) ) {
			$this->data = '';
		}

		wfProfileOut( __METHOD__ );
	}

}
