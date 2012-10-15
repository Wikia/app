<?php

/**
 * CheckUser API Query Module
 */
class ApiQueryCheckUser extends ApiQueryBase {
	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'cu' );
	}

	public function execute() {
		global $wgUser, $wgCheckUserForceSummary;

		$db = $this->getDB( DB_SLAVE );
		$params = $this->extractRequestParams();

		list( $request, $target, $reason, $timecond, $limit, $xff ) = array(
			$params['request'], $params['target'], $params['reason'],
			$params['timecond'], $params['limit'], $params['xff'] );

		if ( !$wgUser->isAllowed( 'checkuser' ) ) {
			$this->dieUsage( 'You need the checkuser right', 'permissionerror' );
		}

		if ( $wgCheckUserForceSummary && is_null( $reason ) ) {
			$this->dieUsage( 'You must define reason for check', 'missingdata' );
		}

		$reason = wfMsgForContent( 'checkuser-reason-api', $reason );
		$timeCutoff = strtotime( $timecond ); // absolute time
		if ( !$timeCutoff ) {
			$this->dieUsage( 'You need use correct time limit (like "2 weeks")', 'invalidtime' );
		}

		$this->addTables( 'cu_changes' );
		$this->addOption( 'LIMIT', $limit + 1 );
		$this->addOption( 'ORDER BY', 'cuc_timestamp DESC' );
		$this->addWhere( "cuc_timestamp > " . $db->addQuotes( $db->timestamp( $timeCutoff ) ) );

		switch ( $request ) {
			case 'userips':
				$user_id = User::idFromName( $target );
				if ( !$user_id ) {
					$this->dieUsage( 'Target user does not exist', 'nosuchuser' );
				}

				$this->addFields( array( 'cuc_timestamp', 'cuc_ip', 'cuc_xff' ) );
				$this->addWhereFld( 'cuc_user_text', $target );
				$res = $this->select( __METHOD__ );
				$result = $this->getResult();

				$ips = array();
				foreach ( $res as $row ) {
					$timestamp = wfTimestamp( TS_ISO_8601, $row->cuc_timestamp );
					$ip = strval( $row->cuc_ip );

					if ( !isset( $ips[$ip] ) ) {
						$ips[$ip]['end'] = $timestamp;
						$ips[$ip]['editcount'] = 1;
					} else {
						$ips[$ip]['start'] = $timestamp;
						$ips[$ip]['editcount']++;
					}
				}

				$resultIPs = array();
				foreach ( $ips as $ip => $data ) {
					$data['address'] = $ip;
					$resultIPs[] = $data;
				}

				CheckUser::addLogEntry( 'userips', 'user', $target, $reason, $user_id );
				$result->addValue( array( 
					'query', $this->getModuleName() ), 'userips', $resultIPs );
				$result->setIndexedTagName_internal( array( 
					'query', $this->getModuleName(), 'userips' ), 'ip' );
				break;

			case 'edits':
				if ( IP::isIPAddress( $target ) ) {
					$cond = CheckUser::getIpConds( $db, $target, isset( $xff ) );
					if ( !$cond ) {
						$this->dieUsage( 'IP or range is invalid', 'invalidip' );
					}
					$this->addWhere( $cond );
					$log_type = array();
					if ( isset( $xff ) ) {
						$log_type[] = 'ipedits-xff';
					} else {
						$log_type[] = 'ipedits';
					}
					$log_type[] = 'ip' ;
				} else {
					$user_id = User::idFromName( $target );
					if ( !$user_id ) {
						$this->dieUsage( 'Target user does not exists', 'nosuchuser' );
					}
					$this->addWhereFld( 'cuc_user_text', $target );
					$log_type = array( 'useredits', 'user' );
				}

				$this->addFields( array( 
					'cuc_namespace', 'cuc_title', 'cuc_user_text', 'cuc_actiontext',
					'cuc_comment', 'cuc_minor', 'cuc_timestamp', 'cuc_ip', 'cuc_xff', 'cuc_agent' 
				) );

				$res = $this->select( __METHOD__ );
				$result = $this->getResult();

				$edits = array();
				foreach ( $res as $row ) {
					$edit = array(
						'timestamp' => wfTimestamp( TS_ISO_8601, $row->cuc_timestamp ),
						'ns'        => intval( $row->cuc_namespace ),
						'title'     => $row->cuc_title,
						'user'      => $row->cuc_user_text,
						'ip'        => $row->cuc_ip,
						'agent'     => $row->cuc_agent,
					);
					if ( $row->cuc_actiontext ) {
						$edit['summary'] = $row->cuc_actiontext;
					} elseif ( $row->cuc_comment ) {
						$edit['summary'] = $row->cuc_comment;
					}
					if ( $row->cuc_minor ) {
						$edit['minor'] = 'm';
					}
					if ( $row->cuc_xff ) {
						$edit['xff'] = $row->cuc_xff;
					}
					$edits[] = $edit;
				}

				CheckUser::addLogEntry( $log_type[0], $log_type[1], 
					$target, $reason, isset($user_id) ? $user_id : '0' );
				$result->addValue( array( 
					'query', $this->getModuleName() ), 'edits', $edits );
				$result->setIndexedTagName_internal( array(
					'query', $this->getModuleName(), 'edits' ), 'action' );
				break;

			case 'ipusers':
				if ( IP::isIPAddress( $target )  ) {
					$cond = CheckUser::getIpConds( $db, $target, isset( $xff ) );
					$this->addWhere( $cond );
					$log_type = 'ipusers';
					if ( isset( $xff ) ) {
						$log_type .= '-xff';
					}
				} else {
					$this->dieUsage( 'IP or range is invalid', 'invalidip' );
				}

				$this->addFields( array( 
					'cuc_user_text', 'cuc_timestamp', 'cuc_ip', 'cuc_agent' ) );

				$res = $this->select( __METHOD__ );
				$result = $this->getResult();

				$users = array();
				foreach ( $res as $row ) {
					$user = $row->cuc_user_text;
					$ip = $row->cuc_ip;
					$agent = $row->cuc_agent;

					if ( !isset( $users[$user] ) ) {
						$users[$user]['end'] = wfTimestamp( TS_ISO_8601, $row->cuc_timestamp );
						$users[$user]['editcount'] = 1;
						$users[$user]['ips'][] = $ip;
						$users[$user]['agents'][] = $agent;
					} else {
						$users[$user]['start'] = wfTimestamp( TS_ISO_8601, $row->cuc_timestamp );
						$users[$user]['editcount']++;
						if ( !in_array( $ip, $users[$user]['ips'] ) ) {
							$users[$user]['ips'][] = $ip;
						}
						if ( !in_array( $agent, $users[$user]['agents'] ) ) {
							$users[$user]['agents'][] = $agent;
						}
					}
				}

				$resultUsers = array();
				foreach ( $users as $userName => $userData ) {
					$userData['name'] = $userName;
					$result->setIndexedTagName( $userData['ips'], 'ip' );
					$result->setIndexedTagName( $userData['agents'], 'agent' );

					$resultUsers[] = $userData;
				}

				CheckUser::addLogEntry( $log_type, 'ip', $target, $reason );
				$result->addValue( array( 
					'query', $this->getModuleName() ), 'ipusers', $resultUsers );
				$result->setIndexedTagName_internal( array( 
					'query', $this->getModuleName(), 'ipusers' ), 'user' );
				break;

			default:
				$this->dieUsage( 'Invalid request mode', 'invalidmode' );
		}
	}

	public function mustBePosted() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	public function getAllowedParams() {
		return array(
			'request'  => array(
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_TYPE => array(
					'userips',
					'edits',
					'ipusers',
				)
			),
			'target'   => array(
				ApiBase::PARAM_REQUIRED => true,
			),
			'reason'   => null,
			'limit'    => array(
				ApiBase::PARAM_DFLT => 1000,
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_MIN  => 1,
				ApiBase::PARAM_MAX  => 500,
				ApiBase::PARAM_MAX2 => 5000,
			),
			'timecond' => array(
				ApiBase::PARAM_DFLT => '-2 weeks'
			),
			'xff'      => null,
		);
	}

	public function getParamDescription() {
		return array(
			'request'  => array(
				'Type of CheckUser request',
				' userips - get IP of target user',
				' edits   - get changes from target IP or range',
				' ipusers - get users from target IP or range',
			),
			'target'   => "Username or IP-address/range to perform check",
			'reason'   => 'Reason to check',
			'limit'    => 'Limit of rows',
			'timecond' => 'Time limit of user data (like "2 weeks")',
			'xff'      => 'Use xff data instead of IP',
		);
	}

	public function getDescription() {
		return 'Allows check which IPs are used by a given username and which usernames are used by a given IP';
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(),
			array(
				array( 'nosuchuser' ),
				array( 'invalidip' ),
				array( 'permissionerror' ),
				array( 'invalidmode' ),
				array( 'missingdata' ),
			)
		);
	}

	public function getExamples() {
		return array(
			'api.php?action=query&list=checkuser&curequest=userips&cutarget=Jimbo_Wales',
			'api.php?action=query&list=checkuser&curequest=edits&cutarget=127.0.0.1/16&xff=1&cureason=Some_check',
		);
	}

	public function getHelpUrls() {
		return 'http://www.mediawiki.org/wiki/Extension:CheckUser#API';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryCheckUser.php 110807 2012-02-06 23:58:27Z aaron $';
	}
}
