<?php
/**
 * Controller to fetch information from WikiaHubs pages
 */
class WikiaHubsApiController extends WikiaApiController {
	const DEFAULT_LANG = 'en';
	const CLIENT_CACHE_VALIDITY = 86400; //24*60*60 = 24h

	const PARAMETER_VERTICAL = 'vertical';
	const PARAMETER_TIMESTAMP = 'timestamp';

	/**
	 * Get explore module data from given date and vertical
	 *
	 * @requestParam integer $vertical [REQUIRED] vertical id see 
	 * @requestParam integer $timestamp [REQUIRED]
	 * @requestParam string $lang [OPTIONAL] default set to EN
	 *
	 * @responseParam array $items The list of top articles by pageviews matching the optional filtering
	 * @responseParam string $basepath domain of a wiki to create a url for an article
	 *
	 * @example
	 * @example &vertical=2&date=1359504000
	 * @example &vertical=2&date=1359504000&lang=de
	 */
	public function getExploreModule() {
		$this->wf->ProfileIn( __METHOD__ );
		
		$moduleId = MarketingToolboxModel::MODULE_EXPLORE;
		$verticalId = $this->request->getInt('vertical');
		$timestamp = $this->request->getInt('timestamp');
		$lang = $this->request->getVal('lang', self::DEFAULT_LANG);
		$model = new MarketingToolboxModel($this->app);
		
		if( !in_array($verticalId, $model->getVerticalsIds()) || $verticalId <= 0 ) {
			throw new InvalidParameterApiException( self::PARAMETER_VERTICAL );
		}

		if( $timestamp <= 0 ) {
			throw new InvalidParameterApiException( self::PARAMETER_VERTICAL );
		}
		
		$allModulesData = $model->getModulesData($lang, MarketingToolboxModel::SECTION_HUBS, $verticalId, $timestamp);
		
		if( !empty($allModulesData['moduleList'][$moduleId]['data']) ) {
			$this->response->setVal('data', $allModulesData['moduleList'][$moduleId]['data']);
		} else {
			throw new NotFoundApiException();
		}
		
		$this->response->setCacheValidity(
			self::CLIENT_CACHE_VALIDITY,
			self::CLIENT_CACHE_VALIDITY,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);
		
		$this->wf->ProfileOut( __METHOD__ );
	}
	
}
