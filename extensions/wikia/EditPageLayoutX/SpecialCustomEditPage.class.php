<?php

/**
 * class for special pages implementing custom edit pages
 *
 * @author macbre
 */

class SpecialCustomEditPage extends SpecialPage {
	/* status for title */

	const STATUS_OK = 0;
	const STATUS_EMPTY = -1;
	const STATUS_INVALID = -2;
	const STATUS_ALREADY_EXISTS = -3;

	/* mode of edit page */

	const MODE_UNKNOWN = 0;
	const MODE_NEW_SETUP = 1;
	const MODE_NEW = 2;
	const MODE_EDIT = 3;

	protected $app;
	protected $out;
	protected $request;
	protected $mEditPage;
	protected $mEditedArticle;
	protected $mHiddenFields = array(); // hidden fields - will be moved to mEditPage when created
	protected $mPageTitle = null;
	protected $contentStatus = null;
	protected $titleFieldName = 'wpTitle';
	protected $pageIdFieldName = "pageId";
	protected $titleStatus = self::STATUS_OK;
	protected $titleNS = null;
	protected $fullScreen = true;
	protected $editNoticesStack = array();
	protected $hideTitle = false;

	public function __construct( $name = '', $restriction = '', $listed = true, $function = false, $file = 'default', $includable = false ) {
		parent::__construct( $name, $restriction, $listed, $function, $file, $includable );

		$this->app = F::app();
		$this->out = $this->app->getGlobal('wgOut');
		$this->request = $this->app->getGlobal('wgRequest');
		$this->user = $this->app->getGlobal('wgUser');
		$this->contLang = $this->app->getGlobal('wgContLang');
	}

	/**
	 * Log utility
	 */
	protected function log($method, $data) {
		$data = !is_string($data) ? print_r($data, true) : $data;

		wfDebug("{$method}: {$data}\n");
	}

	/**
	 * Use given Article object as edit form content source
	 */
	protected function setEditedArticle(Article $article) {
		$this->mEditedArticle = $article;

		$this->log(__METHOD__, $article->getTitle()->getPrefixedText());
	}

	/**
	 * Returns the currently edited Article object
	 */
	protected function getEditedArticle() {
		return $this->mEditedArticle;
	}

	/**
	 * Returns the currently edited Title object
	 */
	protected function getEditedTitle() {
		$editedArticle = $this->getEditedArticle();
		return $editedArticle ? $editedArticle->getTitle() : false;
	}

	/**
	 * Use given Title object as edit form content source
	 */
	protected function setEditedTitle(Title $title) {
		$article = new Article($title);
		$this->setEditedArticle($article);
	}

	protected function setPageTitle($title) {
		$this->mPageTitle = $title;
	}

	protected function getPageTitle() {
		return $this->mPageTitle;
	}

	protected function addHiddenField($field) {
		if(!empty($field['valuefromrequest'])) {
			$valuefromrequest = $this->getField($field['valuefromrequest'], '');
			if( !empty($valuefromrequest) ) {
				$field['value'] = $valuefromrequest;
			}
		}
		$this->mHiddenFields[] = $field;
	}

	/**
	 * Add checkbox next to "minor edit"
	 */
	protected function addCustomCheckbox($name, $label, $checked) {
		$this->mEditPage->addCustomCheckbox($name, $label, $checked);
	}

	/**
	 * Ferce user to provide article name
	 */
	protected function forceUserToProvideTitle($msg) {
		if($this->mode == self::MODE_EDIT) {
			return;
		}

		$this->addHiddenField(array(
			'name' => $this->titleFieldName,
			'type' => 'text',
			'label' => wfMsg($msg),
			'valuefromrequest' => $this->titleFieldName,
			'value' => $this->getEditedArticle()->getTitle()->getText(),
			'required' => true
		));

		$this->log(__METHOD__, 'title forced');
	}

	/**
	 * Add dismissable notice and prevent submit of the edit form
	 */
	public function addEditNotice($text) {
		if (!empty($this->mEditPage)) {
			$this->mEditPage->addEditNotice($text);
		} else {
			$this->editNoticesStack[] = $text;
		}
	}

	/**
	 * Get value of given request parameter
	 */
	protected function getField($fieldName, $default = '') {
		return $this->request->getVal($fieldName, $default);
	}

	/**
	 * Return wikitext from given POST request
	 */
	protected function getWikitextFromField($fieldName) {
		$wikitext = $this->request->getText($fieldName);

		// perform reverse parsing when needed (i.e. convert HTML from RTE to wikitext)
		if (class_exists('RTE') && ($this->request->getVal('RTEMode') == 'wysiwyg' || $this->request->getVal('mode') == 'wysiwyg' )) {
			$wikitext = RTE::HtmlToWikitext($wikitext);
			$this->request->setVal('RTEMode', null);
		}

		return $wikitext;
	}

