<?php

	/**
	 * Hubs V3 Hook Model
	 *
	 * @author Damian Jóźwiak
	 *
	 */

class WikiaHubsV3HooksModel extends WikiaModel {
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
}
