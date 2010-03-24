<?php

class RTE {

	// unique editor instance ID
	private static $instanceId = null;

	// reference to RTEParser object instance
	public static $parser = null;

	// should we use Wysiwyg editor?
	private static $useWysiwyg = true;

	// are we using development version of CK?
	private static $devMode;

	// mode in which CK editor should be stared
	private static $initMode = 'wysiwyg';

	// list of edgecases which occured in parsed wikitext
	public static $edgeCases = array();

	// Title object of currently edited page
	private static $title;

	/**
	 * Perform "reverse" parsing of HTML to wikitext when saving / doing preview from wysiwyg mode
	 */
	public static function reverse($form,  $out = null) {
		global $wgRequest, $wgHooks, $wgRC2UDPEnabled;

		wfProfileIn(__METHOD__);

		if($wgRequest->wasPosted()) {
			if($wgRequest->getVal('RTEMode') == 'wysiwyg') {
				RTE::log('performing reverse parsing back to wikitext');
				if($out == null) {
					$wikitext = RTE::HtmlToWikitext($wgRequest->getText('wpTextbox1'));
					$wgRequest->setVal('wpTextbox1', $wikitext);
				} else {
					$form->textbox1 = $form->getContent();
				}
				if(!empty($wgRC2UDPEnabled) && !empty($wgRequest->data['wpSave'])) {
					$wgHooks['ArticleSaveComplete'][] = 'RTE::notifySave';
				}
			}
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	public static function notifySave(&$article, &$user, &$text, &$summary, &$minoredit, &$watchthis, &$sectionanchor, &$flags, $revision) {
		global $wgTitle;

		wfProfileIn(__METHOD__);

		if(is_object($revision) && is_object($wgTitle)) {
			global $wgSitename;

			$data = array('title' => $wgSitename, 'description' => '<a href="'.$wgTitle->getFullURL('diff=' . $revision->getId()).'">diff</a>');

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_TIMEOUT, 3);
			curl_setopt($ch, CURLOPT_URL, "http://fp026.sjc.wikia-inc.com/inez/test.php");
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_exec($ch);
			curl_close($ch);
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Callback function for preg_replace_callback which handle placeholer markers.
	 * Called from RTEParser class.
	 *
	 * @author: Inez Korczyński
	 */
	public static function replacePlaceholder($var) {
		$data = RTEData::get('placeholder', intval($var[1]));

		if($data) {
			return RTE::renderPlaceholder($data['type'], $data);
		}
	}

	/**
	 * Render HTML for given placeholder
	 *
	 * @author: Macbre
	 */
	public static function renderPlaceholder($label, $data) {
		// store data
		$dataIdx = RTEData::put('data', $data);

		// render placeholder
		global $wgBlankImgUrl;
		return Xml::element('img', array(
			'_rte_dataidx' => sprintf('%04d', $dataIdx),
			'_rte_placeholder' => true,
			'class' => "placeholder placeholder-{$data['type']}",
			'src' => $wgBlankImgUrl,
			'type' => $data['type'],
		));
	}

	/**
	 * Setup Rich Text Editor by loading needed JS/CSS files and adding hook(s)
	 *
	 * @author Inez Korczyński, Macbre
	 */
	public static function init(&$form) {
		global $wgOut, $wgJsMimeType, $wgExtensionsPath, $wgStyleVersion, $wgHooks, $wgRequest;

		wfProfileIn(__METHOD__);

		RTE::log('init');

		// save reference to Title object of currently edited page
		self::$title = $form->mTitle;

		// check 'useeditor' URL param, user settings...
		self::checkEditorConditions();

		// i18n
                wfLoadExtensionMessages('RTE');

		// should CK editor be disabled?
		if (self::$useWysiwyg === false) {
			RTE::log('fallback to MW editor');
			wfProfileOut(__METHOD__);
			return true;
		}

		// used for load time reports
		$wgOut->addInlineScript('var wgRTEStart = new Date();');

		// load JS code
		self::$devMode = $wgRequest->getVal('source', false);
		if (!empty(self::$devMode)) {
			// load development version
			$wgOut->addScript("<script src=\"$wgExtensionsPath/wikia/RTE/ckeditor/ckeditor_source.js?$wgStyleVersion\" type=\"$wgJsMimeType\"></script>");
			$wgOut->addScript("<script src=\"$wgExtensionsPath/wikia/RTE/js/RTE.js?$wgStyleVersion\" type=\"$wgJsMimeType\"></script>");
		}
		else {
			// load minified version
			$wgOut->addScript("<script type=\"$wgJsMimeType\" src=\"$wgExtensionsPath/wikia/RTE/ckeditor/ckeditor.js?$wgStyleVersion\"></script>");
		}

		$wgOut->addExtensionStyle("$wgExtensionsPath/wikia/RTE/css/RTE.css?$wgStyleVersion");

		// parse wikitext of edited page and add extra fields to editform
		$wgHooks['EditPage::showEditForm:fields'][] = 'RTE::init2';

		// disable save / preview / show changes buttons until RTE is fully loaded
		$wgHooks['EditPageBeforeEditButtons'][] = 'RTE::disableEditButtons';

		// add global JS variables
		$wgHooks['MakeGlobalVariablesScript'][] = 'RTE::makeGlobalVariablesScript';

		// add fake form used by MW suggest
		$wgOut->addHTML( Xml::openElement('form', array('id' => 'RTEFakeForm')) . Xml::closeElement('form') );

		// adds fallback for non-JS users (RT #20324)
		self::addNoScriptFallback();

		// wysiwyg editor is on
		global $wgWysiwygEdit;
		$wgWysiwygEdit = true;

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Parse wikitext of edited article, so CK can be provided with HTML
	 */
	public static function init2(&$form, &$out) {
		wfProfileIn(__METHOD__);

		// add hidden edit form field
		$out->addHTML( "\n" . Xml::element('input', array('type' => 'hidden', 'value' => '', 'name' => 'RTEMode', 'id' => 'RTEMode')) );

		// add fields to perform temporary save
		self::addTemporarySaveFields($out);

		// let's parse wikitext (only for wysiwyg mode)
		if (self::$initMode == 'wysiwyg') {
			$html = RTE::WikitextToHtml($form->textbox1);
		}

		// check for edgecases (found during parsing done above)
		if (RTE::edgeCasesFound()) {
			self::setInitMode('source');

			// get edgecase type and add it to JS variables
			$edgeCaseType = Xml::encodeJsVar(self::getEdgeCaseType());
			$out->addInlineScript("var RTEEdgeCase = {$edgeCaseType}");
		}

		// parse wikitext using RTEParser (only for wysiwyg mode)
		if (self::$initMode == 'wysiwyg') {
			// set editor textarea content
			$form->textbox1 = $html;
		}

		// allow other extensions to add extra HTML to edit form
		wfRunHooks('RTEAddToEditForm', array(&$form, &$out));

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Disable save / preview / show changes buttons until RTE is fully loaded
	 *
	 * @author Macbre
	 */
	public static function disableEditButtons(&$editPage, &$checkboxes) {
		wfProfileIn(__METHOD__);

		// add disabled='disabled' attribute
		$buttons = array('save', 'preview', 'diff');
		foreach($buttons as $button) {
			$checkboxes[$button] = substr($checkboxes[$button], 0, -3) . ' disabled="disabled" />';
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Add global JS variables
	 *
	 * @author Macbre
	 */
	public static function makeGlobalVariablesScript(&$vars) {
		global $wgLegalTitleChars, $wgServer, $wgScriptPath;

		wfProfileIn(__METHOD__);

		// CK instance id
		$vars['RTEInstanceId'] = self::getInstanceId();

		// development version of CK?
		$vars['RTEDevMode'] = !empty(self::$devMode);

		// initial CK mode (wysiwyg / source)
		$vars['RTEInitMode'] = self::$initMode;

		// constants for regexp checking in links editor
		$vars['RTEUrlProtocols'] = wfUrlProtocols();
		$vars['RTEValidTitleChars'] = $wgLegalTitleChars;

		// list of templates to be shown in dropdown on toolbar
		$vars['RTETemplatesDropdown'] = self::getTemplateDropdownList();

		// list of magic words
		$vars['RTEMagicWords'] = self::getMagicWords();

		// messages to be used in JS code
		$vars['RTEMessages'] = self::getMessages();

		// local path to RTE (used to apply htc fixes for IE)
		// this MUST point to local domain
		$vars['RTELocalPath'] = $wgServer .  $wgScriptPath . '/extensions/wikia/RTE';

		// link to raw version of MediaWiki:Common.css
		global $wgSquidMaxage;
		$query = wfArrayToCGI(array(
			'action' => 'raw',
			'maxage' => $wgSquidMaxage,
			'usemsgcache' => 'yes',
			'ctype' => 'text/css',
			'smaxage' => $wgSquidMaxage,
		));
		$vars['RTEMWCommonCss'] = $wgServer . Skin::makeNSUrl('Common.css', $query, NS_MEDIAWIKI);

		// domain and path for cookies
		global $wgCookieDomain, $wgCookiePath;
		$vars['RTECookieDomain'] = $wgCookieDomain;
		$vars['RTECookiePath'] = $wgCookiePath;

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Adds fallback for non-JS users (RT #20324)
	 */
	private static function addNoScriptFallback() {
		global $wgOut;

		$fallbackMessage = trim(wfMsgExt('rte-no-js-fallback', 'parseinline'));
		$wgOut->addHTML(
<<<HTML

<noscript>
	<style type="text/css">
		#editform {
			display: none;
		}

		.RTEFallback,
		#page_bar {
			display: block !important;
		}
	</style>
	<div class="RTEFallback usermessage">$fallbackMessage</div>
</noscript>

HTML
		);
	}

	/**
	 * Add fields to perform temporary save
	 */
	private static function addTemporarySaveFields($out) {
		$out->addHtml(
			"\n".
			Xml::element('input', array('type' => 'hidden', 'id' => 'RTETemporarySaveType', 'name' => 'RTETemporarySaveType')).
			Xml::element('input', array('type' => 'hidden', 'id' => 'RTETemporarySaveContent', 'name' => 'RTETemporarySaveContent')).
			"\n"
		);
	}

	/**
	 * Check CK editor conditions (fallback to MW editor / switch to source mode)
	 *
	 * Handle useeditor URL param, user settings, current skin, edgecases...
	 */
	private static function checkEditorConditions() {
		global $wgRequest, $wgUser;

		wfProfileIn(__METHOD__);

		// check browser compatibility
		if (!self::isCompatibleBrowser()) {
			RTE::log('editor is disabled because of unsupported browser');
			self::disableEditor();
		}

		// check useeditor URL param (wysiwyg / source / mediawiki)
		$useEditor = $wgRequest->getVal('useeditor', false);

		if (!empty($useEditor)) {
			RTE::log("useeditor = '{$useEditor}'");

			switch($useEditor) {
				case 'mediawiki':
					self::disableEditor();
					break;

				case 'source':
					self::setInitMode('source');
					break;
			}
		}

		// check namespaces
		global $wgWysiwygDisabledNamespaces, $wgWysiwygDisableOnTalk;
		if(!empty($wgWysiwygDisabledNamespaces) && is_array($wgWysiwygDisabledNamespaces)) {
			if(in_array(self::$title->getNamespace(), $wgWysiwygDisabledNamespaces)) {
				self::disableEditor();
			}
		} else {
			if(self::$title->getNamespace() == NS_TEMPLATE || self::$title->getNamespace() == NS_MEDIAWIKI) {
				self::disableEditor();
			}
		}
		if(!empty($wgWysiwygDisableOnTalk)) {
			if(self::$title->isTalkPage()) {
				self::disableEditor();
			}
		}

		// RT #10170: do not initialize for user JS/CSS subpages
		if (self::$title->isCssJsSubpage()) {
			RTE::log('editor is disabled on user JS/CSS subpages');
			self::disableEditor();
		}

		// check user preferences option
		$userOption = $wgUser->getOption('enablerichtext');
		if( ($userOption != true) && ($useEditor != 'wysiwyg') ) {
			RTE::log('editor is disabled because of user preferences');
			self::disableEditor();
		}

		// check current skin - enable RTE only on Monaco
		$skinName = get_class($wgUser->getSkin());
		if($skinName != 'SkinMonaco') {
			RTE::log("editor is disabled because skin {$skinName} is unsupported");
			self::disableEditor();
		}

		// start in source when previewing from source mode
		$action = $wgRequest->getVal('action', 'view');
		$mode = $wgRequest->getVal('RTEMode', false);
		if ($action == 'submit' && $mode == 'source') {
			RTE::log('POST triggered from source mode');
			RTE::setInitMode('source');
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Disable CK editor - MediaWiki editor will be loaded
	 */
	public static function disableEditor() {
		self::$useWysiwyg = false;

		RTE::log('CK editor disabled');
	}

	/**
	 * Set init mode of CK editor
	 */
	public static function setInitMode($mode) {
		self::$initMode = ($mode == 'wysiwyg') ? 'wysiwyg' : 'source';

		RTE::log(__METHOD__, self::$initMode);
	}

	/**
	 * Add given edgecase to the list of found edgecases
	 */
	public static function edgeCasesPush($edgecase) {
 		self::$edgeCases[] = $edgecase;
	}

	/**
	 * Checks whether RTEParser found any wikitext edgecases
	 */
	public static function edgeCasesFound() {
		$found = !empty(self::$edgeCases);

		if ($found) {
			// list edgecases in MW debug log
			$edgecases = implode(',', self::$edgeCases);
			RTE::log("edgecase(s) found - {$edgecases}");
		}

		return $found;
	}

	/**
	 * Returns type of edgecase found in wikitext
	 */
	public static function getEdgeCaseType() {
		$ret = false;

		if (!empty(self::$edgeCases)) {
			$ret = strtolower(self::$edgeCases[0]);
		}

		RTE::log(__METHOD__, $ret);

		return $ret;
	}

	/**
	 * Parse given wikitext to HTML for CK
	 */
	public static function WikitextToHtml($wikitext) {
		global $wgTitle, $wgParser;

		wfProfileIn(__METHOD__);

		$options = new ParserOptions();
		// don't show [edit] link for sections
		$options->setEditSection(false);
		// use modified Linker
		$options->setSkin( new RTELinker() );
		// disable headings numbering
		$options->setNumberHeadings(false);

		RTE::$parser = new RTEParser();

		RTE::$parser->mTagHooks = &$wgParser->mTagHooks;
		RTE::$parser->mStripList = &$wgParser->mStripList;

		$html = RTE::$parser->parse($wikitext, $wgTitle, $options)->getText();

		wfProfileOut(__METHOD__);

		return $html;
	}

	/**
	 * Parse given HTML from CK back to wikitext
	 */
	public static function HtmlToWikitext($html) {
		wfProfileIn(__METHOD__);

		$RTEReverseParser = new RTEReverseParser();
		$wikitext = $RTEReverseParser->parse($html);

		wfProfileOut(__METHOD__);

		return $wikitext;
	}

	/**
	 * Add given message / dump given variable to MW log
	 *
	 * @author Macbre
	 */
	public static function log($msg, $var = NULL) {
		$debug = 'RTE: ';

		if (is_string($msg)) {
			$debug .= $msg;
		}
		else {
			$debug .= ' - >>' . print_r($msg, true) . '<<';
		}

		if ($var !== NULL) {
			$debug .= ' - >>' . print_r($var, true) . '<<';
		}

		wfDebug("{$debug}\n");
	}

	/**
	 * Add hexdump of given variable to MW log
	 *
	 * @author Macbre
	 */
	public static function hex($method, $string) {
		$debug = "RTE: {$method}\n" . Wikia::hex($string, false, false, true);

		wfDebug("{$debug}\n");
	}

	/**
	 * Return unique editor instance ID
	 */
	public static function getInstanceId() {
		wfProfileIn(__METHOD__);

		if (self::$instanceId === null) {
			global $wgCityId;

			$id = uniqid(mt_rand());
			self::$instanceId = "{$wgCityId}-{$id}";
		}

		wfProfileOut(__METHOD__);

		return self::$instanceId;
	}

	public static function getTemplateParams($titleObj, $parser) {
		global $wgRTETemplateParams;

		wfProfileIn(__METHOD__);

		$wgRTETemplateParams = true;

		$params = array();

		$templateDom = $parser->getTemplateDom($titleObj);
		if($templateDom[0]) {
			$templateArgs = $templateDom[0]->getChildrenOfType('tplarg')->node;
			for($i = 0; $i < $templateArgs->length; $i++) {
				$params[] = $templateArgs->item($i)->firstChild->textContent;
			}
		}

		$wgRTETemplateParams = false;

		$ret = array_values(array_unique($params));

		wfProfileOut(__METHOD__);

		return $ret;
	}

	/*
	 * Return list of templates to be placed in dropdown menu on CK toolbar
	 */
	private static function getTemplateDropdownList() {
		wfProfileIn(__METHOD__);

		// TODO: add caching for this data
		$templateDropdown = array();
		$lines = explode("\n", wfMsg('editor-template-list')); // we do not care if the message is empty

		foreach($lines as $line) {
			if(strrpos($line, '*') === 0) {
				$title = Title::newFromText(trim($line, '* '));
				//$templateDropdown[$title->getPrefixedText()] = RTE::getTemplateParams($title, RTE::$parser);
				if ( is_object( $title ) ) {
					$templateDropdown[] = $title->getPrefixedText();
				}
			}
		}

		wfProfileOut(__METHOD__);

		return $templateDropdown;
	}

	/*
	 * Return list of magic words ({{PAGENAME}}) and double underscores (__TOC__)
	 */
	public static function getMagicWords() {
		wfProfileIn(__METHOD__);

		// magic words list
		$magicWords = MagicWord::getVariableIDs();

		// double underscore magic words list (RT #18631)
		$magicWordsUnderscore = MagicWord::$mDoubleUnderscoreIDs;

		// filter MAG_NOWYSIWYG and MAG_NOSHAREDHELP out from the list (RT #18631)
		// and add to the list of double underscore magic words
		$magicWords = array_flip($magicWords);
		foreach($magicWords as $magic => $tmp) {
			if (substr($magic, 0, 4) == 'MAG_') {
				unset($magicWords[$magic]);
				$magicWordsUnderscore[] = strtolower(substr($magic, 4));
			}
		}
		$magicWords = array_flip($magicWords);

		// merge and sort magic words / double underscores lists, in RTE check type of magic word by searching $magicWordUnderscore list
		$magicWords = array_merge($magicWords, $magicWordsUnderscore);

		sort($magicWords);
		sort($magicWordsUnderscore);

		$ret = array(
			'magicWords' => $magicWords,
			'doubleUnderscores' => $magicWordsUnderscore
		);

		wfProfileOut(__METHOD__);

		return $ret;
	}

	/**
	 * Grabbing list of most included templates
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	static public function getHotTemplates() {
		global $wgMemc;

		wfProfileIn(__METHOD__);

		$key = wfMemcKey('rte', 'template-list');
		$list = $wgMemc->get($key);

		if (empty($list)) {
			$dbr = wfGetDB(DB_SLAVE);
			$conds = array(
				'qc_type' => 'Mostlinkedtemplates',
				'qc_namespace' => NS_TEMPLATE,
			);

			// handle list of excluded templates
			global $wgTemplateExcludeList;
			if (is_array($wgTemplateExcludeList) && count($wgTemplateExcludeList)) {
				$templateExcludeListA = array();
				foreach($wgTemplateExcludeList as $tmpl) {
					$templateExcludeListA[] = $dbr->AddQuotes($tmpl);
				}
				$conds[] = 'qc_title NOT IN (' . implode(',', $templateExcludeListA) . ')';
			}

			$res = $dbr->select('querycache', 'qc_title', $conds, __METHOD__, array('ORDER BY' => 'qc_value DESC', 'LIMIT' => 10));
			$list = array();

			while ($row = $dbr->fetchObject($res)) {
				$title = Title::newFromText($row->qc_title, NS_TEMPLATE);
				if (!$title->exists()) {
					continue;
				}
				$list[] = $row->qc_title;
			}

			$wgMemc->set($key, $list, 3600);
		}

		wfProfileOut(__METHOD__);

		return $list;
	}

	/**
	 * Get messages to be used in JS code
	 */
	static private function getMessages() {
		global $wgLang;

		wfProfileIn(__METHOD__);

		$ret = array(
			'ellipsis' => wfMsg('ellipsis'),
			'more' => wfMsg('moredotdotdot'),
			'template' => $wgLang->getNsText(NS_TEMPLATE), # localised template namespace name (RT #3808)

			// RT #36073
			'edgecase' => array(
				'title' => wfMsg('rte-edgecase-info-title'),
				'content' => wfMsg('rte-edgecase-info'),
			),
		);

		wfProfileOut(__METHOD__);

		return $ret;
	}

	/**
	 * Add "Enable Rich Text Editing" as the first option in editing tab of user preferences
	 */
	function userPreferences($preferencesForm, &$toggles) {
		// add JS to hide certain switches when wysiwyg is enabled
		global $wgOut, $wgJsMimeType, $wgExtensionsPath, $wgStyleVersion;
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"$wgExtensionsPath/wikia/RTE/js/RTE.preferences.js?$wgStyleVersion\"></script>" );

		// add RTE switch as the first one in "editing" prefs tab
		array_unshift($toggles, 'enablerichtext');

		return true;
	}

	/**
	 * Add user toggles
	 */
	static public function userToggle(&$toggles) {
		$toggles[] = 'enablerichtext';
		return true;
	}

	/**
	 * Modify values returned by User::getOption() when wysiwyg is enabled
	 */
	static public function userGetOption($options, $name, $value) {
		wfProfileIn(__METHOD__);

		// do not continue if user didn't turn on wysiwyg in preferences
		if (empty($options['enablerichtext'])) {
			wfProfileOut(__METHOD__);
			return true;
		}

		// options to be modified
		$values = array(
			'editwidth' => false,
			'showtoolbar' => true,
			'previewonfirst' => false,
			'previewontop' => true,
			'disableeditingtips' => true,
			'disablelinksuggest' => false,
			'externaleditor' => false,
			'externaldiff' => false,
			'disablecategoryselect' => false,
		);

		if ( array_key_exists($name, $values) ) {
			// don't continue when on Special:Preferences (actually only check namespace ID, it's faster)
			global $wgTitle;
			if ( !empty($wgTitle) && ($wgTitle->getNamespace() == NS_SPECIAL) ) {
				wfProfileOut(__METHOD__);
				return true;
			}
			$value = $values[$name];
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Check whether current browser is compatible with RTE
	 *
	 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
	 * Copyright (C) 2003-2009 Frederico Caldeira Knabben
	 */
	private static function isCompatibleBrowser() {
		wfProfileIn(__METHOD__);

		if ( isset( $_SERVER ) ) {
			$sAgent = $_SERVER['HTTP_USER_AGENT'] ;
		}
		else {
			global $HTTP_SERVER_VARS ;
			if ( isset( $HTTP_SERVER_VARS ) ) {
				$sAgent = $HTTP_SERVER_VARS['HTTP_USER_AGENT'] ;
			}
			else {
				global $HTTP_USER_AGENT ;
				$sAgent = $HTTP_USER_AGENT ;
			}
		}

		RTE::log(__METHOD__, $sAgent);

		$ret = false;

		if ( strpos($sAgent, 'Chrome') !== false )
		{
			$ret = true;
		}
		else if ( strpos($sAgent, 'MSIE') !== false && strpos($sAgent, 'mac') === false && strpos($sAgent, 'Opera') === false )
		{
			$iVersion = (float)substr($sAgent, strpos($sAgent, 'MSIE') + 5, 3) ;
			$ret = ($iVersion >= 7.0) ;
		}
		else if ( strpos($sAgent, 'Gecko/') !== false )
		{
			$iVersion = (int)substr($sAgent, strpos($sAgent, 'Gecko/') + 6, 8) ;
			$ret = ($iVersion >= 20030210) ;
		}
		else if ( strpos($sAgent, 'Opera/') !== false )
		{
			$fVersion = (float)substr($sAgent, strpos($sAgent, 'Opera/') + 6, 4) ;
			$ret = ($fVersion >= 9.5) ;
		}
		else if ( strpos($sAgent, 'Mobile') !== false && strpos($sAgent, 'Safari') !== false )
		{
			// disable for mobile devices from Apple (RT #38829)
			$ret = false;
		}
		else if ( preg_match( "|AppleWebKit/(\d+)|i", $sAgent, $matches ) )
		{
			$iVersion = $matches[1] ;
			$ret = ( $matches[1] >= 522 ) ;
		}

		RTE::log(__METHOD__, $ret ? 'yes' : 'no');

		wfProfileOut(__METHOD__);

		return $ret;
	}
}
