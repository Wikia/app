<?php

/**
 * This class represents poll and provides interface for voting / unvoting.
 */

class WikiaPoll {

	private $mData;
	private $mExists;
	private $mMemcacheKey;
	private $mPollId;

	const CACHE_TTL = 86400;
	const CACHE_VER = 5;

	private function __construct($pollId) {
		$this->mData = null;
		$this->mExists = false;
		$this->mMemcacheKey = wfMemcKey('poll', 'data', $pollId, self::CACHE_VER);
		$this->mPollId = $pollId;

		wfDebug(__METHOD__ . ": poll #{$pollId}\n");
	}

	/**
	 * Return instance of WikiaPoll for given article from Poll namespace
	 */
	static public function newFromArticle(Page $article) {
		$id = $article->getId();
		return self::newFromId($id);
	}

	/**
	 * Return instance of WikiaPoll for given title from Poll namespace
	 */
	static public function newFromTitle(Title $title) {
		$id = $title->getArticleId();
		return self::newFromId($id);
	}

	/**
	 * Return instance of WikiaPoll for given poll ID
	 */
	static public function newFromId($id) {
		return $id ? new self($id) : null;
	}

	/**
	 * Load poll data (try to use cache layer)
	 */
	private function load($master = false) {
		global $wgMemc;
		wfProfileIn(__METHOD__);

		if (!$master) {
			$this->mData = $wgMemc->get($this->mMemcacheKey);
		}

		if (empty($this->mData)) {
			$article = Article::newFromID($this->mPollId);

			// check poll existance
			if (empty($article)) {
				wfDebug(__METHOD__ . ": poll doesn't exist\n");
				wfProfileOut(__METHOD__);
				return;
			}

			// parse wikitext with possible answers (stored as wikitext list)
			$content = $article->getContent();

			$lines = explode("\n", $content);
			$answers = array();
			foreach($lines as $line) {
				$line = trim($line, '* ');
				if ($line != '') {
					$answers[] = array(
						'text' => $line,
						'votes' => 0,
					);
				}
			}

			// get poll's author and creation timestamp
			$title = $article->getTitle();
			$firstRev = $title->getFirstRevision();

			// TODO: handle poll parameters (image / video for poll)
			$params = array();

			// query for votes
			$votes = 0;
			$whichDB = $master ? DB_MASTER : DB_SLAVE;
			$dbr = wfGetDB($whichDB);
			$res = $dbr->select(
				array('poll_vote'),
				array('poll_answer as answer', 'COUNT(*) as cnt'),
				array('poll_id' => $this->mPollId),
				__METHOD__,
				array('GROUP BY' => 'poll_answer')
			);

			while ($row = $dbr->fetchObject($res)) {
				$answers[$row->answer]['votes'] = $row->cnt;
				$votes += $row->cnt;
			}

			/*
			// use random data
			$votes = 0;
			foreach($answers as &$answer) {
				$answer['votes'] = mt_rand(0, 3000);
				$votes += $answer['votes'];
			}
			*/

			$this->mData = array(
				'creator' => $firstRev->getUser(Revision::RAW),
				'created' => $firstRev->getTimestamp(),
				'touched' => $article->getTouched(),
				'title' => $title->getText(),
				'question' => $title->getText(),
				'answers' => $answers,
				'params' => $params,
				'votes' => $votes,
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
		return $this->mPollId;
	}

	/**
	 * Get poll's data
	 */
	public function getData() {
		if (is_null($this->mData)) {
			$this->load();
		}

		return $this->mData;
	}

	/**
	 * Return true if current poll exists
	 */
	public function exists() {
		if (is_null($this->mData)) {
			$this->load();
		}

		return $this->mExists === true;
	}

	/**
	 * Return poll's title (i.e. question)
	 */
	public function getTitle() {
		if (is_null($this->mData)) {
			$this->load();
		}

		return $this->mData['title'];
	}

	/**
	 * Register vote for given answer from current user (use IP for anons)
	 */
	public function vote($answerId) {
		global $wgUser, $wgRequest;
		wfProfileIn(__METHOD__);

		$ip = $wgRequest->getIP();
		$user = $wgUser->getId();

		wfDebug(__METHOD__ . ": voting for answer #{$answerId} on behalf of user #{$user} / {$ip}\n");

		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();

		/**
		 * delete old answer (if any)
		 */
		$dbw->delete(
			'poll_vote',
			array(
				'poll_id' => $this->mPollId,
				'poll_user' => $user,
			),
			__METHOD__
		);

		/**
		 * insert new one
		 */
		$dbw->insert(
			'poll_vote',
			array(
				'poll_id' => $this->mPollId,
				'poll_user' => $user,
				'poll_ip' => $ip,
				'poll_answer' => $answerId,
				'poll_date' => date('Y-m-d H:i:s')
			),
			__METHOD__
		);
		$dbw->commit();

		$this->purge();

		// forces reload of memcache object from master before anyone else can get to it. :)
		$this->load(true);

		wfProfileOut(__METHOD__);
	}

	/**
	 * Check if current user (use IP for anons) has voted
	 */
	public function hasVoted() {
		global $wgUser;
		wfProfileIn(__METHOD__);

		$dbr = wfGetDB(DB_SLAVE);
		$votes = $dbr->selectField(
			array('poll_vote'),
			array('COUNT(*)'),
			array(
				'poll_id' => $this->mPollId,
				'poll_user' => $wgUser->getId()
			),
			__METHOD__
		);

		$hasVoted = $votes > 0;

		wfProfileOut(__METHOD__);
		return $hasVoted;
	}

	/**
	 * Render HTML for Poll page
	 */
	public function render() {
		return F::app()->renderView('WikiaPoll', 'Index', array('poll' => $this));
	}

	/**
	 * Render HTML for embedded poll
	 */
	public function renderEmbedded() {
		return F::app()->renderView('WikiaPoll', 'Index', array('poll' => $this, 'embedded' => true));
	}

	/**
	 * Purges memcache entry and articles having current poll transcluded
	 */
	public function purge() {
		global $wgMemc;
		wfProfileIn(__METHOD__);

		// clear data cache
		$wgMemc->delete($this->mMemcacheKey);
		$this->mData = null;

		$article = Article::newFromId($this->mPollId);
		if (!empty($article)) {
			// purge poll page
			$article->doPurge();

			// purge articles embedding this poll
			$updateJob = new HTMLCacheUpdate($article->getTitle(), 'templatelinks');
			$updateJob->doUpdate();

			// apply changes to page_touched fields
			$dbw = wfGetDB(DB_MASTER);
			$dbw->commit();
		}

		wfDebug(__METHOD__ . ": purged poll #{$this->mPollId}\n");

		wfProfileOut(__METHOD__);
	}
}
