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
	
	private function getGlobalOrDefault( string $globalName ): array {
		return isset( $GLOBALS[$globalName] ) ? $GLOBALS[$globalName] : [];
	}

	public function permissionsConfiguration(): PermissionsConfiguration {
		if ( $this->permissionsConfiguration === null ) {
			$this->permissionsConfiguration = new PermissionsConfiguration(
					$this->getGlobalOrDefault( 'wgGroupPermissions' ),
					$this->getGlobalOrDefault( 'wgAddGroupsLocal' ),
					$this->getGlobalOrDefault( 'wgRemoveGroupsLocal' ),
					$this->getGlobalOrDefault( 'wgGroupsAddToSelfLocal' ),
					$this->getGlobalOrDefault( 'wgGroupsRemoveFromSelfLocal' ),
					$this->getGlobalOrDefault( 'wgRestrictedAccessGroups' ),
					$this->getGlobalOrDefault( 'wgRestrictedAccessExemptGroups' )
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
