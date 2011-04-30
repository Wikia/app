<?php

/**
 * Oasis module for EditPageLayout
 *
 * Renders modified HTML for edit pages
 */
class EditPageLayoutModule extends Module {

	// globals
	var $wgBlankImgUrl;

	// template variables
	var $bodytext;

	// action for edit form
	var $editFormAction;

	// rendered summary box
	var $summaryBox;

	// notices
	var $notices;

	/**
	 * Render HTML for whole edit page
	 */
	public function executeIndex() {
		// render edit page content
		$body = wfRenderModule('EditPageLayout', 'EditPage');

		// page has one column
		OasisModule::addBodyClass('oasis-one-column');

		// render Oasis module
		$this->html = F::app()->renderView( 'Oasis', 'Index', array('body' => $body) );
	}

	/**
	 * Render template for <body> tag content
	 */
	public function executeEditPage() {
		$app = WF::build('App');

		$helper = WF::build('EditPageLayoutHelper');
		$editPage = $helper->getEditPage();

		// render WikiLogo
		$wikiHeaderData = Module::get('WikiHeader')->getData();

		// move wordmark data
		$this->wordmark = $wikiHeaderData;

		// render global and user navigation
		$this->header = wfRenderModule('GlobalHeader');

		// Editing [foo]
		$title = $editPage->getEditedTitle();
		$section = $app->getGlobal('wgRequest')->getVal('section');

		if ($section == 'new') {
			$msgKey = 'editingcomment';
		}
		else if (is_numeric($section)) {
			$msgKey = 'editingsection';
		}
		else {
			$msgKey = 'editing';
		}

		// title
		$titleText = $title->getPrefixedText();

		if ($titleText == '') {
			$titleText = ' ';
		}

		$this->title = $app->runFunction('wfMsg', $msgKey,
			Xml::element('a', array('href' => $title->getLocalUrl()), $titleText));

		// render help link and point the link to new tab
		$this->helpLink = $app->runFunction('wfMsgExt', 'editpagelayout-helpLink', array('parseinline'));
		$this->helpLink = str_replace('<a ', '<a target="_blank" ', $this->helpLink);

		// action for edit form
		$this->editFormAction = $editPage->getFormAction();

		// summary box
		$this->summaryBox = $editPage->renderSummaryBox();

		// extra buttons
		$this->buttons = $editPage->getControlButtons();


		// dismissable notices
		$this->notices = $editPage->getNotices();
		$this->noticesHtml = $editPage->getNoticesHtml();

		// check if we're in read only mode
		// disable edit form when in read-only mode
		if ($app->runFunction('wfReadOnly')) {
			$this->bodytext = '<div id="mw-read-only-warning" class="WikiaArticle">'.
					$app->runFunction('wfMsg', 'oasis-editpage-readonlywarning', $app->runFunction('wfReadOnlyReason')).
					'</div>';

			wfDebug(__METHOD__ . ": edit form disabled because read-only mode is on\n");
		}
	}
}
