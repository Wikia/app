<?php

require_once( dirname( __FILE__ ) . "/Maintenance.php" );

class MaintenanceTaskScheduler extends Maintenance {
	public function __construct() {
		parent::__construct();

		$this->mDescription = "Adds task execution to the queue";
		$this->addArg( "script", "Script that is going to be executed", true );
		$this->addOption( "active", "Run on wikis which are active at least <param> days" );
		$this->addOption( "id", "Wiki IDs (separated with comma)" );
	}

	public function execute() {
		global $wgExternalSharedDB;

		$script = $this->getArg( 0 );
		$active = $this->getOption( "active" );

		$idsParam = [];
		if ( $this->getOption( "id" ) !== null ) {
			$idsParam = array_map( "intval", explode( ",", $this->getOption( "id" ) ) );
		}

		$this->output( "Scheduling ${script}\n" );

		$db = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		// TODO: Handle 300k wikis
		$this->getWikis( $idsParam, $active )
			->runLoop( $db, function ( $data, $row ) use ( $script ) {
				$this->scheduleTask( $row->city_id, $script );
			} );
	}

	private function getWikis( array $idsParam = [], int $active = null ) {
		$sql = ( new \WikiaSQL() )
			->SELECT( "city_id" )
			->FROM( "city_list" );

		if ( count( $idsParam ) > 0 ) {
			$sql->WHERE( "city_id" )
				->IN( $idsParam );
		}

		if ( $active !== null ) {
			$timestampSql = "city_last_timestamp BETWEEN TIMESTAMP( DATE_SUB(CURDATE(), INTERVAL %d DAY) ) AND NOW()";
			$sql->AND_( sprintf( $timestampSql, $active ) );
		}

		return $sql;
	}

	private function scheduleTask( int $wikiId, string $script ) {
		$task = new \Wikia\Tasks\Tasks\MaintenanceTask();
		$task->wikiId( $wikiId );
		$task->call( "run", $script );

		$task_id = $task->queue();

		$this->output( "Scheduled ${task_id}\n" );
	}
}

$maintClass = "MaintenanceTaskScheduler";

require_once( RUN_MAINTENANCE_IF_MAIN );
