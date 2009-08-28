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

	static function addPage($bolek_id, $page_id) {
		// refuse to add !isContentPage and !NS_PROJECT pages

		$dbw = self::_getDB(DB_MASTER);
		try {
			$dbw->insert(
				"bolek",
				array(
					"b_bolek_id"  => $bolek_id,
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

	static function getCollection($bolek_id) {
		$result = array();

		$dbr = self::_getDB(DB_SLAVE);
		$res = $dbr->select(
			array("bolek"),
			array("b_page_id"),
			array("b_bolek_id" => $bolek_id),
			__METHOD__,
			array("ORDER BY" => "b_timestamp")
		);
		while ($row = $dbr->fetchObject($res)) {
			$result[] = $row->b_page_id;
		}
		$dbr->freeResult($res);

		return $result;
	}

	static function clearCollection($bolek_id) {
		$dbw = self::_getDB(DB_MASTER);
		$dbw->delete(
			"bolek",
			array("b_bolek_id" => $bolek_id),
			__METHOD__
		);

		$result = "All pages removed from the collection.";

		return $result;
	}

	static function getCollectionTimestamp($bolek_id) {
		$dbr = self::_getDB(DB_SLAVE);
		$res = $dbr->select(
			array("bolek"),
			array("max(b_timestamp) AS timestamp"),
			array("b_bolek_id" => $bolek_id),
			__METHOD__
		);
		while ($row = $dbr->fetchObject($res)) {
			$result = $row->timestamp;
		}
		$dbr->freeResult($res);

		if (empty($result)) $result = 0;

		return $result;
	}

	static function removePage($bolek_id, $page_id) {
		$dbw = self::_getDB(DB_MASTER);
		try {
			$dbw->delete(
				"bolek",
				array(
					"b_bolek_id"   => $bolek_id,
					"b_page_id"   => $page_id,
				),
				__METHOD__
			);
			$result = "Page {$page_id} removed from the collection.";
		} catch (DBQueryError $e) {
			$result = "Error with page {$page_id}: {$e->error}";
			throw $e;
		}

		return $result;
	}

	static function getCover($bolek_id) {
		$dbr = self::_getDB(DB_SLAVE);
		$res = $dbr->select(
			array("bolek_meta"),
			array("bm_cover"),
			array("bm_bolek_id" => $bolek_id),
			__METHOD__
		);
		while ($row = $dbr->fetchObject($res)) {
			$result = unserialize($row->bm_cover);
		}
		$dbr->freeResult($res);

		if (empty($result)) $result = array(
			"background_color" => "#FF6600",
			"title_color"      => "#FFF",
			"title_size"       => "80pt",
			"title"            => "Magazine Title",
			"subtitle_color"   => "#FFF505",
			"subtitle_size"    => "28pt",
			"subtitle"         => "Subtitle which will be slightly longer",
			"image"            => "http://images.wikia.com/muppet/images/7/79/Kermit-the-frog.jpg",
		);

		return $result;
	}

	static function customizeCover($bolek_id, $cover) {
		$dbw = self::_getDB(DB_MASTER);
		try {
			$dbw->insert(
				"bolek_meta",
				array(
					"bm_bolek_id"   => $bolek_id,
					"bm_cover"     =>  serialize($cover),
					"bm_timestamp" =>  time(),
				),
				__METHOD__
			);
			$result = "Cover customized.";
		} catch (DBQueryError $e) {
			if (1062 == $e->errno) { // ER_DUP_ENTRY
				$dbw->update(
					"bolek_meta",
					array(
						"bm_cover"     => serialize($cover),
						"bm_timestamp" => time(),
					),
					array("bm_bolek_id" => $bolek_id),
					__METHOD__
				);
				$result = "Cover customized.";
			} else {
				$result = "Error with cover customization: {$e->error}";
				throw $e;
			}
		}

		return $result;
	}

	static function getCoverTimestamp($bolek_id) {
		$dbr = self::_getDB(DB_SLAVE);
		$res = $dbr->select(
			array("bolek_meta"),
			array("bm_timestamp"),
			array("bm_bolek_id" => $bolek_id),
			__METHOD__
		);
		while ($row = $dbr->fetchObject($res)) {
			$result = $row->bm_timestamp;
		}
		$dbr->freeResult($res);

		if (empty($result)) $result = 0;

		return $result;
	}

	static function getTimestamp($bolek_id) {
		return max(Bolek::getCollectionTimestamp($bolek_id), Bolek::getCoverTimestamp($bolek_id));
	}
}
