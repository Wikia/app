<?php

class WikiaHubsModuleWAMService extends WikiaHubsModuleNonEditableService {
	const WAM_SCORE_CHANGE_UP = 1;
	const WAM_SCORE_NO_CHANGE = 0;
	const WAM_SCORE_CHANGE_DOWN = -1;
	const WAM_SCORE_DECIMALS = 2;

	/**
	 * @var WikiaHubsWAMModel
	 */
	protected $model;

	const MODULE_ID = 10;

	/**
	 * @param Array $params
	 * @return array
	 */
	protected function prepareParameters($params) {
		$params['limit'] = $this->getModel()->getWamLimitForHubPage();

		if( !empty($params['ts']) && $params['ts'] >= strtotime(date('d-m-Y'))) {
			$params['ts'] = null;
		}

		if( empty($params['image_height']) ) {
			$params['image_height'] = $this->getModel()->getImageHeight();
		}

		if( empty($params['image_width']) ) {
			$params['image_width'] = $this->getModel()->getImageWidth();
		}

		if( empty($this->verticalId) ) {
			$this->verticalId = WikiFactoryHub::getInstance()->getVerticalId($this->cityId);
		}

		if( empty($this->langCode) ) {
			$this->langCode = $this->app->wg->ContLang->getCode();
		}

		return parent::prepareParameters([
			'wam_day' => $params['ts'],
			'vertical_id' => $this->verticalId,
			'wiki_lang' => $this->langCode,
			'exclude_blacklist' => true,
			'fetch_admins' => true,
			'fetch_wiki_images' => true,
			'limit' => $params['limit'],
			'sort_column' => 'wam_index',
			'sort_direction' => 'DESC',
			'wiki_image_height' => $params['image_height'],
			'wiki_image_width' => $params['image_width'],
		]);
	}

	public function loadData($model, $params) {
		$hubParams = $this->getHubsParams();
		$lastTimestamp = $model->getLastPublishedTimestamp(
			$hubParams,
			$params['ts']
		);

		$params = $this->prepareParameters($params);

		$structuredData = WikiaDataAccess::cache(
			$this->getMemcacheKey(
				$lastTimestamp,
				$this->skinName
			),
			WikiaResponse::CACHE_SHORT,
			function () use( $model, $params ) {
				return $this->loadStructuredData($model, $params);
			}
		);

		if ( $this->getShouldFilterCommercialData() ) {
			$structuredData = $this->filterCommercialData( $structuredData );
		}

		return $structuredData;
	}

	protected function loadStructuredData($model, $params) {
		try {

			$apiResponse = $this->app->sendRequest('WAMApi', 'getWAMIndex', $params)->getData();

		} catch (WikiaHttpException $e) {

			$logMsg = 'Message: ' . $e->getLogMessage() . ' Details: ' . $e->getDetails();
			Wikia::log(__METHOD__, false, $logMsg );
			Wikia::logBacktrace(__METHOD__);

		}

		$data = [
			'vertical_id' => $params['vertical_id'],
			'api_response' => $apiResponse,
		];

		return $this->getStructuredData($data);
	}

	public function getWamPageUrl () {
		try {
			$wikiId = (new WikiaCorporateModel())->getCorporateWikiIdByLang( $this->langCode );
		} catch ( Exception $e ) {
			$wikiId = WikiService::WIKIAGLOBAL_CITY_ID;
		}

		$wamPageConfig = WikiFactory::getVarByName( 'wgWAMPageConfig', $wikiId )->cv_value;
		$pageName = ( !empty( $wamPageConfig['pageName'] ) ) ? $wamPageConfig['pageName'] : 'WAM';

		$url = GlobalTitle::newFromText( $pageName, NS_MAIN, $wikiId )->getFullURL();

		return $url;
	}

	public function getStructuredData($data) {
		$hubModel = $this->getWikiaHubsModel();

		$structuredData = [
			'wamPageUrl' => $this->getWamPageUrl(),
			'verticalName' => $hubModel->getVerticalName($data['vertical_id']),
			'canonicalVerticalName' => str_replace(' ', '', $hubModel->getCanonicalVerticalName($data['vertical_id'])),
			'ranking' => []
		];

		$rank = 1;
		$wamIndex = $data['api_response']['wam_index'];
		foreach($wamIndex as $wiki) {
			$wamScore = $wiki['wam'];
			$wamChange = $wiki['wam_change'];
			$wamPrevScore = $wamScore - $wamChange;

			$structuredData['ranking'][] = [
				'rank' => $rank,
				'wamScore' => round($wamScore, self::WAM_SCORE_DECIMALS),
				'imageUrl' => $wiki['wiki_image'],
				'wikiName' => $wiki['title'],
				'wikiUrl' => $this->addProtocolToLink($wiki['url']),
				'change' => $this->getWamWikiChange($wamScore, $wamPrevScore),
			];
			$rank++;
		}

		return $structuredData;
	}

	protected function getWamWikiChange($wamScore, $wamPrevScore) {
		$result = self::WAM_SCORE_NO_CHANGE;
		$wamScore = round($wamScore, self::WAM_SCORE_DECIMALS);
		$wamPrevScore = round($wamPrevScore, self::WAM_SCORE_DECIMALS);
		$wamChange = $wamScore - $wamPrevScore;

		if( $wamChange > 0 ) {
			$result = self::WAM_SCORE_CHANGE_UP;
		} else if( $wamChange < 0 ) {
			$result = self::WAM_SCORE_CHANGE_DOWN;
		}

		return $result;
	}

	public function getWikiaHubsModel() {
		return new WikiaHubsModel();
	}

	public function render($data) {
		$data['imagesHeight'] = $this->getModel()->getImageHeight();
		$data['imagesWidth'] = $this->getModel()->getImageWidth();
		$data['scoreChangeMap'] = [self::WAM_SCORE_CHANGE_DOWN => 'down', self::WAM_SCORE_NO_CHANGE => 'nochange', self::WAM_SCORE_CHANGE_UP => 'up'];

		return parent::render($data);
	}

	public function getModel() {
		if( !$this->model ) {
			$this->model = new WikiaHubsWAMModel();
		}

		return $this->model;
	}

	/**
	 * Remove non-commercial wikis.
	 * @param $data
	 * @return mixed
	 */
	protected function filterCommercialData( $data ) {
		$service = $this->getLicensedWikisService();
		$data['ranking'] = array_values( array_filter( $data['ranking'], function( $element ) use($service) {
			return $service->isCommercialUseAllowedByUrl($element['wikiUrl']);
		} ) );
		return $data;
	}
}
