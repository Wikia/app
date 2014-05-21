<?php
/**
 * Created by PhpStorm.
 * User: krzychu
 * Date: 21.05.14
 * Time: 15:44
 */

class TvRssModel extends BaseRssModel {
	const FEED_NAME = 'tv';
	public function getFeedTitle() {
		return 'Wikia Tv Shows';
	}

	public function getFeedLanguage() {
		return 'en';
	}

	public function getFeedDescription() {
		return 'Wikia Tv Shows';
	}

	public function getFeedData() {

		if ($this->isFreshContentInDb(self::FEED_NAME)){
			return $this->getLastRecoredsFromDb(self::FEED_NAME);
		}
		return [];
	}
}