<?php
class ScavengerHuntEntries {

	const ENTRIES_TABLE_NAME = "scavenger_hunt_entries";

	protected $app = null;

	public function __construct( WikiaApp $app ) {
		$this->app = $app;
	}

	/**
	 * @return ScavengerHuntEntry
	 */
	public function newEntry() {
		$entry = WF::build('ScavengerHuntEntry');
		$entry->setEntries($this);
		return $entry;
	}

	public function save( ScavengerHuntEntry $entry ) {
		$fields = array(
			'game_id' => $entry->getGameId(),
			'user_id' => $entry->getUserId(),
			'entry_name' => $entry->getName(),
			'entry_email' => $entry->getEmail(),
			'entry_answer' => $entry->getAnswer(),
		);

		$db = $this->getDb(DB_MASTER);
		$db->insert(
			self::ENTRIES_TABLE_NAME,
			$fields,
			__METHOD__
		);
		$db->commit();
		return true;
	}

	public function findAllByGameId( $gameId, $startEntryId = 0, $limit = -1 ) {
		$where = array(
			'game_id' => (int)$gameId,
			'entry_id >= ' . (int)$startEntryId,
		);
		$options = array();
		if ($limit > 0) {
			$options['LIMIT'] = $limit;
		}
		$db = $this->getDb();
		$set = $db->select(
			array( self::ENTRIES_TABLE_NAME ),
			array( 'entry_id', 'game_id', 'user_id', 'entry_name', 'entry_email', 'entry_answer' ),
			array( 'game_id' => (int)$gameId ),
			__METHOD__,
			$options
		);

		$entries = array();
		while( $row = $set->fetchObject( $set ) ) {
			$entries[] = $this->newEntryFromRow($row);
		}

		return $entries;
	}

	/**
	 * get db handler
	 * @return DatabaseBase
	 */
	protected function getDb( $type = DB_SLAVE ) {
		return $this->app->runFunction( 'wfGetDB', $type, array(), $this->app->getGlobal( 'wgExternalDatawareDB' ) );
	}

	protected function newEntryFromRow( $row ) {
		$entry = $this->newEntry();

		$entry->setEntryId($row->entry_id);
		$entry->setGameId($row->game_id);
		$entry->setUserId($row->user_id);
		$entry->setName($row->entry_name);
		$entry->setEmail($row->entry_email);
		$entry->setAnswer($row->entry_answer);

		return $entry;
	}
}