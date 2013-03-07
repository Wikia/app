<?php

class MarketingToolboxModuleWAMService extends MarketingToolboxModuleNonEditableService
{
	const MODULE_ID = 10;

	public function getStructuredData($data) {
		$structuredData = [];

		/*
		$wamIndex = $this->app->sendRequest('WAMApiController', 'getWAMIndex', array(
			'wam_day' => $wamDay,
			'wam_previous_day' => $wamPrevDay,
			'vertical_id' => $verticalId,
			'wiki_lang' => $lang,
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
