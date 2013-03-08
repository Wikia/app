<?php

class MarketingToolboxModuleWAMService extends MarketingToolboxModuleNonEditableService {
	const MODULE_ID = 10;
	//TODO: remove const below after WAM page finished
	const WIKIA_HOME_PAGE_WAM_URL = 'http://www.wikia.com/WAM';

	public function getDataParameters($langCode, $verticalId, $limit, $hubTimestamp) {
		//TODO: add wam_previous_day
		if(empty($hubTimestamp)) {
			$hubTimestamp = strtotime('00:00 -2 day');
		}

		return array(
			'wam_day' => $hubTimestamp,
			'wam_previous_day' => strtotime('-1 day', $hubTimestamp),
			'vertical_id' => $verticalId,
			'wiki_lang' => $langCode,
			'fetch_admins' => true,
			'fetch_wiki_images' => true,
			'limit' => $limit,
			'sort_column' => 'wam_index',
			'sort_direction' => 'DESC'
		);
	}

	public function getModuleData($params) {
		// Temporary data
		$data = new stdClass();

		$url  = 'http://sandbox-s4.www.wikia.com/wikia.php?controller=WAMApi&method=getWAMIndex&';
		$url .= http_build_query($params);
		
		if( $apiData = file_get_contents($url) ) {
			$data = [
				'vertical_id' => $params['vertical_id'],
				'api_response' => json_decode($apiData, true),
			];
		}
		
		return $data;
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
		foreach($wamIndex as $i => $wiki) {
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

	public function render($structuredData) {
		//MOCKED DATA remove after FB#98999 is done
		$data = array(
			'wamPageUrl' => 'http://www.wikia.com/WAM',
			'verticalName' => 'Video Games',
			'ranking' => array(
				array(
					'rank' => '111',
					'wamScore' => '222',
					'imageUrl' => '333',
					'imageWidth' => '25',
					'imageHeight' => '25',
					'wikiName' => '444',
					'wikiUrl' => '555',
					'change' => '1'
				),
			),
		);
		//END OF MOCKED DATA
		
		return parent::render($data);
	}
}
