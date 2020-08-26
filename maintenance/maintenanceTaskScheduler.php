<?php

use Wikia\Tasks\Tasks\MaintenanceTask;
use Wikia\Tasks\Queues\ScheduledMaintenanceQueue;

require_once( dirname( __FILE__ ) . "/Maintenance.php" );

class MaintenanceTaskScheduler extends Maintenance {
	private $wikiIds = [];

	public function __construct() {
		parent::__construct();

		$this->mDescription = "Adds task execution to the queue";
		$this->addArg( "script", "Script that is going to be executed", true );
		$this->addOption( "active", "Run on wikis which are active at least <param> days" );
		$this->addOption( "cluster", "Cluster name, possible values: c1, ..., c7" );
		$this->addOption( "id", "Wiki IDs (separated with comma)" );
		$this->addOption( "params", "Script command line optional parameters" );
	}

	public function execute() {
		global $wgExternalSharedDB;

		$script = $this->getArg( 0 );
		$active = $this->getOption( "active" );
		$cluster = $this->getOption( "cluster" );
		$params = $this->getOption( "params", '' );

		$idsParam = [];
		if ( $this->getOption( "id" ) !== null ) {
			$idsParam = array_map( "intval", str_getcsv( $this->getOption( "id" ), "," ) );
		}

		$this->output( "Scheduling ${script} ${params}\n" );

		$db = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		$this->getWikis( $idsParam, $active, $cluster )
			->runLoop( $db, function ( $data, $row ) {
				$this->wikiIds[] = $row->city_id;
			} );

		$this->scheduleTasks($this->wikiIds, $script, $params);
	}

	private function getWikis( array $idsParam = [], int $active = null, string $cluster = null ) {
		$sql = ( new \WikiaSQL() )
			->SELECT( "city_id" )
			->FROM( "city_list" )
			->WHERE( 'city_public' )->EQUAL_TO( WikiFactory::PUBLIC_WIKI )
			->AND_( 'city_path' )->EQUAL_TO( WikiFactory::SLOT_1 );

		if ( count( $idsParam ) > 0 ) {
			$sql->AND_( "city_id" )
				->IN( $idsParam );
		}

		if ( $active !== null ) {
			$timestampSql = "city_last_timestamp BETWEEN TIMESTAMP( DATE_SUB(CURDATE(), INTERVAL %d DAY) ) AND NOW()";
			$sql->AND_( sprintf( $timestampSql, intval( $active ) ) );
		}

		if ( $cluster !== null ) {
			$sql->AND_( 'city_cluster' )
				->EQUAL_TO( $cluster );
		}

		return $sql;
	}

	/**
	 * @param int[] $wikiIds list of IDs of wikis where the script should be run
	 * @param string $script
	 * @param string $params
	 */
	private function scheduleTasks( array $wikiIds, string $script, string $params ) {
		$task = new MaintenanceTask();
		$task->call( 'run', $script, $params );
		$task
			->setQueue(ScheduledMaintenanceQueue::NAME)
			->wikiId( $wikiIds )
			->queue();

		$this->output( "Scheduled MaintenanceTask queue\n" );
	}
}

$maintClass = "MaintenanceTaskScheduler";

require_once( RUN_MAINTENANCE_IF_MAIN );
