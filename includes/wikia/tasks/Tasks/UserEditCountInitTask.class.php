<?php
namespace Wikia\Tasks\Tasks;

/**
 * Class UserEditCountInitTask initializes the user_editcount field for user in shared table.
 * @package Wikia\Tasks\Tasks
 */
class UserEditCountInitTask extends BaseTask {
	/**
	 * Initialize user_editcount field for the given user on wikicities table
	 *
	 * @param int $userId
	 * @param int $editCount
	 */
	public function initEditCount( int $userId, int $editCount ) {
		global $wgExternalSharedDB;

		$wikiCitiesDb = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );

		$wikiCitiesDb->update(
			'`user`',
				[ 'user_editcount' => $editCount ],
				[
					'user_id' => $userId,
					'user_editcount IS NULL',
				],
				__METHOD__
		);
	}
}
