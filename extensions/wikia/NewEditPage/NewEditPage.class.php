<?php

class NewEditPage {

	// this flag indicates we're on not exisiting article page
	private static $notExistingPage = false;

	// store skin name
	private static $skinName = false;

	/**
	 * Helper method checking name of the current skin
	 *
	 * @author Maciej Brencz <macbre wikia-inc.com>
	 */
	private static function isMonacoSkin() {
		if (empty(self::$skinName)) {
			global $wgUser;
			self::$skinName = get_class($wgUser->getSkin());
		}

		return self::$skinName == 'SkinMonaco';
	}

	/**
	 * Add custom CSS to page of not existing articles
	 *
	 * @author Maciej Brencz <macbre wikia-inc.com>
	 */
	public static function articleView($title) {
		global $wgRequest;

		wfProfileIn(__METHOD__);

		// limit to not existing articles and view mode
		if (!$title->exists() && $wgRequest->getVal('action', 'view') == 'view') {
			self::$notExistingPage = true;
			self::addCSS();
		}

		wfProfileOut(__METHOD__);

		return $title;
	}

	/**
	 * Add CSS to view / edit pages
	 *
	 * @author Maciej Brencz <macbre wikia-inc.com>
	 */
	public static function addCSS() {
		global $wgWysiwygEdit, $wgOut, $wgUser, $wgExtensionsPath, $wgStyleVersion;

		wfProfileIn(__METHOD__);

		// do not touch skins other than Monaco (RT #13061)
		if (!self::isMonacoSkin()) {
			wfProfileOut(__METHOD__);
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

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Add red preview notice in old editor
	 *
	 * @author Maciej Brencz <macbre wikia-inc.com>
	 */
	public static function addPreviewBar($editPage) {
		global $wgOut, $wgHooks, $wgRequest;

		wfProfileIn(__METHOD__);

		// do not touch skins other than Monaco (RT #13061)
		if (!self::isMonacoSkin()) {
			wfProfileOut(__METHOD__);
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

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Add brown old revision notice in old editor
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	public static function addOldRevisionBar($editPage) {
		global $wgOut, $wgHooks, $wgRequest;

		wfProfileIn(__METHOD__);

		// do not touch skins other than Monaco (RT #13061)
		if (!self::isMonacoSkin()) {
			wfProfileOut(__METHOD__);
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

		wfProfileOut(__METHOD__);

		// false to supress original warning
		return false;
	}

	/**
	 * Add page title before preview HTML
	 *
	 * @author Maciej Brencz <macbre wikia-inc.com>
	 */
	public static function addPreviewTitle($wgOut, $text) {
		global $wgTitle, $wgCustomTitle;

		wfProfileIn(__METHOD__);

		$wgOut->addHTML('<h1 id="new_edit_page_preview_title">' . ( isset($wgCustomTitle) ? $wgCustomTitle->getPrefixedText() : $wgTitle->getPrefixedText() ) . '</h1>');

		// find first closing </h2> and remove preview notice
		$pos = strpos($text, '</h2>');
		if ($pos !== false) {
			$text = substr($text, $pos+5);
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Move edit page title after undo success message box (RT #22732)
	 *
	 * @author Maciej Brencz <macbre wikia-inc.com>
	 */
	public static function undoSuccess($editPage, $text) {
		wfProfileIn(__METHOD__);

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

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Shorten edit page 'transcluded pages' list using JS (RT #22760)
	 *
	 * @author Maciej Brencz <macbre wikia-inc.com>
	 */
	public static function formatTemplates($sk, $templates, $text) {
		global $wgUser, $wgOut, $wgEnableTranscludedPagesToggle;

		wfProfileIn(__METHOD__);

		// check the switch
		if (empty($wgEnableTranscludedPagesToggle)) {
			return true;
		}

		// apply this change only in Monaco
		if (!self::isMonacoSkin()) {
			return true;
		}

		// i18n
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

		wfProfileOut(__METHOD__);

		return true;
	}
}
