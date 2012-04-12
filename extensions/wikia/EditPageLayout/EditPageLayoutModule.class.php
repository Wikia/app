<?php

/**
 * Oasis module for EditPageLayout
 *
 * Renders modified HTML for edit pages
 */
class EditPageLayoutModule extends WikiaController {

	const TITLE_MAX_LENGTH = 30;
	
	public function init() {
		$this->bodytext = F::app()->getSkinTemplateObj()->data['bodytext'];
	}
	
	/**
	 * Render HTML for whole edit page
	 */
	public function executeIndex() {
		// render edit page content
		$body = F::app()->renderView('EditPageLayout', 'EditPage');

		// page has one column
		OasisModule::addBodyClass('oasis-one-column');

		// adding 'editor' class as a CSS helper
		OasisModule::addBodyClass('editor');

		// render Oasis module
		$this->html = F::app()->renderView( 'Oasis', 'Index', array('body' => $body) );
	}

	/**
	 * Render template for <body> tag content
	 */
	public function executeEditPage() {
		$app = WF::build('App');

		$app->wf->ProfileIn(__METHOD__);

		$helper = WF::build('EditPageLayoutHelper');
		$editPage = $helper->getEditPage();

		if ($helper->fullScreen) {
			// add stylesheet
			$app->wg->Out->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/EditPageLayout/css/EditPageLayout.scss'));
			$packageName = 'epl';
			if (class_exists('RTE') && RTE::isEnabled() && !$editPage->isReadOnlyPage()) {
				$packageName = 'eplrte';
			}
			$srcs = F::build('AssetsManager',array(),'getInstance')->getGroupCommonURL($packageName);
			$wgJsMimeType = $app->wg->JsMimeType;
			foreach($srcs as $src) {
				$app->wg->Out->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$src}\"></script>");
			}
		}

		// render WikiLogo
		$wikiHeaderData = Module::get('WikiHeader', 'Wordmark')->getData();

		// move wordmark data
		$this->wordmark = $wikiHeaderData;

		// render global and user navigation
		$this->header = wfRenderModule('GlobalHeader');

		// Editing [foo]
		$this->title = $editPage->getEditedTitle();
		$section = $app->getGlobal('wgRequest')->getVal('section');

		// Is user logged in?
		$this->isLoggedIn = $this->wg->User->isLoggedIn();

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
		$this->helpLink = $app->runFunction('wfMsgExt', 'editpagelayout-helpLink', array('parseinline'));
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
			? $app->runFunction('wfMsg', 'editpagelayout-notificationsLink-none')
			: $app->runFunction('wfMsgExt', 'editpagelayout-notificationsLink', array('parsemag'), count($this->notices));

		// check if we're in read only mode
		// disable edit form when in read-only mode
		if ($app->runFunction('wfReadOnly')) {
			$this->bodytext = '<div id="mw-read-only-warning" class="WikiaArticle">'.
					$app->runFunction('wfMsg', 'oasis-editpage-readonlywarning', $app->runFunction('wfReadOnlyReason')).
					'</div>';

			wfDebug(__METHOD__ . ": edit form disabled because read-only mode is on\n");
		}

		$this->hideTitle = $editPage->hideTitle;

		$this->app->wf->RunHooks('EditPageLayoutExecute', array($this));
		$app->wf->ProfileOut(__METHOD__);
	}
}
