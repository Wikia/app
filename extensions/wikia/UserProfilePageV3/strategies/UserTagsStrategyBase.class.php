<?php
/**
 * @desc Base class for handling user "tags" logic in user masthead
 */
abstract class UserTagsStrategyBase {
	protected $app;
	/** @var User */
	protected $user;

	//instance cache for UserTwoTagsStrategy::getUsersEffectiveGroups()
	protected $usersEffectiveGroups = null;

	//TODO: reuse consts -- are there substitutes?
	const WIKIA_GROUP_STAFF_NAME = 'staff';
	const WIKIA_GROUP_AUTHENTICATED_NAME = 'authenticated';
	const WIKIA_GROUP_SYSOP_NAME = 'sysop';
	const WIKIA_GROUP_BUREAUCRAT_NAME = 'bureaucrat';
	const WIKIA_GROUP_WIKIA_STAR = 'wikiastars';

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
		wfProfileIn(__METHOD__);

		// check if the user is blocked locally, if not, also check if they're blocked globally (via Phalanx)
		$isBlocked = $this->user->isBlocked( true, false) || $this->user->isBlockedGlobally();

		if( $isBlocked && !$this->isUserInGroup(self::WIKIA_GROUP_STAFF_NAME) ) {
			wfProfileOut(__METHOD__);
			return true;
		}

		wfProfileOut(__METHOD__);
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
		wfProfileIn(__METHOD__);

		$wiki = WikiFactory::getWikiById($this->app->wg->CityId);
		if( intval($wiki->city_founding_user) === $this->user->GetId() ) {
			// mech: BugId 18248
			$founder = $this->isUserInGroup(self::WIKIA_GROUP_SYSOP_NAME) || $this->isUserInGroup(self::WIKIA_GROUP_BUREAUCRAT_NAME);

			wfProfileOut(__METHOD__);
			return $founder;
		}

		wfProfileOut(__METHOD__);
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
		if( !isset($this->groupsRank[$group1]) && !isset($this->groupsRank[$group2]) ) {
			$result = 0;
		} elseif( !isset($this->groupsRank[$group1]) && isset($this->groupsRank[$group2]) ) {
			$result = 1;
		} elseif( !isset($this->groupsRank[$group2]) && isset($this->groupsRank[$group1]) ) {
			$result = -1;
		} else {
			$result = ($this->groupsRank[$group1] < $this->groupsRank[$group2]) ? 1 : -1;
		}

		return $result;
	}

	/**
	 * @return string
	 */
	protected function getTagFromGroups() {
		wfProfileIn(__METHOD__);

		$result = '';
		$group = $this->getUsersHighestGroup($this->user);
		if( $group ) {
			$result = wfMessage('user-identity-box-group-' . $group)->escaped();
		}

		/* See if user is banned from chat */
		if (!empty($this->app->wg->EnableChat) && (new ChatUser($this->user))->isBanned() ) {
			$result = wfMsg('user-identity-box-banned-from-chat');
		}

		wfProfileOut(__METHOD__);
		return $result;
	}

	/**
	 * @brief Gets string with user most important group
	 *
	 * @return string | boolean
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	protected function getUsersHighestGroup() {
		wfProfileIn(__METHOD__);

		$userGroups = $this->getUsersEffectiveGroups();
		wfProfileIn(__METHOD__.'-sort');
		usort($userGroups, array($this, 'sortUserGroups'));
		wfProfileOut(__METHOD__.'-sort');


		//just a regular member by default
		$group = false;

		if (isset($userGroups[0]) && in_array($userGroups[0], array_keys($this->groupsRank))) {
			$group = $userGroups[0];
		}

		wfProfileOut(__METHOD__);
		return $group;
	}

}
