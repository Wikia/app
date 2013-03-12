<?php

class MarketingToolboxModuleWAMService extends MarketingToolboxModuleNonEditableService {
	const WAM_SCORE_CHANGE_UP = 1;
	const WAM_SCORE_NO_CHANGE = 0;
	const WAM_SCORE_CHANGE_DOWN = -1;
	const WAM_SCORE_DECIMALS = 2;
	
	/**
	 * @var MarketingToolboxWAMModel
	 */
	protected $model;
	
	const MODULE_ID = 10;
	//TODO: remove const below after WAM page finished
	const WIKIA_HOME_PAGE_WAM_URL = 'http://www.wikia.com/WAM';

	/**
	 * @param Array $params
	 * @return array
	 */
	protected function prepareParameters($params) {
		$params['limit'] = $this->getModel()->getWamLimitForHubPage();
		
		if( empty($params['ts']) ) {
			$params['ts'] = strtotime('00:00 -2 day');
		}

		if( empty($params['ts_previous_day']) ) {
			$params['ts_previous_day'] = strtotime('-1 day', $params['ts']);
		}

		if( empty($params['image_height']) ) {
			$params['image_height'] = $this->getModel()->getImageHeight();
		}

		if( empty($params['image_width']) ) {
			$params['image_width'] = $this->getModel()->getImageWidth();
		}

		return parent::prepareParameters([
			'wam_day' => $params['ts'],
			'wam_previous_day' => $params['ts_previous_day'],
			'vertical_id' => $params['vertical_id'],
			'wiki_lang' => $params['lang'],
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
		$params = $this->prepareParameters($params);
		
		if( !empty($this->app->wg->DevelEnvironment) ) {
			$apiResponse = ['vertical_id' => 2, 'wam_index' => []];
		} else {
			$apiResponse = $this->app->sendRequest('WAMApi', 'getWAMIndex', $params)->getData();
		}

		$data = [
			'vertical_id' => $params['vertical_id'],
			'api_response' => $apiResponse,
		];
		
		return $this->getStructuredData($data);
	}

	public function getStructuredData($data) {
		$hubModel = $this->getWikiaHubsModel();
		
		$structuredData = [
			'wamPageUrl' => self::WIKIA_HOME_PAGE_WAM_URL,
			'verticalName' => $hubModel->getVerticalName($data['vertical_id']),
			'ranking' => []
		];
		
		$rank = 1;
		$wamIndex = $data['api_response']['wam_index'];
		foreach($wamIndex as $wiki) {
			$structuredData['ranking'][] = [
				'rank' => $rank,
				'wamScore' => round($wiki['wam'], self::WAM_SCORE_DECIMALS),
				'imageUrl' => $wiki['wiki_image'],
				'wikiName' => $wiki['title'],
				'wikiUrl' => $this->addProtocolToLink($wiki['url']),
				'change' => $this->getWamWikiChange($wiki['wam_change']),
			];
			$rank++;
		}
		
		return $structuredData;
	}
	
	protected function getWamWikiChange($wamChange) {
		$result = self::WAM_SCORE_NO_CHANGE;
		$floatWamChange = (float) $wamChange;
		
		if( $floatWamChange > 0 ) {
			$result = self::WAM_SCORE_CHANGE_UP;
		} else if( $floatWamChange < 0 ) {
			$result = self::WAM_SCORE_CHANGE_DOWN;
		}
		
		return $result;
	}

	public function getWikiaHubsModel() {
		return new WikiaHubsV2Model();
	}

	public function render($data) {
		$data['imagesHeight'] = $this->getModel()->getImageHeight();
		$data['imagesWidth'] = $this->getModel()->getImageWidth();
		$data['searchHubName'] = $this->getSearchHubName($data['verticalName']);
		$data['scoreChangeMap'] = [self::WAM_SCORE_CHANGE_DOWN => 'down', self::WAM_SCORE_NO_CHANGE => 'nochange', self::WAM_SCORE_CHANGE_UP => 'up'];

		return parent::render($data);
	}
	
	public function getModel() {
		if( !$this->model ) {
			$this->model = new MarketingToolboxWAMModel();
		}
		
		return $this->model;
	}

	/**
	 * @desc Since search works better only for EN hub pages we implemented this simple method
	 * 
	 * @param int|string $vertical vertical name or id
	 * @return string
	 */
	protected function getSearchHubName($vertical) {
		$searchNames = F::app()->wg->WikiaHubsSearchMapping;
		if( !empty($searchNames[$vertical]) ) {
			return $searchNames[$vertical];
		}
		
		return null;
	}
}
