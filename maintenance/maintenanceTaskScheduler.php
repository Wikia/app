<?php

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
	}

	public function execute() {
		global $wgExternalSharedDB;

		$script = $this->getArg( 0 );
		$active = $this->getOption( "active" );
		$cluster = $this->getOption( "cluster" );

		$idsParam = [];
		if ( $this->getOption( "id" ) !== null ) {
			$idsParam = array_map( "intval", str_getcsv( $this->getOption( "id" ), "," ) );
		}

		$this->output( "Scheduling ${script}\n" );

		$db = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		// TODO: Handle 300k wikis
		$this->getWikis( $idsParam, $active, $cluster )
			->runLoop( $db, function ( $data, $row ) {
				$wikiIds[] = $row->city_id;
			} );

		$this->scheduleTask($this->wikiIds, $script);
	}

	private function getWikis( array $idsParam = [], int $active = null, string $cluster = null ) {
		$sql = ( new \WikiaSQL() )
			->SELECT( "city_id" )
			->FROM( "city_list" )
			->WHERE("city_public")->EQUAL_TO(WikiFactory::PUBLIC_WIKI);

		if ( count( $idsParam ) > 0 ) {
			$sql->WHERE( "city_id" )
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

	private function scheduleTask( array $wikiIds, string $script ) {
		$task = new \Wikia\Tasks\Tasks\MaintenanceTask();
		$task->wikiId( $wikiIds );
		$task->call( "run", $script, $this->mOptions, $this->mArgs );

		$task->queue();

		$this->output( "Scheduled MaintenanceTask queue\n" );
	}
}

$maintClass = "MaintenanceTaskScheduler";

require_once( RUN_MAINTENANCE_IF_MAIN );
