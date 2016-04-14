<?php

class PortabilityDashboardModel {
	const PORTABILITY_DASHBOARD_TABLE = 'portability_dashboard';

	private $connection;

	public function __construct( $db = null ) {
		$this->connection = $db;
	}

	public function getList() {
		return ( new WikiaSQL() )
			->SELECT_ALL()
			->FROM( self::PORTABILITY_DASHBOARD_TABLE )
			->run( $this->getConnection(), function ( ResultWrapper $rows ) {
				$result = [];
				while( $row = $rows->fetchObject() ) {
					$result[] = [
						'wiki_id' => $row->wiki_id,
						'portability' => $row->portability,
						'infobox_portability' => $row->infobox_portability,
						'traffic' => $row->traffic,
						'migration_impact' => $row->migration_impact
					];
				}
				return $result;
			} );
	}

	private function getConnection() {
		if ( !isset( $this->connection ) ) {
			global $wgExternalDatawareDB;
			$this->connection = wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB );
		}
		return $this->connection;
	}

}
