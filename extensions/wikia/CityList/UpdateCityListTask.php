<?php

use Wikia\Tasks\Tasks\BaseTask;

class UpdateCityListTask extends BaseTask {
	private $sharedDatabaseMaster;

	/**
	 * @param string $timestamp MW timestamp of current time
	 */
	public function updateLastTimestamp( string $timestamp ) {
		$dbw = $this->getSharedDatabaseMaster();

		$dbw->update(
			'city_list',
			[ 'city_last_timestamp' => $timestamp ],
			[ 'city_id' => $this->getWikiId() ],
			__METHOD__
		);
	}

	private function getSharedDatabaseMaster() {
		if ( !$this->sharedDatabaseMaster ) {
			global $wgExternalSharedDB;
			$this->sharedDatabaseMaster = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );
		}

		return $this->sharedDatabaseMaster;
	}
}
