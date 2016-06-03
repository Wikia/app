<?php

class CommunityPageSpecialTopAdminsFormatter {
	const TOP_ADMINS_MODULE_LIMIT = 3;
	const TOP_ADMINS_LIST = 'topAdminsList';
	const OTHER_ADMINS_COUNT = 'otherAdminsCount';
	const HAVE_OTHER_ADMINS = 'haveOtherAdmins';
	const ALL_ADMINS_COUNT = 'allAdminsCount';

	/**
	 * Returns array with fields to supply topAdmins.mustache template
	 * If there are more than three admins provided returns first two and the count of remaining ones
	 * @param array $allAdminsList
	 * @return array
	 */
	public static function prepareData( array $allAdminsList ) {
		$allAdminsCount = count( $allAdminsList );
		$otherAdminsCount = self::prepareRemainingCount( $allAdminsCount );
		return [
			self::TOP_ADMINS_LIST => self::prepareAdminsToShow( $allAdminsCount, $otherAdminsCount, $allAdminsList ),
			self::OTHER_ADMINS_COUNT => $otherAdminsCount,
			self::HAVE_OTHER_ADMINS => $otherAdminsCount > 0,
			self::ALL_ADMINS_COUNT => $allAdminsCount,
		];
	}

	private function prepareRemainingCount( $topAdminsCount ) {
		if ( $topAdminsCount > self::TOP_ADMINS_MODULE_LIMIT ) {
			return $topAdminsCount - self::TOP_ADMINS_MODULE_LIMIT + 1;
		}
		return 0;
	}

	private function prepareAdminsToShow( $allCount, $otherCount, array $list ) {
		// JPN-491 Randomize top admins
		shuffle( $list );
		return array_slice( $list, 0, $allCount - $otherCount );
	}
}
