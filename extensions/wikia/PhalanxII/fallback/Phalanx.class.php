<?php

class PhalanxFallback {

	const TYPE_CONTENT = 1;
	const TYPE_SUMMARY = 2;
	const TYPE_TITLE = 4;
	const TYPE_USER = 8;
	const TYPE_ANSWERS_QUESTION_TITLE = 16;
	const TYPE_ANSWERS_RECENT_QUESTIONS = 32;
	const TYPE_WIKI_CREATION = 64;
	const TYPE_COOKIE = 128;
	const TYPE_EMAIL = 256;
	const SCRIBE_KEY = 'log_phalanx';
	const LAST_UPDATE_KEY = 'phalanx:last-update';

	const FLAG_EXACT = 1;
	const FLAG_REGEX = 2;
	const FLAG_CASE = 4;

	public static $typeNames = array(
		1 => 'content',
		2 => 'summary',
		4 => 'title',
		8 => 'user',
		16 => 'answers-question-title',
		32 => 'answers-recent-questions',
		64 => 'wiki-creation',
		128 => 'cookie',
		256 => 'email'
	);

	public static $moduleData = array();
	public static $moduleDataShort = array();

	/*
		get the values for the expire select
	*/
	static public function getExpireValues() {
		$expiry_values = explode(",", wfMsg('phalanx-expire-durations'));
		$expiry_text = array("1 hour","2 hours","4 hours","6 hours","1 day","3 days","1 week","2 weeks","1 month","3 months","6 months","1 year","infinite");

		return array_combine($expiry_text, $expiry_values);
	}

	/*
	 * get last filter change date
	 */
	static public function getLastUpdate() {
		global $wgMemc;
		return $wgMemc->get( wfSharedMemcKey( self::LAST_UPDATE_KEY ) );
	}

	/*
	 *
	 */
	static public function setLastUpdate() {
		global $wgMemc;
		return $wgMemc->set( wfSharedMemcKey( self::LAST_UPDATE_KEY ), wfTimestampNow() );
	}

