<?php

/**
 * Custom implementation of EditPage class (remove certain elements)
 */
class EditPageLayout extends EditPage {

	const COPYRIGHT_CACHE_TTL = 86400;

	protected $app;
	protected $out;
	protected $request;
	/**
	 * @var EditPageLayoutHelper
	 */
	protected $helper = null;

	// emit <form> tag wrapping #EditPage section
	protected $dontWrapWithForm = true;

	// text for preloading into editor
	protected $preloadedText = false;

	// Title object of the page handling edit page submit
	protected $mCustomHandlerTitle = null;

	// hidden fields - shown as a dialog when "Edit title" button is clicked
	protected $mHiddenFields = array();

	// custom checkboxes shown next to minor edit in page controls module (BugId:6247)
	protected $mCustomCheckboxes = array();

	// settings for summary box (textarea in right rail's page controls)
	protected $mSummaryBox = array();

	// HTML for dismissable notices (from MW)
	/* @var $mCoreEditNotices EditPageNotices */
	protected $mCoreEditNotices = null;

	// custom notices from extensions
	/* @var $mEditNotices EditPageNotices */
	protected $mEditNotices = null;

	// HTML rendered by form callbck
	protected $mCallbackNotices = null;

	// buttons in page controls section
	protected $mControlButtons = array(
		array( 'type' => 'preview' ),
		array( 'type' => 'save' ),
	);

	// prevent of save
	public $mPreventSave = false;

	// used to call beforeSave method
	public $mSpecialPage = null;

	// is edit page read only (i.e. anon can not edit)
	protected $mIsReadOnlyPage;

	// is permission error triggered
	public $mHasPermissionError = false;

	// edit page preloads
	protected $mEditPagePreloads = array();

	// hide title on special CreateBlogPage
	public $hideTitle = false;

	// prevent rendering list of used templates
	protected $preventRenderingTemplatesList = true;

	/**
	 * @param Article $article
	 */
	function __construct(Article $article) {
		$this->app = F::app();
		$this->out = $this->app->wg->Out;
		$this->request = $this->app->wg->Request;

		wfProfileIn(__METHOD__);

		parent::__construct($article);

		$this->helper = EditPageLayoutHelper::getInstance();

		// default setup of summary box
		$this->mSummaryBox = array(
			'name' => 'wpSummary',
			'placeholder' => wfMsg('editpagelayout-pageControls-summaryLabel'),
		);

		$this->mCoreEditNotices = new EditPageNotices();
		$this->mEditNotices = new EditPageNotices();

		// add messages (fetch them using <script> tag)
		JSMessages::enqueuePackage('EditPageLayout', JSMessages::EXTERNAL);

		wfProfileOut(__METHOD__);
	}

	function edit() {
		parent::edit();

		// handle "section=new" case
		$section = $this->app->getGlobal('wgRequest')->getVal('section');

		if ($section == 'new') {
			$this->mSummaryBox['placeholder'] = wfMsg('editpagelayout-pageControls-newSectionLabel');
		}
	}

	/**
	 * Attempt submission (no UI)
	 * @return one of the constants describing the result
	 */
	function internalAttemptSave(&$result, $bot = false) {

		if(!empty($this->mSpecialPage)) {
			$this->mSpecialPage->beforeSave();
		}

		if (!$this->mEditNotices->isEmpty()) {
			wfDebug(__METHOD__ . ": custom edit notices found - submit prevented\n");
			$ret = Status::newGood();
			$ret->setResult( false, self::AS_SUMMARY_NEEDED );
		}
		else {
			// tell MW core to save the article
			$ret = parent::internalAttemptSave($result, $bot);

			// add a message returned by hook
			if ($this->hookError !== '') {
				$this->mEditNotices->add($this->hookError, 'HookError');
			}
		}

		$this->lastSaveStatus = $ret;

		wfDebug(__METHOD__ . ": returned #" . $ret->value . "\n");

		// fire a custom hook when an edit from the edit page is successful (BugId:1317)
		if (in_array($ret->value, array(self::AS_SUCCESS_UPDATE, self::AS_SUCCESS_NEW_ARTICLE, self::AS_OK, self::AS_END))) {
			wfDebug(__METHOD__ . ": successful save\n");
			wfRunHooks('EditPageSuccessfulSave', array($this, $ret));
		}

		return $ret;
	}

