<?php

/**
 * This class represents a quiz element (question and answers) and provides interface for answering / unanswering.
 */

class WikiaQuizElement {

	private $mData;
	private $mExists;
	private $mMemcacheKey;
	private $mQuizElementId;

	const CACHE_TTL = 86400;
	const CACHE_VER = 5;
	const ANSWER_MARKER = '* ';
	const CORRECT_ANSWER_MARKER = '(+)';

	private function __construct($quizElementId) {
		$this->mData = null;
		$this->mExists = false;
		$this->mMemcacheKey = wfMemcKey('quizElement', 'data', $quizElementId, self::CACHE_VER);
		$this->mQuizElementId = $quizElementId;

		wfDebug(__METHOD__ . ": quizElement #{$quizElementId}\n");
	}

	/**
	 * Return instance of WikiaQuizElement for given article from Quiz namespace
	 */
	static public function newFromArticle(Article $article) {
		$id = $article->getID();
		return self::newFromId($id);
	}

	/**
	 * Return instance of WikiaQuizElement for given title from Quiz namespace
	 */
	static public function newFromTitle(Title $title) {
		$id = $title->getArticleId();
		return self::newFromId($id);
	}

	/**
	 * Return instance of WikiaQuizElement for given quizElement ID
	 */
	static public function newFromId($id) {
		return $id ? new self($id) : null;
	}

	/**
	 * Load quizElement data (try to use cache layer)
	 */
	private function load($master = false) {
		global $wgMemc;
		wfProfileIn(__METHOD__);

		if (!$master) {
			$this->mData = $wgMemc->get($this->mMemcacheKey);
		}

		if (empty($this->mData)) {
			$article = Article::newFromID($this->mQuizElementId);

			// check quizElement existance
			if (empty($article)) {
				wfDebug(__METHOD__ . ": quizElement doesn't exist\n");
				wfProfileOut(__METHOD__);
				return;
			}

			// parse wikitext with possible answers (stored as wikitext list)
			$content = $article->getContent();

			$lines = explode("\n", $content);
			$answers = array();
			foreach($lines as $line) {
				// answers are specially marked
				$lineHdr = substr($line, 0, strlen(self::ANSWER_MARKER));
				switch ($lineHdr) {
					case self::ANSWER_MARKER:
						$line = substr($line, strlen($lineHdr));
						break;
					default:
						continue;
				}
				// correct answer has another marker
				$correct = FALSE;
				if (substr($line, 0, strlen(self::CORRECT_ANSWER_MARKER)) == self::CORRECT_ANSWER_MARKER) {
					$correct = TRUE;
					$line = trim( substr($line, strlen(self::CORRECT_ANSWER_MARKER)) );
				}
				if ($line != '') {
					$answers[] = array(
						'text' => $line,
                                                'correct' => $correct
					);
				}
			}

			// get quizElement's author and creation timestamp
			$title = $article->getTitle();
			$firstRev = $title->getFirstRevision();

			// TODO: handle quizElement parameters (image / video for quizElement)
			$params = array();

//			// query for votes
//			$votes = 0;
//			$whichDB = $master ? DB_MASTER : DB_SLAVE;
//			$dbr = wfGetDB($whichDB);
//			$res = $dbr->select(
//				array('poll_vote'),
//				array('poll_answer as answer', 'COUNT(*) as cnt'),
//				array('poll_id' => $this->mPollId),
//				__METHOD__,
//				array('GROUP BY' => 'poll_answer')
//			);
//
//			while ($row = $dbr->fetchObject($res)) {
//				$answers[$row->answer]['votes'] = $row->cnt;
//				$votes += $row->cnt;
//			}

			$this->mData = array(
				'creator' => $firstRev->mUser,
				'created' => $firstRev->mTimestamp,
				'touched' => $article->getTouched(),
				'title' => $title->getText(),
				'question' => $title->getText(),
				'answers' => $answers,
				'params' => $params,
			);

			wfDebug(__METHOD__ . ": loaded from scratch\n");

			// store it in memcache
			$wgMemc->set($this->mMemcacheKey, $this->mData, self::CACHE_TTL);
		}
		else {
			wfDebug(__METHOD__ . ": loaded from memcache\n");
		}

		$this->mExists = true;

		wfProfileOut(__METHOD__);
		return;
	}

	public function getId() {
		return $this->mQuizElementId;
	}

	/**
	 * Get quizElement's data
	 */
	public function getData() {
		if (is_null($this->mData)) {
			$this->load();
		}

		return $this->mData;
	}

	/**
	 * Return true if current quizElement exists
	 */
	public function exists() {
		if (is_null($this->mData)) {
			$this->load();
		}

		return $this->mExists === true;
	}

	/**
	 * Return quizElement's title (i.e. question)
	 */
	public function getTitle() {
		if (is_null($this->mData)) {
			$this->load();
		}

		return $this->mData['title'];
	}

	/**
	 * Register answer from current user (use IP for anons)
	 */
	public function vote($answerId) {
		global $wgUser;
		wfProfileIn(__METHOD__);

		$ip = wfGetIP();
		$user = $wgUser->getId();

		wfDebug(__METHOD__ . ": registering answer #{$answerId} on behalf of user #{$user} / {$ip}\n");

//		$dbw = wfGetDB( DB_MASTER );
//		$dbw->begin();
//
//		/**
//		 * delete old answer (if any)
//		 */
//		$dbw->delete(
//			'poll_vote',
//			array(
//				'poll_id' => $this->mPollId,
//				'poll_user' => $user,
//			),
//			__METHOD__
//		);
//
//		/**
//		 * insert new one
//		 */
//		$status = $dbw->insert(
//			'poll_vote',
//			array(
//				'poll_id' => $this->mPollId,
//				'poll_user' => $user,
//				'poll_ip' => $ip,
//				'poll_answer' => $answerId,
//				'poll_date' => date('Y-m-d H:i:s')
//			),
//			__METHOD__
//		);
//		$dbw->commit();
//
//		$this->purge();

		// forces reload of memcache object from master before anyone else can get to it. :)
		$this->load(true);

		wfProfileOut(__METHOD__);
	}

	/**
	 * Check if current user (use IP for anons) has voted
	 */
	public function hasAnswered() {
		global $wgUser;
		wfProfileIn(__METHOD__);

//		$dbr = wfGetDB(DB_SLAVE);
//		$votes = $dbr->selectField(
//			array('poll_vote'),
//			array('COUNT(*)'),
//			array(
//				'poll_id' => $this->mPollId,
//				'poll_user' => $wgUser->getId()
//			),
//			__METHOD__
//		);
//
//		$hasVoted = $votes > 0;
//
//		wfProfileOut(__METHOD__);
//		return $hasVoted;
                return false;
	}

//	/**
//	 * Render HTML for Quiz page
//	 */
//	public function render() {
//		return wfRenderModule('WikiaQuiz', 'Index', array('quiz' => $this));
//	}

	/**
	 * Purges memcache entry
	 */
	public function purge() {
		global $wgMemc;
		wfProfileIn(__METHOD__);

		// clear data cache
		$wgMemc->delete($this->mMemcacheKey);
		$this->mData = null;

		$article = Article::newFromId($this->mQuizElementId);
		if (!empty($article)) {
			// purge quizElement page
			$article->doPurge();

			// apply changes to page_touched fields
			$dbw = wfGetDB(DB_MASTER);
			$dbw->commit();
		}

		wfDebug(__METHOD__ . ": purged quizElement #{$this->mQuizElementId}\n");

		wfProfileOut(__METHOD__);
	}
}
