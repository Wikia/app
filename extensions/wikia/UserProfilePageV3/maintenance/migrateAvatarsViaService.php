<?php

/**
 * Script migrates the user avatars from DFS to user avatars service
 *
 * @see PLATFORM-1419
 *
 * @author Macbre
 * @ingroup Maintenance
 */

putenv( 'SERVER_ID=117' ); // run in the context of a community wiki

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

/**
 * Maintenance script class
 */
class AvatarsMigrator extends Maintenance {

	public function execute() {
		$this->output( "Getting the list of all accounts with avatar set..." );
	}

	/**
	 * Return true if a given URL is the default one
	 *
	 * Can be either:
	 *
	 *  - an exmpty string
	 *  - http://vignette4.wikia.nocookie.net/messaging/images/1/19/Avatar.jpg/revision/latest/scale-to-width/150?format=jpg
	 *  - http://images3.wikia.nocookie.net/__cb2/messaging/images/thumb/1/19/Avatar.jpg/150px-Avatar.jpg
	 *  - Avatar.jpg
	 *
	 * @param $url
	 * @returm boolean
	 */
	public static function isDefaultAvatar( $url ) {
		return ( $url === '' ) || ( strpos( $url, 'Avatar.jpg' ) !== false );
	}

	/**
	 * Is a given URL set for a new avatar (i.e. uploaded via avatars service)
	 *
	 * @param $url
	 * @return boolean
	 */
	public static function isNewAvatar( $url ) {
		return !self::isDefaultAvatar( $url ) && startsWith( $url, 'http://' );
	}
}

$maintClass = AvatarsMigrator::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
