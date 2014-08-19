<?php

class EntertainmentDeHubOnlyRssModel extends HubOnlyRssModel {
	const FEED_NAME = 'Entertainment';
	public function getFeedTitle() {
		return 'Wikia Entertainment Feed';
	}

	public static function getFeedLanguage() {
		return 'de';
	}

	public function getFeedDescription() {
		return 'Aus der Community - Entertainment';
	}

	protected function getHubCityIds() {
		return [ 997567, 953627, 953542, 953665 ];
	}


}