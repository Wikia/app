<?php

class LifestyleHubOnlyRssModel extends HubOnlyRssModel {
	const FEED_NAME = 'Lifestyle';
	const LANGUAGE = 'en';

	public function getFeedTitle() {
		return 'Wikia Lifestyle Feed';
	}

	public function getFeedDescription() {
		return 'From Wikia community - Lifestyle';
	}

	protected function getHubCityIds() {
		return [ 952281 ];
	}
}