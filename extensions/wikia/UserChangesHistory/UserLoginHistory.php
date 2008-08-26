<?php

/**
 * Register when & where user is logged in
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia.com>
 */

/**
CREATE TABLE `user_login_history` (
  `user_id` int(5) unsigned NOT NULL,
  `city_id` int(9) unsigned default '0',
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `login_from` varchar(10) NOT NULL default 'auto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8
**/


$wgHooks[ "UserLoginComplete" ][ ] = array( "wfUserLoginHistoryInsert", "form" );
$wgHooks[ "UserLoadFromSession" ][ ] = array( "wfUserLoginHistoryInsert", "auto" );

function wfUserLoginHistoryInsert( $from, $User ) {
	global $wgCityId;

	wfProfileIn( __METHOD__ );

	/**
	 * if user id is empty it means that user object is not loaded
	 * store information only for registered users
	 */
	$user_id = $User->getId();
	if ( $user_id ) {

		error_log( __METHOD__ .": $from $wgCityId" );
		error_log( print_r( $User, 1 ) );
		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert(
			wfSharedTable( "user_login_history" ),
			array(
				"user_id" => $user_id,
				"city_id" => $wgCityId,
				"login_from" => $from
			),
			__METHOD__
		);
	}

	wfProfileOut( __METHOD__ );

	return true;
}
