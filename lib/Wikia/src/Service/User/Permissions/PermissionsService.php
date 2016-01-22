<?php

namespace Wikia\Service\User\Permissions;

interface PermissionsService {
	public function getExplicitUserGroups( $cityId, \User $user );

	public function getEffectiveUserGroups( $cityId, \User $user, $reCacheAutomaticGroups = false );

	public function getAutomaticUserGroups( \User $user, $reCacheGroups = false );
}
