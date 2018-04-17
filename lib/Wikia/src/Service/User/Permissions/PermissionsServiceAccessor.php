<?php

namespace Wikia\Service\User\Permissions;

use Wikia\Factory\ServiceFactory;

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
			$this->permissionsService = ServiceFactory::instance()->permissionsFactory()->permissionsService();
		}

		return $this->permissionsService;
	}
} 
