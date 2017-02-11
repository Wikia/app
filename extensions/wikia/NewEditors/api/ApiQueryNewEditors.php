<?php

/**
 * API module which returns list of users' first edits, including revision id, date and user name
 * @ingroup API
 */
class ApiQueryNewEditors extends ApiQueryBase {

	public function __construct( ApiBase $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'fe' );
	}

	public function execute() {
		$params = $this->extractRequestParams();

		$this->addTables( 'recentchanges' );

		$this->addFields( 'rc_this_oldid as diff_id' );
		$this->addFields( 'rc_timestamp as diff_timestamp' );
		$this->addFields( 'rc_user_text as diff_author' );

		$this->addWhere( 'rc_type < ' . RC_MOVE );
		$this->addWhere( [ 'rc_bot' => 0 ] );

		$this->addTimestampWhereRange( 'rc_timestamp', $params['dir'], $params['after'], $params['before'] );

		$this->addOption( 'GROUP BY', 'rc_user' );
		$this->addOption( 'HAVING', 'diff_id = (SELECT min(rev_id) from revision where rev_user = rc_user)' );
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
				'username' => $row->diff_author
			];

			$fit = $result->addValue( [ 'query', $this->getModuleName() ], null, $editInfo );
			if ( !$fit ) {
				$this->setContinueEnumParameter( 'before', wfTimestamp( TS_ISO_8601, $row->diff_timestamp ) );
				break;
			}
		}

		$result->setIndexedTagName_internal( [ 'query', $this->getModuleName() ], 'firstedits' );

		$this->getMain()->setCacheMode( 'public' );
		$this->getMain()->setCacheMaxAge( WikiaResponse::CACHE_SHORT );
	}

	private function getMaximumRange() {
		global $wgRCMaxAge;
		return $wgRCMaxAge / 86400;
	}

	public function getVersion() {
		return __CLASS__. 'v1';
	}

	public function getAllowedParams() {
		return [
			'after' => [
				ApiBase::PARAM_TYPE => 'timestamp',
			],
			'before' => [
				ApiBase::PARAM_TYPE => 'timestamp'
			],
			'dir' => [
				ApiBase::PARAM_TYPE => [
					'newer',
					'older'
				],
				ApiBase::PARAM_DFLT => 'older'
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
		$prefix = $this->getModulePrefix();
		$days = $this->getMaximumRange();

		return [
			'after' => 'Only get users who joined after this date.',
			'before' => "Only get users who joined before this date. Can't be more than $days days before the present date.",
			'dir' => $this->getDirectionDescription( $prefix ),
			'limit' => 'The maximum amount of entries to list',
		];
	}

	public function getDescription() {
		$days = $this->getMaximumRange();
		return "Returns user name and first edit rev id and timestamp for new editors who first edited in the last $days days";
	}

	public function getExamples() {
		return [
			'api.php?action=query&list=neweditors',
			'api.php?action=query&list=neweditors&fedir=newer'
		];
	}
}
