<?php

class WikiaQuizAjax {

	/**
	 * Create a new quiz
	 */
	static public function createQuiz() {
		wfProfileIn(__METHOD__);

		$wgRequest = F::app()->getGlobal('wgRequest');
		$wgUser = F::app()->getGlobal('wgUser');

		// create article in NS_WIKIA_QUIZ
		$title = trim($wgRequest->getVal ('title'));
		$title_object = Title::newFromText($title, NS_WIKIA_QUIZ);

		if (is_object ($title_object) && $title_object->exists() ) {
			$res = array (
				'success' => false,
				'error' => F::app()->renderView('Error', 'Index', array(wfMsg('wikiaquiz-error-duplicate-quiz')))
				);
		} else if ($title_object == null) {
			$res = array (
				'success' => false,
				'error' => F::app()->renderView('Error', 'Index', array(wfMsg('wikiaquiz-error-invalid-quiz')))
				);
		} else {	// create questions
			$error = null;
			$content = self::parseCreateEditQuizRequest($wgRequest, null, $error);
			if ($error) {
				$res = array (
					'success' => false,
					'error' => F::app()->renderView('Error', 'Index', array($error))
					);
			}
			else {
				$article = new Article($title_object);
				$status = $article->doEdit($content, 'Quiz Created', EDIT_NEW, false, $wgUser);
				$title_object = $article->getTitle();

				// fixme: check status object
				$res = array (
					'success' => true,
					'quizId' => $article->getID(),
					'url'  => $title_object->getLocalUrl() ,
					'title' => $title_object->getPrefixedText()
					);
			}

		}

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Update quiz
	 */
	static public function updateQuiz() {
		wfProfileIn(__METHOD__);

		$wgRequest = F::app()->getGlobal('wgRequest');
		$wgUser = F::app()->getGlobal('wgUser');

		$res = array();

		$quizId = $wgRequest->getInt ('quizId');
		$quiz = WikiaQuiz::newFromId($quizId);

		if (empty($quiz) || !$quiz->exists()) {
			$res = array (
				'success' => false,
				'error' => F::app()->renderView('Error', 'Index', array(wfMsg('wikiaquiz-error-invalid-quiz')))
				);
		} else {
			$error = null;
			$content = self::parseCreateEditQuizRequest($wgRequest, $quiz, $error);
			if ($error) {
				$res = array (
					'success' => false,
					'error' => F::app()->renderView('Error', 'Index', array($error))
					);
			}
			else {
				$article = Article::newFromID($quizId);
				$status = $article->doEdit($content, 'Quiz Updated', EDIT_UPDATE, false, $wgUser);
				$title_object = $article->getTitle();
				// @todo check status object
				$res = array (
					'success' => true,
					'quizId' => $article->getID(),
					'url'  => $title_object->getLocalUrl() ,
					'title' => $title_object->getPrefixedText()
					);
			}

		}

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Create a new quiz eleemnt
	 * @see WikiaQuizElement.class.php
	 */

	static public function createQuizArticle() {
		wfProfileIn(__METHOD__);

		$wgRequest = F::app()->getGlobal('wgRequest');
		$wgUser = F::app()->getGlobal('wgUser');

		$title = $wgRequest->getVal ('question');
		$title_object = Title::newFromText($title, NS_WIKIA_QUIZARTICLE);

		if (is_object ($title_object) && $title_object->exists() ) {
			$res = array (
				'success' => false,
				'error' => F::app()->renderView('Error', 'Index', array(wfMsg('wikiaquiz-error-duplicate-question')))
				);
		} else if ($title_object == null) {
			$res = array (
				'success' => false,
				'error' => F::app()->renderView('Error', 'Index', array(wfMsg('wikiaquiz-error-invalid-question')))
				);
		} else {
			$error = null;
			$content = self::parseCreateEditQuizArticleRequest($wgRequest, null, $error);
			if ($error) {
				$res = array (
					'success' => false,
					'error' => F::app()->renderView('Error', 'Index', array($error))
					);
			}
			else {
				$article = new Article($title_object);
				$status = $article->doEdit($content, 'Quiz Article Created', EDIT_NEW, false, $wgUser);
				$title_object = $article->getTitle();

				// fixme: check status object
				$res = array (
					'success' => true,
					'quizElementId' => $article->getID(),
					'url'  => $title_object->getLocalUrl() ,
					'question' => $title_object->getPrefixedText()
					);
			}

		}
		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * Update the contents of an existing quizElement
	 * @param wgRequest quizElementId
	 */

	static public function updateQuizArticle() {
		wfProfileIn(__METHOD__);
		$wgRequest = F::app()->getGlobal('wgRequest');
		$wgUser = F::app()->getGlobal('wgUser');

		$res = array();

		$quizElementId = $wgRequest->getInt ('quizElementId');
		$quizElement = WikiaQuizElement::newFromId($quizElementId);

//		$newTitle = $wgRequest->getVal ('question');
//		$newTitleObject = Title::newFromText($newTitle, NS_WIKIA_QUIZARTICLE);
//		if (is_object($newTitleObject)) {
//			$newArticle = new Article($newTitleObject);
//		}

		// validation
//		if (is_object ($newTitleObject) && $newTitleObject->exists()
//		&& $newArticle->getID() != $quizElementId) {
//			$res = array (
//				'success' => false,
//				'error' => F::app()->renderView('Error', 'Index', array(wfMsg('wikiaquiz-error-duplicate-question')))
//				);
//		} else if ($newTitleObject == null) {
//			$res = array (
//				'success' => false,
//				'error' => F::app()->renderView('Error', 'Index', array(wfMsg('wikiaquiz-error-invalid-question')))
//				);
//		} else {
//
//		}
		if (empty($quizElement) || !$quizElement->exists()) {
			$res = array (
				'success' => false,
				'error' => F::app()->renderView('Error', 'Index', array(wfMsg('wikiaquiz-error-invalid-article')))
				);
		} else {
			$error = null;
			$content = self::parseCreateEditQuizArticleRequest($wgRequest, $quizElement, $error);
			if ($error) {
				$res = array (
					'success' => false,
					'error' => F::app()->renderView('Error', 'Index', array($error))
					);
			}
			else {
				$article = Article::newFromID($quizElementId);
				$status = $article->doEdit($content, 'Quiz Question and Answers Updated', EDIT_UPDATE, false, $wgUser);
				$title_object = $article->getTitle();
				// @todo check status object
				$res = array (
					'success' => true,
					'quizElementId' => $article->getID(),
					'url'  => $title_object->getLocalUrl() ,
					'question' => $title_object->getPrefixedText()
					);
			}

		}

		wfProfileOut(__METHOD__);
		return $res;
	}

	/**
	 * checks for quizElement existing
	 * returns contents of quizElement
	 *
	 * @param wgRequest quizElementId
	 * @return array {exists, url, text}
	 */

	static public function get() {
		wfProfileIn(__METHOD__);
		$wgRequest = F::app()->getGlobal('wgRequest');

		$res = array (
				'exists' => false ,
		);
		$id = $wgRequest->getInt ('quizElementId', 0);
		if ($id != 0) {
			$article_object = Article::newFromID($id);
			$title_object = $article_object->getTitle();
		}

		if (is_object ($title_object) && $title_object->exists() ) {
			$res = array (
				'exists' => true,
				'url'  => $title_object->getLocalUrl() ,
				'question' => $title_object->getPrefixedText(),
				'content' => $article_object->getContent()
			);
		}
		wfProfileOut(__METHOD__);
		return $res;
	}

	private static function parseCreateEditQuizRequest(WebRequest $request, $quiz, &$error) {
		$wgUser = F::app()->getGlobal('wgUser');
		$wgLang = F::app()->getGlobal('wgContLang');

		// parse quiz fields
		$quizContent = '';

		// title
		if (!empty($quiz)) {
			$title = $quiz->getTitle();
		}
		else {
			$title = trim($request->getVal ('title'));
		}

		// title screen text
		$titleScreenText = trim($request->getVal ('titlescreentext'));
		if ($titleScreenText) {
			$quizContent .= WikiaQuiz::TITLESCREENTEXT_MARKER . $titleScreenText . "\n";
		}

		// facebook recommendation description
		$fbRecommendationText = trim($request->getVal ('fbrecommendationtext'));
		if ($fbRecommendationText) {
			$quizContent .= WikiaQuiz::FBRECOMMENDATIONTEXT_MARKER . $fbRecommendationText . "\n";
		}

		// title screen images
		$titleScreenImages = $request->getArray ('titlescreenimage');
		foreach($titleScreenImages as $image) {
			if ($image) {
				if (!self::isValidImage($image)) {
					$error = wfMsg('wikiaquiz-error-invalid-image', $image);
					return;
				}
				$quizContent .= WikiaQuiz::IMAGE_MARKER . $image . "\n";
			}
		}

		// More Info heading
		$moreInfoHeading = trim($request->getVal ('moreinfoheading'));
		if ($moreInfoHeading) {
			$quizContent .= WikiaQuiz::MOREINFOHEADING_MARKER . $moreInfoHeading . "\n";
		}

		// Are emails required?
		if ($request->getCheck('requireemail')) {
			$quizContent .= WikiaQuiz::REQUIRE_EMAIL_MARKER . "true\n";
		}

		// More Info links
		$moreInfoArticles = $request->getArray ('moreinfoarticle');
		$moreInfoLinkTexts = $request->getArray ('moreinfolinktext');
		foreach($moreInfoArticles as $index=>$articleName) {
			if ($articleName) {
				$moreInfoLinkText = isset($moreInfoLinkTexts[$index]) ? $moreInfoLinkTexts[$index] : '';
				if (Http::isValidURI($articleName)) {
					$quizContent .= WikiaQuiz::MOREINFOLINK_MARKER . $articleName . WikiaQuiz::MOREINFOLINK_TEXT_MARKER . $moreInfoLinkText . "\n";
				}
				else {
					$title_object = Title::newFromText($articleName);
					if (is_object ($title_object) && $title_object->exists() ) {
						$quizContent .= WikiaQuiz::MOREINFOLINK_MARKER . $articleName . WikiaQuiz::MOREINFOLINK_TEXT_MARKER . $moreInfoLinkText . "\n";
					}
					else {
						$error = wfMsg('wikiaquiz-error-invalid-article-with-details', $articleName);
						return;

					}
				}
			}
		}

		$patternCategory = "/\[\[".$wgLang->getNsText(NS_CATEGORY)."\:".WikiaQuiz::QUIZ_CATEGORY_PREFIX . $title."(\|(.+))*\]\]/";

		//process questions (quizelements)
		$questions = $request->getArray ('question');
		foreach ($questions as $index=>$question) {
			$question = trim($question);
			if (!$question) {
				continue;
			}

			$title_object = Title::newFromText($question, NS_WIKIA_QUIZARTICLE);

			if (is_object ($title_object) && $title_object->exists() ) {
				// update category tag
				$article = new Article($title_object);
				$content = $article->getContent();
				$newContent = null;

				$matches = null;
				preg_match($patternCategory, $content, $matches);
				if (isset($matches[2])) {
					if ($matches[2] != $index) {
						$replace = "[[".$wgLang->getNsText(NS_CATEGORY).":".WikiaQuiz::QUIZ_CATEGORY_PREFIX . $title."|".$index."]]";
						$newContent = preg_replace($patternCategory, $replace, $content);
					}
				}
				else {
					// this category is new for this article. append to contents.
					$newContent .= self::getCategoryText($title, $index);
				}

				if ($newContent) {
					$status = $article->doEdit($newContent, 'Quiz Question and Answers Updated', EDIT_UPDATE, false, $wgUser);
				}
			} else if ($title_object == null) {
				$error = wfMsg('wikiaquiz-error-invalid-question');
				return;
			}
			else {
				// create question
				$content = self::getCategoryText($title, $index);
				$article = new Article($title_object);
				$status = $article->doEdit($content, 'Quiz Article Created', EDIT_NEW, false, $wgUser);
				//@todo check status
			}
		}

		if (!empty($quiz)) {
			// remove old questions from quiz
			$questionKeys = array_flip($questions);
			$elements = $quiz->getElements();
			if (is_array($elements)) {
				foreach ($elements as $element) {
					$question = trim($element['title']);
					if ($question) {
						if (!array_key_exists($question, $questionKeys)) {
							$title_object = Title::newFromText($question, NS_WIKIA_QUIZARTICLE);
							$article = new Article($title_object);
							$content = $article->getContent();
							$content = preg_replace($patternCategory, '', $content);
							$status = $article->doEdit($content, 'Quiz Question and Answers Updated', EDIT_UPDATE, false, $wgUser);
						}
					}
				}
			}
		}

		return $quizContent;
	}

	private static function parseCreateEditQuizArticleRequest(WebRequest $request, WikiaQuizElement $quizElement, &$error) {
		if (!empty($quizElement)) {
			$title = $quizElement->getTitle();
			$quiz = $quizElement->getQuizTitle();
			$order = $quizElement->getOrder();
		}
		else {
			$order = '';
			$title = trim($request->getVal ('question'));
			$quiz = trim($request->getVal ('quiz'));
		}
		$image = trim($request->getVal ('image'));
		$explanation = trim($request->getVal ('explanation'));
		$video = trim($request->getVal ('video'));
		$answers = $request->getArray ('answer');  // array
		$correctAnswer = trim($request->getVal( 'correct' ));
		$answerImages = $request->getArray('answer-image');	// array

		$content = "";
		$content .= WikiaQuizElement::TITLE_MARKER . $title . "\n";
		if ($image) {
			if (!self::isValidImage($image)) {
				$error = wfMsg('wikiaquiz-error-invalid-image', $image);
				return;
			}
			$content .= WikiaQuizElement::IMAGE_MARKER . $image . "\n";
		}
		if ($video) {
			if (!self::isValidVideo($video)) {
				$error = wfMsg('wikiaquiz-error-invalid-video', $video);
				return;
			}
			$content .= WikiaQuizElement::VIDEO_MARKER . $video . "\n";
		}
		if ($explanation) {
			$content .= WikiaQuizElement::EXPLANATION_MARKER . $explanation . "\n";
		}
		if ($quiz) {
			$content .= self::getCategoryText($quiz, $order);
		}
		else {
			$error = wfMsg('wikiaquiz-error-invalid-quiz');
			return;
		}

		$answerExists = false;
		$correctAnswerExists = false;
		foreach ($answers as $index=>$answer) {
			$answer = trim($answer);
			if ($answer) {
				$answerExists = true;
				$correctAnswerContent = "";
				if ($index == $correctAnswer) {
					if ($correctAnswerExists) {
						$error = wfMsg('wikiaquiz-error-invalid-correct-answer');
						return;
					}
					else {
						$correctAnswerExists = true;
					}
					$correctAnswerContent .= WikiaQuizElement::CORRECT_ANSWER_MARKER . ' ';
				}

				$answerImageContent = "";
				$answerImage = trim($answerImages[$index]);
				if ($answerImage) {
					if (!self::isValidImage($answerImage)) {
						$error = wfMsg('wikiaquiz-error-invalid-image', $answerImage);
						return;
					}
					$answerImageContent .= WikiaQuizElement::ANSWER_IMAGE_MARKER . $answerImages[$index];
				}

				$content .= WikiaQuizElement::ANSWER_MARKER . "$correctAnswerContent$answer$answerImageContent\n";
			}
		}

		if (!$answerExists) {
			$error = wfMsg('wikiaquiz-error-missing-answers');
			return;
		}

		if (!$correctAnswerExists) {
			$error = wfMsg('wikiaquiz-error-invalid-correct-answer');
			return;
		}

		return $content;
	}

	private static function isValidImage($filename) {
		$fileTitle = Title::newFromText($filename, NS_FILE);
		$image = wfFindFile($fileTitle);
		if ( !is_object( $image ) || $image->height == 0 || $image->width == 0 ){
			return false;
		}

		return true;

	}

	/**
	 * @TODO support for video from repo
	 * @param string $name
	 * @return boolean
	 */
	private static function isValidVideo($name) {

		$bResult = WikiaFileHelper::isTitleVideo( $name );
		return $bResult;
	}

	private static function getCategoryText($title, $order='') {
		$wgLang = F::app()->getGlobal('wgContLang');
		$text = '[[' .  $wgLang->getNsText(NS_CATEGORY) . ':' . WikiaQuiz::QUIZ_CATEGORY_PREFIX . $title;
		if ($order) {
			$text .= '|' . $order;
		}
		$text .= "]]\n";

		return $text;
	}

	/**
	 * Adds given email to the list and sends confirmation message
	 */
	public static function addEmail() {
		global $wgRequest, $wgUser;

		$ret = array(
			'ok' => false,
			'msg' => '',
		);

		$email = $wgRequest->getVal('email');
		$token = $wgRequest->getVal('token');
		$quizId = $wgRequest->getInt('quizid');

		// validate token
		if ($wgUser->matchEditToken($token, 'WikiaQuiz' /* $salt */)) {
			// validate email
			if (Sanitizer::validateEmail($email)) {
				$to = new MailAddress($email);
				$from = new MailAddress(WikiaQuiz::EMAIL_SENDER);
				$subject = wfMsg('wikiaquiz-game-email-subject');
				$body = wfMsg('wikiaquiz-game-email-body');

				// send an email
				$result = UserMailer::send($to, $from, $subject, $body, null /* $replyto */, null /* $contentType */, WikiaQuiz::EMAIL_CATEGORY /* $category */);

				if ($result->isOK()) {
					$ret['ok'] = true;
				}
				else {
					$ret['msg'] = wfMsg('wikiaquiz-game-email-error', $result->getMessage());
				}

				// store an email
				$entry = (new EmailsStorage)->newEntry(EmailsStorage::QUIZ);
				$entry->setPageId($quizId);
				$entry->setEmail($email);
				$ret['entryId'] = $entry->store();
			}
			else {
				$ret['msg'] = wfMsg('wikiaquiz-game-email-valid-please');
			}
		}
		else {
			$ret['msg'] = wfMsg('wikiaquiz-game-email-token-mismatch');
		}

		return $ret;
	}
}
