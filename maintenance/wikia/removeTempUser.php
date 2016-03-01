<?php

/**
 * Script that removes old TempUser accounts
 *
 * @see PLATFORM-1146
 * @see CE-1182
 *
 * @author Macbre
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/RemoveUserBase.class.php' );

class RemoveTempUserAccounts extends RemoveUserBase {

	const TEMPUSER_PREFIX = 'TempUser';
	const USER_TABLE = '`user`';

	protected $mDescription = 'This script removes TempUser accounts';

	/**
	 * Get temp user accounts
	 *
	 * - check if these accounts are really temp ones
	 * - do not remove accounts with password set (122 of them)
	 *
	 * @param DatabaseBase $db
	 * @return int[]
	 */
	protected function getAccountsToRemove( DatabaseBase $db ) {
		$res = $db->select(
			self::USER_TABLE,
			[
				'user_id',
				'user_name'
			],
			[
				'user_name ' . $db->buildLike( self::TEMPUSER_PREFIX, $db->anyString() ),
				'user_password' => '',
			],
			__METHOD__
		);

		$users = [];
		while ( $user = $res->fetchObject() ) {
			// check if this is really a temp user: "TempUser" + <user ID>
			if ( $user->user_name === self::TEMPUSER_PREFIX . $user->user_id ) {
				$users[] = intval( $user->user_id );
			}
			else {
				$this->output( sprintf( " > skipped %s (#%d)\n", $user->user_name, $user->user_id ) );
			}
		}

		return $users;
	}
}

$maintClass = "RemoveTempUserAccounts";
require_once( RUN_MAINTENANCE_IF_MAIN );
