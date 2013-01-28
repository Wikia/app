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
	static $typeNames = array(
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

	public function __construct( WikiaApp $app, $blockId = 0 ) {
		$this->app = $app;
		$this->blockId = intval( $blockId );
		$this->data = array();
	}

	public static function newFromId( $blockId ) {
		$instance = F::build( 'Phalanx', array( 'app' => F::app(), 'blockId' => $blockId ) );

		/* read data from database */
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
				'lang'      => $row->p_lang,
			);
		}
		
		$this->wf->profileOut( __METHOD__ );
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
	public static function getTypeNames( $typemask ) {
		$types = array();

		/* iterate for each module for which block is saved */
		for ( $bit = $typemask & 1, $type = 1; $typemask; $typemask >>= 1, $bit = $typemask & 1, $type <<= 1 ) {
			if (!$bit) continue; 
			$types[$type] = self::$typeNames[$type];
		}

		return $types;
	}
}