	/**
	 * load title from Request (get)
	 */

	protected function loadTitleFromRequest() {
		$titleId = intval($this->getField($this->pageIdFieldName));
		$oTitle = $titleId ? Title::newFromID( $titleId ) : null;
		return $oTitle;
	}


	/**
	 * Function used to load props etc.
	 */
	protected function afterArticleInitialize($mode, $title, $article) {
		return true;
	}

	/**
	 * Function used to render some html instead of editpage textarea
	 */
	public function showOwnTextbox() {
		return false;
	}

	/**
	 * create and return default title can be override by not empty title
	 */
	protected function getDefaultTitle() {
		$defaultTitle = new Title;

		// default title should be in the $titleNS namespace (BugId:8331)
		if (!is_null($this->titleNS)) {
			$defaultTitle->mNamespace = $defaultTitle->mDefaultNamespace = $this->titleNS;

			// don't show recreation warning (FIXME, I'am an ugly hack)
			$defaultTitle->mPrefixedText = 'DummyPrefixedText';
			$this->hideTitle = true;
		}

		return $defaultTitle;
	}

	/**
	 * Get edit page object
	 */
	public function getEditPage() {
		return $this->mEditPage;
	}

	/**
	 * initialize article title
	 */
	protected function initializeTitle($postedTitle) {
		if(!empty($postedTitle)) {
			$postedTitle =  $this->getTitlePrefix() . $postedTitle;
		}

		$requestedTitle = $this->loadTitleFromRequest();
		$requestedArticle = $requestedTitle ? new Article($requestedTitle) : null;

		if ($requestedTitle && ( $this->titleNS == null || $requestedTitle->getNamespace() ==  $this->titleNS)
				&& $requestedArticle && $requestedArticle->exists()) {
			// We are editing an existing article
			$this->setEditedTitle($requestedTitle);
			$this->mode = self::MODE_EDIT;
			return true;
		}


		$title = $this->getDefaultTitle();
		$this->setEditedTitle($title);

		$this->mode = self::MODE_NEW_SETUP;
		if ($this->request->wasPosted()) {
			$this->mode = self::MODE_NEW;
		}

		if ( empty( $postedTitle ) ) {
			$this->titleStatus = self::STATUS_EMPTY;
		} else {
			// We are trying to create new article
			if($this->titleNS == null ) {
				$title = Title::newFromText( $postedTitle );
			} else {
				$title = Title::newFromText( $postedTitle, $this->titleNS  );
			}
			if ( !$title || strlen( $title->getFragment() ) > 0 ) {
				$this->titleStatus = self::STATUS_INVALID;
			} else {
				$article = new Article( $title );
				if ( $article->exists() ) {
					$this->titleStatus = self::STATUS_ALREADY_EXISTS;
				}
				$this->setEditedTitle($title);
			}
		}
	}

	/**
	 * used by to add same prefix before title (example: blogs)
	 */
	protected function getTitlePrefix() {
		return "";
	}

	/**
	 * initialize article edit page
	 */
	protected function initializeEditPage() {
		$helper = EditPageLayoutHelper::getInstance();

		$editPage = $helper->setupEditPage($this->mEditedArticle, $this->fullScreen, get_class($this) );

		//var used by onMakeGlobalVariablesScript in EditPageLayoutHelper
		if(!empty($this->titleNS)) {
			$helper->addJsVariable('wgEditedTitleNS', $this->contLang->getFormattedNsText( $this->titleNS ));
		} else {
			$helper->addJsVariable('wgEditedTitleNS', '');
		}

		$helper->addJsVariable('wgEditedTitlePrefix', $editPage->titlePrefix = $this->getTitlePrefix());

		if ($this->mode == self::MODE_NEW_SETUP) {
			$helper->addJsVariable('wgEditPageIsNewArticle', true);
		}
		return $editPage;
	}

