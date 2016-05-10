<?php

class Phalanx implements arrayaccess {
	const TYPE_CONTENT = 1;
	const TYPE_SUMMARY = 2;
	const TYPE_TITLE = 4;
	const TYPE_USER = 8;
	const TYPE_ANSWERS_QUESTION_TITLE = 16;
	const TYPE_ANSWERS_RECENT_QUESTIONS = 32;
	const TYPE_WIKI_CREATION = 64;
	const TYPE_EMAIL = 256;

	const SCRIBE_KEY = 'log_phalanx';
	const LAST_UPDATE_KEY = 'phalanx:last-update';

	const FLAG_EXACT = 1;
	const FLAG_REGEX = 2;
	const FLAG_CASE = 4;

	private $blockId = 0;
	private $db_table = 'phalanx';

	public $moduleData = array();
	public $moduleDataShort = array();

	private static $typeNames = array(
		1   => 'content',
		2   => 'summary',
		4   => 'title',
		8   => 'user',
		16  => 'question_title',
		32  => 'recent_questions',
		64  => 'wiki_creation',
		256 => 'email'
	);
	private static $expiry_values = 'phalanx-expire-durations';
	private static $expiry_text = array(
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

	public function __construct( $blockId = 0 ) {
		$this->app = F::app();
		$this->wf = $this->app->wf;
		$this->wg = $this->app->wg;
		$this->blockId = intval( $blockId );
		$this->data = array();
	}

	/**
	 * @param $blockId int
	 * @return Phalanx
	 */
	public static function newFromId( $blockId ) {
		$instance = new Phalanx( $blockId );

		/* read data from database */
		$instance->load();
		return $instance;
	}

	public function toArray() {
		return $this->data;
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
		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB( DB_SLAVE, array(), $this->app->wg->ExternalSharedDB );

		$row = $dbr->selectRow( $this->db_table, '*', array( 'p_id' => $this->blockId ), __METHOD__ );

		if ( is_object( $row ) ) {
			$this->data = array(
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
				'comment'   => $row->p_comment,
				'lang'      => $row->p_lang,
				'ip_hex'    => $row->p_ip_hex
			);
		}

		wfProfileOut( __METHOD__ );
	}

	public function save() {
		wfProfileIn( __METHOD__ );

		if ( ( $this->data['type'] & self::TYPE_USER ) && User::isIP( $this->data['text'] ) ) {
			if ( wfIsTrustedProxy( $this->data['text'] ) ) {
				// Don't allow to set blocks for trusted proxies or Wikia network hosts
				#return false;
			}

			$this->data['ip_hex'] = IP::toHex( $this->data['text'] );
		}

		$dbw = wfGetDB( DB_MASTER, array(), $this->wg->ExternalSharedDB );
		if ( empty( $this->data['id'] ) ) {
			/* add block */
			$dbw->insert( $this->db_table, $this->mapToDB(), __METHOD__ );
			$action = 'add';
		} else {
			$dbw->update( $this->db_table, $this->mapToDB(), array( 'p_id' => $this->data['id'] ), __METHOD__ );
			$action = 'edit';
		};

		if ( $dbw->affectedRows() ) {
			if ( $action == 'add' ) {
				$this->data['id'] = $dbw->insertId();
			}
			$this->log( $action );
		} else {
			$action = '';
		}
		$dbw->commit();

		wfProfileOut( __METHOD__ );
		return ( $action ) ? $this->data['id'] : false;
	}

	public function delete() {
		wfProfileIn( __METHOD__ );

		if (empty($this->data)) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$dbw = wfGetDB( DB_MASTER, array(), $this->wg->ExternalSharedDB );
		$dbw->delete( $this->db_table, array( 'p_id' => $this->data['id'] ), __METHOD__ );

		if ( $removed = $dbw->affectedRows() ) {
			$this->log( 'delete' );
		}
		$dbw->commit();

		wfProfileOut( __METHOD__ );
		return ( $removed ) ? $this->data['id'] : false;
	}

	/* get the values for the expire select */
	public static function getExpireValues() {
		return array_combine( self::$expiry_text, explode(",", wfMsg( self::$expiry_values ) ) );
	}

	/*
	 * @author tor <tor@wikia-inc.com>
	 * @author Marooned <marooned at wikia-inc.com>
	 *
	 * @param $typemask bit mask of types
	 * @return Array of strings with human-readable names
	 */
	public static function getTypeNames( $typemask ) {
		$types = array();

		/* iterate for each module for which block is saved */
		for ( $bit = $typemask & 1, $type = 1; $typemask; $typemask >>= 1, $bit = $typemask & 1, $type <<= 1 ) {
			if (!$bit) continue;
			$types[$type] = self::$typeNames[$type];
		}

		return $types;
	}

	/* get all phalanx types */
	public static function getAllTypeNames() {
		return self::$typeNames;
	}

	/* map array keys to fields in phalanx table */
	private function mapToDB() {
		$fields = array();
		foreach( $this->data as $key => $field  ) {
			$fields[ 'p_' . $key ] = $field;
		}
		return $fields;
	}

	private function log( $action ) {
		$title = Title::newFromText('PhalanxStats/' . $this->data['id'], NS_SPECIAL);
		$types = implode( ',', Phalanx::getTypeNames( $this->data['type'] ) );

		if ( $this->data['type'] & Phalanx::TYPE_EMAIL ) {
			$logType = 'phalanxemail';
		} else {
			$logType = 'phalanx';
		}

		$log = new LogPage( $logType );
		$log->addEntry(
			$action,
			$title,
			wfMsgExt( 'phalanx-rule-log-details', array( 'parsemag', 'content' ), $this->data['text'], $types, $this->data['reason'] )
		);
	}
}
