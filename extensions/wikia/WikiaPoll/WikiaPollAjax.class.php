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
		global $wgRequest, $wgUser;
		wfProfileIn(__METHOD__);

		$title = $wgRequest->getVal ('question');
		$answers = $wgRequest->getArray ('answer');  // array

		$title_object = Title::newFromText ($title, NS_WIKIA_POLL) ;

		if (is_object ($title_object) && $title_object->exists() ) {
			$res = array (
				'success' => false,
				'error' => wfRenderModule('Error', 'Index', wfMsg('wikiapoll-error-duplicate'))
				);
		} else if ($title_object == null) {
			$res = array (
				'success' => false,
				'error' => wfRenderModule('Error', 'Index', wfMsg('wikiapoll-error-invalid-title'))
				);			
		} else {

			$content = "";
			foreach ($answers as $answer) {
				$content .= "*$answer\n";
			}

			$article = new Article($title_object, NS_WIKIA_POLL);
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
		global $wgRequest, $wgUser;
		wfProfileIn(__METHOD__);

		$pollId = $wgRequest->getInt ('pollId');
		$answers = $wgRequest->getArray ('answer');  // array
		$res = array();
		$poll = WikiaPoll::newFromId($pollId);
		if (!empty($poll) && $poll->exists()) {

			$content = "";
			foreach ($answers as $answer) {
				$content .= "*$answer\n";
			}

			$article = Article::newFromID($pollId);
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

		return $res;
		wfProfileOut(__METHOD__);
	}

	/**
	 * checks for poll existing
	 * returns contents of poll
	 * 
	 * @param wgRequest pollId
	 * @return array {exists, url, text}
	 */

	static public function get() {
		global $wgRequest ;
		wfProfileIn(__METHOD__);

		$res = array (
				'exists' => false ,
		);
		$id = $wgRequest->getInt ('pollId', 0);
		if ($id != 0) {
			$article_object = Article::newFromID ($id) ;
			$title_object = $article_object->getTitle();
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
		global $wgRequest, $wgTitle;
		wfProfileIn(__METHOD__);

		$pollId = $wgRequest->getInt('pollId');
		$poll = WikiaPoll::newFromId($pollId);
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
		global $wgRequest;
		wfProfileIn(__METHOD__);

		$pollId = $wgRequest->getInt('pollId');
		$poll = WikiaPoll::newFromId($pollId);
		$ret = array();

		if (!empty($poll) && $poll->exists()) {
			$ret['hasVoted'] = $poll->hasVoted();
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}
	
}
