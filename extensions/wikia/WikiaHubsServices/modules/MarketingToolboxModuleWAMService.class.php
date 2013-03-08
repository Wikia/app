<?php

class MarketingToolboxModuleWAMService extends MarketingToolboxModuleNonEditableService
{
	const MODULE_ID = 10;

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
			$data = json_decode($apiData);
		}
		
		return $data;
		//return $this->app->sendRequest('WAMApiController', 'getWAMIndex', $params)->getData();
	}

	public function getStructuredData($data) {
		$structuredData = [];

		return $data;
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
