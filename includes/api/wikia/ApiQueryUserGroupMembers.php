<?php

/**
 * SUS-3109: API module to get users who are members of some user group
 */
class ApiQueryUserGroupMembers extends ApiQueryBase {
	use \Wikia\Service\User\Permissions\PermissionsServiceAccessor;

	public function __construct( ApiBase $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'gm' );
	}

	public function execute() {
		$params = $this->extractRequestParams();

		if ( empty( $params['groups'] ) ) {
			$this->dieUsageMsg( [ 'missingparam', 'groups' ] );
		}

		$groupMembers = $this->permissionsService()->getUsersInGroups( $params['groups'] );
		ksort( $groupMembers );
		$userNames = User::whoAre( array_keys( $groupMembers ) );

		$result = $this->getResult();
		$count = 0;

		foreach ( $groupMembers as $userId => $userGroups ) {
			// If the offset param is set, we must display only results that come after it
			if ( !empty( $params['offset'] ) && $userId < $params['offset'] ) {
				continue;
			}

			$count++;
			if ( $count > $params['limit'] ) {
				$this->setContinueEnumParameter( 'offset', $userId );
				break;
			}

			$row = [
				'userid' => $userId,
				'name' => $userNames[$userId],
				'groups' => $userGroups
			];

			$result->setIndexedTagName( $row['groups'], 'g' );

			if ( !$result->addValue( 'users', null, $row ) ) {
				$this->setContinueEnumParameter( 'offset', $userId );
				break;
			}
		}

		$result->setIndexedTagName_internal( 'users', 'user' );
	}

	protected function getAllowedParams() {
		return [
			'groups' => [
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_ISMULTI => true,
			],
			'offset' => [
				ApiBase::PARAM_TYPE => 'integer',
			],
			'limit' => [
				ApiBase::PARAM_DFLT => 10,
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 => ApiBase::LIMIT_BIG2,
			],
		];
	}

	public function getCacheMode( $params ) {
		return 'anon-public user-private';
	}

	protected function getParamDescription() {
		return [
			'groups' => 'List of user groups whose members to get',
			'offset' => 'Optional offset user ID parameter for paging',
			'limit' => 'Maximum number of results to return'
		];
	}

	public function getExamples() {
		return [
			'api.php?action=query&list=groupmembers&gmgroups=soap|staff&gmlimit=15',
			'api.php?action=query&list=groupmembers&gmgroups=sysop&gmoffset=999&',
		];
	}

	protected function getDescription() {
		return 'Get users who are members of one of the given group(s).';
	}

	public function getVersion() {
		return __CLASS__ . '-v1';
	}
}
