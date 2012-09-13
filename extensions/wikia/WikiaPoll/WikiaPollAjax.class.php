<?php

class WikiaPollAjax {

	/**
	 * Create a new poll
	 * @param wgRequest question
	 * @param wgRequest answer   (expects PHP array style in the form <input name=answer[]>)
		// Page Content should be of a different style so we have to translate
		//  *question 1\n
		//  *question 2\n
	 */
	static public function create() {
		wfProfileIn(__METHOD__);

		$wgRequest = F::app()->getGlobal('wgRequest');
		$wgUser = F::app()->getGlobal('wgUser');

		$title = $wgRequest->getVal ('question');
		$answers = $wgRequest->getArray ('answer');  // array

		$title_object = F::build('Title', array($title, NS_WIKIA_POLL), 'newFromText');

		if (is_object ($title_object) && $title_object->exists() ) {
			$res = array (
				'success' => false,
				'error' => F::app()->renderView('Error', 'Index', array(wfMsg('wikiapoll-error-duplicate')))
				);
		} else if ($title_object == null) {
			$res = array (
				'success' => false,
				'error' => F::app()->renderView('Error', 'Index', array(wfMsg('wikiapoll-error-invalid-title')))
				);
		} else {

			$content = "";
			foreach ($answers as $answer) {
				$content .= "*$answer\n";
			}

			$article = F::build('Article', array($title_object, NS_WIKIA_POLL));
			$status = $article->doEdit($content, 'Poll Created', EDIT_NEW, false, $wgUser);
			$title_object = $article->getTitle();

			// fixme: check status object
			$res = array (
				'success' => true,
				'pollId' => $article->getID(),
				'url'  => $title_object->getLocalUrl() ,
				'question' => $title_object->getPrefixedText()
				);
		}
		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Update the contents of an existing poll
	 * @param wgRequest pollId
	 */
	static public function update() {
		wfProfileIn(__METHOD__);
		$wgRequest = F::app()->getGlobal('wgRequest');
		$wgUser = F::app()->getGlobal('wgUser');

		$pollId = $wgRequest->getInt ('pollId');
		$answers = $wgRequest->getArray ('answer');  // array
		$res = array();
		$poll = F::build('WikiaPoll', array($pollId), 'newFromId');

		if (!empty($poll) && $poll->exists()) {

			$content = "";
			foreach ($answers as $answer) {
				$content .= "*$answer\n";
			}

			$article = Article::newFromID($pollId);
			if ( $article instanceof Article ) {
				$status = $article->doEdit($content, 'Poll Updated', EDIT_UPDATE, false, $wgUser);
				$title_object = $article->getTitle();
				// Fixme: check status object
				$res = array (
					'success' => true,
					'pollId' => $article->getID(),
					'url'  => $title_object->getLocalUrl() ,
					'question' => $title_object->getPrefixedText()
				);
			}
		}

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * checks for poll existing
	 * returns contents of poll
	 *
	 * @param wgRequest pollId
	 * @return array {exists, url, text}
	 */
	static public function get() {
		wfProfileIn(__METHOD__);
		$wgRequest = F::app()->getGlobal('wgRequest');

		$res = array (
				'exists' => false ,
		);
		$id = $wgRequest->getInt ('pollId', 0);
		if ($id != 0) {
			$article_object = F::build('Article', array($id), 'newFromID');
			$title_object = $article_object instanceof Article ? $article_object->getTitle() : false;
		}

		if (is_object ($title_object) && $title_object->exists() ) {
			$res = array (
				'exists' => true,
				'url'  => $title_object->getLocalUrl() ,
				'question' => $title_object->getPrefixedText(),
				'answer' => $article_object->getContent()
			);
		}
		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Register vote and return refreshed poll's HTML
	 *
	 * @param wgRequest pollId
	 * @return array {html}
	 */
	static public function vote() {
		wfProfileIn(__METHOD__);
		$wgRequest = F::app()->getGlobal('wgRequest');
		$wgTitle = F::app()->getGlobal('wgTitle');

		$pollId = $wgRequest->getInt('pollId');
		$poll = F::build('WikiaPoll', array($pollId), 'newFromId');

		$html = '';
		if (!empty($poll) && $poll->exists()) {

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
		}

		$ret = array(
			'html' => $html,
		);

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Checks if current user has voted
	 * @param wgRequest pollId
	 * @return array {hasVoted}
	 */
	static public function hasVoted() {
		wfProfileIn(__METHOD__);

		$pollId = F::app()->getGlobal('wgRequest')->getInt('pollId');
		$poll = F::build('WikiaPoll', array($pollId), 'newFromId');

		$ret = array();

		if (!empty($poll) && $poll->exists()) {
			$ret['hasVoted'] = $poll->hasVoted();
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}

}
