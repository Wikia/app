<?php

class GamesDeHubOnlyRssModel extends HubOnlyRssModel {
	const FEED_NAME = 'Games';
	const LANGUAGE = 'de';
	public function getFeedTitle() {
		return 'Wikia Videospiele Feed';
	}

	public function getFeedDescription() {
		return 'Aus der Community - Videospiele';
	}

	protected function getHubCityIds() {
		return [ 952341 ];
	}
}