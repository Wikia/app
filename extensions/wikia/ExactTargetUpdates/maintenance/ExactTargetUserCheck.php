<?php
/**
 * Returns user and user_properties data from ExactTarget for provided user ID
 *
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * @author Kamil Koterba <kamil@wikia-inc.com>
 *
 */

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class ExactTargetUserCheck extends Maintenance {

	public function __construct() {
		$this->addOption( 'user_id', 'User id to check data for.' );
		$this->addDescription( 'Returns user and user_properties data from ExactTarget for provided user ID.' );
		parent::__construct();
	}

	/**
	 * Maintenance script entry point.
	 * Gathering user edits data from last day and adding update task to job queue.
	 */
	public function execute() {
		$userId = $this->getOption( 'user_id' );
		print_r( "ExactTarget data for user ID: $userId\n\n" );
		print_r( "=User=\n" );
		print_r( ( new \Wikia\ExactTarget\ExactTargetClient() )->retrieveUser( $userId ) );
		print_r( "\n\n" );

		print_r( "=User properties=\n" );
		print_r( ( new \Wikia\ExactTarget\ExactTargetClient() )->retrieveUserProperties( $userId ) );
		print_r( "\n\n" );

		print_r( "=User groups=\n" );
		print_r( ( new \Wikia\ExactTarget\ExactTargetClient() )->retrieveUserGroups( $userId ) );
		print_r( "\n\n" );

		print_r( "=Subscriber=\n" );
		print_r( ( new \Wikia\ExactTarget\ExactTargetClient() )->retrieveEmailByUserId( $userId ) );
		print_r( "\n\n" );
	}

}

$maintClass = "ExactTargetUserCheck";
require_once( RUN_MAINTENANCE_IF_MAIN );
