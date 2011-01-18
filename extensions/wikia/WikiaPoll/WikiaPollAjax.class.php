<?php

class WikiaPollAjax {

	/**
	 * Register vote and return refreshed poll's HTML
	 */
	static public function vote($poll) {
		global $wgRequest, $wgTitle;
		wfProfileIn(__METHOD__);

		// register vote
		$answer = $wgRequest->getInt('answer');
		$poll->vote($answer);

		// render new poll
		if ($wgTitle->getNamespace() == NS_WIKIA_POLL) {
			$html = $poll->render();
		}
		else {
			$html = $poll->renderEmbedded();
		}

		$ret = array(
			'html' => $html,
		);

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Checks if current user has voted
	 */
	static public function hasVoted($poll) {
		wfProfileIn(__METHOD__);

		$ret = array(
			'hasVoted' => $poll->hasVoted(),
		);

		wfProfileOut(__METHOD__);
		return $ret;
	}
}
