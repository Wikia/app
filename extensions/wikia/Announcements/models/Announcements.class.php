<?php

class Announcements {

	/**
	 * @desc Get users who edited or contributed on specific wiki in specific amount of time
	 *
	 * @param $wikiId
	 * @param $period
	 *
	 * @return mixed
	 */
	public function getActiveUsers( int $wikiId, int $period ) {
		global $wgSpecialsDB;

		$specialsDb = wfGetDB( DB_SLAVE, [], $wgSpecialsDB );

		return $specialsDb->selectFieldValues(
			'events_local_users',
			'user_id',
			[
				'wiki_id' => $wikiId,
				'editdate > NOW() - INTERVAL ' . $period . ' DAY',
			],
			__METHOD__
		);
	}
}
