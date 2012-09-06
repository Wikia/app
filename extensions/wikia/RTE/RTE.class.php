<?php

class RTE {

	// unique editor instance ID
	private static $instanceId = null;

	// reference to RTEParser object instance
	public static $parser = null;

	// should we use Wysiwyg editor?
	private static $useWysiwyg = true;

	// reason of fallback to source mode
	private static $wysiwygDisabledReason = false;

	// are we using development version of CK?
	private static $devMode;

	// mode in which CK editor should be stared
	private static $initMode = 'wysiwyg';

	// list of edgecases which occurred in parsed wikitext
	public static $edgeCases = array();

	// Title object of currently edited page
	private static $title;

	/**
	 * Perform "reverse" parsing of HTML to wikitext when saving / doing preview from wysiwyg mode
	 */
	public static function reverse($form,  $out = null) {
		global $wgRequest;
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
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Callback function for preg_replace_callback which handle placeholer markers.
	 * Called from RTEParser class.
	 *
	 * @author: Inez KorczyDski
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
		// this is placeholder
		$data['placeholder'] = 1;

		// Special case for WikiaPoll placeholder
		// If we do more of these, refactor
		if (defined ( "NS_WIKIA_POLL" )) {
			global $wgContLang;
			$pollNamespace = $wgContLang->getNsText( NS_WIKIA_POLL );
			// Check for both canonical Poll and localized version of Poll
			if (isset($data['title']) && ( (stripos($data['title'], 'Poll') === 0) || (stripos($data['title'], $pollNamespace) === 0) ) ) {
				$data['type'] = 'poll';
				$cssClass = "media-placeholder placeholder-poll";
				$title = Title::newFromText($data['title'], NS_WIKIA_POLL);
				if ($title->exists()) {
					$data['pollId'] = $title->getArticleId();
					$poll = WikiaPoll::newFromTitle($title);
					$pollData = $poll->getData();
					$data['question'] = $pollData['question'];
					if (isset($pollData['answers'])) {
						foreach ($pollData["answers"] as $answer ) {
							$data['answers'][] = $answer['text'];
						}
					}
				}
			}
		}

		// store data
		$dataIdx = RTEData::put('data', $data);

		// render placeholder
		global $wgBlankImgUrl;
		return Xml::element('img', array(
			'_rte_dataidx' => sprintf('%04d', $dataIdx),
			'class' => "placeholder placeholder-{$data['type']}",
			'src' => $wgBlankImgUrl,
			'type' => $data['type'],
		));
	}