	/**
	 * Attempt submission
	 * @return bool false if output is done, true if the rest of the form should be displayed
	 */
	function attemptSave() {
		$break = parent::attemptSave();
		return $break;
	}

	/**
	 * Get HTML of notices shown above the editor and use show it as custom dismissable notice
	 */
	protected function showHeader() {
		wfProfileIn(__METHOD__);
		$oldHtml = $this->out->getHTML();

		$this->out->clearHTML();

		$bridge = new EditPageOutputBridge($this,$this->mCoreEditNotices);
		parent::showHeader();

		// handle notices related to edit undo
		if ($this->editFormPageTop != '') {
			$bridge->getMockObject()->addHTML($this->editFormPageTop);
			$this->editFormPageTop = '';
		}

		$bridge->close();

		// restore state of output
		$this->out->clearHTML();
		$this->out->addHTML($oldHtml);

		wfProfileOut(__METHOD__);
	}

	/**
	 * Get HTML of notices shown above the editor and use show it as custom dismissable notice
	 */
	public function blockedPage() {
		$this->helper->addJsVariable( 'wgEditPageIsReadOnly', true );
		$first = $this->firsttime || ( !$this->save && $this->textbox1 == '' );

		$bridge = new EditPageOutputBridge($this,$this->mCoreEditNotices);
		parent::blockedPage();
		$bridge->close();

		$this->mCoreEditNotices->get( 'blockedtext' )->setSummary( wfMsg( 'editpagelayout-blocked-user' ) );
		$this->mCoreEditNotices->remove( 'blockededitsource' );
		$this->mCoreEditNotices->remove( false );

		// restore state of output
		$this->out->clearHTML();

		$this->out->addHtml('<div id="myedit">');
		$this->out->addHtml( '<h2>' . wfmsgExt( $first ? 'blockedoriginalsource' : 'blockededitsource', array( 'parseinline' ), $this->mTitle->getPrefixedText() ) . '</h2>' );
		$this->showTextbox1();
		$this->out->addHtml('</div>');
	}

	public function setPreloadedText( $text ) {
		$this->preloadedText = $text;
	}

	/**
	 * Get list of dismissable notices (both custom and coming from MW)
	 */
	public function getNotices() {
		$notices = array_merge($this->mCoreEditNotices->getSummary(),$this->mEditNotices->getSummary());

		return $notices;
	}

	/**
	 * Get all notices in HTML format (ready to show to the user)
	 */
	public function getNoticesHtml() {
		$html = $this->mCoreEditNotices->getHtml() . $this->mEditNotices->getHtml();

		return $html;
	}

	/**
	 * Add dismissable notice and prevent submit of the edit form
	 */
	public function addEditNotice($text, $id = false) {
		$this->mEditNotices->add($text, $id);

		wfdebug(__METHOD__ . ": \"{$text}\"\n");
	}

	/**
	 * Add button to Page Controls section
	 */
	public function addControlButton( $button ) {
		$this->mControlButtons[] = $button;
	}

	/**
	 * Set list of buttons visible in Page Controls
	 * @param $buttons
	 */
	public function setControlButtons( $buttons ) {
		$this->mControlButtons = $buttons;
	}

	/**
	 * Get all buttons in Page Controls section
	 */
	public function getControlButtons() {
		$buttons = $this->mControlButtons;
		$seqNo = 0;
		foreach ($buttons as $k => $v) {
			$buttons[$k] = array_merge($v,array(
				// overrides
				'seqNo' => $seqNo++,
			));
		}
		return $buttons;
	}

