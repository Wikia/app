<?php

/**
 * Created by PhpStorm.
 * User: krzychu
 * Date: 29.05.14
 * Time: 09:04
 */
class EntertainmentHubOnlyRssModel extends HubOnlyRssModel {
	const FEED_NAME = 'entertainment';
	const URL_ENDPOINT = '/Entertainment';
	public function getFeedTitle() {
		return 'Wikia Entertainment Feed';
	}

	public function getFeedLanguage() {
		return 'en';
	}

	public function getFeedDescription() {
		return 'From Wikia community - Entertainment';
	}

	protected function getHubCityIds() {
		return [ 952442, 952445, 952443 ];
	}


}