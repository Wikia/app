<?php

class MultiLookupPager extends TablePager {
	const ML_TIMESTAMP = 'ml_ts';
	const USERS = 'users';
	const WIKI_URL = 'wiki_url';

	/** @var string $target */
	private $target;
	/** @var MultiLookupRowFormatter $formatter */
	private $formatter;

	public function __construct( IContextSource $context, $target ) {
		global $wgSpecialsDB;
		parent::__construct( $context );

		$this->target = inet_pton( $target );
		$this->mDb = wfGetDB( DB_SLAVE, [], $wgSpecialsDB );
		$this->formatter = new MultiLookupRowFormatter( $context );
	}

	/**
	 * This function should be overridden to provide all parameters
	 * needed for the main paged query. It returns an associative
	 * array with the following elements:
	 *    tables => Table(s) for passing to Database::select()
	 *    fields => Field(s) for passing to Database::select(), may be *
	 *    conds => WHERE conditions
	 *    options => option array
	 *    join_conds => JOIN conditions
	 *
	 * @return array
	 */
	function getQueryInfo() {
		return [
			'tables' => [ 'multilookup' ],
			'fields' => '*',
			'conds' => [
				'ml_ip_bin' => $this->target
			],
		];
	}

	/**
	 * Get per-wiki info for each row
	 * @param array|object $row
	 * @return string
	 */
	function formatRow( $row ) {
		$wiki = WikiFactory::getWikiByID( $row->ml_city_id );

		if ( $wiki ) {
			$row->users = $this->getWikiUsers($wiki->city_dbname, $wiki->city_path === 'slot2');
			$row->wiki_url = $wiki->city_url;

			return parent::formatRow( $row );
		}

		return '';
	}

	/**
	 * Get recent contributors that used this IP address on a wiki
	 * @param string $dbName
	 * @param bool $isUcpWiki
	 * @return string[] array of user names and IP addresses
	 */
	private function getWikiUsers( $dbName, $isUcpWiki ) {
		$userIp = inet_ntop( $this->target );
		$cacheKey = wfSharedMemcKey( 'multilookup', $userIp, $dbName );

		$conds = $isUcpWiki ? [ 'rc_ip' => $userIp ] : [ 'rc_ip_bin' => $this->target ];

		return WikiaDataAccess::cache( $cacheKey,60 * 15 /* 15 mins */, function () use ( $dbName, $userIp, $conds ) {
			$dbr = wfGetDB( DB_SLAVE, [], $dbName );

			$res = $dbr->select(
				[ 'recentchanges' ],
				[ 'rc_user as user_id' ],
				$conds,
				__METHOD__,
				[ 'DISTINCT' ]
			);

			$users = [];
			foreach ( $res as $user ) {
				// SUS-812: use username lookup - user ID for registered users, IP address for anons
				$userName = User::getUsername( $user->user_id, $userIp );

				$users[] = $userName;
			}

			return $users;
		} );
	}

	/**
	 * Return true if the named field should be sortable by the UI, false
	 * otherwise
	 * Always false - we use frontend sorting
	 *
	 * @param $field String
	 * @return bool
	 */
	function isFieldSortable( $field ) {
		return false;
	}

	function getTableClass() {
		return 'ml-table wikitable sortable';
	}

	/**
	 * Ensure that results are sortable by timestamp
	 *
	 * @param String $field
	 * @param String $value
	 * @return array
	 */
	function getCellAttrs( $field, $value ) {
		if ( $field === static::ML_TIMESTAMP ) {
			return [ 'data-sort-value' => wfTimestamp( TS_UNIX, $value ) ];
		}

		return [];
	}

	/**
	 * Format a table cell. The return value should be HTML, but use an empty
	 * string not &#160; for empty cells. Do not include the <td> and </td>.
	 *
	 * The current result row is available as $this->mCurrentRow, in case you
	 * need more context.
	 *
	 * @param $name String: the database field name
	 * @param $value String: the value retrieved from the database
	 * @return string
	 */
	function formatValue( $name, $value ) {
		switch ( $name ) {
			case static::WIKI_URL:
				return $this->formatter->formatWikiUrl( $value );
			case static::ML_TIMESTAMP:
				return $this->formatter->formatTimestamp( $value );
			case static::USERS:
				return $this->formatter->formatUsers( $this->mCurrentRow );
			default:
				return '';
		}
	}

	/**
	 * The database field name used as a default sort order
	 */
	function getDefaultSort() {
		return static::ML_TIMESTAMP;
	}

	/**
	 * Ensure that results are sorted descending by default
	 * @return bool true
	 */
	protected function getDefaultDirections() {
		return true;
	}

	/**
	 * An array mapping database field names to a textual description of the
	 * field name, for use in the table header. The description should be plain
	 * text, it will be HTML-escaped later.
	 *
	 * @return array
	 */
	function getFieldNames() {
		return [
			static::WIKI_URL => $this->msg( 'multilookupwikiurl' )->text(),
			static::ML_TIMESTAMP => $this->msg( 'multilookuplastedithdr' )->text(),
			static::USERS => $this->msg( 'multilookupdetails' )->text(),
		];
	}
}
