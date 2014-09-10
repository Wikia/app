<?php

/**
 * This class represents a quiz element (question and answers) and provides interface for answering / unanswering.
 */

class WikiaQuizElement {

	private $mData;
	private $mExists;
	private $mMemcacheKey;
	private $mQuizElementId;
	private $mQuizTitleObject;

	const CACHE_TTL = 86400;
	const CACHE_VER = 5;
	const ANSWER_MARKER = '* ';
	const CORRECT_ANSWER_MARKER = '(+)';
	const ANSWER_IMAGE_MARKER = '|';
	const IMAGE_MARKER = 'IMAGE:';
	const TITLE_MARKER = 'TITLE:';
	const EXPLANATION_MARKER = 'EXPLANATION:';
	const REQUIRE_EMAIL_MARKER = 'REQUIREEMAIL:';
	const VIDEO_MARKER = 'VIDEO:';
	const VIDEOWIKI_MARKER = 'VIDEOWIKI:';
	const VIDEO_WIDTH = 560;

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
		global $wgMemc, $wgLang;
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

			// get quizElement's author and creation timestamp
			$title = $article->getTitle();
			$url = $title->getLocalUrl();
			$firstRev = $title->getFirstRevision();
			$titleText = $title->getText();
			$imageSrc = '';
			$imageShort = '';
			$explanation = '';
			$requireEmail = false;
			$videoName = '';
			$videoEmbedCode = '';
			$isVideoExternal = false;
			$quizName = '';	//@todo support multiple quizzes
			$order = '';

			// parse wikitext with possible answers (stored as wikitext list)
			$content = $article->getContent();

			$lines = explode("\n", $content);
			$answers = array();
			foreach($lines as $line) {
				$line = trim($line);
				// override article title
				if (substr($line, 0, strlen(self::TITLE_MARKER)) == self::TITLE_MARKER) {
					$customTitle = trim( substr($line, strlen(self::TITLE_MARKER)) );
					if ($customTitle) {
						$titleText = $customTitle;
					}
				}
				elseif (substr($line, 0, strlen(self::IMAGE_MARKER)) == self::IMAGE_MARKER) {
					$imageShort = trim( substr($line, strlen(self::IMAGE_MARKER)) );
					$imageSrc = $this->getImageSrc($imageShort);
				}
				elseif (substr($line, 0, strlen(self::EXPLANATION_MARKER)) == self::EXPLANATION_MARKER) {
					$explanation = trim( substr($line, strlen(self::EXPLANATION_MARKER)) );
				}
				elseif (startsWith($line, self::VIDEO_MARKER)) {
					$videoName = trim( substr($line, strlen(self::VIDEO_MARKER)) );
				}
				elseif (startsWith($line, self::VIDEOWIKI_MARKER)) {
					$videoName = trim( substr($line, strlen(self::VIDEOWIKI_MARKER)) );
					$isVideoExternal = true;
				}
				elseif (preg_match("/\[\[{$wgLang->getNsText(NS_CATEGORY)}\:(.+?)(\|(.+))*\]\]/", $line, $matches)) {
					if (startsWith($matches[1], WikiaQuiz::QUIZ_CATEGORY_PREFIX)) {
						$quizName = trim( substr($matches[1], strlen(WikiaQuiz::QUIZ_CATEGORY_PREFIX)));
						if (isset($matches[3])) {
							$order = $matches[3];
						}
					}
				}
				// answers are specially marked
				elseif (substr($line, 0, strlen(self::ANSWER_MARKER)) == self::ANSWER_MARKER) {
					$line = substr($line, strlen(self::ANSWER_MARKER));
					// correct answer has another marker
					$correct = FALSE;
					if (substr($line, 0, strlen(self::CORRECT_ANSWER_MARKER)) == self::CORRECT_ANSWER_MARKER) {
						$correct = TRUE;
						$line = trim( substr($line, strlen(self::CORRECT_ANSWER_MARKER)) );
					}
					if ($line != '') {
						$answerChunks = explode(self::ANSWER_IMAGE_MARKER, $line);
						$answers[] = array(
							'text' => $answerChunks[0],
							'correct' => $correct,
							'image' => isset($answerChunks[1]) ? $this->getImageSrc($answerChunks[1]) : '',
							'imageShort' => isset($answerChunks[1]) ? $answerChunks[1] : ''
						);
					}
				}	elseif (substr($line, 0, strlen(self::REQUIRE_EMAIL_MARKER)) == self::REQUIRE_EMAIL_MARKER) {
					$line = substr($line, strlen(self::REQUIRE_EMAIL_MARKER));
					$requireEmail = ($line == 'true');
				}
			}

