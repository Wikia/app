<?php

class ApiAbuseFilterCheckMatch extends ApiBase {
	public function execute() {
		$params = $this->extractRequestParams();
		$this->requireOnlyOneParameter( $params, 'vars', 'rcid', 'logid' );

		// "Anti-DoS"
		if ( !$this->getUser()->isAllowed( 'abusefilter-modify' ) ) {
			$this->dieUsageMsg( 'permissiondenied' );
		}

		if ( $params['vars'] ) {
			$vars = FormatJson::decode( $params['vars'], true );
		} elseif ( $params['rcid'] ) {
			$dbr = wfGetDB( DB_SLAVE );
			$row = $dbr->selectRow(
				'recentchanges',
				'*',
				array( 'rc_id' => $params['rcid'] ),
				__METHOD__
			);

			if ( !$row ) {
				$this->dieUsageMsg( array( 'nosuchrcid', $params['rcid'] ) );
			}

			$vars = AbuseFilter::getVarsFromRCRow( $row );
		} elseif ( $params['logid'] ) {
			$dbr = wfGetDB( DB_SLAVE );
			$row = $dbr->selectRow(
				'abuse_filter_log',
				'*',
				array( 'afl_id' => $params['logid'] ),
				__METHOD__
			);

			if ( !$row ) {
				$this->dieUsage(
					"There is no abuselog entry with the id ``{$params['logid']}''",
					'nosuchlogid'
				);
			}

			$vars = AbuseFilter::loadVarDump( $row->afl_var_dump );
		}

		if ( AbuseFilter::checkSyntax( $params[ 'filter' ] ) !== true ) {
			$this->dieUsage( 'The filter has invalid syntax', 'badsyntax' );
		}

		$result = AbuseFilter::checkConditions( $params['filter'], $vars );
		$this->getResult()->addValue(
			null,
			$this->getModuleName(),
			array( 'result' => $result )
		);
	}

	public function getAllowedParams() {
		return array(
			'filter' => array(
				ApiBase::PARAM_REQUIRED => true,
			),
			'vars' => null,
			'rcid' => array(
				ApiBase::PARAM_TYPE => 'integer'
			),
			'logid' => array(
				ApiBase::PARAM_TYPE => 'integer'
			),
		);
	}

	public function getParamDescription() {
		return array(
			'filter' => 'The full filter text to check for a match',
			'vars' => 'JSON encoded array of variables to test against',
			'rcid' => 'Recent change ID to check against',
			'logid' => 'Abuse filter log ID to check against',
		);
	}

	public function getDescription() {
		return array(
			'Check to see if an AbuseFilter matches a set of variables, edit'
			. 'or logged AbuseFilter event.',
			'vars, rcid or logid is required however only one may be used',
		);
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(),
			$this->getRequireOnlyOneParameterErrorMessages( array( 'vars', 'rcid', 'logid' ) ),
			array(
				array( 'permissiondenied' ),
				array( 'nosuchrcid' ),
				array( 'code' => 'nosuchlogid', 'info' => 'There is no abuselog entry with the id given' ),
				array( 'code' => 'badsyntax', 'info' => 'The filter has invalid syntax' ),
			)
		);
	}

	public function getExamples() {
		return array(
			'api.php?action=abusefiltercheckmatch&filter=!("autoconfirmed"%20in%20user_groups)&rcid=15'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiAbuseFilterCheckMatch.php 108852 2012-01-13 21:36:51Z reedy $';
	}
}
