<?php
class MarketingToolboxModuleWikiastatsService extends MarketingToolboxModuleNonEditableService {

	const MODULE_ID = 11;

	protected function loadStructuredData($model, $params) {
		return $this->getStructuredData($params);
	}

	public function getStructuredData($data) {
		return $this->app->sendRequest('WikiaStatsController', 'getWikiaStats')->getData();
	}
}