	/**
	 * Send the edit form and related headers to $wgOut
	 * @param $formCallback Optional callable that takes an OutputPage
	 *                      parameter; will be called during form output
	 *                      near the top, for captchas and the like.
	 */
	function showEditForm($formCallback=null) {
		wfProfileIn(__METHOD__);

		// get HTML from form callback
		if (is_callable($formCallback)) {
			wfDebug(__METHOD__ . ": has form callback\n");

			$out = new OutputPage();
			call_user_func_array($formCallback, array(&$out));
			$this->mCallbackNotices = $out->getHTML();

			$formCallback = null;
		}

		if ($this->preloadedText !== false) {
			$this->textbox1 = $this->preloadedText;
		}

		// show diff only (handle edit reverts)
		if ($this->formtype == 'diff') {
			$this->out->addHtml('<div id="diff">');
			$this->showDiff();
			$this->out->addHtml('</div>');
		}

		parent::showEditForm($formCallback);
		wfProfileOut(__METHOD__);
	}

	/**
	 * Override importFormData  to add possibility to prevent save during post request
	 */
	function importFormData( &$request ) {
		parent::importFormData($request);
		if( $this->mPreventSave ) {
			$this->save = false;
		}
	}

	/**
	 * Set Title object of the page which should handle page save
	 */
	public function setCustomFormHandler(Title $title) {
		$this->mCustomHandlerTitle = $title;
	}

	/**
	 * @return Title
	 */
	public function getCustomFormHandler() {
		return $this->mCustomHandlerTitle;
	}

	/**
	 * Return URL to be used as action attribute for edit form
	 */
	public function getFormAction() {
		return parent::getActionURL(!is_null($this->mCustomHandlerTitle) ? $this->mCustomHandlerTitle : $this->mTitle);
	}

	/**
	 * Return Title object of currently edit page
	 */
	public function getEditedTitle() {
		return $this->mTitle;
	}

	/**
	 * Add hidden field to be shown in "Edit title" dialog
	 */
	public function addHiddenField($field) {
		$this->mHiddenFields[] = $field;
	}

	/**
	 * Return HTML of hidden <section> with custom hidden fields
	 */
	public function renderHiddenFields() {
		$html = '<fieldset id="EditPageHiddenFields">';
		foreach($this->mHiddenFields as $field) {
			switch ($field['type']) {
				case 'checkbox':
					$elementAttr = array(
						'type' => 'checkbox',
						'name' => $field['name'],
						'value' => $field['value'],
						'data-required' => !empty($field['required']) ? 1 : null,
					);

					if(!empty($field['value'])) {
						$elementAttr['checked'] = 'checked';
					}

					$fieldHtml = Xml::element('input', $elementAttr);
					break;
				case 'text':
					$fieldHtml = Xml::element('input', array(
						'type' => 'text',
						'name' => $field['name'],
						'value' => $field['value'],
						'data-required' => !empty($field['required']) ? 1 : null,
					));
					break;
				case 'textarea':
					$fieldHtml = Xml::element('textarea', array(
						'name' => $field['name'],
						'data-required' => !empty($field['required']) ? 1 : null,
					), (string)$field['value'], false);
					break;
				case 'hidden':
					$fieldHtml = Xml::element('input',array(
						'type' => 'hidden',
						'name' => $field['name'],
						'value' => $field['value'],
						'data-required' => null,
					));
					break;
			}

			// add label
			if (isset($field['label'])) {
				$html .= "<label>{$field['label']}{$fieldHtml}</label>";
			}
			else {
				$html .= $fieldHtml;
			}
		}

		$html .= '</fieldset>';
		return $html;
	}

	/**
	 * Add custom checkbox next to "minor edit"
	 */
	public function addCustomCheckbox($name, $label, $checked) {
		$this->mCustomCheckboxes[] = array(
			'name' => $name,
			'label' => $label,
			'checked' => !empty($checked),
		);
	}

	/**
	 * Get custom checkboxes
	 */
	public function getCustomCheckboxes() {
		return $this->mCustomCheckboxes;
	}

	/**
	 * Get HTML render by callback provided for showEditForm method
	 */
	public function renderCallbackNotices() {
		$html = '';

		if ($this->mCallbackNotices != '') {
			$html = '<fieldset id="EditPageCallbackFields" style="display: none">';
			$html .= $this->mCallbackNotices;
			$html .= '</fieldset>';
		}

		return $html;
	}

