<?php

class CommunityPageSpecialTopAdminsFormatter {
	const TOP_ADMINS_MODULE_LIMIT = 2;
	const TOP_ADMINS_LIST = 'topAdminsList';
	const HAVE_OTHER_ADMINS = 'haveOtherAdmins';
	const ALL_ADMINS_COUNT = 'allAdminsCount';

	/**
	 * Returns array with fields to supply topAdmins.mustache template
	 * @param array $allAdminsList
	 * @return array
	 */
	public static function prepareData( array $allAdminsList ) {
		$allAdminsCount = count( $allAdminsList );

		return [
			static::TOP_ADMINS_LIST => array_slice( $allAdminsList, 0, static::TOP_ADMINS_MODULE_LIMIT ),
			static::HAVE_OTHER_ADMINS => $allAdminsCount > static::TOP_ADMINS_MODULE_LIMIT,
			static::ALL_ADMINS_COUNT => $allAdminsCount
		];
	}
}
