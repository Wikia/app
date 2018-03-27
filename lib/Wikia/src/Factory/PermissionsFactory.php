<?php
namespace Wikia\Factory;

use Wikia\Service\User\Permissions\PermissionsConfiguration;
use Wikia\Service\User\Permissions\PermissionsService;

class PermissionsFactory extends AbstractFactory {
	/** @var PermissionsConfiguration $permissionsConfiguration */
	private $permissionsConfiguration;

	/** @var PermissionsService */
	private $permissionsService;

	public function setPermissionsService( PermissionsService $permissionsService ) {
		$this->permissionsService = $permissionsService;
	}

	public function permissionsConfiguration(): PermissionsConfiguration {
		if ( $this->permissionsConfiguration === null ) {
			$this->permissionsConfiguration = new PermissionsConfiguration(
					$GLOBALS['wgGroupPermissions'] ?: [],
					$GLOBALS['wgAddGroupsLocal'] ?: [],
					$GLOBALS['wgRemoveGroupsLocal'] ?: [],
					$GLOBALS['wgGroupsAddToSelfLocal'] ?: [],
					$GLOBALS['wgGroupsRemoveFromSelfLocal'] ?: [],
					$GLOBALS['wgRestrictedAccessGroups'] ?: [],
					$GLOBALS['wgRestrictedAccessExemptGroups'] ?: []
				);
		}

		return $this->permissionsConfiguration;
	}

	public function permissionsService(): PermissionsService {
		if ( $this->permissionsService === null ) {
			$this->permissionsService = new PermissionsService( $this->permissionsConfiguration() );
		}

		return $this->permissionsService;
	}
}