	public function renderSummaryBox() {
		$html = Xml::element( 'input', [
			'type' => 'text',
			'id' => $this->mSummaryBox['name'],
			'name' => $this->mSummaryBox['name'],
			'placeholder' => $this->mSummaryBox['placeholder'],
			'tabindex' => '1', // BugId:5327
			'value' => $this->summary,
		] );

		return $html;
	}

	/**
	 * Emit hidden field for "watch this"
	 */
	protected function showStandardInputs( &$tabindex = 2 ) {
		if ($this->watchthis) {
			// emulate checkbox
			$this->out->addHTML(Html::hidden('wpWatchthis', 'on'));
		}
	}

	/**
	 * Add hidden fieldset with custom hidden fields to edit page form
	 */
	protected function showFormBeforeText() {
		parent::showFormBeforeText();

		// Make AjaxLogin work on EditPage without losing user changes - @author: Inez
		$this->out->addHtml(Html::hidden('wpLogin', '') . "\n");

		$this->out->addHtml("\n" . $this->renderHiddenFields() . "\n");
		$this->out->addHtml("\n" . $this->renderCallbackNotices() . "\n");
	}

	/*
	 * Show an edit conflict. textbox1 is already shown in showEditForm().
	 * If you want to use another entry point to this function, be careful.
	 */
	protected function showConflict() {
		if ( wfRunHooks( 'EditPageBeforeConflictDiff', array( &$this, &$this->out ) ) ) {
			// diff
			$this->out->addHtml('<div id="diff">');
			$this->out->wrapWikiMsg( '<h2>$1</h2>', 'editpagelayout-diff-header' );

			$de = new DifferenceEngine( $this->mTitle );

			$de->setText( $this->textbox2, $this->textbox1 );
			$de->showDiff( wfMsg( "yourtext" ), wfMsg( "storedversion" ) );

			$this->out->addHtml('</div>');

			// user's edit
			$this->out->addHtml('<div id="myedit">');
			$this->out->wrapWikiMsg( '<h2>$1</h2>', 'editpagelayout-myedit-header' );
			$this->showTextbox2();
			$this->out->addHtml('</div>');
		}
	}

	protected function showTextbox1($customAttribs = null, $textoverride = null) {
		if(!empty($this->mSpecialPage)) {
			if($this->mSpecialPage->showOwnTextbox()) {
				return true;
			}
		}

		// MW core says: In an edit conflict bypass the overrideable content form method
		// and fallback to the raw wpTextbox1
		// Wikia: in visual mode we want to show HTML (BugId:5428)
		if ($this->isConflict) {
			$textoverride = $this->getContent();

			// parse it for visual editor (if needed) - BugId:7956
			if ($this->app->wg->Request->wasPosted()) {
				if ($this->app->wg->Request->getVal('RTEMode') == 'wysiwyg') {
					$textoverride = RTE::WikitextToHtml($textoverride);
				}
			}
		}

		parent::showTextbox1($customAttribs, $textoverride );
	}

	/**
	 * Add items to loaded content
	 */
	function getContent($def_text = '') {
		$content = parent::getContent();

		$addFile = $this->app->getGlobal('wgRequest')->getVal('addFile');

		if( $addFile ) {
			$file = wfFindFile( $addFile );

			if( $file ) {
				$title = $file->getTitle()->getText();
				$content = "[[File:" . $title . "|right|thumb|335px]] " . $content;
				$type = WikiaFileHelper::isFileTypeVideo( $file ) ? 'video' : 'photo';
				$this->helper->addJsVariable( 'wgEditPageAddFileType', $type );
			}
		}
		return $content;
	}

	/**
	 * Render read-only textarea
	 */
	protected function showTextbox2() {
		$this->showTextbox( $this->textbox2, 'wpTextbox2', array( 'tabindex' => 6, 'readonly' => 'readonly' ) );
	}

