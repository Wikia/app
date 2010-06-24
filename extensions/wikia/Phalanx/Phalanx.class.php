<?php

class Phalanx {

	const TYPE_CONTENT = 1;
	const TYPE_SUMMARY = 2;
	const TYPE_TITLE = 4;
	const TYPE_USER = 8;
	const TYPE_ANSWERS_QUESTION = 16;
	const TYPE_ANSWERS_WORDS = 32;
	const TYPE_WIKI_CREATION = 64;

	public static $typeNames = array(
		1 => 'content',
		2 => 'summary',
		4 => 'title',
		8 => 'user',
		16 => 'answers-question',
		32 => 'answers-words',
		64 => 'wiki-creation'
	);

	/*
		get the values for the expire select
	*/
	static public function getExpireValues() {
		$expiry_values = explode(",", wfMsg('phalanx-expire-durations'));
		$expiry_text = array("1 hour","2 hours","4 hours","6 hours","1 day","3 days","1 week","2 weeks","1 month","3 months","6 months","1 year","infinite");

		return array_combine($expiry_text, $expiry_values);
	}

	/*
	 * getTypeNames
	 *
	 * @author tor <tor@wikia-inc.com>
	 * @author Marooned <marooned at wikia-inc.com>
	 *
	 * @param $typemask bit mask of types
	 * @returns Array of strings with human-readable names
	 */
	static public function getTypeNames( $typemask ) {

		$types = array();

		//iterate for each module for which block is saved
		for ($bit = $typemask&1, $type=1; $typemask; $typemask>>=1, $bit = $typemask&1, $type<<=1) {
			if (!$bit) continue; //skip not used modules
			$types[$type] = self::$typeNames[$type];
		}

		return $types;
	}

	static public function getFromFilter( $moduleId, $lang = null, $master = false ) {
		global $wgExternalSharedDB, $wgMemc;
		wfProfileIn( __METHOD__ );

		$timestampNow = wfTimestampNow();
		$key = 'phalanx:' . $moduleId . ':' . ($lang ? $lang : 'all');
		$blocksData = $wgMemc->get($key);

		//cache miss (or we have expired blocks in cache), get from DB
		if (empty($blocksData) || (!is_null($blocksData['closestExpire']) && $blocksData['closestExpire'] < $timestampNow && $blocksData['closestExpire'])) {
			$blocks = $cond = array();
			$closestTimestamp = 0;
			$dbr = wfGetDB( $master ? DB_MASTER : DB_SLAVE, array(), $wgExternalSharedDB );

			if( !empty( $moduleId ) ) {
				$cond[] = "p_type & $moduleId = $moduleId";
			}
			if( !empty( $lang ) ) {
				$cond[] = "(p_lang = '$lang' OR p_lang IS NULL)";
			} else {
				$cond[] = "p_lang IS NULL";
			}

			$res = $dbr->select(
				'phalanx',
				'*',
				$cond,
				__METHOD__
			);

			while ( $row = $res->fetchObject() ) {
				if ($timestampNow > $row->p_expire && !is_null($row->p_expire)) {
					continue;       //skip expired
				}
				//use p_id as array key for easier deletion from cache
				$blocks[$row->p_id] = array(
					'id' => $row->p_id,
					'author_id' => $row->p_author_id,
					'text' => $row->p_text,
					'type' => $row->p_type,
					'timestamp' => $row->p_timestamp,
					'expire' => $row->p_expire,
					'exact' => $row->p_exact,
					'regex' => $row->p_regex,
					'case' => $row->p_case,
					'reason' => $row->p_reason,
					'lang' => $row->p_lang
				);
				if (!is_null($row->p_expire) && $closestTimestamp > $row->p_expire || !$closestTimestamp) {
					$closestTimestamp = $row->p_expire;
				}
			}

			$blocksData['blocks'] = $blocks;
			$blocksData['closestExpire'] = $closestTimestamp;
			$wgMemc->set($key, $blocksData);
		}

		wfProfileOut( __METHOD__ );
		return $blocksData['blocks'];
	}


