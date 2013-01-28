<?php

class Phalanx implements arrayaccess {
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

	private $blockId = 0;
	private $db_table = 'phalanx';
	private $typeNames = array(
		1   => 'content',
		2   => 'summary',
		4   => 'title',
		8   => 'user',
		16  => 'answers-question-title',
		32  => 'answers-recent-questions',
		64  => 'wiki-creation',
		128 => 'cookie',
		256 => 'email'
	);

	public $moduleData = array();
	public $moduleDataShort = array();

	private $expiry_values = 'phalanx-expire-durations';
	private $expiry_text = array(
		"1 hour",
		"2 hours",
		"4 hours",
		"6 hours",
		"1 day",
		"3 days",
		"1 week",
		"2 weeks",
		"1 month",
		"3 months",
		"6 months",
		"1 year",
		"infinite"
	);

	public function __construct( WikiaApp $app, $blockId ) {
		$this->app = $app;
		$this->blockId = intval( $blockId );
		$this->data = array();
	}

	public static function newFromId( $blockId ) {
		$instance = F::build( 'Phalanx', array( 'app' => F::app(), 'blockId' => $blockId ) );

		// read data from database
		$instance->load();
		return $instance;
	}

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }
    public function offsetExists($offset) {
        return isset($this->data[$offset]);
    }
    public function offsetUnset($offset) {
        unset($this->data[$offset]);
    }
    public function offsetGet($offset) {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }
    
	public function load() {
		$this->wf->profileIn( __METHOD__ );

		$dbr = $this->wf->GetDB( DB_SLAVE, array(), $this->app->wg->ExternalSharedDB );
		
		$row = $dbr->selectRow(
			$this->db_table,
			'*',
			array( 'p_id' => $this->blockId ),
			__METHOD__
		);

		if ( is_object( $row ) ) {
			$block = array(
				'id'        => $row->p_id,
				'author_id' => $row->p_author_id,
				'text'      => $row->p_text,
				'type'      => $row->p_type,
				'timestamp' => $row->p_timestamp,
				'expire'    => $row->p_expire,
				'exact'     => $row->p_exact,
				'regex'     => $row->p_regex,
				'case'      => $row->p_case,
				'reason'    => $row->p_reason,
				'lang'      => $row->p_lang,
			);
			$res = $block;
		} else {
			$res = false;
		}
		
		$this->wf->profileOut( __METHOD__ );
		return $res;
	}
	
	/* get the values for the expire select */
	public function getExpireValues() {
		return array_combine( $this->expiry_text, explode(",", $this->wf->Msg( $this->expiry_values ) ) );
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
	public function getTypeNames( $typemask ) {
		$this->wf->profileIn( __METHOD__ );
		$types = array();

		/* iterate for each module for which block is saved */
		for ( $bit = $typemask & 1, $type = 1; $typemask; $typemask >>= 1, $bit = $typemask & 1, $type <<= 1 ) {
			if (!$bit) continue; 
			$types[$type] = $this->typeNames[$type];
		}

		$this->wf->profileOut( __METHOD__ );
		return $types;
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
			global $wgExternalDatawareDB;
			$fields = array(
				'ps_blocker_id' => $blockerId,
				'ps_blocker_type' => $type,
				'ps_timestamp' => wfTimestampNow(),
				'ps_blocked_user' => $wgUser->getName(),
				'ps_wiki_id' => $wgCityId,
			);			
			$dbw = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );
			$dbw->insert( 'phalanx_stats', $fields );
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
				Wikia::log(__METHOD__, __LINE__, "Bad regex found: $blockText");
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
					Wikia::log(__METHOD__, __LINE__, "Bad regex found: $blockText");
				}
				wfRestoreWarnings();
				if ($matched) {
					$blockData = Phalanx::getFromId($blockId);
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
						$blockData = Phalanx::getFromId($blockId);
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
						$blockData = Phalanx::getFromId($blockId);
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
