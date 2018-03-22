<?php

use Wikia\Logger\WikiaLogger;

class Phalanx extends WikiaModel implements ArrayAccess {
	const TYPE_CONTENT = 1;
	const TYPE_SUMMARY = 2;
	const TYPE_TITLE = 4;
	const TYPE_USER = 8;
	const TYPE_ANSWERS_QUESTION_TITLE = 16;
	const TYPE_ANSWERS_RECENT_QUESTIONS = 32;
	const TYPE_WIKI_CREATION = 64;
	const TYPE_COOKIE = 128;
	const TYPE_EMAIL = 256;
	const TYPE_DEVICE = 512;

	const MAX_TYPE_VALUE = self::TYPE_DEVICE;

	const SCRIBE_KEY = 'log_phalanx';
	const LAST_UPDATE_KEY = 'phalanx:last-update';

	const FLAG_EXACT = 1;
	const FLAG_REGEX = 2;
	const FLAG_CASE = 4;

	const ACTION_ADD_FILTER = 'add';
	const ACTION_MODIFY_FILTER = 'edit';

	private $blockId = 0;
	private $db_table = 'phalanx';

	public $moduleData = [];
	public $moduleDataShort = [];

	private static $typeNames = [
		1   => 'content',
		2   => 'summary',
		4   => 'title',
		8   => 'user',
		16  => 'question_title',
		32  => 'recent_questions',
		64  => 'wiki_creation',
		128 => 'cookie',
		256 => 'email',
		512 => 'device',
	];

	// These types should not be made available when creating blocks but should still be shown
	// for existing blocks.
	private static $unsupportedTypes = [
		128 => 'cookie'
	];

	private static $expiry_values = 'phalanx-expire-durations';
	private static $expiry_text = [
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
	];

	public $data = [];

	public function __construct( $blockId = 0 ) {
		parent::__construct();
		$this->blockId = intval( $blockId );
		$this->data = [];
	}

	/**
	 * @param $blockId int
	 * @return Phalanx
	 */
	public static function newFromId( $blockId ): Phalanx {
		$instance = new Phalanx( $blockId );

		// read data from database
		if ( !empty( $blockId ) ) {
			$instance->load();
		}

		return $instance;
	}

	public function toArray() {
		return $this->data;
	}

