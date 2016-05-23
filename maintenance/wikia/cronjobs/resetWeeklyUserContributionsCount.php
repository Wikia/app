<?php

use \Wikia\Logger\WikiaLogger;

/**
 * On Special:Community we have weekly users rank with most contributions.
 * We need to reset it after every Sunday
 */

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

/**
 * Class resetWeeklyUserContributionsCount
 */
class resetWeeklyUserContributionsCount extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'reset weekly user contributions count';
	}

	public function execute() {
		$dbw = wfGetDB( DB_MASTER );

		$result = ( new WikiaSQL() )
			->DELETE( 'wikia_user_properties' )
			->WHERE( 'wup_property' )->EQUAL_TO( 'editcountThisWeek' )
			->run( $dbw );

		if ( $result === false ) {
			WikiaLogger::instance()->error( 'Reset Weekly Contributions Count' );
		}
	}
}

$maintClass = 'resetWeeklyUserContributionsCount';
require_once( RUN_MAINTENANCE_IF_MAIN );
