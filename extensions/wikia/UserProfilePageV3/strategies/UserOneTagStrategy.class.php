<?php
/**
 * @desc Class which is handling logic operations connected to users groups and displaying them in user masthead (one tag at most)
 */
class UserOneTagStrategy extends UserTagsStrategyBase {
	protected $groupsRank = array(
		'authenticated' => 7,
		'sysop' => 6,
		'staff' => 5,
		'helper' => 4,
		'vstf' => 3,
		'council' => 2,
		'chatmoderator' => 1,
	);

	/**
	 * @desc Returns at most one-element array
	 *
	 * @return array
	 */
	public function getUserTags() {
		$this->app->wf->ProfileIn(__METHOD__);

		$tags = array();
		if( $this->isBlocked() ) {
			//blocked user has only one tag displayed "Blocked"
			$tags[] = $this->app->wf->Msg('user-identity-box-group-blocked');
		} else {
			if( $this->isFounder() ) {
				$tags[] = $this->app->wf->Msg('user-identity-box-group-founder');
			} else {
				$this->getTagFromGroups($tags);
			}
		}

		$this->app->wf->ProfileOut(__METHOD__);
		return $tags;
	}

}