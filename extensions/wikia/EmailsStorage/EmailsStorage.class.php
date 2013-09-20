<?php

class EmailsStorage {

	const TABLE_NAME = 'emails_storage';

	// registered sources - update getSourcesId() method as well
	const SCAVENGER_HUNT = 1;
	const QUIZ = 2;

	protected $app = null;

	public function __construct(WikiaApp $app = null) {
		if( is_null( $app ) ) {
			$app = F::app();
		}
		$this->app = $app;
	}

	/**
	 * Return instance of EmailsStorageEntry object containing data from row provided
	 *
	 * @param object $row data from database
	 * @return EmailsStorageEntry entry object
	 */
	public function newEntryFromRow($row) {
		$entry = new EmailsStorageEntry($this->app, $row->source_id);

		$entry->setPageId($row->page_id);
		$entry->setCityId($row->city_id);
		$entry->setEmail($row->email);
		$entry->setUserId($row->user_id);
		$entry->setBeaconId($row->beacon_id);
		$entry->setFeedback($row->feedback);
		$entry->setTimestamp($row->timestamp);

		return $entry;
	}

	/**
	 * Return instance of EmailsStorageEntry object containing data from row provided
	 *
	 * This is your entry point
	 *
	 * @param int $sourceId type of source (see EmailsStorage class for constants with sources definition)
	 * @return EmailsStorageEntry entry object
	 */
	public function newEntry($sourceId) {
		$entry = new EmailsStorageEntry($this->app, $sourceId);
		$entry->setStorage($this);
		return $entry;
	}

	/**
	 * Return email entries from given source
	 *
	 * @param int $sourceId type of source to get emails from
	 * @return array set of EmailsStorageEntry object
	 */
	public function getAllBySourceId($sourceId) {
		wfProfileIn(__METHOD__);

		$dbr = $this->getDB(DB_SLAVE);
		$res = $dbr->select(self::TABLE_NAME, array(
			'source_id',
			'page_id',
			'city_id',
			'email',
			'user_id',
			'beacon_id',
			'feedback',
			'timestamp',
		), array(
			'source_id' => intval($sourceId),
		), __METHOD__);

		$entries = array();

		while($row = $res->fetchObject()) {
			$entries[] = $this->newEntryFromRow($row);
		}

		wfProfileOut(__METHOD__);
		return $entries;
	}

	/**
	 * Return all source types registered in the "system"
	 *
	 * @return array list of source IDs
	 */
	public function getSourcesId() {
		return array(
			self::SCAVENGER_HUNT => 'scavenger-hunt',
			self::QUIZ => 'quiz',
		);
	}

	/**
	 * Stores given entry in database and returns ID
	 *
	 * @param EmailsStorageEntry $entry entry to be added to database
	 * @return int ID of added entry
	 */
	public function store(EmailsStorageEntry $entry) {
		wfProfileIn(__METHOD__);

		$row = array(
			'source_id' => $entry->getSourceId(),
			'page_id' => intval($entry->getPageId()),
			'city_id' => $entry->getCityId(),
			'email' => $entry->getEmail(),
			'user_id' => $entry->getUserId(),
			'beacon_id' => (string) $entry->getBeaconId(),
			'feedback' => (string) $entry->getFeedback(),
			'timestamp' => wfTimestampNow(),
		);

		$dbw = $this->getDb(DB_MASTER);
		$dbw->insert(
			self::TABLE_NAME,
			$row,
			__METHOD__
		);

		$id = $dbw->insertId();
		$dbw->commit();

		wfProfileOut(__METHOD__);
		return $id;
	}

	/**
	 * get db handler
	 * @return DatabaseBase
	 */
	protected function getDb($type = DB_SLAVE) {
		return wfGetDB($type, array(), $this->app->wg->ExternalDatawareDB);
	}
}