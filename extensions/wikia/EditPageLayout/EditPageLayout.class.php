<?php

/**
 * Custom implementation of EditPage class (remove certain elements)
 */
class EditPageLayout extends EditPage {

	protected $app;
	protected $out;
	protected $request;

	// emit <form> tag wrapping #EditPage section
	protected $dontWrapWithForm = true;

	// text for preloading into editor
	protected $preloadedText = false;

	// Title object of the page handling edit page submit
	protected $mCustomHandlerTitle = null;

	// hidden fields - shown as a dialog when "Edit title" button is clicked
	protected $mHiddenFields = array();

	// settings for summary box (textarea in right rail's page controls)
	protected $mSummaryBox = array();

	// HTML for dismissable notices (from MW)
	protected $mCoreEditNotices = null;

	// custom notices from extensions
	protected $mEditNotices = null;

	// HTML rendered by form callbck
	protected $mCallbackNotices = null;

	// buttons in page controls section
	protected $mControlButtons = array(
		array( 'type' => 'preview' ),
		array( 'type' => 'save' ),
	);

	//prevent of save
	public $mPreventSave = false;

	//used to call beforeSave method
	public $mSpecialPage = null;

	// is edit page read only (i.e. anon can not edit)
	protected $mIsReadOnlyPage;

	// is permission error triggered
	public $mHasPermissionError = false;

	function __construct(Article $article) {
		parent::__construct($article);

		$this->app = WF::build('App');
		$this->out = $this->app->getGlobal('wgOut');
		$this->request = $this->app->getGlobal('wgRequest');

		// default setup of summary box
		$this->mSummaryBox = array(
			'name' => 'wpSummary',
			'placeholder' => wfMsg('editpagelayout-pageControls-summaryLabel'),
		);

		$this->mCoreEditNotices = WF::build('EditPageNotices');
		$this->mEditNotices = WF::build('EditPageNotices');


		// add messages (fetch them using <script> tag)
		JSMessages::getInstance()->enqueuePackage('EditPageLayout', JSMessages::EXTERNAL);
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
			$ret = self::AS_SUMMARY_NEEDED;
		}
		else {
			$ret = parent::internalAttemptSave($result, $bot);
		}

		$this->lastSaveStatus = $ret;

		wfDebug(__METHOD__ . ": returned #{$ret}\n");

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
		$oldHtml = $this->out->getHTML();

		$this->out->clearHTML();

		$bridge = WF::build('EditPageOutputBridge',array($this,$this->mCoreEditNotices));
		parent::showHeader();

		// handle notices related to edit undo
		if ($this->editFormPageTop != '') {
			$bridge->getMockObject()->addHTML($this->editFormPageTop);
			$this->editFormPageTop = '';
		}

		$bridge->close();
//		var_dump($this->out->getHTML());
		/*
		$notices = $this->out->getHTML();
		if ($notices != '') {
			$this->mCoreEditNotices = $notices;
		}
		*/

		// restore state of output
		$this->out->clearHTML();
		$this->out->addHTML($oldHtml);
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
	public function addEditNotice($text) {
		$this->mEditNotices->add($text);

		wfDebug(__METHOD__ . ": \"{$text}\"\n");
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
			$buttons[$k] = array_merge(array(
				// defaults
				'enabled' => true,
			),$v,array(
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
			$this->out->addHtml('<div class="gap">&nbsp;</div>');
			$this->out->addHtml('<div id="diff">');
			$this->showDiff();
			$this->out->addHtml('</div>');
		}
		
		parent::showEditForm($formCallback);
		
	}

	/**
	 * Override importFormData  to add possibility to prevent save during post request
	 */
	function importFormData( &$request ) {
		$out = parent::importFormData($request);
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
		$html = Xml::element('textarea', array(
			'id' => $this->mSummaryBox['name'],
			'name' => $this->mSummaryBox['name'],
			'placeholder' => $this->mSummaryBox['placeholder'],
		), $this->summary, false /* $allowShortTag */);

		return $html;
	}

	/**
	 * Emit hidden field for "watch this"
	 */
	protected function showStandardInputs( &$tabindex = 2 ) {
		$this->out->addHTML(Xml::check('wpWatchthis', $this->watchthis, array('type' => 'hidden')));
	}

	/**
	 * Add hidden fieldset with custom hidden fields to edit page form
	 */
	protected function showFormBeforeText() {
		parent::showFormBeforeText();
		$this->out->addHtml("\n" . $this->renderHiddenFields() . "\n");
		$this->out->addHtml("\n" . $this->renderCallbackNotices() . "\n");
	}

	/*
	 * Show an edit conflict. textbox1 is already shown in showEditForm().
	 * If you want to use another entry point to this function, be careful.
	 */
	protected function showConflict() {
		$this->textbox2 = $this->textbox1;
		$this->textbox1 = $this->getContent();

		if ( wfRunHooks( 'EditPageBeforeConflictDiff', array( &$this, &$this->out ) ) ) {
			$this->out->addHtml('<div class="gap">&nbsp;</div>');

			// diff
			$this->out->addHtml('<div id="diff">');
			$this->out->wrapWikiMsg( '<h2>$1</h2>', 'editpagelayout-diff-header' );

			$de = new DifferenceEngine( $this->mTitle );
			$de->setText( $this->textbox2, $this->textbox1 );
			$de->showDiff( wfMsg( "yourtext" ), wfMsg( "storedversion" ) );

			$this->out->addHtml('</div>');

			$this->out->addHtml('<div class="gap">&nbsp;</div>');

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
		parent::showTextbox1($customAttribs, $textoverride );
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
	function readOnlyPage( $source = null, $protected = false, $reasons = array(), $action = null ) {
		$this->mIsReadOnlyPage = true;

		parent::readOnlyPage($source, $protected, $reasons, $action);
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
	 * Overwrite methods below to remove certain elements of the edit page
	 */
	protected function getCopywarn() {}
	protected function showEditTools() {}
	protected function showIntro() {}
	protected function showSummaryInput( $isSubjectPreview, $summary = "" ) {}
	protected function displayPreviewArea( $previewOutput, $isOnTop = false ) {}
}
