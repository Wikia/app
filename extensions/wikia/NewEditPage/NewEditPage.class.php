<?php

class NewEditPage {

	// this flag indicates we're on not exisiting article page
	private static $notExistingPage = false;

	// add custom CSS to page of not existing articles
	public static function articleView($title) {

		global $wgNewEditPageNewArticle, $wgRequest;

		// limit to not existing articles and view mode
		if (!$title->exists() && $wgRequest->getVal('action', 'view') == 'view') {
			self::$notExistingPage = true;
			self::addCSS();
		}

		return $title;
	}

	// add CSS to view / edit pages
	public static function addCSS() {
		global $wgWysiwygEdit, $wgOut, $wgUser, $wgExtensionsPath, $wgStyleVersion;

		// do not touch skins other than Monaco (RT #13061)
		$skinName = get_class($wgUser->getSkin());
		if ($skinName != 'SkinMonaco') {
			return true;
		}

		if (self::$notExistingPage) {
			// new article notice
			$cssFile = 'NewEditPageNewArticle.css';
		}
		else if (!empty($wgWysiwygEdit)) {
			// edit mode in wysiwyg
			$cssFile = 'NewEditPageWysiwyg.css';
		}
		else {
			// edit mode in old MW editor
			$cssFile = 'NewEditPage.css';
		}

		// add static CSS file
		$wgOut->addLink(array(
			'rel' => 'stylesheet',
			'href' => "{$wgExtensionsPath}/wikia/NewEditPage/{$cssFile}?{$wgStyleVersion}",
			'type' => 'text/css'
		));

		return true;
	}

	// add red preview notice in old editor
	public static function addPreviewBar($editPage) {
		global $wgOut, $wgUser, $wgHooks, $wgRequest;

		// do not touch skins other than Monaco (RT #13061)
		$skinName = get_class($wgUser->getSkin());
		if ($skinName != 'SkinMonaco') {
			return true;
		}

		// we're in preview mode
		// extra check for categories - they have `formtype` always set to 'preview' (rt#15017)
		if ($editPage->formtype == 'preview' && !($editPage->mTitle->mNamespace == NS_CATEGORY && ($wgRequest->getVal('action') != 'submit' || !$wgRequest->wasPosted()))) {
			wfLoadExtensionMessages('NewEditPage');
			$wgOut->addHTML('<div class="new_edit_page_notice" id="new_edit_page_preview_notice">' . wfMsg('new-edit-page-preview-notice') . '</div>');

			// add page title before preview HTML
			$wgHooks['OutputPageBeforeHTML'][] = 'NewEditPage::addPreviewTitle';

			// hide page title in preview mode
			$wgOut->addHTML('<style type="text/css">.firstHeading {display: none}</style>');
		}

		return true;
	}

	/**
	 * add brown old revision notice in old editor
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	public static function addOldRevisionBar($editPage) {
		global $wgOut, $wgUser, $wgHooks, $wgRequest;

		// do not touch skins other than Monaco (RT #13061)
		$skinName = get_class($wgUser->getSkin());
		if ($skinName != 'SkinMonaco') {
			return true;
		}

		if (!$editPage->mArticle->isCurrent()) {
			wfLoadExtensionMessages('NewEditPage');
			$wgOut->addHTML('<div class="new_edit_page_notice" id="new_edit_page_old_revision_notice">' . wfMsgExt('editingold', 'parseinline') . '</div>');

			// add page title before preview HTML
			$wgHooks['OutputPageBeforeHTML'][] = 'NewEditPage::addPreviewTitle';

			// hide page title in preview mode
			$wgOut->addHTML('<style type="text/css">.firstHeading {display: none}</style>');
		}
		//false to supress original warning
		return false;
	}

	// add page title before preview HTML
	public static function addPreviewTitle($wgOut, $text) {
		global $wgTitle, $wgCustomTitle;
		$wgOut->addHTML('<h1 id="new_edit_page_preview_title">' . ( isset($wgCustomTitle) ? $wgCustomTitle->getPrefixedText() : $wgTitle->getPrefixedText() ) . '</h1>');

		// find first closing </h2> and remove preview notice
		$pos = strpos($text, '</h2>');
		if ($pos !== false) {
			$text = substr($text, $pos+5);
		}

		return true;
	}

	// move edit page title after undo success message box (RT #22732)
	public static function undoSuccess($editPage, $text) {
		if ( strpos($editPage->editFormPageTop, '<div class="mw-undo-success">') !== false ) {
			global $wgOut, $wgTitle, $wgCustomTitle;

			// hide page title in preview mode
			$wgOut->addHTML('<style type="text/css">.firstHeading {display: none}</style>');

			// add title
			$editPage->editFormPageTop .= Xml::element('h1',
				array('class' => 'firstHeading', 'style' => 'display: block'),
				(isset($wgCustomTitle) ? $wgCustomTitle->getPrefixedText() : $wgTitle->getPrefixedText())
			);
		}
		return true;
	}

	// Shorten edit page 'transcluded pages' list using JS (RT #22760)
	public static function formatTemplates($sk, $templates, $text) {
		global $wgUser, $wgOut, $wgEnableTranscludedPagesToggle;

		// check the switch
		if (empty($wgEnableTranscludedPagesToggle)) {
			return true;
		}

		// apply this change only in Monaco
		if (get_class($wgUser->getSkin()) != 'SkinMonaco') {
			return true;
		}

		wfLoadExtensionMessages('NewEditPage');

		$msg = wfMsgExt('templatesused-toggle', array('parsemag'), count($templates));

		$text = strtr($text, array(
			'</p>' => '<a class="templatesUsedToggle" onclick="templatesUsedToggle(this)" style="cursor: pointer">['. htmlspecialchars($msg).']</a></p>',
			'<ul>' => '<ul style="display: none">',
		));

		$wgOut->addInlineScript(
<<<JS
		var templatesUsedHidden = true;
		function templatesUsedToggle(node) {
			$(node).closest('.templatesUsed').find('ul').toggle();
			templatesUsedHidden = !templatesUsedHidden;
		}
JS
		);

		return true;
	}
}
