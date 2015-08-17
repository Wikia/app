<?php

/**
 * Maintenance script to clear the notification tables:
 *    - remove old notifications from database and user's cache (older that \WallHelper::$NOTIFICATION_EXPIRE_DAYS days)
 *    - remove queued notifications older than \WallHelper::$NOTIFICATION_EXPIRE_DAYS days
 *    - remove processed notifications older than \WallHelper::$NOTIFICATION_EXPIRE_DAYS days
 *
 * @author Evgeniy
 */

const RESULT_OK = 0;
const RESULT_READ_ONLY = 1;

ini_set( 'include_path', dirname( __FILE__ ) . '/../../../maintenance/' );

require_once( 'commandLine.inc' );

if ( isset( $options['help'] ) ) {
	die( "Usage: php maintenance.php [--only-cache] [--help]
	--only-cache		clear users' cache only
	--help			this message\n\n" );
}

if ( wfReadOnly() ) {
	echo( 'Error: In read only mode.' );
	exit( RESULT_READ_ONLY );
}

$onlyCache = isset( $options['only-cache'] );

$wallNotification = new WallNotificationsEveryone();
$wallNotification->clearQueue( $onlyCache );
exit( RESULT_OK );
