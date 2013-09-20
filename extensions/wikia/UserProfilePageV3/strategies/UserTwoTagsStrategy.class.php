<?php
/**
 * @desc Class which is handling logic operations connected to users groups and displaying them in user masthead (two "tags" at most)
 */
class UserTwoTagsStrategy extends UserTagsStrategyBase {
	/**
	 * Used to compare user rights in UserIdentityBox::sortUserGroups()
	 * @var array
	 */
	protected $groupsRank = array(
		'sysop' => 7,
		'helper' => 6,
		'adminmentor' => 5,
		'vstf' => 4,
		'voldev' => 3,
		'council' => 2,
		'chatmoderator' => 1,
	);

	/**
	 * @desc Returns at most two-elements array
	 *
	 * @return array
	 */
	public function getUserTags() {
		wfProfileIn(__METHOD__);

		$tags = array();
		if( $this->isBlocked() ) {
		//blocked user has only one tag displayed "Blocked"
			$tags[] = wfMsg('user-identity-box-group-blocked');
		} else {
			$firstTag = $this->getFirstTag();
			$secondTag = $this->getSecondTag();
			$tags = $this->getMergedTags($firstTag, $secondTag);
		}

		wfProfileOut(__METHOD__);
		return $tags;
	}

	/**
	 * @desc Returns "Staff", "Authenticated" or empty string for given user
	 *
	 * @return string
	 */
	protected function getFirstTag() {
		wfProfileIn(__METHOD__);
		$tag = '';
		$groupNameSuffix = null;
		if( $this->isUserInGroup(self::WIKIA_GROUP_STAFF_NAME) ) {
			$groupNameSuffix = self::WIKIA_GROUP_STAFF_NAME;
		} else if( $this->isUserInGroup(self::WIKIA_GROUP_AUTHENTICATED_NAME) ) {
			$groupNameSuffix = self::WIKIA_GROUP_AUTHENTICATED_NAME;
		} else if( $this->isUserInGroup(self::WIKIA_GROUP_WIKIA_STAR) ) {
			$groupNameSuffix = self::WIKIA_GROUP_WIKIA_STAR;
		}

		if( !is_null($groupNameSuffix) ) {
			$tag = wfMsg('user-identity-box-group-' . $groupNameSuffix);
		}
		wfProfileOut(__METHOD__);

		return $tag;
	}

	/**
	 * @desc Returns "Founder" or one of other rights from $groupRank
	 *
	 * @return string
	 */
	protected function getSecondTag() {
		if( $this->isFounder() ) {
			$tag = wfMsg('user-identity-box-group-founder');
		} else {
			$tag = $this->getTagFromGroups();
		}

		return $tag;
	}

	/**
	 * @desc Returns array with none, one or two string elements ;)
	 *
	 * @param string $first
	 * @param string $second
	 *
	 * @return array
	 */
	protected function getMergedTags($first, $second) {
		if( !empty($first) && !empty($second) ) {
			$result = array($first, $second);
		} elseif( empty($first) && !empty($second) ) {
			$result = array($second);
		} elseif( !empty($first) && empty($second) ) {
			$result = array($first);
		} else {
			$result = array();
		}

		return $result;
	}
}
