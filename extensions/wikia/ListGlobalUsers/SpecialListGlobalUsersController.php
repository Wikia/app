<?php

use Wikia\Service\User\Permissions\PermissionsServiceAccessor;

class SpecialListGlobalUsersController extends WikiaSpecialPageController {
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

		$groupsToSelect = array_intersect( $globalGroups, $queryGroups );

		$groupNameForm = [];

		foreach ( $globalGroups as $groupName ) {
			$groupNameForm[] = [
				'groupName' => $groupName,
				'groupLabel' => User::getGroupName( $groupName ),
				'active' => in_array( $groupName, $groupsToSelect )
			];
		}

		$this->setVal( 'groupNameForm', $groupNameForm );

		$userSet = [];
		if ( !empty( $groupsToSelect ) ) {
			$databaseService = new DatabaseGlobalUsersService();
			$cachedService = new CachedGlobalUsersService( $this->wg->Memc, $databaseService );

			$userSet = $cachedService->getGroupMembers( $groupsToSelect );
		}

		$this->setVal( 'userSet', $userSet );
	}
}
