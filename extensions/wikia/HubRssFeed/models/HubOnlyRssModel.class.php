<?php

abstract class HubOnlyRssModel extends BaseRssModel {

	const MAX_NUM_ITEMS_IN_FEED = 15;

	protected function loadData( $lastTimestamp, $duplicates ) {

		$rawData = [ ];
		foreach ( $this->getHubCityIds() as $hubCityId ) {
			$rawData = array_merge( $rawData, $this->getDataFromHubs( $hubCityId, $lastTimestamp, $duplicates ) );
		}

		$out = $this->finalizeRecords( $rawData, static::FEED_NAME );
		return $out;
	}

	protected function formatTitle( $item ) {
		return $item;
	}

	protected abstract function getHubCityIds();
} 