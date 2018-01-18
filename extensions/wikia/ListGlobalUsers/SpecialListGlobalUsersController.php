<?php

use Wikia\Service\User\Permissions\PermissionsServiceAccessor;

class SpecialListGlobalUsersController extends WikiaSpecialPageController {
	const GROUPS_SELECTED_BY_DEFAULT = [ 'global-discussions-moderator', 'helper', 'staff', 'vanguard', 'vstf' ];

	use PermissionsServiceAccessor;

	public function __construct() {
		parent::__construct( 'ListGlobalUsers' );
	}

	public function index() {
		$this->setHeaders();
		$this->response->setFormat( WikiaResponse::FORMAT_HTML );

		$this->getContext()->getOutput()->addModules( 'ext.wikia.ListGlobalUsers' );

		$permissionsConfiguration = $this->permissionsService()->getConfiguration();
		$queryGroups = $this->request->getArray( 'groups' );

		// support querying for single group passed as special page /parameter
		if ( !empty( $this->getPar() ) ) {
			$queryGroups[] = $this->getPar();
		}

		$globalGroups = array_diff(
			$permissionsConfiguration->getGlobalGroups(),
			$permissionsConfiguration->getImplicitGroups()
		);

		asort( $globalGroups );

		$groupsToSelect = array_intersect( $globalGroups, $queryGroups ) ?: static::GROUPS_SELECTED_BY_DEFAULT;

		$groupNameCheckBoxSet = [];

		foreach ( $globalGroups as $groupName ) {
			$groupNameCheckBoxSet[] = [
				'groupName' => $groupName,
				'groupId' => "mw-input-groups-$groupName",
				'groupLabel' => User::getGroupName( $groupName ),
				'checked' => in_array( $groupName, $groupsToSelect ) ? 'checked' : ''
			];
		}

		$this->setVal( 'formAction', $this->getTitle()->getLocalURL() );
		$this->setVal( 'groupNameCheckBoxSet', $groupNameCheckBoxSet );

		$userSet = [];
		if ( !empty( $groupsToSelect ) ) {
			$databaseService = new DatabaseGlobalUsersService();
			$cachedService = new CachedGlobalUsersService( $this->wg->Memc, $databaseService );

			$userSet = $cachedService->getGroupMembers( $groupsToSelect );
		}

		$this->setVal( 'userSet', $userSet );
	}
}
