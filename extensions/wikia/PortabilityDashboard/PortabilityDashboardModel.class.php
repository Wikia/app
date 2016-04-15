<?php

class PortabilityDashboardModel {
	const PORTABILITY_DASHBOARD_TABLE = 'portability_dashboard';
	const WIKI_ID_FIELD = 'wiki_id';
	const CUSTOM_INFOBOXES_FIELD = 'custom_infoboxes';
	const TYPELESS_FIELD = 'typeless';

	private $connection;

	public function __construct( $db = null ) {
		$this->connection = $db;
	}

	public function getList() {
		return ( new WikiaSQL() )
			->SELECT_ALL()
			->FROM( self::PORTABILITY_DASHBOARD_TABLE )
			->run( $this->readDB(), function ( ResultWrapper $rows ) {
				$result = [ ];
				while ( $row = $rows->fetchObject() ) {
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

	public function updateInfoboxesCount( $wikiId, $count ) {
		( new WikiaSQL() )
			->INSERT()
			->INTO( self::PORTABILITY_DASHBOARD_TABLE, [ self::WIKI_ID_FIELD, self::CUSTOM_INFOBOXES_FIELD ] )
			->VALUES( [ [ (int)$wikiId, (int)$count ] ] )
			->ON_DUPLICATE_KEY_UPDATE( [ self::CUSTOM_INFOBOXES_FIELD => (int)$count ] )
			->run( $this->connect( DB_MASTER ) );
	}

	public function updateTemplatesTypeCount( $wikiId, $count ) {
		( new WikiaSQL() )
			->INSERT()
			->INTO( self::PORTABILITY_DASHBOARD_TABLE, [ self::WIKI_ID_FIELD, self::TYPELESS_FIELD ] )
			->VALUES( [ [ (int)$wikiId, (int)$count ] ] )
			->ON_DUPLICATE_KEY_UPDATE( [ self::TYPELESS_FIELD => (int)$count ] )
			->run( $this->connect( DB_MASTER ) );
	}

	private function readDB() {
		if ( !isset( $this->connection ) ) {
			$this->connection = $this->connect( DB_SLAVE );
		}
		return $this->connection;
	}

	private function connect( $type = DB_SLAVE ) {
		global $wgExternalDatawareDB;
		return wfGetDB( $type, array(), $wgExternalDatawareDB );
	}
}
