<?php

/**
 * Created by PhpStorm.
 * User: krzychu
 * Date: 29.05.14
 * Time: 09:04
 */
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