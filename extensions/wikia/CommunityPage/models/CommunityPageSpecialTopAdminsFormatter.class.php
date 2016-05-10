<?php

class CommunityPageSpecialTopAdminsFormatter {
	const TOP_ADMINS_MODULE_LIMIT = 3;

	/**
	 * Returns array with fields to supply topAdmins.mustache template
	 * If there are more than three admins provided returns first two and the count of remaining ones
	 * @param array $topAdminsDetails
	 * @return array
	 */
	public static function prepareData( array $topAdminsDetails ) {
		$topAdminsCount = count( $topAdminsDetails );
		$otherAdminsCount = self::prepareRemainingCount( $topAdminsCount );
		return [
			'topAdminsList' => self::prepareAdminsToShow( $topAdminsCount, $otherAdminsCount, $topAdminsDetails ),
			'otherAdminsCount' => $otherAdminsCount,
			'haveOtherAdmins' => $otherAdminsCount > 0,
			'allAdminsCount' => $topAdminsCount,
		];
	}

	private function prepareRemainingCount( $topAdminsCount ) {
		return $topAdminsCount > self::TOP_ADMINS_MODULE_LIMIT
			? $topAdminsCount - self::TOP_ADMINS_MODULE_LIMIT + 1
			: 0;
	}

	private function prepareAdminsToShow( $topAdminsCount, $otherAdminsCount, $topAdminsDetails ) {
		return array_slice( $topAdminsDetails, 0, $topAdminsCount - $otherAdminsCount );
	}
}
