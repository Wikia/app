<?php

/**
 * CheckUser API Query Module
 */
class ApiQueryCheckUserLog extends ApiQueryBase {
	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'cul' );
	}

	public function execute() {
		global $wgUser;

		$params = $this->extractRequestParams();

		if ( !$wgUser->isAllowed( 'checkuser-log' ) ) {
			$this->dieUsage( 'You need the checkuser-log right', 'permissionerror' );
		}

		list( $user, $limit, $target, $from, $to ) = array( $params['user'], $params['limit'],
			$params['target'], $params['from'], $params['to'] );

		$this->addTables( 'cu_log' );
		$this->addOption( 'LIMIT', $limit + 1 );
		$this->addTimestampWhereRange( 'cul_timestamp', 'older', $from, $to );
		$this->addFields( array( 
			'cul_timestamp', 'cul_user_text', 'cul_reason', 'cul_type', 'cul_target_text' ) );

		if ( isset( $user ) ) {
			$this->addWhereFld( 'cul_user_text', $user );
		}
		if ( isset( $target ) ) {
			$this->addWhereFld( 'cul_target_text', $target );
		}

		$res = $this->select( __METHOD__ );
		$result = $this->getResult();

		$log = array();
		foreach ( $res as $row ) {
			$log[] = array(
				'timestamp' => wfTimestamp( TS_ISO_8601, $row->cul_timestamp ),
				'checkuser' => $row->cul_user_text,
				'type'      => $row->cul_type,
				'reason'    => $row->cul_reason,
				'target'    => $row->cul_target_text,
			);
		}

		$result->addValue( array( 'query', $this->getModuleName() ), 'entries', $log );
		$result->setIndexedTagName_internal( 
			array( 'query', $this->getModuleName(), 'entries' ), 'entry' );
	}

	public function getAllowedParams() {
		return array(
			'user'   => null,
			'target' => null,
			'limit'  => array(
				ApiBase::PARAM_DFLT => 10,
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_MIN  => 1,
				ApiBase::PARAM_MAX  => ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 => ApiBase::LIMIT_BIG2,
			),
			'from'  => array(
				ApiBase::PARAM_TYPE => 'timestamp',
			),
			'to'    => array(
				ApiBase::PARAM_TYPE => 'timestamp',
			),
		);
	}

	public function getParamDescription() {
		return array(
			'user'   => 'Username of CheckUser',
			'target' => "Checked user or IP-address/range",
			'limit'  => 'Limit of rows',
			'from'   => 'The timestamp to start enumerating from',
			'to'     => 'The timestamp to end enumerating',
		);
	}

	public function getDescription() {
		return 'Allows get entries of CheckUser log';
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(),
			array(
				array( 'permissionerror' ),
			)
		);
	}

	public function getExamples() {
		return array(
			'api.php?action=query&list=checkuserlog&culuser=WikiSysop&limit=25',
			'api.php?action=query&list=checkuserlog&cultarget=127.0.0.1&culfrom=20111015230000',
		);
	}

	public function getHelpUrls() {
		return 'http://www.mediawiki.org/wiki/Extension:CheckUser#API';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryCheckUserLog.php 110807 2012-02-06 23:58:27Z aaron $';
	}
}