<?php

class StarWarsRssModel extends BaseRssModel {

	const FEED_NAME = "StarWars";
	const MAX_NUM_ITEMS_IN_FEED = 15;
	const LANGUAGE = 'en';

	public function getFeedTitle() {
		return 'Wikia StarWars Feed';
	}

	public function getFeedDescription() {
		return 'From Wikia community - StarWars';
	}

	protected function loadData( $lastTimestamp, $duplicates ) {
		$swProvider = new StarWarsDataProvider();
		$swData = $swProvider->getData( $lastTimestamp );
		$swData = $this->removeDuplicates( $swData, $duplicates );
		$out = $this->finalizeRecords( $swData );
		return $out;
	}

	protected function finalizeRecords( $swData ) {
		$out = [ ];
		foreach ( $swData as $item ) {
			$out[ $item[ 'url' ] ] = $item;
		}
		$out = $this->fixDuplicatedTimestamps( $out );
		$out = $this->addFeedsToDb( $out, self::getFeedName()  );
		return $out;
	}

	protected function formatTitle( $item ) {
		return $item;
	}
}