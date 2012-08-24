<?php
/**
 * @desc Class which is handling logic operations connected to users groups and displaying them in user masthead (two "tags" at most)
 */
class UserTwoTagsStrategy extends UserOneTagStrategy {
	/**
	 * Used to compare user rights in UserIdentityBox::sortUserGroups()
	 * @var array
	 */
	protected $groupsRank = array(
		'sysop' => 5,
		'helper' => 4,
		'vstf' => 3,
		'council' => 2,
		'chatmoderator' => 1,
	);

	/**
	 * @return array
	 */
	public function getUserTags() {
		$this->app->wf->ProfileIn(__METHOD__);

		$tags = array();
		if( $this->isBlocked() ) {
			//blocked user has only one tag displayed "Blocked"
			$tags[] = $this->app->wf->Msg('user-identity-box-group-blocked');
		} else {
			$this->getFirstTag($tags);

			if( $this->isFounder() ) {
				$tags[] = $this->app->wf->Msg('user-identity-box-group-founder');
			} else {
				$this->getTagFromGroups($tags);
			}
		}

		$this->app->wf->ProfileOut(__METHOD__);
		return $tags;
	}

	/**
	 * @desc Puts "Staff" or "Authenticated" at the begining in user's tags
	 *
	 * @param Array $tags should be an empty array
	 * @return bool
	 */
	protected function getFirstTag(&$tags) {
		if( $this->isUserInGroup(self::WIKIA_GROUP_STAFF_NAME) ) {
			array_unshift($tags, $this->app->wf->Msg('user-identity-box-group-' .  self::WIKIA_GROUP_STAFF_NAME));
		} else if( $this->isUserInGroup(self::WIKIA_GROUP_AUTHENTICATED_NAME) ) {
			array_unshift($tags, $this->app->wf->Msg('user-identity-box-group-' . self::WIKIA_GROUP_AUTHENTICATED_NAME));
		}
	}
}