	/*
	 * getTypeNames
	 *
	 * @author tor <tor@wikia-inc.com>
	 * @author Marooned <marooned at wikia-inc.com>
	 *
	 * @param $typemask bit mask of types
	 * @return Array of strings with human-readable names
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

	static public function getFromFilter( $moduleId, $lang = null, $master = false, $skipCache = false ) {
		global $wgExternalSharedDB, $wgMemc;
		wfProfileIn( __METHOD__ );

		$timestampNow = wfTimestampNow();
		$key = 'phalanx:' . $moduleId . ':' . ($lang ? $lang : 'all');
		$sLang = $lang ? $lang : 'all';
		if ( $skipCache ) {
			$blocksData = null;
		} else if (isset(self::$moduleData[$moduleId][$sLang])) {
			$blocksData = self::$moduleData[$moduleId][$sLang];
		} else {
			$blocksData = $wgMemc->get($key);
		}

		//cache miss (or we have expired blocks in cache), get from DB
		if ( empty($blocksData) || (!is_null($blocksData['closestExpire']) && $blocksData['closestExpire'] < $timestampNow && $blocksData['closestExpire'])) {
			$blocks = $cond = array();
			$closestTimestamp = 0;
			$dbr = wfGetDB( $master ? DB_MASTER : DB_SLAVE, array(), $wgExternalSharedDB );

			if( !empty( $moduleId ) && is_numeric( $moduleId ) ) {
				$cond[] = "p_type & $moduleId = $moduleId";
			}
			if( !empty( $lang ) && Language::isValidCode( $lang ) ) {
				$cond[] = "(p_lang = '$lang' OR p_lang IS NULL)";
			} else {
				$cond[] = "p_lang IS NULL";
			}

			$cond[] = "p_expire is null or p_expire > '{$timestampNow}'";

			$res = $dbr->select(
				'phalanx',
				'*',
				$cond,
				__METHOD__
			);

			while ( $row = $res->fetchObject() ) {
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
		self::$moduleData[$moduleId][$sLang] = $blocksData;

		wfProfileOut( __METHOD__ );
		return $blocksData['blocks'];
	}

	static public function getFromFilterShort( $moduleId, $lang = null, $master = false, $skipCache = false ) {
		global $wgExternalSharedDB, $wgMemc;
		wfProfileIn( __METHOD__ );

		$timestampNow = wfTimestampNow();
		$key = 'phalanx:' . $moduleId . ':' . ($lang ? $lang : 'all') . ':short';
		$sLang = $lang ? $lang : 'all';
		if ( $skipCache ) {
			$blocksData = null;
		} else if (isset(self::$moduleDataShort[$moduleId][$sLang])) {
			$blocksData = self::$moduleDataShort[$moduleId][$sLang];
		} else {
			$blocksData = $wgMemc->get($key);
		}

		//cache miss (or we have expired blocks in cache), get from DB
		if ( empty($blocksData) || (!is_null($blocksData['closestExpire']) && $blocksData['closestExpire'] < $timestampNow && $blocksData['closestExpire'])) {
			$blocks = $cond = array();
			$closestTimestamp = 0;
			$dbr = wfGetDB( $master ? DB_MASTER : DB_SLAVE, array(), $wgExternalSharedDB );

			if( !empty( $moduleId ) && is_numeric( $moduleId ) ) {
				$cond[] = "p_type & $moduleId = $moduleId";
			}
			if( !empty( $lang ) && Language::isValidCode( $lang ) ) {
				$cond[] = "(p_lang = '$lang' OR p_lang IS NULL)";
			} else {
				$cond[] = "p_lang IS NULL";
			}

			$cond[] = "p_expire is null or p_expire > '{$timestampNow}'";

			$res = $dbr->select(
				'phalanx',
				'*',
				$cond,
				__METHOD__
			);

			foreach ($res as $row) {
				$blocks[$row->p_id] = array(
					$row->p_id,
					$row->p_text,
					  ($row->p_exact ? self::FLAG_EXACT : 0)
					+ ($row->p_regex ? self::FLAG_REGEX : 0)
					+ ($row->p_case ? self::FLAG_CASE : 0)
				);
				if (!is_null($row->p_expire) && $closestTimestamp > $row->p_expire || !$closestTimestamp) {
					$closestTimestamp = $row->p_expire;
				}
			}

			$blocksData['blocks'] = $blocks;
			$blocksData['closestExpire'] = $closestTimestamp;
			$wgMemc->set($key, $blocksData);
		}
		self::$moduleDataShort[$moduleId][$sLang] = $blocksData;

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
			array( 'p_id' => intval( $blockerId ) ),
			__METHOD__
		);

		if( is_object( $row ) ) {
			$block = array(
				'id' => $row->p_id,
				'author_id' => $row->p_author_id,
				'authorId' => $row->p_author_id, /* uses in PhalanxII */
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

