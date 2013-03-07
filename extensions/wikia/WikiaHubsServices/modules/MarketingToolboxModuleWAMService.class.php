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

	public function getStructuredData($data) {
		$structuredData = [];
/*
		$wamIndex = $this->app->sendRequest('WAMApiController', 'getWAMIndex', array(
			'wam_day' => $wamDay,
			'wam_previous_day' => $wamPrevDay,
			'vertical_id' => $this->verticalId,
			'wiki_lang' => $this->langCode,
			'fetch_admins' => true,
			'fetch_wiki_images' => true,
			'limit' => $limit,
			'sort_column' => 'wam_index',
			'sort_direction' => 'DESC'
		))->getData();*/

		return $data;
	}


	public function render($structuredData) {
		//MOCKED DATA remove after FB#98999 is done
		$data = array(
			'wamPageUrl' => 'http://www.wikia.com/WAM',
			'verticalName' => 'Video Games',
			'ranking' => array(
				/*
				array(
					'rank' => '',
					'wamScore' => '',
					'imageUrl' => '',
					'imageWidth' => '',
					'imageHeight' => '',
					'wikiName' => '',
					'wikiUrl' => '',
				),
				*/
			),
		);
		//END OF MOCKED DATA
		
		return parent::render($data);
	}
}
