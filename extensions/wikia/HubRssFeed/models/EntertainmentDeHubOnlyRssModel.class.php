<?php

class EntertainmentDeHubOnlyRssModel extends HubOnlyRssModel {
	const FEED_NAME = 'Entertainment';
	const LANGUAGE = 'de';
	public function getFeedTitle() {
		return 'Wikia Entertainment Feed';
	}

	public function getFeedDescription() {
		return 'Aus der Community - Entertainment';
	}

	protected function getHubCityIds() {
		return [ 997567, 953627, 953542, 953665 ];
	}


}