			$res = $block;
		} else {
			$res = false;
		}
		wfProfileOut( __METHOD__ );
		return $res;
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
		global $wgUser, $wgCityId;

		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return;
		}

		// hack to not count testFilters hits,
		// otherwise phalanxexempt users will *not* get here
		if ( $wgUser->isAllowed( 'phalanxexempt' ) ) {
			wfProfileOut( __METHOD__ );
			return;
		}
		
		if ( class_exists('WScribeClient') ) {
			try {
				$fields = array(
					'blockId'			=> $blockerId,
					'blockType'			=> $type,
					'blockTs' 			=> wfTimestampNow(),
					'blockUser' 		=> $wgUser->getName(),
					'city_id' 			=> $wgCityId,
				);	
				$data = json_encode( $fields );
				WScribeClient::singleton( self::SCRIBE_KEY )->send( $data );
			}
			catch( TException $e ) {
				Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
			}
		} else {
			global $wgSpecialsDB;
			$fields = array(
				'ps_blocker_id' => $blockerId,
				'ps_blocker_type' => $type,
				'ps_timestamp' => wfTimestampNow(),
				'ps_blocked_user' => $wgUser->getName(),
				'ps_wiki_id' => $wgCityId,
			);
			$dbw = wfGetDB( DB_MASTER, array(), $wgSpecialsDB );
			$dbw->insert( 'phalanx_stats', $fields, __METHOD__ );
		}

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
	static function isBlocked($text, $blockData, $writeStats = true) {
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
				Wikia\Logger\WikiaLogger::instance()->error(
					__METHOD__ . ' - bad regex found',
					[
						'exception' => new Exception(),
						'regex' => $blockText
					]
				);
			}
			wfRestoreWarnings();
			if ($matched) {
				if ($writeStats) {
					self::addStats($blockData['id'], $blockData['type']);
				}
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
					if ($writeStats) {
						self::addStats($blockData['id'], $blockData['type']);
					}
					$result['blocked'] = true;
					$result['msg'] = $blockData['text'];    //original case
				}
			} else {
				if ( !empty($blockText) && strpos($text, $blockText) !== false) {
					if ($writeStats) {
						self::addStats($blockData['id'], $blockData['type']);
					}
					$result['blocked'] = true;
					$result['msg'] = $blockData['text'];    //original case
				}
			}
		}
		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * test if provided text is blocked
	 * @param string $text string to be tested against filter
	 * @param array $blocksData blocks data (text, params, id), either in full or short format
	 * @param boolean $writeStats should stats be recorded?
	 * @param array $matchingBlockData (out) block data that matched
	 *
	 * @return Array with 'blocked' key containing boolean status
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 * @author Władysław Bodzek
	 */
	static function findBlocked($text, $blocksData, $writeStats = true, &$matchingBlockData = null) {
		wfProfileIn( __METHOD__ );
		$result = array('blocked' => false, 'msg' => '');
		foreach ($blocksData as $blockData) {
			if ( isset( $blockData['id'] ) ) { // full format
				$blockId = $blockData['id'];
				$blockText = $blockData['text'];
				$isRegex = $blockData['regex'];
				$isExact = $blockData['exact'];
				$isCase = $blockData['case'];
			} else { // short format
				list( $blockId, $blockText, $blockFlags ) = $blockData;
				$isRegex = ($blockFlags & self::FLAG_REGEX) > 0;
				$isExact = ($blockFlags & self::FLAG_EXACT) > 0;
				$isCase = ($blockFlags & self::FLAG_CASE) > 0;
			}
			$origText = $blockText;

			if ($isRegex) {
				//escape slashes uses as regex delimiter
				$blockText = str_replace('/', '\/', preg_replace('|\\\*/|', '/', $blockText));
				if ($isExact) {
					//add begining and end anchor only once (user might added it already)
					if (strpos($blockText, '^') !== 0) {
						$blockText = '^' . $blockText;
					}
					if (substr($blockText, -1) != '$') {
						$blockText .= '$';
					}
				}
				$blockText = "/$blockText/";
				if (!$isCase) {
					$blockText .= 'i';
				}
				//QuickFix™ for bad regexes
				//TODO: validate regexes on save/edit
				wfSuppressWarnings();
				$matched = preg_match($blockText, $text, $matches);
				if ($matched === false) {
					Wikia\Logger\WikiaLogger::instance()->error(
						__METHOD__ . ' - bad regex found',
						[
							'exception' => new Exception(),
							'regex' => $blockText
						]
					);
				}
				wfRestoreWarnings();
				if ($matched) {
					$blockData = self::getFromId($blockId);
					if ( $blockData ) {
						if ($writeStats) {
							self::addStats($blockData['id'], $blockData['type']);
						}
						$result['blocked'] = true;
						$result['msg'] = $matches[0];
					}
				}
			} else { //plain text
				if (!$isCase) {
					$text = strtolower($text);
					$blockText = strtolower($blockText);
				}
				if ($isExact) {
					if ($text == $blockText) {
						$blockData = self::getFromId($blockId);
						if ( $blockData ) {
							if ($writeStats) {
								self::addStats($blockData['id'], $blockData['type']);
							}
							$result['blocked'] = true;
							$result['msg'] = $origText;    //original case
						}
					}
				} else {
					if ( !empty($blockText) && strpos($text, $blockText) !== false) {
						$blockData = self::getFromId($blockId);
						if ( $blockData ) {
							if ($writeStats) {
								self::addStats($blockData['id'], $blockData['type']);
							}
							$result['blocked'] = true;
							$result['msg'] = $origText;    //original case
						}
					}
				}
			}
			if ( $result['blocked'] ) {
				$matchingBlockData = $blockData;
				break;
			}
		}
		wfProfileOut( __METHOD__ );
		return $result;
	}


	static public function clearCache( $moduleId, $lang ) {
		$sLang = $lang ? $lang : 'all';
		unset(self::$moduleData[$moduleId][$sLang]);
		unset(self::$moduleDataShort[$moduleId][$sLang]);
	}
}