	static public function getFromId( $blockerId ) {
		global $wgExternalSharedDB;
		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

		//rarely used (only for edit and remove?), no memcache here

		$row = $dbr->selectRow(
			'phalanx',
			'*',
			"p_id = $blockerId",
			__METHOD__
		);

		if( is_object( $row ) ) {
			$block = array(
				'id' => $row->p_id,
				'author_id' => $row->p_author_id,
				'text' => $row->p_text,
				'type' => $row->p_type,
				'timestamp' => $row->p_timestamp,
				'expire' => $row->p_expire,
				'exact' => $row->p_exact,
				'regex' => $row->p_regex,
				'case' => $row->p_case,
				'reason' => $row->p_reason,
				'lang' => $row->p_lang,
			);

			wfProfileOut( __METHOD__ );
			return $block ;
		} else {
			wfProfileOut( __METHOD__ );
			return false ;
		}
	}

	/**
	 * addStats
	 *
	 * counts statistics for blocks
	 *
	 * @author tor <tor@wikia-inc.com>
	 *
	 * @param $blockerId Int unique block identifier
	 * @param $type Int unique block type identifier
	 *
	 * @todo use a message queue for this
	 */
	static public function addStats( $blockerId, $type ) {
		global $wgExternalSharedDB, $wgUser, $wgCityId;

		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return;
		}

		// hack to not count testFilters hits,
		// otherwise phalanxexempt users will *not* get here
		if ( $wgUser->isAllowed( 'phalanxexempt' ) ) {
			return;
		}

		$fields = array(
			'ps_blocker_id' => $blockerId,
			'ps_blocker_type' => $type,
			'ps_timestamp' => wfTimestampNow(),
			'ps_blocked_user' => $wgUser->getName(),
			'ps_wiki_id' => $wgCityId,
		);

		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

		$dbw->insert( 'phalanx_stats', $fields );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * test if provided text is blocked
	 * @param string $text string to be tested against filter
	 * @param array $blockData block data (text, params, id)
	 *
	 * @return Array with 'blocked' key containing boolean status
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	static function isBlocked($text, $blockData) {
		wfProfileIn( __METHOD__ );
		$result = array('blocked' => false, 'msg' => '');
		$blockText = $blockData['text'];

		if ($blockData['regex']) {
			//escape slashes uses as regex delimiter
			$blockText = str_replace('/', '\/', preg_replace('|\\\*/|', '/', $blockText));
			if ($blockData['exact']) {
				//add begining and end anchor only once (user might added it already)
				if (strpos($blockText, '^') !== 0) {
					$blockText = '^' . $blockText;
				}
				if (substr($blockText, -1) != '$') {
					$blockText .= '$';
				}
			}
			$blockText = "/$blockText/";
			if (!$blockData['case']) {
				$blockText .= 'i';
			}
			//QuickFix™ for bad regexes
			//TODO: validate regexes on save/edit
			wfSuppressWarnings();
			$matched = preg_match($blockText, $text, $matches);
			if ($matched === false) {
				Wikia::log(__METHOD__, __LINE__, "Bad regex found: $blockText");
			}
			wfRestoreWarnings();
			if ($matched) {
				self::addStats($blockData['id'], $blockData['type']);
				$result['blocked'] = true;
				$result['msg'] = $matches[0];
			}
		} else { //plain text
			if (!$blockData['case']) {
				$text = strtolower($text);
				$blockText = strtolower($blockText);
			}
			if ($blockData['exact']) {
				if ($text == $blockText) {
					self::addStats($blockData['id'], $blockData['type']);
					$result['blocked'] = true;
					$result['msg'] = $blockData['text'];    //original case
				}
			} else {
				if (strpos($text, $blockText) !== false) {
					self::addStats($blockData['id'], $blockData['type']);
					$result['blocked'] = true;
					$result['msg'] = $blockData['text'];    //original case
				}
			}
		}
		wfProfileOut( __METHOD__ );
		return $result;
	}
}
