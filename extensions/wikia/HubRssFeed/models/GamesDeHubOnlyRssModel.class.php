<?php

class GamesDeHubOnlyRssModel extends HubOnlyRssModel {
	const FEED_NAME = 'Games';

	public function getFeedTitle() {
		return 'Wikia Videospiele Feed';
	}

	public static function getFeedLanguage() {
		return 'de';
	}

	public function getFeedDescription() {
		return 'Aus der Community - Videospiele';
	}

	protected function getHubCityIds() {
		return [ 952341 ];
	}
}