	/**
	 * Special page's entry point
	 */
	public function execute($par) {
		//set action to have some value(not empty)
		$this->action = $this->request->getVal('action', 'edit');
		$this->request->setVal( 'action', $this->action );

		$value = $this->getField($this->titleFieldName);

		if($this->initializeTitle( $value ) === false) {
			return ;
		}

		$this->addHiddenField(array(
			'name' => $this->pageIdFieldName,
			'type' => 'hidden',
			'label' => false,
			'valuefromrequest' => $this->pageIdFieldName,
			'value' => $this->getTitle()->getArticleID(),
			'required' => true
		));

		$pageTitle = $this->getPageTitle();
		if( !empty($pageTitle) ) {
			$this->setPageTitle($pageTitle);
		}

		if ( class_exists( 'CategorySelectHooksHelper') ) {
			CategorySelectHooksHelper::onMediaWikiPerformAction( null, null, $pageTitle, null, null, null, false );
		}

		// (try to) create instance of custom EditPage class
		$this->mEditPage = $this->initializeEditPage();

		if (!($this->mEditPage instanceof EditPage)) {
			return;
		}
		$this->mEditPage->hideTitle = $this->hideTitle;

		$this->afterArticleInitialize($this->mode, $this->getEditedArticle()->getTitle(), $this->getEditedArticle());

		$this->setUpControlButtons();

		// handle POSTed requests as AJAX requests
		if ($this->request->wasPosted()) {
			$method = $this->request->getVal('method');

			// execute processXxxx method
			if (!empty($method)) {
				$this->log(__METHOD__, "post request - '{$method}'");

				$methodName = 'process' . ucfirst($method);

				// use POSTed "title" value
				if (method_exists($this, $methodName)) {
					$data = $this->$methodName();

					$this->request->response()->header('application/json; charset=utf-8');

					$this->out->setArticleBodyOnly(true);
					$this->out->addHtml(json_encode($data));

					// leave now - just emit JSON
					return;
				}
			}

			// prepare for MW save
			if ($this->action == 'submit') {
				$this->log(__METHOD__, 'saving...');
				$this->log(__METHOD__, $this->request->getValues());

				$content = trim($this->getWikitextFromRequest());
				$this->request->setVal('wpTextbox1', $content);
				$this->contentStatus = null;
				if ($content == '') {
					$this->contentStatus = EditPage::AS_BLANK_ARTICLE;
				}
				// perform additional checks
				$this->processSubmit();

				// check for notices
				if (!empty($this->mEditNotices)) {
					$this->log(__METHOD__, 'preveting');
				}
			}
		}

		// set this special page as a custom handler of save / preview / show changes requests
		$this->mEditPage->setCustomFormHandler(Title::makeTitle(NS_SPECIAL, $this->mName));

		// preload text if
		$preloadedText = $this->getWikitextForPreload();
		if ($preloadedText !== false) {
			$this->mEditPage->setPreloadedText($preloadedText);
		}

		$this->mEditPage->mSpecialPage = $this;


		// render edit form
		$this->mEditPage->lastSaveStatus = null;

		$this->renderHeader($par);

		foreach ($this->editNoticesStack as $editNotice) {
			$this->mEditPage->addEditNotice($editNotice);
		}

		foreach ($this->mHiddenFields as $field) {
			$this->mEditPage->addHiddenField($field);
		}

		// render special page setup method
		$this->mEditPage->submit();

		if (!empty($this->mEditPage->lastSaveStatus)) {
			$this->afterSave($this->mEditPage->lastSaveStatus);
		}

		$this->renderFooter($par);
		// set custom page title
		$this->out->setPageTitle($this->mPageTitle);
	}

	/**
	 * Called when special page is rendered
	 */
	function renderHeader($par) {

	}

	/**
	 * Called after code edit page render
	 */
	function renderFooter($par) {

	}

	/**
	 * Allow extensions to perform additional checks when saving an article
	 */
	protected function processSubmit() {
		// no errors were found - proceed
		return true;
	}

	/**
	 * Return wikitext
	 */
	public function getWikitextFromRequest() {
		// "wikitext" field used when generating preview / diff
		$wikitext = $this->request->getText('wikitext');
		$method = $this->request->getVal('method', '');

		if ($wikitext == '') {
			if ($method == 'preview' || $method == 'diff') {
				$wikitext = $this->getWikitextFromField('content');

				// Add categories to wikitext for preview and diff
				if ( !empty( $this->app->wg->EnableCategorySelectExt ) ) {
					$categories = $this->request->getVal( 'categories', '' );

					if ( !empty( $categories ) ) {
						$wikitext .= CategoryHelper::changeFormat( $categories, 'json', 'wikitext' );
					}
				}

			// "wpTextbox1" field used when submitting editpage
			// (needs to be processed by Reverse Parser if saved from wysiwyg mode)
			} else {
				$wikitext = $this->getWikitextFromField('wpTextbox1');
			}
		}

		return $wikitext;
	}

	/**
	 * Return wikitext for generating preview / diff / to be saved
	 */
	public function getWikitextFromRequestForPreview($title) {
		$this->initializeTitle($title);
		return $this->getWikitextFromRequest();
	}

	/**
	 * Override this to take action after page has been saved
	 * @param int $status EditPage save status
	 */
	protected function afterSave( $status ) {
	}

	/**
	 * Used to set some default values (summery etc.)
	 */
	public function beforeSave() {
	}

	/**
	 * Override this method to deliver text to be preloaded into editor
	 * Enter description here ...
	 */
	protected function getWikitextForPreload() {
		return false;
	}

	/**
	 * Override this method to set up buttons in Page Controls module
	 */
	protected function setUpControlButtons() {
	}

	/**
	 * Function used to render some html instead preview or diff
	 */

	public function getOwnPreviewDiff( $wikitext, $method ) {
		return false;
	}
}