    public function offsetSet( $offset, $value ) {
        if ( is_null( $offset ) ) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetExists( $offset ) {
        return isset( $this->data[$offset] );
    }

    public function offsetUnset( $offset ) {
        unset( $this->data[$offset] );
    }

    public function offsetGet( $offset ) {
        return isset( $this->data[$offset] ) ? $this->data[$offset] : null;
    }

	public function load() {
		wfProfileIn( __METHOD__ );

		$dbr = $this->getDatabase( DB_SLAVE );

		$row = $dbr->selectRow( $this->db_table, '*', [ 'p_id' => $this->blockId ], __METHOD__ );

		if ( is_object( $row ) ) {
			$this->data = [
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
			];
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Check if this Phalanx filter is of a givent ype
	 * @param int $type one of the TYPE_* constants
	 * @return bool
	 */
	public function isOfType( int $type ): bool {
		return (bool)( $this->data['type'] & $type );
	}

	public function save() {
		wfProfileIn( __METHOD__ );

		if ( !$this->validateUserFilter() ) {
			return false;
		}

		$dbw = $this->getDatabase( DB_MASTER );
		if ( empty( $this->data['id'] ) ) {
			/* add block */
			$dbw->insert( $this->db_table, $this->mapToDB(), __METHOD__ );
			$action = static::ACTION_ADD_FILTER;
		} else {
			$dbw->update( $this->db_table, $this->mapToDB(), array( 'p_id' => $this->data['id'] ), __METHOD__ );
			$action = static::ACTION_MODIFY_FILTER;
		};

		if ( $dbw->affectedRows() ) {
			if ( $action === static::ACTION_ADD_FILTER ) {
				$this->data['id'] = $dbw->insertId();
			}
			$this->log( $action );
		} else {
			$action = '';
		}
		// Commit the transaction so that Phalanx service will see the update when it is notified
		$dbw->commit();

		wfProfileOut( __METHOD__ );
		return ( $action ) ? $this->data['id'] : false;
	}

	/**
	 * SUS-1207: Inserts a Phalanx bulk filter (filter for multiple targets with shared filter settings) into the database
	 * Uses single INSERT operation
	 * @param string[] $bulkTargets filter targets
	 * @return int[] array of block IDs inserted
	 */
	public function insertBulkFilter( array &$bulkTargets ): array {
		$rows = [];
		foreach ( $bulkTargets as $target ) {
			$this->data['text'] = $target;

			if ( !$this->validateUserFilter() ) {
				continue;
			}

			$rows[] = $this->mapToDB();
		}

		$dbw = $this->getDatabase( DB_MASTER );
		$dbw->insert( $this->db_table, $rows, __METHOD__ );

		// If the insert was successful, we need to provide the block IDs generated
		// so that we can notify the Scala service to load them into memory
		$insertCount = $dbw->affectedRows();
		$rowCount = count( $rows );

		Wikia\Util\Assert::true( $insertCount === $rowCount, 'Insert failure for Phalanx bulk filter', [
			'bulkEntriesCount' => $rowCount,
			'insertedCount' => $insertCount,
			'targets' => $bulkTargets
		] );

		$blockIds = [];
		if ( $insertCount ) {
			$blockId = $dbw->insertId();
			foreach ( $rows as $row ) {
				$this->data['id'] = $blockId;
				$this->data['text'] = $row['p_text'];

				// log block insertion to MediaWiki Special:Log
				$this->log( static::ACTION_ADD_FILTER );
				$blockIds[] = $blockId;
				$blockId++;
			}
		}

		// Finally, commit the transaction so that Phalanx service will see the update when it is notified
		$dbw->commit();

		return $blockIds;
	}

	public function delete() {
		wfProfileIn( __METHOD__ );

		$return = false;

		if ( empty( $this->data ) ) {
			wfProfileOut( __METHOD__ );
			return $return;
		}

		$dbw = $this->getDatabase( DB_MASTER );
		$dbw->delete( $this->db_table, ['p_id' => $this->data['id']], __METHOD__ );

		$removed = $dbw->affectedRows();

		// Commit the transaction so that Phalanx service will see the update when it is notified
		$dbw->commit();

		global $wgSpecialsDB;
		$sdw = wfGetDB( DB_MASTER, [], $wgSpecialsDB );
		$sdw->delete( 'phalanx_stats', [ 'ps_blocker_id' => $this->data['id'] ], __METHOD__ );

		if ( $removed ) {
			$this->log( 'delete' );
			WikiaLogger::instance()->info( 'Phalanx block rule deleted', $this->data );
			$return = $this->data['id'];
		}

		wfProfileOut( __METHOD__ );
		return $return;
	}

	/**
	 * Get the values for the expire select
	 *
	 * @return array
	 */
	public static function getExpireValues() {
		return array_combine( self::$expiry_text, explode( ",", wfMsg( self::$expiry_values ) ) );
	}

	/**
	 * Convert a bit field in an int to an array of type names.
	 *
	 * @param int $typeField bit field of types
	 * @return array strings with human-readable names
	 */
	public static function getTypeNames( $typeField ) {
		$types = [];

		// Start with the largest type bit mask we have, e.g. 0b100000000 = 512
		$bitMask = self::MAX_TYPE_VALUE;

		while ( $bitMask ) {
			// If the current bit given by $bitMask is set in $typeField AND we have a
			// type name for it, save it in $types.  Otherwise skip.
			if ( $typeField & $bitMask && !empty( self::$typeNames[$bitMask] ) ) {
				$types[$bitMask] = self::$typeNames[$bitMask];
			}
			$bitMask >>= 1;
		}

		// Some data we get will have bits set that are no longer recognized.  If this is the
		// case at lease output something
		if ( count( $types ) == 0 ) {
			$types[0] = 'unknown';
		}

		return $types;
	}

	/**
	 * Get all phalanx types
	 *
	 * @return array
	 */
	public static function getAllTypeNames() {
		return self::$typeNames;
	}

	/**
	 * Get supported phalanx types
	 *
	 * @return array
	 */
	public static function getSupportedTypeNames() {
		return array_diff( self::$typeNames, self::$unsupportedTypes );
	}

	/**
	 * Mmap array keys to fields in phalanx table
	 *
	 * @return array
	 */
	private function mapToDB() {
		$fields = [];
		foreach ( $this->data as $key => $field  ) {
			$fields[ 'p_' . $key ] = $field;
		}
		return $fields;
	}

	/**
	 * If this is an user filter, check if it is not a trusted network IP address
	 * If it's an IP address, format it correctly
	 * @return bool true if this user filter is valid, false if it would block trusted host
	 */
	private function validateUserFilter(): bool {
		if ( ( $this->data['type'] & self::TYPE_USER ) && User::isIP( $this->data['text'] ) ) {
			if ( wfIsTrustedProxy( $this->data['text'] ) ) {
				// Don't allow to set blocks for trusted proxies or Wikia network hosts
				return false;
			}
		}
		return true;
	}

	/**
	 * Get connection to Phalanx table on external shared DB
	 *
	 * Phalanx table is encoded in utf-8, while in most cases MW communicate with
	 * databases using latin1, so sometimes we get strings in wrong encoding.
	 * The only way to force utf-8 communication (adding SET NAMES utf8) is setting
	 * global variable wgDBmysql5.
	 *
	 * @see https://github.com/Wikia/app/blob/dev/includes/db/DatabaseMysqlBase.php#L113
	 *
	 * @param int $dbType master or slave
	 * @return DatabaseBase
	 */
	protected function getDatabase( int $dbType = DB_SLAVE ): DatabaseBase {
		$wrapper = new Wikia\Util\GlobalStateWrapper( [
			'wgDBmysql5' => true
		] );

		$db = $wrapper->wrap( function () use ( $dbType ) {
			global $wgExternalSharedDB;
			return wfGetDB( $dbType, [], $wgExternalSharedDB );
		} );

		return $db;
	}

	private function log( $action ) {
		$title = Title::newFromText( 'PhalanxStats/' . $this->data['id'], NS_SPECIAL );
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
			wfMessage(
				'phalanx-rule-log-details',
				$this->data['text'], $types, $this->data['reason']
			)->inContentLanguage()->escaped()
		);
	}
}
