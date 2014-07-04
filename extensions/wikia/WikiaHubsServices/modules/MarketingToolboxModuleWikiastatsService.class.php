<?php
class MarketingToolboxModuleWikiastatsService extends MarketingToolboxModuleNonEditableService {

	const MODULE_ID = 11;

	public function getStructuredData($data) {
		$structuredData = $this->app->sendRequest('WikiaStatsController', 'getWikiaStats')->getData();
		foreach ($data as $key => $value) {
			$this->$key = $value;
		}
		return $structuredData;
	}
}
