<?php

/**
 * API module which returns list of users' first edits, including revision id, date and user name
 * @ingroup API
 */
class ApiQueryFirstEdits extends ApiQueryBase {

	public function __construct( ApiBase $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'fe' );
	}

	public function execute() {
		$params = $this->extractRequestParams();

		$this->addTables( 'recentchanges' );

		$this->addFields( 'MIN(rc_this_oldid) as diff_id' );
		$this->addFields( 'MIN(rc_timestamp) as diff_timestamp' );
		$this->addFields( 'rc_user_text' );

		$this->addWhere( 'rc_type < ' . RC_MOVE );
		$this->addTimestampWhereRange( 'rc_timestamp', $params['dir'], $params['start'], $params['end'] );

		$this->addOption( 'GROUP BY', 'rc_user' );
		$this->addOption( 'LIMIT', $params['limit'] + 1 );

		$res = $this->select( __METHOD__ );
		$result = $this->getResult();
		$count = 0;
		/** @var stdClass $row */
		foreach ( $res as $row ) {
			$count++;
			if ( $count >= $params['limit'] ) {
				$this->setContinueEnumParameter( 'start', wfTimestamp( TS_ISO_8601, $row->diff_timestamp ) );
				break;
			}

			$editInfo = $this->parseEditInfo( $row );
			$fit = $result->addValue( [ 'query', $this->getModuleName() ], null, $editInfo );
			if ( !$fit ) {
				$this->setContinueEnumParameter( 'start', wfTimestamp( TS_ISO_8601, $row->diff_timestamp ) );
				break;
			}
		}

		$result->setIndexedTagName_internal( [ 'query', $this->getModuleName() ], 'firstedits' );

		// TODO: Investigate how to invalidate cache of MW API on demand (as with Nirvana)
		//$this->getMain()->setCacheMode( 'public' );
		//$this->getMain()->setCacheMaxAge( WikiaResponse::CACHE_STANDARD );
	}

	/**
	 * Process a result row and convert it into a format suitable for output
	 *
	 * @param stdClass $row DB result row
	 * @return array
	 */
	private function parseEditInfo( $row ) {
		return [
			'id' => $row->diff_id,
			'date' => wfTimestamp( TS_ISO_8601, $row->diff_timestamp ),
			'username' => $row->rc_user_text
		];
	}

	public function getVersion() {
		return __CLASS__. 'v1';
	}

	public function getAllowedParams() {
		return [
			'start' => [
				ApiBase::PARAM_TYPE => 'timestamp'
			],
			'end' => [
				ApiBase::PARAM_TYPE => 'timestamp'
			],
			'dir' => [
				ApiBase::PARAM_TYPE => [ 'newer', 'older' ]
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
		$p = $this->getModulePrefix();

		return [
			'start' => 'The timestamp to start enumerating from',
			'end' => 'The timestamp to stop enumerating at',
			'dir' => $this->getDirectionDescription( $p ),
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
}
