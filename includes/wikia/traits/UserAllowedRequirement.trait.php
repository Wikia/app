<?php
/**
 * UserAccess
 *
 * decide if a user is allowed to access a particular resource
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

trait UserAllowedRequirement {
	protected $userAccessDefaultRequirement;

	/**
	 * mapping of actions and the permissions they require (if they are different than the default). permission values
	 * can be either a string (for a single permission) or an array (for group of permissions)
	 * @return array
	 */
	protected function userAllowedRequirementMapping() {
		return [];
	}

	protected function userAccessRequirementDefault($requirement) {
		$this->userAccessDefaultRequirement = $requirement;
	}

	public function userAllowedRequirementCheck( User $user, $action ) {
		$result = false;
		$mapping = $this->userAllowedRequirementMapping();

		$requiredPerms = array_key_exists($action, $mapping) ? $mapping[$action] : $this->userAccessDefaultRequirement;

		if (!is_array($requiredPerms)) {
			$requiredPerms = [$requiredPerms];
		}

		foreach ($requiredPerms as $perm) {
			if (!$user->isAllowed($perm)) {
				$result = true;
				$this->onUserAllowedRequirementFailed($user, $requiredPerms);
			}
		}

		return $result;
	}

	protected function onUserAllowedRequirementFailed(User $user) {
	}
}

trait UserAllowedRequirementThrowsError {
	use UserAllowedRequirement;

	protected function onUserAllowedRequirementFailed(User $user, $perms) {
		throw new PermissionsError(implode(', ', $perms));
	}
}