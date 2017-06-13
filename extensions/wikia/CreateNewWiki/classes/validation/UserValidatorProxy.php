<?php
namespace Wikia\CreateNewWiki;

use User;

class UserValidatorProxy {
	public function getWikiCreationsToday( User $user ): int {
		global $wgExternalSharedDB;

		$dbr = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
		$row = $dbr->selectRow(
			"city_list",
			[ "count(*) as count" ],
			[
				'city_founding_user' => $user->getId(),
				"date_format(city_created, '%Y%m%d') = date_format(now(), '%Y%m%d')",
			],
			__METHOD__
		);

		return intval( $row->count );
	}
}
