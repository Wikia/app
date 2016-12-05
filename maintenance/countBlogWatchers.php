<?php
require_once __DIR__ . '/Maintenance.php';

class CountBlogWatchers extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->addOption( 'blog', 'The blog watchlist to recount', true, true );
		$this->mDescription = 'Count all real subscribers to the watchlist of a seelected blog';
	}

	public function execute() {
		if ( !$this->hasOption( 'blog' ) ) {
			$this->error( 'A blog is required' );
		}

		$blog = $this->getOption( 'blog' );

		$dbWikia = wfGetDB( DB_SLAVE, [], 'wikia' );
		$dbWikicities = wfGetDB( DB_SLAVE, [], 'wikicities' );
		$dbUserPreferences = wfGetDB( DB_SLAVE, [], 'user_preferences' );

		// take all user ids from watchlist
		$watchlistSQL = '
			SELECT DISTINCT(wl_user) user_id
			FROM watchlist 
			WHERE 
				wl_title LIKE "' . trim( $blog ) . '"
			AND wl_namespace = 502;
		';

		$res = $dbWikia->query( $watchlistSQL, 'CountBlogWatchers::execute' );
		$userIds = [];
		while ( $userId = $dbWikia->fetchObject( $res ) ) {
			$userIds[] = $userId->user_id;
		}
		echo sprintf( "Users on the watchlist: %s\n", number_format( sizeOf( $userIds ) ) );

		// ensure those users are authenticated
		$userSQL = '
			SELECT user_id
			FROM user
			WHERE 
				user_email_authenticated IS NOT NULL 
			AND user_email_authenticated <> ""
			AND user_id IN (' . implode( ',', $userIds ) . ')
		';

		$res = $dbWikicities->query( $userSQL, 'CountBlogWatchers::execute' );
		$userIds = [];
		while ( $userId = $dbWikicities->fetchObject( $res ) ) {
			$userIds[] = $userId->user_id;
		}
		echo sprintf( "Users, confirmed E-Mail: %s\n", number_format( sizeOf( $userIds ) ) );

		// ensure those confirmed users wish to receive emails
		$permissionsSQL = '
			SELECT user_id
			FROM global_preference
			WHERE 
			   user_id IN (' . implode( ',', $userIds ) . ')
			AND
			   (
			         CONCAT(preference_name, preference_value) LIKE "disablemail0"
			      OR CONCAT(preference_name, preference_value) LIKE "disablemail"
			      OR CONCAT(preference_name, preference_value) LIKE "marketingallowed1"
			   )
		';

		$res = $dbUserPreferences->query( $permissionsSQL, 'CountBlogWatchers::execute' );
		$userIds = [];
		while ( $userId = $dbUserPreferences->fetchObject( $res ) ) {
			$userIds[] = $userId->user_id;
		}

		echo sprintf( "Users, confirmed E-Mail, disablemail=0, marketingallowed=1: %s\n", number_format( sizeOf( $userIds ) ) );
	}
}


$maintClass = 'CountBlogWatchers';
require_once( RUN_MAINTENANCE_IF_MAIN );
