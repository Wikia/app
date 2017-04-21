<?php
/**
 * @ingroup Maintenance
 */

// Eliminate the need to set this on the command line
if ( !getenv( 'SERVER_ID' ) ) {
	putenv( "SERVER_ID=177" );
}

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

class UserIter extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = "User Iter";
	}

	public function execute() {
		$dbh = wfGetDB( DB_SLAVE, null, F::app()->wg->ExternalSharedDB );
		$sql = ( new WikiaSQL() )
			->select( 'user_name' )
			->from( 'user' );

		$iter = ( new WikiaSQLIterator( $dbh, $sql ) )
			->startAt( 10 )
			->resultLimit( 100 );

		$stopAt = 30;

		while ( $row = $iter->next() ) {
			echo '>> '.$iter->currentRecordNum() . ' : ' . $row->user_name . "\n";

			if ( $iter->currentRecordNum() >= $stopAt ) {
				break;
			}
		}

		return;
	}
}

$maintClass = "UserIter";
require_once( RUN_MAINTENANCE_IF_MAIN );
