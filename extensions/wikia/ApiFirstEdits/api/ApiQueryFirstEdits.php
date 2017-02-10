<?php

/**
 * API module which returns list of users' first edits, including revision id, date and user name
 * @ingroup API
 */
class ApiQueryFirstEdits extends ApiQueryBase {

	/**
	 * @var int MAX_INTERVAL_SINCE_LAST_EDIT
	 * Maximum time that can elapse since an user's last edit.
	 * If an user edits after not editing for at least this long, they'll be considered a new user.
	 */
	const MAX_INTERVAL_SINCE_LAST_EDIT = 31536000;

	public function __construct( ApiBase $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'fe' );
	}

	public function execute() {
		$params = $this->extractRequestParams();

		$this->addTables( [ 'recentchanges', 'revision' ] );

		$this->addFields( 'MIN(rc_this_oldid) as diff_id' );
		$this->addFields( 'MIN(rc_timestamp) as diff_timestamp' );
		$this->addFields( 'rc_user_text' );

		$this->addWhere( 'rc_type < ' . RC_MOVE );

		//$from = $this->getFromTimestamp( $params['before'] );
		//$this->addTimestampWhereRange( 'rc_timestamp', null, $from, $params['before'] );

		$this->addJoinConds( [ 'revision' => [ 'INNER JOIN', 'rc_this_oldid = rev_id' ] ] );
		$this->addOption( 'GROUP BY', 'rc_user' );
		$this->addOption( 'HAVING', 'diff_timestamp = MIN(rev_timestamp)' );
		$this->addOption( 'LIMIT', $params['limit'] + 1 );

		$res = $this->select( __METHOD__ );
		$result = $this->getResult();
		$count = 0;
		/** @var stdClass $row */
		foreach ( $res as $row ) {
			$count++;
			if ( $count >= $params['limit'] ) {
				$this->setContinueEnumParameter( 'before', wfTimestamp( TS_ISO_8601, $row->diff_timestamp ) );
				break;
			}

			$editInfo = [
				'id' => $row->diff_id,
				'date' => wfTimestamp( TS_ISO_8601, $row->diff_timestamp ),
				'username' => $row->rev_user_text
			];

			$fit = $result->addValue( [ 'query', $this->getModuleName() ], null, $editInfo );
			if ( !$fit ) {
				$this->setContinueEnumParameter( 'before', wfTimestamp( TS_ISO_8601, $row->diff_timestamp ) );
				break;
			}
		}

		$result->setIndexedTagName_internal( [ 'query', $this->getModuleName() ], 'firstedits' );

		// cache for 1 day
		$this->getMain()->setCacheMode( 'public' );
		$this->getMain()->setCacheMaxAge( WikiaResponse::CACHE_STANDARD );

		// use surrogate key for easy cache invalidation
		$this->getOutput()->tagWithSurrogateKeys( static::getSurrogateKey() );
	}

	/**
	 * Return earliest date from which to enumerate first edits
	 *
	 * @param string|null $end only enumerate users who joined before this date, or null to use present date
	 * @return int Unix timestamp
	 */
	private function getFromTimestamp( $end ) {
		if ( is_null( $end ) ) {
			$end = time();
		} else {
			$end = wfTimestamp( TS_UNIX, $end );
		}

		return $end - static::MAX_INTERVAL_SINCE_LAST_EDIT;
	}

	public function getVersion() {
		return __CLASS__. 'v1';
	}

	public function getAllowedParams() {
		return [
			'before' => [
				ApiBase::PARAM_TYPE => 'timestamp'
			],
			'limit' => [
				ApiBase::PARAM_DFLT => 10,
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 => ApiBase::LIMIT_BIG2
			],
		];
	}

	public function getParamDescription() {
		return [
			'before' => 'Only enumerate users who joined before this date',
			'limit' => 'The maximum amount of entries to list',
		];
	}

	public function getDescription() {
		return 'Returns the first edit of users on this wiki, including user name, diff id and timestamp';
	}

	public function getExamples() {
		return [
			'api.php?action=query&list=firstedits',
			'api.php?action=query&list=firstedits&fedir=newer'
		];
	}

	/**
	 * Returns surrogate key used to tag all responses of this module so that they can be easily invalidated
	 * @return string
	 */
	public static function getSurrogateKey() {
		return Wikia::surrogateKey( __CLASS__ );
	}
}
