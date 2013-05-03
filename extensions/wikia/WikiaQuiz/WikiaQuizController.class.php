<?php

class WikiaQuizController extends WikiaController {

	/**
	 * Render HTML Quiz namespace pages
	 */

	public function init() {
		$this->wgBlankImgUrl = $this->wg->BlankImgUrl;
		$this->quiz = null;
		$this->quizElement = null;
		$this->data = null;
	}

	public function executeIndex($params) {
		if (!$this->checkPermissions()) {
			return;
		}

		if (!empty($params['quiz'])) {
			$this->quiz = $params['quiz'];
			$this->data = $this->quiz->getData();
		}
	}

	public function executeArticleIndex($params) {
		if (!$this->checkPermissions()) {
			return;
		}

		if (!empty($params['quizElement'])) {
			$this->quizElement = $params['quizElement'];
			$this->data = $this->quizElement->getData();
		}
	}

	public function executePlayQuiz($params) {
		global $wgUser, $wgOut, $wgRequest, $wgSiteName;

		$this->data = $params['data'];

		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();
		$this->wordmarkType = $settings['wordmark-type'];
		$this->wordmarkText = $settings['wordmark-text'];
		if ($this->wordmarkType == 'graphic') {
			$this->wordmarkUrl = wfReplaceImageServer($settings['wordmark-image-url'], SassUtil::getCacheBuster());
		}

		// Facebook opengraph meta data
		$wgOut->addMeta('property:og:title', $this->data['titlescreentext']);
		$wgOut->addMeta('property:og:type', 'game');
		$wgOut->addMeta('property:og:url', $wgRequest->getFullRequestURL());
		$wgOut->addMeta('property:og:site_name', $wgSiteName);

		// mech: simply stripping the tags wont work, as some tags have to be replaced with a space
		$descrition = $this->data['fbrecommendationtext'];
		if (!$descrition) {
			/* mech: fbrecommendationtext field was intoduced while fixing bug 14843.
			 * For older quizes the FB recommendation description defaults to titlescreentext
			 */
			$descrition = str_replace('<', ' <', $this->data['titlescreentext']);  // introduce an extra space at in front of tags
			$descrition = strip_tags($descrition);
			$descrition = preg_replace('/\s\s+/u', ' ', $descrition);	// eliminate extraneous whitespaces
		}
		$wgOut->addMeta('property:og:description', $descrition);
		$wgOut->addMeta('property:og:image', $this->wordmarkUrl);

		$this->username = $wgUser->getName();
		$this->isAnonUser = $wgUser->isAnon();

		// render this array in PHP and encode it properly for JS
		$this->quizVars = array(
			'cadence' => array(
				wfMsg('wikiaquiz-game-cadence-3'),
				wfMsg('wikiaquiz-game-cadence-2'),
				wfMsg('wikiaquiz-game-cadence-1'),
			),
			'correctLabel' => wfMsg('wikiaquiz-game-correct-label'),
			'incorrectLabel' => wfMsg('wikiaquiz-game-incorrect-label'),
		);

		// prefill with user's email
		$this->defaultEmail = $wgUser->isLoggedIn() ? $wgUser->getEmail() : '';

		// use token to prevent direct requests to the backend for storing emails
		$this->token = $wgUser->getEditToken('WikiaQuiz' /* $salt */);
	}

	/**
	 * depracated, keeping for reference.  Please do not delete the other resources (js, css)
	 * @author Hyun Lim
	 */
	public function executeSampleQuiz() {
		$this->executeGetQuiz();
	}

	/**
	 * depracated, keeping for reference.  Please do not delete the other resources (js, css)
	 * @author Hyun Lim
	 */
	public function executeSampleQuiz2() {
		$this->executeGetQuiz();
	}

	public function executeGetQuizElement() {
		$wgRequest = F::app()->getGlobal('wgRequest');
		$elementId = $wgRequest->getVal('elementId');
		if ($elementId) {
			$quizElement = WikiaQuizElement::newFromId($elementId);
			$this->data = $quizElement->getData();
		}
	}

	public function executeGetQuiz() {
		$wgRequest = F::app()->getGlobal('wgRequest');
		$quizName = $wgRequest->getVal('quiz');
		if ($quizName) {
			$title = Title::newFromText($quizName, NS_WIKIA_QUIZ);
			$quiz = WikiaQuiz::newFromTitle($title);
			$this->data = $quiz->getData();
		}
	}

	public function executeCreateQuiz() {

	}

	public function executeEditQuiz($params) {
		$title = Title::newFromText ($params['title'], NS_WIKIA_QUIZ) ;

		if (is_object($title) && $title->exists()) {
			$this->quiz = WikiaQuiz::NewFromTitle($title);
			$this->data = $this->quiz->getData();
		}
	}

	public function executeCreateQuizArticle() {

	}

	public function executeEditQuizArticle($params) {
		$title = Title::newFromText ($params['title'], NS_WIKIA_QUIZARTICLE) ;

		if (is_object($title) && $title->exists()) {
			$this->quizElement = WikiaQuizElement::NewFromTitle($title);
			$this->data = $this->quizElement->getData();
		}
	}

	private function checkPermissions() {
		global $wgUser, $wgOut;

		if ($wgUser->isBlocked()) {
			throw new UserBlockedError( $wgUser->mBlock );
		}
		if (!$wgUser->isAllowed('wikiaquiz')) {
			throw new PermissionsError( "" );
		}
		if (wfReadOnly() && !wfAutomaticReadOnly()) {
			$wgOut->readOnlyPage();
			return false;
		}

		return true;
	}

}