	/**
	 * Setup Rich Text Editor by loading needed JS/CSS files and adding hook(s)
	 *
	 * @author Inez KorczyDski, Macbre
	 */
	public static function init(&$form) {
		global $wgOut, $wgJsMimeType, $wgExtensionsPath, $wgHooks, $wgAllInOne, $wgRequest;

		wfProfileIn(__METHOD__);

		RTE::log('init');

		// save reference to Title object of currently edited page
		self::$title = $form->mTitle;

		// check 'useeditor' URL param, user settings...
		self::checkEditorConditions();

		// add global JS variables
		$wgHooks['MakeGlobalVariablesScript'][] = 'RTE::makeGlobalVariablesScript';

		// should CK editor be disabled?
		if (self::$useWysiwyg === false) {
			RTE::log('fallback to MW editor');
			wfProfileOut(__METHOD__);
			return true;
		}

		// devmode
		self::$devMode = $wgRequest->getBool('allinone', $wgAllInOne) === false;

		// add RTE javascript files
		// scripts loaded by edit page layout

		// add RTE css file
		$wgOut->addExtensionStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/RTE/css/RTE.scss'));

		// parse wikitext of edited page and add extra fields to editform
		$wgHooks['EditPage::showEditForm:fields'][] = 'RTE::init2';

		// add CSS class to <body> tag
		$wgHooks['SkinGetPageClasses'][] = 'RTE::addBodyClass';

		// remove default editor toolbar (RT #78393)
		$wgHooks['EditPageBeforeEditToolbar'][] = 'RTE::removeDefaultToolbar';

		// add fake form used by MW suggest in CK dialogs
		$wgHooks['SkinAfterBottomScripts'][] = 'RTE::onSkinAfterBottomScripts';

		// adds fallback for non-JS users (RT #20324)
		self::addNoScriptFallback();

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
	 * Add global JS variables
	 *
	 * @author Macbre
	 */
	public static function makeGlobalVariablesScript(&$vars) {
		global $wgLegalTitleChars, $wgServer, $wgExtensionsPath;

		wfProfileIn(__METHOD__);

		// reason why wysiwyg is disabled
		if (self::$useWysiwyg === false) {
			if (!empty(self::$wysiwygDisabledReason)) {
				$vars['RTEDisabledReason'] = self::$wysiwygDisabledReason;
			}

			// no reason to add variables listed below
			wfProfileOut(__METHOD__);
			return true;
		}

		// CK instance id
		$vars['RTEInstanceId'] = self::getInstanceId();

		// development version of CK?
		if (!empty(self::$devMode)) {
			$vars['RTEDevMode'] = true;
		}

		// initial CK mode (wysiwyg / source)
		$vars['RTEInitMode'] = self::$initMode;

		// constants for regexp checking in links editor
		$vars['RTEUrlProtocols'] = wfUrlProtocols();

		// BugID: 2138 - generate utf-8 friendly regexp pattern
		$legalChars = substr($wgLegalTitleChars, 0, -10);
		$legalChars .= '\u00A1-\uFFFF';
		$vars['RTEValidTitleChars'] = $legalChars;

		// list of templates to be shown in dropdown on toolbar
		$vars['RTETemplatesDropdown'] = self::getTemplateDropdownList();

		// list of magic words
		$vars['RTEMagicWords'] = self::getMagicWords();

		// messages to be used in JS code
		$vars['RTEMessages'] = self::getMessages();

		// local path to RTE (used to apply htc fixes for IE)
		// this MUST point to local domain
		$vars['RTELocalPath'] = $wgServer . '/extensions/wikia/RTE';

		$vars['CKEDITOR_BASEPATH'] = $wgExtensionsPath . '/wikia/RTE/ckeditor/';

		// link to raw version of MediaWiki:Common.css
		global $wgSquidMaxage;
		$query = wfArrayToCGI(array(
			'usemsgcache' => 'yes',
			'ctype' => 'text/css',
			'smaxage' => $wgSquidMaxage,
			'action' => 'raw',
			'maxage' => $wgSquidMaxage,
		));

		$vars['RTESiteCss'] = $wgServer . Skin::makeNSUrl( ( F::app()->checkSkin( 'oasis' ) ) ? 'Wikia.css' : 'Common.css', $query, NS_MEDIAWIKI );

		// domain and path for cookies
		global $wgCookieDomain, $wgCookiePath;
		$vars['RTECookieDomain'] = $wgCookieDomain;
		$vars['RTECookiePath'] = $wgCookiePath;

		// allow other extensions to add extra global JS variables to edit form
		wfRunHooks('RTEAddGlobalVariablesScript', array(&$vars));

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Add class to <body> tag
	 */
	public static function addBodyClass(&$classes) {
		$classes .= ' rte';
		return true;
	}

	/**
	 * Removes default editor toolbar, so we can lazy load icons for source mode toolbar (RT #78393)
	 */
	public static function removeDefaultToolbar(&$toolbar) {
		$toolbar = strtr($toolbar, array(
			'<div id="toolbar">' => '',
			'</div>' => '',
		));
		return true;
	}

	/**
	 * Add fake form used by MW suggest in CK dialogs
	 */
	public static function onSkinAfterBottomScripts($skin, &$text) {
		$text .= Xml::openElement('form', array('id' => 'RTEFakeForm')) . Xml::closeElement('form');
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
			self::disableEditor('browser');
		}

		// check useeditor URL param (wysiwyg / source / mediawiki)
		$useEditor = $wgRequest->getVal('useeditor', false);

		if (!empty($useEditor)) {
			RTE::log("useeditor = '{$useEditor}'");

			switch($useEditor) {
				case 'mediawiki':
					self::disableEditor('useeditor');
					break;

				case 'source':
					self::setInitMode('source');
					break;

				case 'wysiwyg':
				case 'visual':
					$forcedWysiwyg = true;
					self::setInitMode('wysiwyg');
					break;
			}
		}

		// check namespaces
		global $wgWysiwygDisabledNamespaces, $wgWysiwygDisableOnTalk, $wgEnableSemanticMediaWikiExt;
		if(!empty($wgWysiwygDisabledNamespaces) && is_array($wgWysiwygDisabledNamespaces)) {
			if(in_array(self::$title->getNamespace(), $wgWysiwygDisabledNamespaces)) {
				self::disableEditor('disablednamespace');
			}
		} else {
			if(self::$title->getNamespace() == NS_TEMPLATE || self::$title->getNamespace() == NS_MEDIAWIKI) {
				self::disableEditor('namespace');
			}
		}
		if(!empty($wgWysiwygDisableOnTalk)) {
			if(self::$title->isTalkPage()) {
				self::disableEditor('talkpage');
			}
		}
		// BugId: 11336 disable RTE on Special SMW namespaces
		if ($wgEnableSemanticMediaWikiExt && in_array(self::$title->getNamespace(), array( SMW_NS_PROPERTY, SF_NS_FORM, NS_CATEGORY, SMW_NS_CONCEPT ))) {
			self::disableEditor('smw_namespace');
		}

		// RT #10170: do not initialize for user JS/CSS subpages
		if (self::$title->isCssJsSubpage()) {
			RTE::log('editor is disabled on user JS/CSS subpages');
			self::disableEditor('cssjssubpage');
		}

		// check user preferences option
		$userOption = $wgUser->getOption('enablerichtext');
		if( ($userOption != true) && empty($forcedWysiwyg) ) {
			RTE::log('editor is disabled because of user preferences');
			self::disableEditor('userpreferences');
		}

		// check current skin - enable RTE only on Oasis
		$skinName = get_class(RequestContext::getMain()->getSkin());
		if($skinName != 'SkinOasis') {
			RTE::log("editor is disabled because skin {$skinName} is unsupported");
			self::disableEditor('skin');
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
	public static function disableEditor($reason = false) {
		self::$useWysiwyg = false;
		self::$wysiwygDisabledReason = $reason;

		RTE::log("CK editor disabled - the reason is '{$reason}'");
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
		// disable headings numbering
		$options->setNumberHeadings(false);

		RTE::$parser = new RTEParser();

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

	public static function getTemplateParams(Title $titleObj, Parser $parser) {
		global $wgRTETemplateParams;
		wfProfileIn(__METHOD__);

		$params = array();

		$wgRTETemplateParams = true;
		$templateDom = $parser->getTemplateDom($titleObj);
		$wgRTETemplateParams = false;

		if($templateDom[0]) {
			// BugId:982 - use xpath to find all <tplarg> nodes
			$xpath = $templateDom[0]->getXPath();

			// <tplarg><title>foo</title></tplarg>
			$nodes = $xpath->query('//tplarg/title');

			foreach($nodes as $node) {
				// skip nested <tplarg> tags
				if ($node->childNodes->length == 1) {
					$params[$node->textContent] = 1;
				}
			}
		}

		$ret = array_keys($params);

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/*
	 * Return list of templates to be placed in dropdown menu on CK toolbar
	 * (moved to TemplateService)
	 */
	private static function getTemplateDropdownList() {
		return TemplateService::getPromotedTemplates();
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
	 * (moved to TemplateService)
	 */
	static public function getHotTemplates() {
		return TemplateService::getHotTemplates();
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
	 * In some cases the entire RTE is disabled (fallback to mediawiki editor)
	 * The self::$useWysiwyg variable is set to false in this case
	 * In some cases, RTE is enabled but starts in source mode by default
	 * The self::$initMode variable is checked for this
	 * @return boolean true/false if we are in fancy edit mode
	 */

	static function isWysiwygModeEnabled() {
		return (self::$useWysiwyg && self::$initMode == "wysiwyg");
	}

	/**
	 * This will be false if mediawiki editor is being used
	 * @return boolean true/false if RTE is enabled
	 */
	static function isEnabled() {
		return self::$useWysiwyg;
	}

	/**
	 * Add "Enable Rich Text Editing" as the first option in editing tab of user preferences
	 */
	static function onEditingPreferencesBefore($user, &$preferences) {
		// add JS to hide certain switches when wysiwyg is enabled
		global $wgOut, $wgJsMimeType, $wgExtensionsPath;
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"$wgExtensionsPath/wikia/RTE/js/RTE.preferences.js\"></script>" );

		// add RTE related section under "Editing" tab
		$preferences['enablerichtext'] = array(
			'type' => 'toggle',
			'section' => 'editing/rte',
			'label-message' => 'enablerichtexteditor',
		);

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
			global $wgTitle, $wgRTEDisablePreferencesChange;
			if ( !empty($wgRTEDisablePreferencesChange) || !empty($wgTitle) && ($wgTitle->getNamespace() == NS_SPECIAL) ) {
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

		if ( isset( $_SERVER ) && isset($_SERVER['HTTP_USER_AGENT'])) {
			$sAgent = $_SERVER['HTTP_USER_AGENT'] ;
		}
		else {
			global $HTTP_SERVER_VARS ;
			if ( isset( $HTTP_SERVER_VARS ) && isset($HTTP_SERVER_VARS['HTTP_USER_AGENT']) ) {
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
