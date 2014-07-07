<?php

class LifestyleHubOnlyRssModel extends HubOnlyRssModel {
	const FEED_NAME = 'lifestyle';
	const URL_ENDPOINT = '/Lifestyle';

	public function getFeedTitle() {
		return 'Wikia Lifestyle Feed';
	}

	public function getFeedLanguage() {
		return 'en';
	}

	public function getFeedDescription() {
		return 'From Wikia community - Lifestyle';
	}

	protected function getHubCityIds() {
		return [ 952281 ];
	}
}