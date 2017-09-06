<?php


namespace Discussions;

class WallHistoryFinder {

	const TABLE_WALL_HISTORY = 'wall_history';
	const COLUMNS = [
		'revision_id',
		'deleted_or_removed',
		'event_date',
		'reason',
		'action',
		'is_reply',
		'post_user_id',
	];

	private $dbh;

	public function __construct( $dbh ) {
		$this->dbh = $dbh;
	}

	public function find() {
		return ( new \WikiaSQL() )->SELECT( ...self::COLUMNS )
			->FROM( self::TABLE_WALL_HISTORY )
			->WHERE( 'post_ns' )
			->EQUAL_TO( NS_WIKIA_FORUM_BOARD )
			->run( $this->dbh );
	}

}
