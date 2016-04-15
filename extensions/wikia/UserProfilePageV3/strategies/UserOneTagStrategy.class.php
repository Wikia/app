<?php
/**
 * @desc Class which is handling logic operations connected to users groups and displaying them in user masthead (one tag at most)
 */
class UserOneTagStrategy extends UserTagsStrategyBase {
	protected $groupsRank = array(
		'authenticated' => 10,
		'sysop' => 9,
		'staff' => 8,
		'helper' => 7,
		'vstf' => 6,
		'vanguard' => 5,
		'voldev' => 4,
		'council' => 3,
		'threadmoderator' => 2,
		'chatmoderator' => 1,
	);

	/**
	 * @desc Returns at most one-element array
	 *
	 * @return array
	 */
	public function getUserTags() {
		wfProfileIn(__METHOD__);

		if( $this->isBlocked( true, false ) ) {
			$tag = wfMessage('user-identity-box-group-blocked')->escaped();
		} elseif( $this->isFounder() ) {
			$tag = wfMessage('user-identity-box-group-founder')->escaped();
		} else {
			$tag = $this->getTagFromGroups();
		}
		$tags = !empty($tag) ? array($tag) : array();

		wfProfileOut(__METHOD__);
		return $tags;
	}

}