	/**
	 * Show a read-only error
	 * Parameters are the same as OutputPage:readOnlyPage()
	 * Redirect to the article page if redlink=1
	 */
	function displayPermissionsError( array $permErrors ) {
		$this->mIsReadOnlyPage = true;
		$this->helper->addJsVariable( 'wgEditPageIsReadOnly', true );

		$formatPermissionsErrorMessage = $this->app->wg->Out->formatPermissionsErrorMessage( $permErrors, 'edit' );
		$content = $this->app->wg->Out->parse($formatPermissionsErrorMessage);
		$this->mEditPagePreloads['PermissionsError'] = array(
			'content' => $content,
			'class' => 'permissions-errors',
		);

		// All of the following is pasted from EditPage:displayPermissionsError and pruned

		if ( $this->app->wg->Request->getBool( 'redlink' ) ) {
			// The edit page was reached via a red link.
			// Redirect to the article page and let them click the edit tab if
			// they really want a permission error.
			$this->app->wg->Out->redirect( $this->mTitle->getFullUrl() );
			return;
		}

		$content = $this->getContent();

		$this->app->wg->Out->setPageTitle( wfMessage( 'viewsource-title', $this->getContextTitle()->getPrefixedText() ) );
		$this->app->wg->Out->addBacklinkSubtitle( $this->getContextTitle() );

		# If the user made changes, preserve them when showing the markup
		# (This happens when a user is blocked during edit, for instance)
		if ( !$this->firsttime ) {
			$content = $this->textbox1;
			$this->app->wg->Out->addWikiMsg( 'viewyourtext' );
		} else {
			$this->app->wg->Out->addWikiMsg( 'viewsourcetext' );
		}

		$this->showTextbox( $content, 'wpTextbox1', array( 'readonly' ) );

		$this->app->wg->Out->addHTML( Html::rawElement( 'div', array( 'class' => 'templatesUsed' ),
			Linker::formatTemplates( $this->getTemplates() ) ) );

		if ( $this->mTitle->exists() ) {
			$this->app->wg->Out->returnToMain( null, $this->mTitle );
		}

	}

	public function isReadOnlyPage() {
		return !empty($this->mIsReadOnlyPage);
	}

	/**
	 * Handle edit permission errors
	 */
	protected function getEditPermissionErrors() {
		$permErrors = parent::getEditPermissionErrors();

		if ($permErrors) {
			$this->mHasPermissionError = true;
		}

		return $permErrors;
	}

	/**
	 * Show all applicable editing introductions
	 *
	 * - new article intro
	 * - custom intro (editintro=Foo in URL)
	 * - talk page intro
	 * - main page educational note (BugId:51755)
	 *
	 * Handle preloads (BugId:5652)
	 */
	protected function showIntro() {
		// Code based on EditPage.php
		if (!$this->mTitle->exists() ) {
			if ( $this->app->wg->User->isLoggedIn() ) {
				$msgName = 'newarticletext';
				$class = 'mw-newarticletext';
			} else {
				$msgName = 'newarticletextanon';
				$class = 'mw-newarticletextanon';
			}

			// Give a notice if the user is editing a deleted/moved page...
			$titleText = $this->mTitle->getPrefixedText();
			if( !empty( $titleText ) ) {
				$out = new OutputPage();
				$resultRowsNum = LogEventsList::showLogExtract( $out, array( 'delete', 'move' ), $titleText,
					'', array( 'lim' => 10,
						   'conds' => array( "log_action != 'revision'" ),
						   'showIfEmpty' => false,
						   'msgKey' => array( 'recreate-moveddeleted-warn') )
				);
			}

			// check for empty message (BugId:6923)
			$parsedMsg = wfMsg($msgName);
			if (!wfEmptyMsg($msgName, $parsedMsg) && strip_tags($parsedMsg) != '') {
				$msg = wfMsgExt($msgName, array('parse'));

				$this->mEditPagePreloads['EditPageIntro'] = array(
					'content' => $msg,
					'class' => $class,
				);
			}
		}

		// custom intro
		$this->showCustomIntro();

		// Intro text for talk pages (BugId:7092)
		if ($this->mTitle->isTalkPage()) {
			$this->mEditPagePreloads['EditPageTalkPageIntro'] = array(
				'content' => wfmsgExt('talkpagetext', array('parse')),
				'class' => 'mw-talkpagetext',
			);
		} elseif ( $this->mTitle->isMainPage() && !$this->mTitle->isProtected() && !$this->userDismissedEduNote() ) {
			//if this is an unprotected main page and user hasn't seen the main page educational notice -- show it :)
			/** @var $notice EditPageNotice */
			$msg = wfMsgExt('mainpagewarning-notice', array('parse') );
			$notice = new EditPageNotice( $msg, 'MainPageEduNote' );
			$this->helper->addJsVariable('mainPageEduNoteHash', $notice->getHash());
			$this->addEditNotice($notice);
		}

		// Edit notice (BugId:7616)
		$editnotice_ns_key = 'editnotice-'.$this->mTitle->getNamespace();
		$editnotice_ns_msg = new Message( $editnotice_ns_key );
		if ( !$editnotice_ns_msg->isDisabled() ) {
			$this->mEditPagePreloads['EditPageEditNotice'] = array(
				'content' => $editnotice_ns_msg->parse(),
				'class' => 'mw-editnotice',
			);
		}
	}

