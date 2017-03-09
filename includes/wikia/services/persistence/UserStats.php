<?php

/**
 * Class UserStats represents a collection of user properties
 * that provide basic user statistics, such as edit count etc.
 */
class UserStats implements ArrayAccess {

	const USER_STATS_PROPERTIES = [
		'editcount',
		'editcountThisWeek',
		'firstContributionTimestamp',
		'lastContributionTimestamp'
	];

	/**
	 * @var array $propMap Associative array of user property names and values
	 */
	private $propMap = [];

	/**
	 * @var int $userId ID of the user whose stats this object contains
	 */
	private $userId;

	/** @var bool $updated
	 * Whether the DB needs to be updated with data stored in this object
	 */
	private $needsUpdate;

	/**
	 * Returns if the DB needs to be updated with data stored in this object
	 * Set to true on property manipulation
	 *
	 * @see UserStats::offsetSet()
	 * @return bool
	 */
	public function needsUpdate(): bool {
		return $this->needsUpdate;
	}

	/**
	 * UserStats constructor - sets user ID of user we want to load stats for.
	 * @param int $userId
	 */
	public function __construct( int $userId ) {
		$this->userId = $userId;
	}

	/**
	 * Load user stats of the current user from the database.
	 * @param DatabaseBase $db DB connection to use
	 */
	public function load( DatabaseBase $db ) {
		$res = $db->select(
			'wikia_user_properties',
			[ 'wup_property', 'wup_value' ],
			[ 'wup_user' => $this->userId, 'wup_property' => self::USER_STATS_PROPERTIES ],
			__METHOD__
		);

		foreach ( $res as $row ) {
			$this->propMap[$row->wup_property] = $row->wup_value;
		}
	}

	/**
	 * Save the user stats of this user to the database.
	 * @param DatabaseBase $db DB connection to use
	 */
	public function persist( DatabaseBase $db ) {
		// Neither MW DB helpers nor FluentSql support conditional UPDATEs
		$sql = "UPDATE wikia_user_properties SET wup_value = CASE wup_property";

		$statNames = array_keys( $this->propMap );
		foreach ( $this->propMap as $statName => $statValue ) {
			$sqlStatName = $db->addQuotes( $statName );
			$sqlStatValue = $db->addQuotes( $statValue );

			$sql .= " WHEN $sqlStatName THEN $sqlStatValue";
		}

		$sql .= ' ELSE wup_value END';
		$sql .= ' WHERE wup_property IN ' . $db->makeList( $statNames );
		$sql .= ' AND wup_user = ' . $db->addQuotes( $this->userId );
		$sql .= ';';

		$db->query( $sql, __METHOD__ );
	}

	/**
	 * @inheritdoc
	 */
	public function offsetExists( $offset ) {
		return isset( $this->propMap[$offset] );
	}

	/**
	 * @inheritdoc
	 */
	public function offsetGet( $offset ) {
		return $this->propMap[$offset];
	}

	/**
	 * @inheritdoc
	 */
	public function offsetSet( $offset, $value ) {
		$this->propMap[$offset] = $value;

		// Mark that DB needs to be updated since we changed data
		$this->needsUpdate = true;
	}

	/**
	 * @inheritdoc
	 */
	public function offsetUnset( $offset ) {
		unset( $this->propMap[$offset] );
	}
}
