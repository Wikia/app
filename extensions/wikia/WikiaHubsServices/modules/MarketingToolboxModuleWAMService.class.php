<?php

class MarketingToolboxModuleWAMService extends MarketingToolboxModuleNonEditableService {
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
		
		//TODO: add wam_previous_day
		if( empty($params['ts']) ) {
			$params['ts'] = strtotime('00:00 -2 day');
		}
		
		return parent::prepareParameters([
			'wam_day' => $params['ts'],
			'wam_previous_day' => strtotime('-1 day', $params['ts']),
			'vertical_id' => $params['vertical_id'],
			'wiki_lang' => $params['lang'],
			'fetch_admins' => true,
			'fetch_wiki_images' => true,
			'limit' => $params['limit'],
			'sort_column' => 'wam_index',
			'sort_direction' => 'DESC'
		]);
	}

	public function loadData($model, $params) {
		$params = $this->prepareParameters($params);
		$url  = 'http://sandbox-s4.www.wikia.com/wikia.php?controller=WAMApi&method=getWAMIndex&';
		$url .= http_build_query($params);
		
		if( $apiData = file_get_contents($url) ) {
			$data = [
				'vertical_id' => $params['vertical_id'],
				'api_response' => json_decode($apiData, true),
			];
		}
		
		return $this->getStructuredData($data);
		//return $this->app->sendRequest('WAMApiController', 'getWAMIndex', $params)->getData();
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
				'wamScore' => $wiki['wam'],
				'imageUrl' => $wiki['wiki_image'],
				'wikiName' => $wiki['title'],
				'wikiUrl' => $wiki['url'],
				'change' => $this->getWamWikiChange($wiki['wam_change']),
			];
			$rank++;
		}
		
		return $structuredData;
	}
	
	protected function getWamWikiChange($wamChange) {
		$result = 0;
		$floatWamChange = (float) $wamChange;
		
		if( $floatWamChange > 0 ) {
			$result = 1;
		} else if( $floatWamChange < 0 ) {
			$result = -1;
		}
		
		return $result;
	}

	public function getWikiaHubsModel() {
		return new WikiaHubsV2Model();
	}

	public function render($data) {
		return parent::render($data);
	}
	
	public function getModel() {
		if( !$this->model ) {
			$this->model = new MarketingToolboxWAMModel();
		}
		
		return $this->model;
	}
}
