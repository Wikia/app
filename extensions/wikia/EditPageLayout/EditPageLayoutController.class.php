<?php

/**
 * Oasis module for EditPageLayout
 *
 * Renders modified HTML for edit pages
 */
class EditPageLayoutController extends WikiaController {

	const TITLE_MAX_LENGTH = 30;

	public function init() {
		$this->bodytext = $this->app->getSkinTemplateObj()->data['bodytext'];
	}

	/**
	 * Render HTML for whole edit page
	 */
	public function executeIndex() {
		// render edit page content
		$body = $this->app->renderView('EditPageLayout', 'EditPage');

		// page has one column
		OasisController::addBodyClass('oasis-one-column');

		// adding 'editor' class as a CSS helper
		OasisController::addBodyClass('editor');
		
		// temporary grid transition code, remove after transition
		OasisController::addBodyClass('WikiaGrid');

		// render Oasis module
		$this->html = F::app()->renderView( 'Oasis', 'Index', array('body' => $body) );
	}

	/**
	 * Render template for <body> tag content
	 */
	public function executeEditPage() {
		wfProfileIn(__METHOD__);

		$helper = EditPageLayoutHelper::getInstance();
		$editPage = $helper->getEditPage();

		if ($helper->fullScreen) {
			// add stylesheet
			$this->wg->Out->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/EditPageLayout/css/EditPageLayout.scss'));
			$packageName = 'epl';
			if (class_exists('RTE') && RTE::isEnabled() && !$editPage->isReadOnlyPage()) {
				$packageName = 'eplrte';
			}
			$srcs = AssetsManager::getInstance()->getGroupCommonURL($packageName);
			$wgJsMimeType = $this->wg->JsMimeType;
			foreach($srcs as $src) {
				$this->wg->Out->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$src}\"></script>");
			}
		}

		// render WikiLogo
		$response = $this->app->sendRequest('WikiHeader', 'Wordmark');

		// move wordmark data
		$this->wordmark = $response->getData();

		// render global and user navigation
		$this->header = F::app()->renderView('GlobalHeader', 'Index');

		// Editing [foo]
		$this->title = $editPage->getEditedTitle();
		$section = $this->wg->Request->getVal('section');

		// Is user logged in?
		$this->isLoggedIn = $this->wg->User->isLoggedIn();

		// Can the user minor edit?
		$this->canMinorEdit = $this->title->exists()
		                    && $this->isLoggedIn
		                    && $this->wg->User->isAllowed( 'minoredit' );

		// Text for Edit summary label
		$wpSummaryLabelText = 'editpagelayout-edit-summary-label';

		if ($section == 'new') {
			$msgKey = 'editingcomment';
			// If adding new section to page, change label text (BugId: 7243)
			$wpSummaryLabelText = 'editpagelayout-subject-headline-label';
		}
		else if (is_numeric($section)) {
			$msgKey = 'editingsection';
		}
		else {
			$msgKey = 'editing';
		}

		// title
		$this->titleText = $this->title->getPrefixedText();

		if ($this->titleText == '') {
			$this->titleText = ' ';
		}

		// limit title length
		if (mb_strlen($this->titleText) > self::TITLE_MAX_LENGTH) {
			$this->titleShortText = htmlspecialchars(mb_substr($this->titleText, 0, self::TITLE_MAX_LENGTH)) . '&hellip;';
		}
		else {
			$this->titleShortText = htmlspecialchars($this->titleText);
		}

		$this->editing = wfMsg($msgKey, '');

		$this->wpSummaryLabelText = wfMsg($wpSummaryLabelText);

		// render help link and point the link to new tab
		$this->helpLink = wfMsgExt( 'editpagelayout-helpLink', array('parseinline') );
		$this->helpLink = str_replace('<a ', '<a target="_blank" ', $this->helpLink);

		// action for edit form
		$this->editFormAction = $editPage->getFormAction();

		// preloads
		$this->editPagePreloads = $editPage->getEditPagePreloads();

		// minor edit checkbox (BugId:6461)
		$this->minorEditCheckbox = !empty($editPage->minoredit);

		// summary box
		$this->summaryBox = $editPage->renderSummaryBox();

		// extra buttons
		$this->buttons = $editPage->getControlButtons();

		// extra checkboxes
		$this->customCheckboxes = $editPage->getCustomCheckboxes();

		// dismissable notifications
		$this->notices = $editPage->getNotices();
		$this->noticesHtml = $editPage->getNoticesHtml();

		// notifications link (BugId:7951)
		$this->notificationsLink =
			(count($this->notices) == 0)
			? wfMsg('editpagelayout-notificationsLink-none')
			: wfMsgExt('editpagelayout-notificationsLink', array('parsemag'), count($this->notices));

		// check if we're in read only mode
		// disable edit form when in read-only mode
		if (wfReadOnly()) {
			$this->bodytext = '<div id="mw-read-only-warning" class="WikiaArticle">'.
					wfMsg('oasis-editpage-readonlywarning', wfReadOnlyReason() ).
					'</div>';

			wfDebug(__METHOD__ . ": edit form disabled because read-only mode is on\n");
		}

		$this->hideTitle = $editPage->hideTitle;

		wfRunHooks('EditPageLayoutExecute', array($this));

		wfProfileOut(__METHOD__);
	}
}
