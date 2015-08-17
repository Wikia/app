<?php

/**
 * Script that removes fake users created during RenameUser process
 *
 * @see PLATFORM-1318
 * @see uncycloUsersMigrator.php
 *
 * @author Macbre
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/RemoveUserBase.class.php' );

class RemoveRenamedAccounts extends RemoveUserBase {

	const RENAMEDUSER_PROPERTY_PREFIX = 'renamed_to=W-';
	const USER_PROPERTIES_TABLE = '`user_properties`';

	protected $mDescription = 'This script removes fake user accounts created by RenameUser process';

	/**
	 * RenameUser process marks fake user accounts in user_properties table:
	 *
	 * select up_user, up_value from user_properties where  up_property = 'renameData' and up_value LIKE 'renamed_to=W-%' limit 15;
	 *
	 * @see https://github.com/Wikia/app/commit/14238c4bdace691da929b46a55012f152ac815fa
	 *
	 * @param DatabaseBase $db
	 * @return int[]
	 */
	protected function getAccountsToRemove( DatabaseBase $db ) {
		$users = $db->selectFieldValues(
			self::USER_PROPERTIES_TABLE,
			'up_user',
			[
				'up_property' => 'renameData',
				'up_value ' . $db->buildLike( self::RENAMEDUSER_PROPERTY_PREFIX, $db->anyString() ),
			],
			__METHOD__
		);

		return $users;
	}
}

$maintClass = "RemoveRenamedAccounts";
require_once( RUN_MAINTENANCE_IF_MAIN );
