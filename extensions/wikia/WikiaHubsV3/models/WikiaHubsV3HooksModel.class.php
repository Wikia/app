<?php

	/**
	 * Hubs V3 Hook Model
	 *
	 * @author Damian Jóźwiak
	 *
	 */

class WikiaHubsV3HooksModel extends WikiaModel {
	/**
	 * Uses flipped $wgWikiaHubsPages array to return comscore id of a hub page
	 *
	 * @param String $dbKeyName
	 * @return bool
	 */
	public function getHubPageId($dbKeyName) {
		//TODO: Change to one vertical per page
		$verticals = array_flip($this->app->wg->WikiaHubsV2Pages);
		if( isset($verticals[$dbKeyName]) ) {
			return $verticals[$dbKeyName];
		}

		return false;
	}

	/**
	 * Get timestamp from split dbKey
	 *
	 * @param array $dbKeyNameSplit
	 *
	 * @return int|null
	 */
	public function getTimestampFromSplitDbKey($dbKeyNameSplit) {
		if (isset($dbKeyNameSplit[1])) {
			unset($dbKeyNameSplit[0]);
			$hubDate = implode('/', $dbKeyNameSplit);
			$hubDate = str_replace('_', '-', $hubDate);
			$hubTimestamp = $this->getTimestampFromUserDate($hubDate);
		} else {
			$hubTimestamp = null;
		}
		return $hubTimestamp;
	}

	/**
	 * Get timestamp from date
	 *
	 * @param $date
	 *
	 * @return int
	 */
	protected function getTimestampFromUserDate($date) {
		return strtotime($date);
	}

	/**
	 * Get canonical url form Hub (remove date at the end of url)
	 *
	 * @param string $hubName
	 * @param string $url
	 *
	 * @return string
	 */
	public function getCanonicalHrefForHub($hubName, $url) {
		return mb_substr($url, 0, mb_strpos($url, $hubName) + mb_strlen($hubName));
	}
}
