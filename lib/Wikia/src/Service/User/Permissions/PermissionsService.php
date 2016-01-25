<?php

namespace Wikia\Service\User\Permissions;

interface PermissionsService {
	public function getGlobalGroups();

	public function getImplicitGroups();

	public function getExplicitUserGroups( $cityId, $userId );

	public function getExplicitGlobalUserGroups( $userId );

	public function getExplicitLocalUserGroups( $cityId, $userId );

	public function getEffectiveUserGroups( $cityId, \User $user, $reCacheAutomaticGroups = false );

	public function getAutomaticUserGroups( \User $user, $reCacheAutomaticGroups = false );

}
