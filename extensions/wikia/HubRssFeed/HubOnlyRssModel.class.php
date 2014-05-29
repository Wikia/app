<?php
/**
 * Created by PhpStorm.
 * User: krzychu
 * Date: 29.05.14
 * Time: 08:54
 */

abstract class HubOnlyRssModel extends BaseRssModel {

	const MAX_NUM_ITEMS_IN_FEED = 15;

	public function getFeedData() {

		$feedRealName = 'hub_'.static::FEED_NAME;

		if ( $this->forceRegenerateFeed == false ) {
			if ( $this->isFreshContentInDb( $feedRealName  ) ) {
				return $this->getLastRecordsFromDb($feedRealName, self::MAX_NUM_ITEMS_IN_FEED );
			}
		}

		$duplicates = $this->getLastDuplicatesFromDb( $feedRealName );
		$timestamp =  $this->getLastFeedTimestamp( $feedRealName ) + 1;
		$rawData = [];
		foreach($this->getHubCityIds() as $hubCityId )
		{
			$rawData = array_merge( $rawData, $this->getDataFromHubs($hubCityId, $timestamp, $duplicates ) );
		}

		$out = $this->finalizeRecords( $rawData, self::MAX_NUM_ITEMS_IN_FEED , $feedRealName );
		return $out;
	}

	protected function formatTitle( $item ) {
		return $item;
	}

	protected abstract function getHubCityIds();
} 