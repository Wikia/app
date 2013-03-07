<?php

class MarketingToolboxModuleWAMService extends MarketingToolboxModuleNonEditableService
{
	const MODULE_ID = 10;

	public function getWamData($wamDay, $wamPrevDay, $verticalId, $lang, $limit) {
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

		//test data
		$data['headline'] = 'New headline';
		$data['text'] = 'test text';

		return $data;
	}

	public function render($structuredData) {

		$data['headline'] = $structuredData['headline'];
		$data['textTest'] = $structuredData['text'];

		return parent::render($data);
	}

	public function getStructuredData($data) {
		$structuredData = [];

		//return $structuredData;
		return $data;
	}
}
