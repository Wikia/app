<?php

class StarWarsRssModel extends BaseRssModel {

	const FEED_NAME = "StarWars";

	public function getFeedTitle() {
		return 'Wikia StarWars Feed';
	}

	public function getFeedLanguage() {
		return 'en';
	}

	public function getFeedDescription() {
		return 'From Wikia community - StarWars';
	}

	protected function loadData( $lastTimestamp, $duplicates ) {
		$swProvider = new StarWarsDataProvider();
		$swData = $swProvider->getData( $lastTimestamp );
		$swData = $this->removeDuplicates( $swData, $duplicates );

		$out = $this->finalizeRecords($swData, self::FEED_NAME );
		return $out;
	}

	protected function formatTitle( $item ) {
		return $item;
	}
}