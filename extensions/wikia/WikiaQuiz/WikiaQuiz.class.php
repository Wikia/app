<?php

/**
 * This class represents a quiz: a set of WikiaQuizElements (question and answers)
 */

class WikiaQuiz {
	private $mCategory;
	private $mData;
	private $mExists;
	private $mMemcacheKey;
	private $mName;
	private $mQuizId;

	const CACHE_TTL = 86400;
	const CACHE_VER = 5;
	const QUIZ_CATEGORY_PREFIX = 'Quiz_';

	private function __construct($quizId) {
		$this->mData = null;
		$this->mExists = false;
		$this->mMemcacheKey = wfMemcKey('quiz', 'data', $quizId, self::CACHE_VER);
		$this->mQuizId = $quizId;

		wfDebug(__METHOD__ . ": quiz #{$quizId}\n");
	}

	/**
	 * Return instance of WikiaQuiz for given quiz ID
	 */
	static public function newFromId($id) {
		return $id ? new self($id) : null;
	}

	/**
	 * Return instance of WikiaQuiz for given name
	 */
	static public function newFromName($name) {
		$catName = self::QUIZ_CATEGORY_PREFIX . $name;

		$cat = Category::newFromName($catName);
		if (!$cat) {
			return false;
		}

		$quiz = new self($cat->getId());
		$quiz->mName = substr($cat->getName(), strlen(self::QUIZ_CATEGORY_PREFIX));
		$quiz->mCategory = $cat;

		return $quiz;
	}

	/**
	 * Load quiz data (try to use cache layer)
	 */
	private function load($master=false) {
		global $wgMemc;
		wfProfileIn(__METHOD__);

		if (!$master) {
			$this->mData = $wgMemc->get($this->mMemcacheKey);
		}

		if (empty($this->mData)) {
			if (empty($this->mCategory)) {
				$this->mCategory = Category::newFromID($this->mQuizId);
			}

			// check quiz existence
			if (empty($this->mCategory) || !$this->mCategory->getID()) {
				wfDebug(__METHOD__ . ": quiz doesn't exist\n");
				wfProfileOut(__METHOD__);
				return;
			}

			// get quiz elements
			$quizElements = array();
			$quizIterator = $this->mCategory->getMembers();
			while ($quizElementTitle = $quizIterator->current()) {
				$quizElement = WikiaQuizElement::newFromId($quizElementTitle->getArticleId());
				$quizElements[] = $quizElement->getData();
				$quizIterator->next();
			}

			$this->mData = array(
				'id' => $this->mQuizId,
				'name' => $this->getName(),
				'elements' => $quizElements,
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
		return $this->mQuizId;
	}

	/**
	 * Get quiz's data
	 */
	public function getData() {
		if (is_null($this->mData)) {
			$this->load();
		}

		return $this->mData;
	}

	/**
	 * Get quiz's name (does not include the mandatory category prefix)
	 */
	public function getName() {
		return $this->mName;
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
	 * Purges memcache entry
	 */
	public function purge() {
		global $wgMemc;
		wfProfileIn(__METHOD__);

		// clear data cache
		$wgMemc->delete($this->mMemcacheKey);
		$this->mData = null;

		$article = Article::newFromId($this->mQuizId);
		if (!empty($article)) {
			// purge quiz page
			$article->doPurge();

			// apply changes to page_touched fields
			$dbw = wfGetDB(DB_MASTER);
			$dbw->commit();
		}

		wfDebug(__METHOD__ . ": purged quiz #{$this->mQuizId}\n");

		wfProfileOut(__METHOD__);
	}
}
