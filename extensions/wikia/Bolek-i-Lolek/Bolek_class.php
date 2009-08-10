<?php

class Bolek {
	private static function _getDB($master_slave = DB_SLAVE) {
		#return wfGetDB($master_slave);

		return wfGetDB(DB_MASTER);
		// master-slave lag )))-:
		// subsequent call to getCollection returns an empty set
		// rewrite as nonstatic object and return local copy
		// (cache would be nice anyway)
	}

	static function addPage($page_id) {
		global $wgUser;

		$dbw = self::_getDB(DB_MASTER);
		try {
			$dbw->insert(
				"bolek",
				array(
					"b_user_id"   => $wgUser->getId(),
					"b_page_id"   => $page_id,
					"b_timestamp" =>  time(),
				),
				__METHOD__
			);
			$result = "Page {$page_id} added to the collection.";
		} catch (DBQueryError $e) {
			if (1062 == $e->errno) { // ER_DUP_ENTRY
				$result = "Page {$page_id} already in the collection.";
			} else {
				$result = "Error with page {$page_id}: {$e->error}";
				throw $e;
			}
		}

		return $result;
	}

	static function getCollection($user_id = null) {
		global $wgUser;
		if (null == $user_id) $user_id = $wgUser->getId();

		$result = array();

		$dbr = self::_getDB(DB_SLAVE);
		$res = $dbr->select(
			array("bolek"),
			array("b_page_id"),
			array("b_user_id" => $user_id),
			__METHOD__,
			array("ORDER BY" => "b_timestamp")
		);
		while ($row = $dbr->fetchObject($res)) {
			$result[] = $row->b_page_id;
		}
		$dbr->freeResult($res);

		return $result;
	}

	static function clearCollection() {
		global $wgUser;

		$dbw = self::_getDB(DB_MASTER);
		$dbw->delete(
			"bolek",
			array("b_user_id" => $wgUser->getId()),
			__METHOD__
		);

		$result = "All pages removed from the collection.";

		return $result;
	}

	static function getCollectionTimestamp() {
		global $wgUser;

		$dbr = self::_getDB(DB_SLAVE);
		$res = $dbr->select(
			array("bolek"),
			array("max(b_timestamp) AS timestamp"),
			array("b_user_id" => $wgUser->getId()),
			__METHOD__
		);
		while ($row = $dbr->fetchObject($res)) {
			$result = $row->timestamp;
		}
		$dbr->freeResult($res);

		if (empty($result)) $result = 0;

		return $result;
	}
}
