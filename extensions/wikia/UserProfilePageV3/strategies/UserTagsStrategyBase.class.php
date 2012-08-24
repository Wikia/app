<?php
/**
 * @desc Base class for handling user "tags" logic in user masthead
 */
class UserTagsStrategyBase {
	protected $app;
	/** @var User */
	protected $user;

	//instance cache for UserTwoTagsStrategy::getUsersEffectiveGroups()
	protected $usersEffectiveGroups = null;

	const WIKIA_GROUP_STAFF_NAME = 'staff';
	const WIKIA_GROUP_AUTHENTICATED_NAME = 'authenticated';
	const WIKIA_GROUP_SYSOP_NAME = 'sysop';
	const WIKIA_GROUP_BUREAUCRAT_NAME = 'bureaucrat';

	/**
	 * Used to compare user groups
	 * @var array
	 */
	protected $groupsRank = array();

	public function __construct($user) {
		$this->app = F::app();
		$this->user = $user;
	}

	/**
	 * @desc Returns true if user is not a staff member and is blocked locally/globally
	 *
	 * @return bool
	 */
	protected function isBlocked() {
		$this->app->wf->ProfileIn(__METHOD__);

		// check if the user is blocked locally, if not, also check if they're blocked globally (via Phalanx)
		$isBlocked = $this->user->isBlocked() || $this->user->isBlockedGlobally();

		if( $isBlocked && !$this->isUserInGroup(self::WIKIA_GROUP_STAFF_NAME) ) {
			$this->app->wf->ProfileOut(__METHOD__);
			return true;
		}

		$this->app->wf->ProfileOut(__METHOD__);
		return false;
	}

	/**
	 * Checks if user is the founder
	 *
	 * @return boolean
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	protected function isFounder() {
		$this->app->wf->ProfileIn(__METHOD__);

		$wiki = F::build('WikiFactory', array($this->app->wg->CityId), 'getWikiById');
		if( intval($wiki->city_founding_user) === $this->user->GetId() ) {
			// mech: BugId 18248
			$founder = $this->isUserInGroup(self::WIKIA_GROUP_SYSOP_NAME) || $this->isUserInGroup(self::WIKIA_GROUP_BUREAUCRAT_NAME);

			$this->app->wf->ProfileOut(__METHOD__);
			return $founder;
		}

		$this->app->wf->ProfileOut(__METHOD__);
		return false;
	}

	/**
	 * @desc Returns instance cached version of user's effective groups not to call User::getEffectiveGroups too many times
	 *
	 * @return null | array
	 */
	protected function getUsersEffectiveGroups() {
		if( is_null($this->usersEffectiveGroups) ) {
			$this->usersEffectiveGroups = $this->user->getEffectiveGroups();
		}

		return $this->usersEffectiveGroups;
	}

	/**
	 * @desc Checks if user is in given user group
	 * @param String $userGroupName user group name in example: 'staff', 'authenticated' etc.
	 *
	 * @return bool
	 */
	protected function isUserInGroup($userGroupName) {
		if( !empty($userGroupName) ) {
			return in_array($userGroupName, $this->getUsersEffectiveGroups());
		}

		return false;
	}

	/**
	 * @brief Sorts user's groups as we want :>
	 *
	 * @desc Use this method in usort() to get "the most important" right in our scale. Our rank
	 * is defined as protected field $groupsRank. The most important has the highest value.
	 *
	 * @param string $group1 first user's group right to compare
	 * @param string $group2 second user's group right to compare
	 *
	 * @return int
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	protected function sortUserGroups($group1, $group2) {
		$this->app->wf->ProfileIn(__METHOD__);

		$result = 0; //means equal here
		if (!isset($this->groupsRank[$group1]) && isset($this->groupsRank[$group2])) {
			$result = 1;
		} else {
			if (isset($this->groupsRank[$group1]) && !isset($this->groupsRank[$group2])) {
				$result = -1;
			} else {
				if (isset($this->groupsRank[$group1]) && isset($this->groupsRank[$group2])) {
					$result = ($this->groupsRank[$group1] < $this->groupsRank[$group2]) ? 1 : -1;
				}
			}
		}

		$this->app->wf->ProfileOut(__METHOD__);
		return $result;
	}

	/**
	 * @param Array $tags
	 * @return string
	 */
	protected function getTagFromGroups( &$tags ) {
		$this->app->wf->ProfileIn(__METHOD__);

		$result = '';
		$group = $this->getUsersHighestGroup($this->user);
		if( $group ) {
			$result = $this->app->wf->Msg('user-identity-box-group-' . $group);
		}

		/* See if user is banned from chat */
		if (!empty($this->app->wg->EnableChat) && Chat::getBanInformation($this->app->wg->CityId, $this->user) !== false) {
			$result = wfMsg('user-identity-box-banned-from-chat');
		}

		if( !empty($result) ) {
			$tags[] = $result;
		}

		$this->app->wf->ProfileOut(__METHOD__);
	}

	/**
	 * @brief Gets string with user most important group
	 *
	 * @return string | boolean
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	protected function getUsersHighestGroup() {
		$this->app->wf->ProfileIn(__METHOD__);

		$userGroups = $this->getUsersEffectiveGroups();
		usort($userGroups, array($this, 'sortUserGroups'));

		if (isset($userGroups[0]) && in_array($userGroups[0], array_keys($this->groupsRank))) {
			$this->app->wf->ProfileOut(__METHOD__);
			$group = $userGroups[0];
		} else {
			//just a member
			$group = false;
		}

		$this->app->wf->ProfileOut(__METHOD__);
		return $group;
	}

}