	/**
	 * @desc Returns true if user is an anon or DB is in read-only mode and false if user hasn't seen the notification about Main Pages in RTE
	 * @return bool
	 */
	protected function userDismissedEduNote() {
		$EditorUserPropertiesHandler = new EditorUserPropertiesHandler();

		try {
			$results = $EditorUserPropertiesHandler->getUserPropertyValue(
				$EditorUserPropertiesHandler->getEditorMainPageNoticePropertyName()
			);
			$result = ($results->value == true) ? true : false;
		} catch( Exception $e ) {
			$result = false;
		}

		return $result;
	}

	/**
	 * Attempt to show a custom editing introduction, if supplied
	 *
	 * @return bool
	 */
	protected function showCustomIntro() {
		// Code based on EditPage.php
		if ( $this->editintro ) {
			$title = Title::newFromText( $this->editintro );
			if ( $title instanceof Title && $title->exists() && $title->userCan( 'read' ) ) {
				$wgOut = new OutputPage();

				// Added using template syntax, to take <noinclude>'s into account.
				$wgOut->addWikiTextTitleTidy( '{{:' . $title->getFullText() . '}}', $this->mTitle );

				// store it
				$text = $wgOut->getHTML();

				$this->mEditPagePreloads['EditPageCustomIntro'] = array(
					'content' => trim($text),
					'class' => 'mw-custompreload',
				);

				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * Get edit page preloads content (both intro and custom intro)
	 */
	public function getEditPagePreloads() {
		return $this->mEditPagePreloads;
	}

	/**
	 * Overwrite methods below to remove certain elements of the edit page
	 */
	protected function getCopywarn() {}
	protected function showSummaryInput( $isSubjectPreview, $summary = "" ) {}
	protected function displayPreviewArea( $previewOutput, $isOnTop = false ) {}

	/**
	 * Should we show a preview when the edit form is first shown?
	 *
	 * We should always return false, so that it's never shown (BugId:7370)
	 *
	 * @return bool
	 */
	protected function previewOnOpen() {
		return false;
	}

	/**
	 * Return contribution/copyright notice
	 */
	public function getCopyrightNotice() {
		global $wgMemc, $wgLang;
		wfProfileIn( __METHOD__ );

		$wikitext = parent::getCopywarn();
		$key = wfMemcKey(__METHOD__,$wgLang->getCode(),md5($wikitext));
		$text = $wgMemc->get($key);
		if ( empty($text) ) {
			wfProfileIn( __METHOD__ . '-parse');
			$text = ParserPool::parse($wikitext, $this->app->wg->Title, new ParserOptions())->getText();
			wfProfileOut( __METHOD__ . '-parse');
			$wgMemc->set($key,$text,self::COPYRIGHT_CACHE_TTL);
		}

		wfProfileOut( __METHOD__ );
		return $text;
	}
}
