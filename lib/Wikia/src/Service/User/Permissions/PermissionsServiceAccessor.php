<?php

namespace Wikia\Service\User\Permissions;

use Wikia\DependencyInjection\Injector;

trait PermissionsServiceAccessor {

	/**
	 * @var PermissionsService
	 */
	private $permissionsService;

	/**
	 * @return PermissionsService
	 */
	protected function permissionsService() {
		if ( is_null( $this->permissionsService ) ) {
			$this->permissionsService = Injector::getInjector()->get( PermissionsService::class );
		}

		return $this->permissionsService;
	}
} 