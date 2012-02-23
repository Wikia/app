<?php
/**
 * Michał Roszka (Mix) <michal@wikia-inc.com>
 *
 * Cleans out the User object cache for specified user.
 *
 * Usage:
 *
 * withcity [--usedb=<wikis>] --maintenance-script="wikia/CleanUserObjectCache.php --user=<userId>"
 *
 * <wikis> - a comma-separated list of wiki dbnames to operate on
 * <userId> - the id of a user (as in wikicities.user.user_id)
 *
 * If the --usedb parameters is skipped, the script will be operating on all wikis, which is not recommended.
 */
$dir = realpath( dirname( __DIR__ ) );
include "{$dir}/commandLine.inc";

class CleanUserObjectCache {

public function execute( $iId ) {
	global $wgMemc;
	$sKey = wfMemcKey( 'user', 'id', $iId );
}

}

// the work...

if ( !isset( $options['user'] ) ) {
	exit( 1 );
}

$oObj = new CleanUserObjectCache();
$oObj->execute( $options['user'] );
exit( 0 );
