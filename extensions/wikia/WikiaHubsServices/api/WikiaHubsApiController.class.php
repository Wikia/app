<?php


/**
 * Controller to fetch information from WikiaHubs pages
 */
class WikiaHubsApiController extends WikiaApiController {
	const DEFAULT_LANG = 'en';

	const PARAMETER_MODULE = 'module';
	const PARAMETER_VERTICAL = 'vertical';
	const PARAMETER_TIMESTAMP = 'ts';
	const PARAMETER_LANG = 'lang';
	const HUBS_V3_VARIABLE_NAME = 'wgEnableWikiaHubsV3Ext';

	/**
	 * Get Hubs list
	 *
	 * @requestParam string $lang [OPTIONAL] default set to EN
	 *
	 * @responseParam array $list list of wikis that are hubsV3, structure of list items: $wikiId, $wikiName, $wikiUrl, $wikiLanguage
	 *
	 * @example
	 * @example &lang=en
	 */
	public function getHubsV3List() {
		$lang = $this->request->getVal(self::PARAMETER_LANG);

		$out = WikiaDataAccess::cache(
			'hubs_list_' . $lang,
			6 * 60 * 60,
			function () use( $lang ) {
				return $this->getHubsWikis( $lang );
			}
		);

		$this->response->setVal('list', $out);
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}

	/**
	 * Get hub module data from given date and vertical
	 *
	 * @requestParam integer $module [REQUIRED] module id see MarketingToolboxModel.class.php from line 9 to 17
	 * @requestParam integer $vertical [REQUIRED] vertical id see WikiFactoryHub::CATEGORY_ID_GAMING, WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT, WikiFactoryHub::CATEGORY_ID_LIFESTYLE
	 * @requestParam integer $timestamp [OPTIONAL] unix timestamp, default current date
	 * @requestParam string $lang [OPTIONAL] default set to EN
	 *
	 * @responseParam array $data - Data return by hub module - structure depends on $module parameter
	 *
	 * @example
	 * @example &module=1&vertical=2&ts=1359504000
	 * @example &module=1&vertical=2&ts=1359504000&lang=de
	 */

	public function getModuleData() {
		wfProfileIn( __METHOD__ );
		
		$moduleId = $this->request->getInt(self::PARAMETER_MODULE);
		$verticalId = $this->request->getInt(self::PARAMETER_VERTICAL);
		$timestamp = $this->request->getInt(self::PARAMETER_TIMESTAMP, strtotime('00:00'));
		$lang = $this->request->getVal(self::PARAMETER_LANG, self::DEFAULT_LANG);
		
		$model = $this->getModel();

		if( !$this->isValidModule($model, $moduleId) ) {
			throw new InvalidParameterApiException( self::PARAMETER_MODULE );
		}
		
		if( !$this->isValidVertical($model, $verticalId) ) {
			throw new InvalidParameterApiException( self::PARAMETER_VERTICAL );
		}

		if( !$this->isValidTimestamp($timestamp) ) {
			throw new InvalidParameterApiException( self::PARAMETER_TIMESTAMP );
		}
		
		$moduleName = $model->getNotTranslatedModuleName($moduleId);
		$moduleService = MarketingToolboxModuleService::getModuleByName($moduleName, $lang, MarketingToolboxModel::SECTION_HUBS, $verticalId);
		
		if( $this->isValidModuleService($moduleService) ) {
			$moduleService->setShouldFilterCommercialData( $this->hideNonCommercialContent() );
			$data = $moduleService->loadData($model, [
				'lang' => $lang,
				'vertical_id' => $verticalId,
				'ts' => $timestamp,
			]);
			$this->response->setVal('data', $data);
		} else {
			throw new BadRequestApiException();
		}
		
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
		
		wfProfileOut( __METHOD__ );
	}
	
	protected function getModel() {
		return new MarketingToolboxModel($this->app);
	}
	
	protected function isValidModule(MarketingToolboxModel $model, $moduleId) {
		if( $moduleId > 0 ) {
			return in_array($moduleId, $model->getModulesIds());
		}
		
		return false;
	}

	protected function isValidVertical(MarketingToolboxModel $model, $verticalId) {
		if( $verticalId > 0 ) {
			return in_array($verticalId, $model->getVerticalsIds());
		}
		
		return false;
	}

	protected function isValidTimestamp($timestamp) {
		if( $timestamp > 0 && $timestamp <= time() ) {
			return true;
		}

		return false;
	}
	
	protected function isValidModuleService($moduleService) {
		return ($moduleService instanceof MarketingToolboxModuleService);
	}

	/**
	 * Get list of hubs from Database
	 *
	 * @param $lang
	 * @return array
	 */
	private function getHubsWikis( $lang ) {
		$varId = WikiFactory::getVarIdByName( self::HUBS_V3_VARIABLE_NAME );

		$wikis = WikiFactory::getListOfWikisWithVar( $varId, 'bool', '=', true );

		if ( !empty( $lang ) ) {
			foreach ( $wikis as $wikiId => $wiki ) {
				if ( $wiki['l'] != $lang ) {
					unset( $wikis[$wikiId] );
				}
			}
		}

		$out = [];
		foreach ( $wikis as $wikiId => $wiki ) {
			$out[] = [
				'id' => $wikiId,
				'name' => $wiki['t'],
				'url' => $wiki['u'],
				'language' => $wiki['l']
			];
		}

		return $out;
	}

}
