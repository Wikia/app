<?php

class QuestionPageController extends PageHeaderController {

	var $authorName;
	var $firstRevTimestamp;

	public function executeIndex($params) {
		global $wgTitle;

		parent::executeIndex($params);

		$this->title = $wgTitle->getText() . wfMsg('?');
		$this->displaytitle = false;

		$rev = $wgTitle->getFirstRevision();
		if($rev) {
			$user = User::newFromId( $rev->getUser() );
			if($user) {
				$this->authorName = $user->getName();
				$this->firstRevTimestamp = wfTimeFormatAgo( $rev->getTimestamp() );
			}
		}

	}

}
