<?php

class LifestyleHubOnlyRssModel extends HubOnlyRssModel {
	const FEED_NAME = 'Lifestyle';

	public function getFeedTitle() {
		return 'Wikia Lifestyle Feed';
	}

	public static function getFeedLanguage() {
		return 'en';
	}

	public function getFeedDescription() {
		return 'From Wikia community - Lifestyle';
	}

	protected function getHubCityIds() {
		return [ 952281 ];
	}
}