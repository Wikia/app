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

	/**
	 * Mark the wiki unavailable for adoption if it was up for adoption,
	 * and the user who made an action was an admin or there were more than 1,000 edits made on wiki.
	 * @param int $userId
	 */
	public function checkIfWikiIsStillAdoptable( int $userId ) {
		$cityId = $this->getWikiId();
		$wiki = WikiFactory::getWikiByID( $cityId );

		if ( !$wiki || !( $wiki->city_flags & WikiFactory::FLAG_ADOPTABLE ) ) {
			return;
		}

		$user = User::newFromId( $userId );

		if ( in_array( 'sysop', $user->getGroups() ) || SiteStats::edits() >= 1000 ) {
			$dbw = $this->getSharedDatabaseMaster();
			$flags = $wiki->city_flags &~ WikiFactory::FLAG_ADOPTABLE;

			$dbw->update(
				'city_list',
				[ 'city_flags' => $flags ],
				[ 'city_id' => $cityId ],
				__METHOD__
			);
		}
	}

	private function getSharedDatabaseMaster() {
		if ( !$this->sharedDatabaseMaster ) {
			global $wgExternalSharedDB;
			$this->sharedDatabaseMaster = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );
		}

		return $this->sharedDatabaseMaster;
	}
}
