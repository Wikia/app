<?php


/**
 * Controller to fetch information from WikiaHubs pages
 */
class WikiaHubsApiController extends WikiaApiController {
	const DEFAULT_LANG = 'en';

	const PARAMETER_MODULE = 'module';
	const PARAMETER_VERTICAL = 'vertical';
	const PARAMETER_CITY = 'city';
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
		$lang = $this->request->getVal( self::PARAMETER_LANG );

		$out = WikiaDataAccess::cache(
			'hubs_list_' . $lang,
			6 * 60 * 60,
			function () use( $lang ) {
				return $this->getHubsWikis( $lang );
			}
		);

		$this->response->setVal( 'list', $out );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}


	/**
	 * Get explore module data from given date and city id
	 *
	 * @requestParam integer $module [REQUIRED] module id see EditHubModel.class.php from line 9 to 17
	 * @requestParam integer $city [REQUIRED] city id of givenhub
	 * @requestParam integer $timestamp [OPTIONAL] unix timestamp, default current date
	 *
	 *
	 * @responseParam array $data - Data return by hub module - structure depends on $module parameter
	 *
	 * @example &module=1&city=2
	 * @example &module=1&city=2&ts=1359504000
	 *
	 */

	public function getModuleData() {
		$this->getModuleDataV3();
	}

	/**
	 * Get explore module data from given date and city id
	 *
	 * @requestParam integer $module [REQUIRED] module id see EditHubModel.class.php from line 9 to 17
	 * @requestParam integer $city [REQUIRED] city id of given hub
	 * @requestParam integer $timestamp [OPTIONAL] unix timestamp, default current date
	 *
	 * @responseParam array $data - Data return by hub module - structure depends on $module parameter
	 *
	 * @example
	 * @example &module=1&city=2&ts=1359504000
	 */

	public function getModuleDataV3() {
		wfProfileIn( __METHOD__ );

		$moduleId = $this->request->getInt(self::PARAMETER_MODULE);
		$cityId = $this->request->getInt(self::PARAMETER_CITY);
		$timestamp = $this->request->getInt(self::PARAMETER_TIMESTAMP, strtotime('00:00'));

		$model = $this->getModelV3();
		$data = null;
		if( !$this->isValidModule($model, $moduleId) ) {
			throw new InvalidParameterApiException( self::PARAMETER_MODULE );
		}

		if( !$this->isValidCity($cityId) ) {
			throw new InvalidParameterApiException( self::PARAMETER_CITY );
		}

		if( !$this->isValidTimestamp($timestamp) ) {
			throw new InvalidParameterApiException( self::PARAMETER_TIMESTAMP );
		}

		$moduleName = $model->getNotTranslatedModuleName($moduleId);
		$moduleService = WikiaHubsModuleService::getModuleByName($moduleName, $cityId);

		if( $this->isValidModuleService($moduleService) ) {
			$moduleService->setShouldFilterCommercialData( $this->hideNonCommercialContent() );

			$data = $moduleService->loadData($model, [
				'city_id' => $cityId,
				'ts' => $timestamp,
			]);

		} else {
			throw new BadRequestApiException();
		}

		$this->setResponseData(
			[ 'data' => $data ],
			[ 'urlFields' =>
				[
					'articleUrl', 'href', 'hubUrl', 'imageLink',
					'imageUrl',  'photoUrl', 'url', 'userUrl', 'wikiUrl'
				]
			],
			WikiaResponse::CACHE_STANDARD
		);


		wfProfileOut( __METHOD__ );
	}

	protected function getModelV3() {
		return new EditHubModel($this->app);
	}
	
	protected function isValidModule(EditHubModel $model, $moduleId) {
		if( $moduleId > 0 ) {
			return in_array($moduleId, $model->getModulesIds());
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
		return ($moduleService instanceof WikiaHubsModuleService);
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
			$out[ $wikiId ] = [
				'id' => $wikiId,
				'name' => $wiki['t'],
				'url' => $wiki['u'],
				'language' => $wiki['l']
			];
		}

		return $out;
	}

	protected function isValidCity( $cityId ) {
		return WikiaDataAccess::cache(
			'hubsapi_is_valid_cityid_' . $cityId,
			6 * 60 * 60,
			function () use( $cityId ) {
				$varId = WikiFactory::getVarIdByName( self::HUBS_V3_VARIABLE_NAME );
				$varData = WikiFactory::getVarById( $varId, $cityId );

				return !empty( $varData ) && !empty( $varData->cv_value ) && unserialize( $varData->cv_value );
			}
		);
	}

}