			// TODO: handle quizElement parameters (image / video for quizElement)
			$params = array();

			$this->mQuizTitleObject = Title::newFromText($quizName, NS_WIKIA_QUIZ);

			if ( !empty( $videoName ) ) {

				$file = wfFindFile($videoName);
				if (WikiaFileHelper::isVideoFile($file)) {
					$file->trackingArticleId = $this->mQuizElementId;
					$videoEmbedCode = $file->getEmbedCode( self::VIDEO_WIDTH );
				}

			}

			$this->mData = array(
				'creator' => $firstRev->getUser(),
				'created' => $firstRev->getTimestamp(),
				'touched' => $article->getTouched(),
				'url' => $url,
				'title' => $titleText,
				'question' => $titleText,
				'answers' => $answers,
				'image' => $imageSrc,
				'imageShort' => $imageShort,
				'explanation' => $explanation,
				'requireEmail' => $requireEmail,
				'videoName' => $videoName,
				'videoEmbedCode' => $videoEmbedCode,
				'quiz' => $quizName,
				'quizUrl' => $this->mQuizTitleObject ? $this->mQuizTitleObject->getLocalUrl() : '',
				'order' => $order,
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

	//@todo refactor this function and the version in WikiaQuiz.class
	private function getImageSrc($filename) {
		$imageSrc = '';
		$fileTitle = Title::newFromText($filename, NS_FILE);
		$image = wfFindFile($fileTitle);
		if ( !is_object( $image ) || $image->height == 0 || $image->width == 0 ){
			return $imageSrc;
		} else {
			$thumbDim = ($image->height > $image->width) ? $image->width : $image->height;
			$imageServing = new ImageServing( array( $fileTitle->getArticleID() ), $thumbDim, array( "w" => $thumbDim, "h" => $thumbDim ) );
			$imageSrc = wfReplaceImageServer(
				$image->getThumbUrl(
					$imageServing->getCut( $thumbDim, $thumbDim )."-".$image->getName()
				)
			);
		}

		return $imageSrc;
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

	public function getQuizTitle() {
		if (is_null($this->mData)) {
			$this->load();
		}

		return $this->mData['quiz'];
	}

	/**
	 * Return quizElement's order in quiz
	 */
	public function getOrder() {
		if (is_null($this->mData)) {
			$this->load();
		}

		return $this->mData['order'];
	}

	/**
	 * Render HTML for QuizElement page
	 */
	public function render() {
		return F::app()->renderView('WikiaQuiz', 'ArticleIndex', array('quizElement' => $this));
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

		$article = Article::newFromId($this->mQuizElementId);
		if (!empty($article)) {
			// purge quizElement page
			$article->doPurge();

			// apply changes to page_touched fields
			$dbw = wfGetDB(DB_MASTER);
			$dbw->commit();
		}

		// purge cached quiz
		if (empty($this->mQuizTitleObject)) {
			$this->load();
		}
		if (!empty($this->mQuizTitleObject)) {
			$quizArticle = new WikiaQuizIndexArticle($this->mQuizTitleObject);
			$quizArticle->doPurge();
		}
		else {
			// should never get to this point
		}

		wfDebug(__METHOD__ . ": purged quizElement #{$this->mQuizElementId}\n");

		wfProfileOut(__METHOD__);
	}
}
