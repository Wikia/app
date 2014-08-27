<?php

class EntertainmentHubOnlyRssModel extends HubOnlyRssModel {
	const FEED_NAME = 'Entertainment';
	const LANGUAGE = 'en';
	public function getFeedTitle() {
		return 'Wikia Entertainment Feed';
	}

	public function getFeedDescription() {
		return 'From Wikia community - Entertainment';
	}

	protected function getHubCityIds() {
		return [ 952442, 952445, 952443 ];
	}


}