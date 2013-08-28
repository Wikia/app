<?php

use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 *     apiVersion="0.2",
 *     swaggerVersion="1.1",
 *     resourcePath="WikiaHubsApi",
 *     basePath="http://www.wikia.com"
 * )
 *
 * @SWG\Model( id="WikiaHubsResultSet" )
 * 		@SWG\Property(
 * 			name="data",
 * 			type="HubsData",
 * 			required="true",
 * 			description="Wrapping object"
 * 		)
 *
 * @SWG\Model( id="HubsData" )
 * 		@SWG\Property(
 * 			name="slides",
 * 			type="Array",
 * 			items="$ref:SlideItem",
 * 			required="true",
 * 			description="Slides collection"
 * 		)
 *
 * @SWG\Model( id="SlideItem" )
 * 		@SWG\Property(
 * 			name="photoUrl",
 * 			type="string",
 * 			required="true",
 * 			description="Image URL"
 * 		)
 * 		@SWG\Property(
 * 			name="strapline",
 * 			type="string",
 * 			required="true",
 * 			description="Headline text"
 * 		)
 * 		@SWG\Property(
 * 			name="shortDesc",
 * 			type="string",
 * 			required="true",
 * 			description="Short description"
 * 		)
 * 		@SWG\Property(
 * 			name="longDesc",
 * 			type="string",
 * 			required="true",
 * 			description="Long description"
 * 		)
 * 		@SWG\Property(
 * 			name="url",
 * 			type="string",
 * 			required="true",
 * 			description="URL to page"
 * 		)
 * 		@SWG\Property(
 * 			name="photoName",
 * 			type="string",
 * 			required="true",
 * 			description="Image name"
 * 		)
 */

/**
 * Controller to fetch information from WikiaHubs pages
 */
class WikiaHubsApiController extends WikiaApiController {
	const DEFAULT_LANG = 'en';
	const CLIENT_CACHE_VALIDITY = 86400; //24*60*60 = 24h

	const PARAMETER_MODULE = 'module';
	const PARAMETER_VERTICAL = 'vertical';
	const PARAMETER_TIMESTAMP = 'ts';
	const PARAMETER_LANG = 'lang';
	
	/**
	 * Get explore module data from given date and vertical
	 *
	 * @requestParam integer $module [REQUIRED] module id see MarketingToolboxModel.class.php from line 9 to 17
	 * @requestParam integer $vertical [REQUIRED] vertical id see WikiFactoryHub::CATEGORY_ID_GAMING, WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT, WikiFactoryHub::CATEGORY_ID_LIFESTYLE
	 * @requestParam integer $timestamp [OPTIONAL] unix timestamp, default current date
	 * @requestParam string $lang [OPTIONAL] default set to EN
	 *
	 * @responseParam array $items The list of top articles by pageviews matching the optional filtering
	 * @responseParam string $basepath domain of a wiki to create a url for an article
	 *
	 * @example
	 * @example &module=1&vertical=2&ts=1359504000
	 * @example &module=1&vertical=2&ts=1359504000&lang=de
	 */

	/**
	 *
	 * @SWG\Api(
	 *     path="/wikia.php?controller=WikiaHubsApi&method=getModuleData",
	 *     description="Get explore module data from given date and vertical",
	 *     @SWG\Operations(
	 *         @SWG\Operation(
	 *             httpMethod="GET",
	 *             summary=" Get explore module data from given date and vertical",
	 *             nickname="getModuleData",
	 *             responseClass="WikiaHubsResultSet",
	 *             @SWG\ErrorResponses(
	 *                 @SWG\ErrorResponse( code="400", reason="Module, vertical or timestamp not valid" )
	 *             ),
	 *             @SWG\Parameters(
	 *                 @SWG\Parameter(
	 *                     name="module",
	 *                     description="Module id",
	 *                     paramType="query",
	 *                     required="true",
	 *                     allowMultiple="false",
	 *                     dataType="int"
	 *                 ),
	 *                 @SWG\Parameter(
	 *                     name="vertical",
	 *                     description="Vertical id",
	 *                     paramType="query",
	 *                     required="true",
	 *                     allowMultiple="false",
	 *                     dataType="int"
	 *                 ),
	 *                 @SWG\Parameter(
	 *                     name="ts",
	 *                     description="Timestamp",
	 *                     paramType="query",
	 *                     required="false",
	 *                     allowMultiple="false",
	 *                     dataType="int"
	 *                 ),
	 *                 @SWG\Parameter(
	 *                     name="lang",
	 *                     description="Language",
	 *                     paramType="query",
	 *                     required="false",
	 *                     allowMultiple="false",
	 *                     dataType="string",
	 * 					   defaultValue="en"
	 *                 )
	 *             )
	 *         )
	 *     )
	 * )
	 *
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
			$data = $moduleService->loadData($model, [
				'lang' => $lang,
				'vertical_id' => $verticalId,
				'ts' => $timestamp,
			]);
			$this->response->setVal('data', $data);
		} else {
			throw new BadRequestApiException();
		}
		
		$this->response->setCacheValidity(
			self::CLIENT_CACHE_VALIDITY,
			self::CLIENT_CACHE_VALIDITY,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);
		
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
	
}