<?php
$wgExtensionCredits['other'][] = array(
	'name' => 'Wikia Rich Text Editor (Wysiwyg)',
	'description' => 'FCKeditor integration for MediaWiki',
	'url' => 'http://www.wikia.com/wiki/c:help:Help:New_editor',
	'version' => 0.16,
	'author' => array('Inez Korczyński', 'Maciej Brencz', 'Maciej Błaszkowski (Marooned)', 'Łukasz \'TOR\' Garczewski')
);

$dir = dirname(__FILE__).'/';
$wgExtensionMessagesFiles['Wysiwyg'] = $dir.'i18n/Wysiwyg.i18n.php';
$wgExtensionMessagesFiles['FCK'] = $dir.'i18n/FCK.i18n.php';
$wgAjaxExportList[] = 'Wysywig_Ajax';
$wgAjaxExportList[] = 'WysiwygToolbarRemoveTooltip';
$wgEnableMWSuggest = true;

$wgHooks['AlternateEdit'][] = 'Wysiwyg_AlternateEdit';
$wgHooks['BlogsAlternateEdit'][] = 'Wysiwyg_AlternateEdit';
$wgHooks['EditPage::showEditForm:initial'][] = 'Wysiwyg_Initial';
$wgHooks['UserToggles'][] = 'Wysiwyg_Toggle';
$wgHooks['UserGetOption'][] = 'Wysiwyg_UserGetOption';
$wgHooks['getEditingPreferencesTab'][] = 'Wysiwyg_UserPreferences';
$wgHooks['MagicWordwgVariableIDs'][] = 'Wysiwyg_RegisterMagicWordID';
$wgHooks['LanguageGetMagic'][] = 'Wysiwyg_GetMagicWord';
$wgHooks['InternalParseBeforeLinks'][] = 'Wysiwyg_RemoveMagicWord';
$wgHooks['LinkEnd'][] = 'Wysiwyg_LinkEnd';
$wgHooks['MakeGlobalVariablesScript'][] = 'Wysiwyg_Variables';

function Wysiwyg_SetDomain(&$skin, &$tpl) {

	$js = <<<EOD
<script type="text/javascript">/*<![CDATA[*/
if(document.domain != 'localhost') {
	var chunks = document.domain.split('.');
	var d = chunks.pop(); // com
	d = chunks.pop() + '.' + d; // wikia.com
	document.domain = d;
}
/*]]>*/</script>
EOD;

	$tpl->data['headlinks'] .= $js;
	return true;
}

function Wysiwyg_RegisterMagicWordID(&$magicWords) {
	$magicWords[] = 'MAG_NOWYSIWYG';
	return true;
}

function Wysiwyg_GetMagicWord(&$magicWords, $langCode) {
	$magicWords['MAG_NOWYSIWYG'] = array(0, '__NOWYSIWYG__');
	return true;
}

function Wysiwyg_RemoveMagicWord(&$parser, &$text, &$strip_state) {
	MagicWord::get('MAG_NOWYSIWYG')->matchAndRemove($text);
	return true;
}

// add "Enable Rich Text Editing" as the first option in editing tab of user preferences
function Wysiwyg_UserPreferences($preferencesForm, $toggles) {
	array_unshift($toggles, 'enablerichtext');

	// add JS to hide certain switches when wysiwyg is enabled
	global $wgOut, $wgJsMimeType, $wgExtensionsPath, $wgStyleVersion;
	$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"$wgExtensionsPath/wikia/Wysiwyg/wysiwyg_preferences.js?$wgStyleVersion\"></script>" );

	return true;
}

// add user toggles
function Wysiwyg_Toggle($toggles) {
	$toggles[] = 'enablerichtext';
	return true;
}

// modify values returned by User::getOption() when wysiwyg is enabled
function Wysiwyg_UserGetOption($options, $name, $value) {

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

function Wysywig_Ajax($type, $input = false, $wysiwygData = false, $pageName = false) {

	if($type == 'html2wiki') {
		return new AjaxResponse(Wysiwyg_HtmlToWikiText($input, $wysiwygData, true));
	} else if($type == 'wiki2html') {
		wfLoadExtensionMessages('Wysiwyg');

		$ret = Wysiwyg_WikiTextToHtml($input, $pageName, true);

		if($ret['type'] == 'html') {
			$separator = Parser::getRandomString();
			header('X-sep: ' . $separator);
			return new AjaxResponse($ret['html']."--{$separator}--".$ret['data']);
		} else if($ret['type'] == 'edgecase') {
			header('X-edgecases: 1');
			return $ret['edgecaseText'];
		}

	}
	return false;
}

function Wysiwyg_Variables(&$vars) {
	// only add variables on edit page using Wysiwyg
	global $wgWysiwygEdit;
	if (empty($wgWysiwygEdit)) {
		return true;
	}

	global $wgWysiwygPath;
	$vars['wgWysiwygPath'] = $wgWysiwygPath;

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

	// merge magic words lists, in FCK check type of magic word by searching $magicWordUnderscore list
	$magicWords = array_merge($magicWords, $magicWordsUnderscore);
	sort($magicWords);
	$vars['wysiwygMagicWordList'] = $magicWords;

	sort($magicWordsUnderscore);
	$vars['wysiwygMagicWordUnderscoreList'] = $magicWordsUnderscore;

	// toolbar tooltip
	$toolbarTooltip = WysiwygToolbarAddTooltip();
	if (!empty($toolbarTooltip)) {
		$vars['wysiwygToolbarTooltip'] = $toolbarTooltip;
	}

	// toolbar buckets & items
	$toolbar = WysiwygGetToolbarData();
	$vars['wysiwygToolbarBuckets'] = $toolbar['buckets'];
	$vars['wysiwygToolbarItems'] = $toolbar['items'];

	// localised template namespace name (RT #3808)
	global $wgLang;
	$vars['wysiwygTemplateNS_name'] = $wgLang->getNsText(NS_TEMPLATE);

	return true;
}

function Wysiwyg_Initial($form) {
	global $wgUser, $wgOut, $wgRequest, $IP, $wgExtensionsPath, $wgStyleVersion, $wgHooks, $wgContentNamespaces;
	global $wgJsMimeType, $wgWysiwygEdit;

	wfProfileIn(__METHOD__);

	// check user preferences option
	if($wgUser->getOption('enablerichtext') != true) {
		wfProfileOut(__METHOD__);
		return true;
	}

	// do not initialize for articles in namespaces different then main, image or user
	$validNamespaces = array_merge( $wgContentNamespaces, array( NS_IMAGE, NS_USER, NS_CATEGORY, NS_VIDEO, NS_SPECIAL ) );
	if(!in_array($form->mTitle->mNamespace, $validNamespaces)) {
		wfProfileOut(__METHOD__);
		return true;
	}

	// RT #10170: do not initialize for user JS/CSS subpages
	if ($form->mTitle->isCssJsSubpage()) {
		wfProfileOut(__METHOD__);
		return true;
	}

	// macbre: enable only on monaco skin
	if( !in_array(get_class($wgUser->getSkin()), array('SkinMonaco', 'SkinAwesome')) ) {
		wfProfileOut(__METHOD__);
		return true;
	}

	if($wgRequest->getVal('useeditor', 'wysiwyg') == 'mediawiki') {
		// editor mode (RT #17269)
		// fallback to old MW editor
		wfProfileOut(__METHOD__);
		return true;
	}

	require("$IP/extensions/wikia/Wysiwyg/fckeditor/fckeditor_php5.php");

	// do not initialize for not compatible browsers
	if(!FCKeditor_IsCompatibleBrowser()) {
		wfProfileOut(__METHOD__);
		return true;
	}

	wfLoadExtensionMessages('Wysiwyg');

	// set global flag - we're using wysiwyg to edit this page
	$wgWysiwygEdit = true;

	// RT #17007
	global $wgWysiwygNoWysiwygFound;
	if (!empty($wgWysiwygNoWysiwygFound)) {
		$msg =  Xml::encodeJsVar( wfMsg('wysiwyg-edgecase-info') . ' ' . wfMsg('wysiwyg-edgecase-nowysiwyg') );
		// TODO: move to Wysiwyg_Variables
		$wgOut->addInlineScript("var noWysiwygMagicWordMsg = {$msg};");
	}

	// CSS
	$wgOut->addExtensionStyle("$wgExtensionsPath/wikia/Wysiwyg/wysiwyg.css?$wgStyleVersion");

	// TODO: move to Wysiwyg_Variables
	$wgOut->addInlineScript(
		"\tvar templateList = " . WysiwygGetTemplateList() . ';' .
		"\n\tvar templateHotList = " . WysiwygGetTemplateHotList() . ';'
	);

	// RT #17499: detect wikis which may cause troubles when serving JS/iframe from images.wikia.com
	global $wgServerName, $wgScriptPath, $wgWysiwygPath;
	if (strpos($wgServerName, 'wikia.com') === false) {
		// serve JS/iframe from wiki domain
		$wgWysiwygPath = 'http://' . $wgServerName . $wgScriptPath . '/extensions/wikia/Wysiwyg';
	}
	else {
		// serve JS/iframe from images.wikia.com
		$wgWysiwygPath = $wgExtensionsPath . '/wikia/Wysiwyg';

		// change document domain to wikia.com
		$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'Wysiwyg_SetDomain';
	}

	// load JS files
	$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"$wgWysiwygPath/fckeditor/fckeditor.js?$wgStyleVersion\"></script>\n" );
	$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"$wgWysiwygPath/wysiwyg.js?$wgStyleVersion\"></script>\n" );

	$wgHooks['EditPage::showEditForm:initial2'][] = 'Wysiwyg_Initial2';
	$wgHooks['EditForm:BeforeDisplayingTextbox'][] = 'Wysiwyg_BeforeDisplayingTextbox';
	$wgHooks['EditPageBeforeEditButtons'][] = 'Wysiwyg_BlockSaveButton';

	wfProfileOut(__METHOD__);
	return true;
}

function Wysiwyg_Initial2($form) {
	global $wgWysiwygData, $wgOut, $wgRequest;
	$wgWysiwygData = '';

	if(!($wgRequest->getVal('useeditor', 'wysiwyg') == 'wysiwygsource' || ($wgRequest->getVal('action') == 'submit' && $wgRequest->getVal('wysiwygTemporarySaveType') == '1'))) {
		$ret = Wysiwyg_WikiTextToHtml($form->textbox1, false, true);
		if($ret['type'] == 'html') {
			$form->textbox1 = $ret['html'];
			$wgWysiwygData = $ret['data'];
		}
	}

	$wgOut->addInlineScript('var fallbackToSourceMode = '.($wgWysiwygData === '' ? 'true' : 'false').';');

	// show first edit messages when needed
	WysiwygFirstEditMessage();

	return true;
}

function Wysiwyg_AlternateEdit($form) {
	global $wgRequest, $wgHooks;
	if(isset($wgRequest->data['wpTextbox1'])) {
		if(isset($wgRequest->data['wysiwygData'])) {
			if($wgRequest->data['wysiwygData'] != '') {
				$wgRequest->data['wpTextbox1'] = Wysiwyg_HtmlToWikiText($wgRequest->data['wpTextbox1'], $wgRequest->data['wysiwygData'], true);
				if(!empty($wgRequest->data['wpSave'])) {
					$wgHooks['ArticleSaveComplete'][] = 'Wysiwyg_NotifySaveComplete';
				}
			}
		}
	}
	return true;
}

function Wysiwyg_NotifySaveComplete(&$article, &$user, &$text, &$summary, &$minoredit, &$watchthis, &$sectionanchor, &$flags, $revision) {
	global $wgDevelEnvironment;
	if(is_object($revision) && empty($wgDevelEnvironment)) {
		global $wgSitename;

		$url = $article->getTitle()->getFullURL();
		$diffEngine = new DifferenceEngine($article->getTitle(), $revision->mParentId, $revision->mId);
		$diffText = $diffEngine->getDiffBody();
		$diffText = str_replace("\n", "", $diffText);
		$out = "<a href=\"{$url}\">link</a><table class='diff'><col class='diff-marker' /><col class='diff-content' /><col class='diff-marker' /><col class='diff-content' /><tbody>{$diffText}</tbody></table>";

		$data = array('title' => $wgSitename, 'description' => $out);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://fp026.sjc.wikia-inc.com/inez/test.php");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
		curl_close($ch);
	}
	return true;
}

function Wysiwyg_BeforeDisplayingTextbox($a, $b) {
	global $wgOut, $wgWysiwygData;
	$wgOut->addHTML('<input type="hidden" id="wysiwygData" name="wysiwygData" value="'.htmlspecialchars($wgWysiwygData).'" />');
	$wgOut->addHTML('<input type="hidden" id="wysiwygTemporarySaveType" name="wysiwygTemporarySaveType" value="" />');
	$wgOut->addHTML('<input type="hidden" id="wysiwygTemporarySaveContent" name="wysiwygTemporarySaveContent" value="" />');
	return true;
}

/**
 * Search for not handled edge cases in FCK editor
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function Wysiwyg_CheckEdgeCases($text) {
	$out = '';
	$edgeCasesFound = array();
	$edgeCases = array(
		'regular' => array(
			//'<!--' => 'wysiwyg-edgecase-comment', // HTML comments
			'{{{' => 'wysiwyg-edgecase-triplecurls', // template parameters
		),
		'regexp' => array(
			'/<span.*?refid/si' => 'wysiwyg-edgecase-syntax', // span with fck metadata - shouldn't be used by user
		)
	);
	foreach($edgeCases['regular'] as $str => $msgkey) {
		if (strpos($text, $str) !== false) {
			$edgeCasesFound[] = wfMsg($msgkey);
		}
	}
	foreach($edgeCases['regexp'] as $regexp => $msgkey) {
		if (preg_match($regexp, $text)) {
			$edgeCasesFound[] = wfMsg($msgkey);
		}
	}

	// macbre: existance of __NOWYSIWYG__ (RT #17005)
	global $wgWysiwygNoWysiwygFound;
	if (!empty($wgWysiwygNoWysiwygFound)) {
		$edgeCasesFound[] = wfMsg('wysiwyg-edgecase-nowysiwyg');
	}
	else {
		if (Wysiwyg_NoWysiwygFound($text)) {
			$edgeCasesFound[] = wfMsg('wysiwyg-edgecase-nowysiwyg');
		}
	}

	// macbre: is current article an redirect (RT #13637)
	if (strtoupper(substr($text, 0, 9)) == '#REDIRECT') {
		$edgeCasesFound[] = wfMsg('wysiwyg-edgecase-redirect');
	}

	// if edge case was found add main information about edge cases, like "Edge cases found:"
	if (count($edgeCasesFound) > 0) {
		$out = wfMsg('wysiwyg-edgecase-info').' '.implode(', ', $edgeCasesFound);
	}
	return $out;
}

/*
 * Check for __NOWYSIWYG__ magic word
 *
 * @author Maciej Brencz <macbre at wikia-inc.com>
 */
$wgHooks['EditPage::getContent::end'][] = 'Wysiwyg_CheckNoWysiwyg';
function Wysiwyg_CheckNoWysiwyg($editPage, $t) {
	global $wgWysiwygNoWysiwygFound;

	// get WHOLE article content, even if doing section edit (RT #17005)
	$text = $editPage->mArticle->getContent();
	$wgWysiwygNoWysiwygFound = Wysiwyg_NoWysiwygFound($text);

	return true;
}

/*
 * Helper function to find __NOWYSIWYG__ magic word in wikitext provided
 *
 * @author Maciej Brencz <macbre at wikia-inc.com>
 */
function Wysiwyg_NoWysiwygFound($text) {
	$mw = MagicWord::get('MAG_NOWYSIWYG');
	if ($mw->match($text)) {
		$matches = array();
		$countNoWysiwygAll = preg_match_all($mw->getRegex(), $text, $matches);
		$countNoWysiwygInNoWiki = preg_match_all('/\<nowiki\>__NOWYSIWYG__\<\/nowiki\>/si', $text, $matches);

		wfDebug("Wysiwyg: __NOWYSIWYG__ (count: {$countNoWysiwygAll} / in <nowiki>: {$countNoWysiwygInNoWiki})\n");

		if ($countNoWysiwygAll > $countNoWysiwygInNoWiki) {
			return true;
		}
	}
	return false;
}

function Wysiwyg_WikiTextToHtml($wikitext, $pageName = false, $encode = false) {
	$edgeCasesText = Wysiwyg_CheckEdgeCases($wikitext);
	if($edgeCasesText != '') {
		return array('type' => 'edgecase', 'edgecaseText' => $edgeCasesText);
	}

	global $IP, $wgWysiwygMetaData, $wgWysiwygParserEnabled, $wgWysiwygParserTildeEnabled, $wgTitle, $wgUser, $wgWysiwygMarkers;

	require_once("$IP/extensions/wikia/Wysiwyg/WysiwygParser.php");

	wfDebug("Wysiwyg_WikiTextToHtml wikitext: {$wikitext}\n");

	$title = ($pageName === false) ? $wgTitle : Title::newFromText($pageName);

	// detect empty lines at the beginning of wikitext
	$emptyLinesAtStart = strspn($wikitext, "\n");

	$options = new ParserOptions();
	$wysiwygParser = new WysiwygParser();
	$wysiwygParser->disableCache();
	$wysiwygParser->startExternalParse($title, $options, OT_HTML, false);

	$wgWysiwygParserTildeEnabled = true;
	$wikitext = $wysiwygParser->preSaveTransform($wikitext, $title, $wgUser, $options);
	$wgWysiwygParserTildeEnabled = false;

	$wgWysiwygParserEnabled = true;
	$html = $wysiwygParser->parse($wikitext, $title, $options)->getText();
	$wgWysiwygParserEnabled = false;

	global $wgWysiwygTableTemplateEdgeCase;
	if(!empty($wgWysiwygTableTemplateEdgeCase)) {
		return array('type' => 'edgecase', 'edgecaseText' => wfMsg('wysiwyg-edgecase-info').' '.wfMsg('wysiwyg-edgecase-templateintable'));
	}

	global $wgWysiwygCommentEdgeCase;
	if(!empty($wgWysiwygCommentEdgeCase)) {
		return array('type' => 'edgecase', 'edgecaseText' => wfMsg('wysiwyg-edgecase-info').' '.wfMsg('wysiwyg-edgecase-comment'));
	}


	// detect empty line at the beginning of wikitext
	if($emptyLinesAtStart == 1) {
		$html = '<!--NEW_LINE-->' . $html;
	}

	// add _wysiwyg_new_line attribute to HTML node following <!--NEW_LINE--> comment
	$html = preg_replace('/<\!--NEW_LINE--><(\w+)/', '<$1 _wysiwyg_new_line="true"', $html);

	// extract refid's of templates from template markers
	preg_match_all('/\x7f-wtb-(\d+)-\x7f/', $html, $matches);

	if(count($matches[1]) > 0) {
		$templateCallsToParse = array();
		foreach($matches[1] as $val) {
			$originalCall = $wgWysiwygMetaData[$val]['originalCall'];
			if($originalCall{strlen($originalCall)-1} != "\n") {
				$originalCall .= "\n";
			}
			$templateCallsToParse[] = $originalCall;
		}

		$templateParser = new Parser();

		//  RT #17279
		global $wgParser;
		$templateParser->mTagHooks = & $wgParser->mTagHooks;
		$templateParser->mStripList = & $wgParser->mStripList;

		$templateParser->setOutputType(OT_HTML);
		$templateCallsParsed = explode("\x7f-sep-\x7f", $templateParser->parse(implode("\x7f-sep-\x7f", $templateCallsToParse), $title, $options, false)->getText());

		$templateCallsParsed =  array_combine($matches[1], $templateCallsParsed);

		wfDebug("Wysiwyg HTML: {$html}\n");

		// save name of HTML tag wrapping template output
		foreach($templateCallsParsed as $refid => $parsed) {

			// get closing tags from the beginning of the original HTML between wtb/wte markers (RT #17553)
			$wgWysiwygMetaData[$refid]['prefix'] = '';

			preg_match('/\x7f-wtb-'.$refid.'-\x7f(.*)\x7f-wte-'.$refid.'-\x7f/s', $html, $parsedOrig);
			if (!empty($parsedOrig)) {
				preg_match('/^\s?(<\/\w+>\s?)+/', ltrim($parsedOrig[1]), $matches);
				if (!empty($matches)) {
					$wgWysiwygMetaData[$refid]['prefix'] = rtrim($matches[0]);
					wfDebug("Wysiwyg template prefix {$matches[0]}\n");
				}
			}

			// get closing tags after the wte marker (RT #17553)
			// they will be compared with tidy'ed preview HTML
			preg_match('/\x7f-wte-'.$refid.'-\x7f(\s?(<\/\w+>\s?)+)/s', $html, $parsedAfter);
			if (!empty($parsedAfter)) {
				$parsedAfter = trim($parsedAfter[2]);
				wfDebug("Wysiwyg template suffix {$parsedAfter}\n");
			}
			else {
				$parsedAfter = false;
			}

			// get template wrapping HTML tag
			$parsed = trim($parsed);

			if (strlen($parsed) > 0 && $parsed{0} != '<') {
				$wrapper = false;
			}
			else {
				// HTML cleanup
				$parsed = Parser::tidy($parsed);

				// remove HTML comments (RT #17554)
				$parsed = Sanitizer::removeHTMLcomments($parsed);

				// get first HTML tag
				$wrapper = substr($parsed, 1, strpos($parsed, '>') - 1);

				// try to get only the name (get rid of attributes)
				if (strpos($wrapper, ' ') !== false) {
					$wrapper = substr($wrapper, 0, strpos($wrapper, ' '));
				}

				// save cleaned HTML for preview in wysiwyg mode
				$templateCallsParsed[$refid] = $parsed;

				wfDebug("Wysiwyg template #{$refid}: {$parsed}\n");
			}
			$wgWysiwygMetaData[$refid]['wrapper'] = $wrapper;

			// RT #17553 - do not fix templates wrapped inside table/div
			if ( in_array($wrapper, array('table', 'div')) ) {
				$wgWysiwygMetaData[$refid]['prefix'] = '';
				$parsedAfter = false;
			}

			// compare end of template preview with $parsedAfter (RT #17553)
			if ($parsedAfter !== false) {
				if ( substr(rtrim($parsed), strlen($parsedAfter) * -1) == $parsedAfter ) {
					wfDebug("Wysiwyg removing template prefix {$parsedAfter}\n");

					// remove from HTML after wte marker
					$html = preg_replace("\x7c".'(\x7f-wte-' . $refid . '-\x7f)\s?' . $parsedAfter . "\x7cs", '\\1', $html);
				}
			}
		}

		$html = preg_replace('/\x7f-wtb-(\d+)-\x7f.*?\x7f-wte-\1-\x7f/sie', "\$wgWysiwygMetaData[\\1]['prefix'] . '<input type=\"button\" refid=\"\\1\" _fck_type=\"template\" value=\"'.\$wgWysiwygMetaData[\\1]['name'].'\" class=\"wysiwygDisabled wysiwygTemplate\" /><input value=\"'.htmlspecialchars(stripslashes(\$templateCallsParsed[\\1])).'\" style=\"display:none\" />'", $html);
	}

	// fix for multiline pre
	$html = preg_replace_callback('#<pre>.*?</pre>#si', 'WysiwygPreCallback', $html);

	// fix for IE
	$html = str_replace("\n", "<!--EOL1-->\n", $html);

	// correctly handle whitespaces at the beginning of list item and inside headers
	$html = preg_replace_callback("/<li>(\s*)/", create_function('$matches','return "<li _wysiwyg_space_after=\"".$matches[1]."\">";'), $html);
	$html = preg_replace_callback("/<h([1-6][^>]*)>(\s*)/", create_function('$matches','return "<h".$matches[1]." _wysiwyg_space_after=\"".$matches[2]."\">";'), $html);

	// replace placeholders with <input> grey boxes
	if (!empty($wgWysiwygMarkers)) {
		$html = strtr($html, $wgWysiwygMarkers);
	}

	// RT #17933 - add <p> before <input> at the beginning of line
	// we need to open paragraph which is closed after <input>
	$html = preg_replace('/^<input type="button" refid=/m', '<p>\0', $html);

	wfDebug("Wysiwyg_WikiTextToHtml html: {$html}\n");

	return array('type' => 'html', 'html' => $html, 'data' => $encode ? Wikia::json_encode($wgWysiwygMetaData, true) : $wgWysiwygMetaData);
}

/**
 * Callback function for preg_replace_callback (RT #19215)
 *
 * @author Maciej Brencz <macbre at wikia-inc.com>
 */
function WysiwygPreCallback($input) {
	return str_replace("\n", "<!--EOLPRE-->\n", $input[0]);
}

function Wysiwyg_HtmlToWikiText($html, $wysiwygData, $decode = false) {

	// fix for IE
	$html = str_replace("<!--EOL1-->\n", "", $html);
	$html = str_replace("<!--EOL1--> ", " ", $html);
	$html = str_replace("<!--EOL1-->", " ", $html);

	// fix for multiline pre
	$html = str_replace("<!--EOLPRE-->", "\n", $html);

	// RT #17007
	$html = str_replace("\x0a\x20\x0d\x0a", "\x0a", $html);

	$html = preg_replace_callback("/<li _wysiwyg_space_after=\"(\s*)\">/", create_function('$matches','return "<li>".$matches[1];'), $html);

	require_once(dirname(__FILE__).'/ReverseParser.php');

	$reverseParser = new ReverseParser();
	$out = $reverseParser->parse($html, $decode ? Wikia::json_decode($wysiwygData, true) : $wysiwygData);

	// fix non-breakable space issue ("empty" diffs)
	$out = str_replace("\xC2\xA0", ' ', $out);

	// Special handling for #REDIRECT (per #13637)
	if(strtoupper(substr($out,0, 26)) == '<NOWIKI>#</NOWIKI>REDIRECT') {
		$outA = split("\n", trim($out));
		if(count($outA) == 1) {
			return str_replace(array('<nowiki>','</nowiki>'), array('',''), $out);
		}
	}

	return $out;
}

function Wysiwyg_WrapTemplate($originalCall, $output, $lineStart) {
	global $wgWysiwygMetaData;

	$refId = count($wgWysiwygMetaData);

	$data = array();
	$data['type'] = 'template';
	$data['originalCall'] = $originalCall;

	if(!empty($lineStart)) {
		$data['lineStart'] = 1;
	}

	$templateName = explode('|', substr($originalCall, 2, -2));
	$data['name'] = trim($templateName[0]);

	$params = WysiwygGetTemplateParams($data['name'], $originalCall);
	if (count($params)) {
		$data['templateParams'] = $params;
	}

	$wgWysiwygMetaData[$refId] = $data;

	// macbre: add \n to the end of multiline templates
	if( (strpos($output, "\n") !== false) && ($output{strlen($output)-1} != "\n") ) {
		$output .= "\n";
	}

	// macbre: fix for templates wrapped by <div> tags (e.g. Template:Navigation on lot of wikis)
	// paragraphs will be added, so newline info won't be lost
	if ( substr($output, 0, 4) == '<div') {
		$output = "\n".trim($output)."\n";
	}

	// RT #19213: don't break table wikitext
	if ( substr($output, 0, 2) == '{|') {
		$output = "\n".$output;
	}

	return "\x7f-wtb-{$refId}-\x7f{$output}\x7f-wte-{$refId}-\x7f";
}

/**
 * Adding reference ID with metadata to global $wgWysiwygMetaData and surround passed element with extra code
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function Wysiwyg_SetRefId($type, $params, $addMarker = true, $returnId = false) {
	global $wgWysiwygMetaData, $wgWysiwygMarkers;

	if(!empty($params['original'])) {
		$params['original'] = preg_replace('/\x7e-start-\d+-stop/', '', $params['original']);
		$params['original'] = preg_replace('/\x7d-\d{4}/', '', $params['original']);
	}

	$refId = count($wgWysiwygMetaData);
	$data = array('type' => $type);
	$result = '';

	// CSS class based on type of placeholder
	$className = 'wysiwygDisabled wysiwyg' . strtr(ucwords($type), array(':' => '', ' ' => ''));

	// macbre: whether to replace $params['text'] with placeholder
	// used for links with templates (e.g. [[foo|{{bar}}]]
	$returnPlaceholder = false;

	$regexPreProcessor = array(
		'search' => array(
			'%<template><title>[^<]*</title><originalCall><!\[CDATA\[(.*?)]]></originalCall>(?:<part>.*?</part>)*</template>%si',
			'%<ext><name>([^>]+)</name><attr>[^>]*</attr><inner>([^>]+)</inner><close>[^>]+</close></ext>%si'),
		'replace' => array(
			'\1',
			'<\1>\2</\1>')
	);

	switch ($type) {
		case 'heading' :
			$data = $params;
			break;
		case 'external link':
			$data['href'] = $params['link'];
			if ($params['original'] != '') {
				$data['original'] = htmlspecialchars_decode(preg_replace($regexPreProcessor['search'], $regexPreProcessor['replace'], $params['original']));
			}
			break;

		case 'internal link':
		case 'internal link: special page':
		case 'internal link: file':
			$data['href'] = ($params['noforce'] ? '' : ':') . $params['link'];
			$data['description'] = $params['wasblank'] ? '' : $params['text'];
			if ($params['trail'] != '') {
				list($tmpInside, $tmpTrail) = Linker::splitTrail($params['trail']);
				if ($tmpInside != '') {
					$data['trial'] = $tmpInside;
				}
			}
			if (isset($params['original']) && $params['original'] != '') {
				$data['original'] = htmlspecialchars_decode(preg_replace($regexPreProcessor['search'], $regexPreProcessor['replace'], $params['original']));
				// do we have template inside link description? -> use placeholder
				if (strpos($data['original'], '{{') !== false) {
					$data['type'] = 'internal link: placeholder';
					unset($data['href']);
					unset($data['description']);
					$result = $data['original'];
					$returnPlaceholder = true;
				}
			}

			break;

		case 'internal link: media':
			$data['href'] = $params['link'];
			$data['description'] = (!empty($params['wasblank']) ? '' : $params['text']);
			$result = '[[' . $params['link'] . (!empty($params['wasblank']) ? '' : '|' . $params['text']) . ']]';
			break;

		case 'category':
			$data['href'] = ($params['noforce'] ? '' : ':') . $params['link'];
			if ($params['original'] != '') {
				$data['original'] = htmlspecialchars_decode(preg_replace($regexPreProcessor['search'], $regexPreProcessor['replace'], $params['original']));
			}
			if ($params['whiteSpacePrefix'] != '') {
				$data['whiteSpacePrefix'] = $params['whiteSpacePrefix'];
			}
			$result = $data['original'];
			break;

		case 'image':
			$data['href'] = ($params['noforce'] ? '' : ':') . $params['link'];
			if ($params['original'] != '') {
				$data['original'] = htmlspecialchars_decode(preg_replace($regexPreProcessor['search'], $regexPreProcessor['replace'], $params['original']));
				if (empty($params['wasblank'])) {
					$data['caption'] = '';

					$caption = $data['original'];
					$captionIsIn = array('template' => 0, 'internal' => 0, 'external' => 0);

					for ($i=strlen($caption)-3; $i >= 2; $i--) {
						if ($caption{$i} == '}' && $caption{$i-1} == '}') {
							$captionIsIn['template']++;
						}
						else if ($caption{$i} == '{' && $caption{$i-1} == '{') {
							$captionIsIn['template']--;
						}
						else if ($caption{$i} == '[' && $caption{$i-1} == '[') {
							$captionIsIn['internal']--;
						}
						else if ($caption{$i} == ']' && $caption{$i-1} == ']') {
							$captionIsIn['internal']++;
						}
						else if ($caption{$i} == '[' && $caption{$i-1} != '[') {
							$captionIsIn['external']--;
						}
						else if ($caption{$i} == ']' && $caption{$i-1} != ']') {
							$captionIsIn['external']++;
						}
						else if ($caption[$i] == '|') {
							if ($captionIsIn['template'] == 0 && $captionIsIn['internal'] == 0 && $captionIsIn['external'] == 0) {
								$data['caption'] = substr($caption, $i+1, -2);
								break;
							}
						}
					}
				}
				// let's replace original wikitext image params (RT #19208)
				$params['text'] = htmlspecialchars(substr($data['original'], 3 + strlen($params['link']), -2));
			}
			break;

		// RT #18490
		case 'image: whitelisted':
			$data['href'] = $params['text'];
			$result = $params['text'];
			break;

		case 'external link: raw image':
			$data['href'] = $params['text'];
			break;

		case 'external link: raw':
			$data['href'] = $params['link'];
			break;

		case 'interwiki':
			$data['originalCall'] = htmlspecialchars_decode(preg_replace($regexPreProcessor['search'], $regexPreProcessor['replace'], $params['original']));
			$result = $data['originalCall'];
			break;

		case 'nowiki':
		case 'gallery':
		case 'html':
		case 'placeholder':
			$data['description'] = $params['text'];
			$result = $params['text'];
			break;

		case 'hook':
			$data['description'] = $params['text'];
			$data['name'] = $params['name'];

			// return different placeholder content for different hook types
			switch($params['name']) {
				case 'inputbox':
				case 'videogallery':
					$result = "<{$params['name']}>";
					break;
				default:
					$result = $params['text'];
			}

			// class name based on hook type
			$className .= ' wysiwygHook' . ucfirst($params['name']);

			break;

		case 'comment':
			$data['originalCall'] = $params['text'];

			// get content of comment
			$value = substr(trim($params['text']), 4, -3);

			// preview
			$value = strtr(htmlspecialchars(trim($value)), array("\n" => '<br />'));
			$data['preview'] = $value;

			// add comment placeholder
			$placeholder = Xml::element('input', array(
				'type' => 'button',
				'refid' => $refId,
				'_fck_type' => $type,
				'class' => $className
			));

			$marker = "\x7f-comment-{$refId}-\x7f";
			$wgWysiwygMarkers[$marker] = $placeholder;

			break;

		case 'double underscore: toc':
			$data['description'] = $params['text'];
			$result = '__TOC__';
			break;

		case 'double underscore':
			$data['description'] = $params['text'];
			$result = $params['text'];
			break;

		case 'tilde':
			$data['description'] = $params['text'];
			$result = $params['text'];
			break;

		case 'video':
			$data['original'] = $params['original'];
			$result = $params['original'];
			break;

		case 'video_add':
			$data['width'] = $params['width'];
			$data['height'] = $params['height'];
			$data['isAlign'] = $params['isAlign'];
			$data['isThumb'] = $params['isThumb'];

			$data['original'] = $params['original'];
			break;
	}

	if($addMarker) {
		$params['text'] .= "\x1$refId\x1";
	}
	if($result != '') {
		$result = str_replace(' wasHtml="1"', '', $result);
		if (isset($data['description'])) {
			$data['description'] =  str_replace(' wasHtml="1"', '', $data['description']);
		}

		$result = Xml::element('input', array(
			'type' => 'button',
			'refid' => $refId,
			'_fck_type' => $type,
			'value' => $result,
			'title' => $result,
			'class' => $className
		));

		// macbre: use placeholders
		// they will be replaced with <input> grey boxes
		if ($returnPlaceholder) {
			$params['text'] = $result;
		}
		$marker = "\x7f-wysiwyg-{$refId}-\x7f";
		$wgWysiwygMarkers[$marker] = $result;
		$result = $marker;
	}

	$wgWysiwygMetaData[$refId] = $data;
	return $returnId ? $refId : $result;
}

/**
 * Getting and removing reference ID from the $text variable
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function Wysiwyg_GetRefId(&$text, $returnIDonly = false) {
	preg_match("#\x1([^\x1]+)#", $text, $m);
	$refId = isset($m[1]) ? ($returnIDonly ? $m[1] : " refid=\"{$m[1]}\"") : '';
	$text = preg_replace("#\x1[^\x1]+\x1#", '', $text);
	return $refId;
}

$wgAjaxExportList[] = 'WysiwygImage';
function WysiwygImage() {
	global $wgRequest, $wgExtensionsPath, $wgStylePath, $wgStyleVersion, $wgTitle;

	$options = new ParserOptions();
	$parser = new Parser();
	$out = $parser->parse($wgRequest->getText('wikitext'), $wgTitle, $options)->getText();

	$html = <<<EOD
<html>
<head>
<style type="text/css">
@import "$wgExtensionsPath/wikia/Wysiwyg/fckeditor/editor/css/fck_editorarea.css?$wgStyleVersion";
@import "$wgStylePath/monobook/main.css?$wgStyleVersion";
* {cursor: default}
</style>
</head>
<body>
$out
</body>
</html>
EOD;

	return new AjaxResponse($html);
}

/**
 * Grabbing all parameters and optionally values from selected template
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function WysiwygGetTemplateParams($name, $templateCall = null) {
	$result = null;
	if ($title = Title::newFromText($name, NS_TEMPLATE)) {
		if ($revision = Revision::newFromTitle($title)) {
			preg_match_all('/(?<!\{)\{\{\{([^{}|<]+)/', $revision->getText(), $result, PREG_PATTERN_ORDER);
			$result = array_flip($result[1]);
			array_walk($result, create_function('&$val, $key', '$val = "";'));
			if (!is_null($templateCall)) {

				$tc = Title::legalChars() . '#%';
				$e1 = "/^([{$tc}]+)(?:\\|(.+?))?]](.*)\$/sD";
				$e1_img = "/^([{$tc}]+)\\|(.*)\$/sD";

				$a = explode('[[', ' '.$templateCall);
				$templateCall = array_shift($a);
				$templateCall = substr($templateCall, 1);

				for($k = 0; isset($a[$k]); $k++) {
					$line = $a[$k];
					if(preg_match($e1, $line, $m)) {
						$templateCall .= str_replace('|', '%08X', '[[' . $m[1] . ($m[2] === '' ? '' : ('|' . $m[2])) . ']]') . $m[3];
					} elseif(preg_match($e1_img, $line, $m)) {
						$templateCall .=  str_replace('|', '%08X', '[[' . $m[1] . '|' . $m[2]);
					} else {
						$templateCall .= '[[' . $line ;
					}
				}

				$args = explode('|', substr($templateCall, 0, -2));
				unset($args[0]);
				foreach($args as $key => $val) {
					$val = str_replace('%08X', '|', $val);
					$vals = explode('=', $val, 2);
					if (count($vals) == 1) {
						$key = trim($key);
						if (array_key_exists($key, $result)) {
							$result[$key] = trim($val, " \n");
						}
					} else {
						$vals[0] = trim($vals[0]);
						if (array_key_exists($vals[0], $result)) {
							$result[$vals[0]] = trim($vals[1], " \n");
						}
					}
				}
			}
		}
	}
	return $result;
}

$wgAjaxExportList[] = 'WysiwygGetTemplateParamsAjax';
function WysiwygGetTemplateParamsAjax($name) {
	$params = WysiwygGetTemplateParams($name);
	return new AjaxResponse( Wikia::json_encode(!empty($params) ? $params : null, true) );
}

/**
 * Grabbing defined list of templates and their parameters
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function WysiwygGetTemplateList() {
	$lines = getMessageAsArray('editor-template-list');
	$nodes = array();
	if(is_array($lines) && count($lines) > 0) {
		foreach($lines as $line) {
			$depth = strrpos($line, '*');
			if($depth === 0) {
				$node = parseItem($line);
				$title = Title::newFromText($node['org'], NS_TEMPLATE);
				if (!$title->exists()) continue;
				$params = WysiwygGetTemplateParams($node['org']);
				$nodes[$node['org']] = array('desc' => $node['text'], 'params' => (!empty($params)) ? $params : null);
			}
		}
	}
	return Wikia::json_encode($nodes, true);
}

/**
 * Grabbing list of most included templates and their parameters
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function WysiwygGetTemplateHotList() {
	global $wgMemc, $wgCityId, $wgTemplateExcludeList;
	$key = "wysiwyg-$wgCityId-template-list";
	$list = $wgMemc->get($key);
	if(empty($list)) {
		$dbr = wfGetDB(DB_SLAVE);
		$templateExcludeList = '';
		if (is_array($wgTemplateExcludeList) && count($wgTemplateExcludeList)) {
			$templateExcludeListA = array();
			foreach($wgTemplateExcludeList as $tmpl) {
				$templateExcludeListA[] = $dbr->AddQuotes($tmpl);
			}
			$templateExcludeList = ' AND qc_title NOT IN (' . implode(',', $templateExcludeListA) . ')';
		}
		$sql = "SELECT * FROM querycache WHERE qc_type = 'Mostlinkedtemplates' AND qc_namespace = " . NS_TEMPLATE . "$templateExcludeList ORDER BY qc_value DESC LIMIT 10;";
		$res = $dbr->query($sql);
		$list = array();
		while ($row = $dbr->fetchObject($res)) {
			$title = Title::newFromText($row->qc_title, NS_TEMPLATE);
			if (!$title->exists()) continue;
			$params = WysiwygGetTemplateParams($row->qc_title);
			$list[$row->qc_title] = (!empty($params)) ? $params : null;
		}
		$list = Wikia::json_encode($list, true);
		$wgMemc->set($key, $list, 60 * 60);
	}
	return $list;
}

/**
 * Returns toolbar buckets and items names
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>
 */
function WysiwygGetToolbarData() {
	$toolbarData = array(
		array(
			'name'  => wfMsg('wysiwyg-toolbar-text-appearance'),
			'items' => array('H2', 'H3', 'Bold', 'Italic', 'Underline', 'StrikeThrough', 'Normal', 'Pre', 'Outdent', 'Indent')
		),
		array(
			'name'  => wfMsg('wysiwyg-toolbar-lists-and-links'),
			'items' => array('UnorderedList', 'OrderedList', 'Link', 'Unlink')
		),
		array(
			'name'  => wfMsg('wysiwyg-toolbar-insert'),
			'items' => array('AddImage', 'AddVideo', 'Table', 'Tildes')
		),
		array(
			'name'  => wfMsg('wysiwyg-toolbar-wiki-templates'),
			'items' => array('InsertTemplate')
		),
		array(
			'name'  => wfMsg('wysiwyg-toolbar-controls'),
			'items' => array('Undo', 'Redo', 'Widescreen', 'Source')
		),
	);

	// generate buckets and items data
	$toolbar = array(
		'buckets' => array(),
		'items' => array()
	);

	foreach($toolbarData as $bucket) {
		$toolbar['buckets'][] = $bucket['name'];

		$toolbar['items'][] = '-';
		$toolbar['items'] = array_merge($toolbar['items'], $bucket['items']);
	}

	return $toolbar;
}

/**
 * Bogus function for setHook
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function WysiwygParserHookCallback($input, $args, $parser) {
	return $input;
}

/**
 * Decide whether we should show first time edit popup
 */
function WysiwygFirstEditMessageShow() {
	global $wgUser, $wgCityId;

	//return true; // debug only!

	// for anon users we have JS logic
	if ($wgUser->isAnon()) {
		return true;
	}

	// for logged-in get preferences entry
	$messageDismissed = $wgUser->getOption('wysiwyg-cities-edits', false);
	return empty($messageDismissed);
}

/**
 * Store list of cities id where we shouldn't show first time edit popup anymore
 */
$wgAjaxExportList[] = 'WysiwygFirstEditMessageSave';
function WysiwygFirstEditMessageSave() {
	global $wgUser, $wgCityId;

	// ignore if user is anon
	if ($wgUser->isAnon()) {
		return;
	}

	// store new value in user settings
	$wgUser->setOption('wysiwyg-cities-edits', '1');
	$wgUser->saveSettings();

	// commit
	$dbw = wfGetDB( DB_MASTER );
	$dbw->commit();

	return new AjaxResponse('ok');
}

/**
 * Show first edit message
 *
 * @author Maciej Brencz <macbre at wikia-inc.com>
 * @todo add logic deciding when to show this message
 */
function WysiwygFirstEditMessage() {
	global $wgOut;

	if ( WysiwygFirstEditMessageShow() ) {
		// HTML for popup body
		$body = wfMsgExt('wysiwyg-first-edit-message', 'parse') .
			'<div style="margin: 8px 0"><input type="checkbox" id="wysiwyg-first-edit-dont-show-me" />'.
			'<label for="wysiwyg-first-edit-dont-show-me">' . wfMsg('wysiwyg-first-edit-dont-show-me') . '</label></div>';

		// properly encode values for JS
		$title = Xml::encodeJsVar( wfMsg('wysiwyg-first-edit-title') );
		$body = Xml::encodeJsVar($body);
		$dismiss = Xml::encodeJsVar( wfMsg('wysiwyg-first-edit-dismiss') );

		$wgOut->addInlineScript('addOnloadHook(function() { wysiwygShowFirstEditMessage(' . $title . ', ' . $body . ', ' . $dismiss  . '); });');
	}

	return;
}

/**
 * Add tooltip on first usage of new toolbar
 *
 * @author Maciej Brencz <macbre at wikia-inc.com>
 */
function WysiwygToolbarAddTooltip() {

	// logic to check whether we should show tooltip
	global $wgUser;

	if ($wgUser->isAnon()) {
		// don't show for anon user
		$closed = true;
	}
	else {
		$closed = $wgUser->getOption('wysiwyg-toolbar-closed', 0) ? true : false;
	}

	return ($closed ? false : wfMsgExt('wysiwyg-tooltip' , 'parse').'<span id="wysiwygToolbarTooltipClose">&nbsp;</span>');
}

/**
 * Permanently remove tooltip
 *
 * @author Maciej Brencz <macbre at wikia-inc.com>
 */
function WysiwygToolbarRemoveTooltip() {

	// store in user settings
	global $wgUser;

	if ($wgUser->isAnon()) {
		return;
	}

	$wgUser->setOption('wysiwyg-toolbar-closed', 1);
	$wgUser->saveSettings();

	// commit
	$dbw = wfGetDB( DB_MASTER );
	$dbw->commit();

	// may fix RT #17951
	$wgUser->invalidateCache();

	return new AjaxResponse('ok');
}

/**
 * Modify links HTML using hook called inside Linker::link()
 *
 * @author Maciej Brencz <macbre at wikia-inc.com>
 */
function Wysiwyg_LinkEnd( $linker, $target, $options, $text, $attribs, $ret) {

	// don't do anything when not in wysiwyg mode
	global $wgWysiwygParserEnabled;
	if (empty($wgWysiwygParserEnabled)) {
		return true;
	}

	// interwiki links
	if ($target->isExternal()) {
		$attribs['refid'] = Wysiwyg_GetRefId($text, true);
	}
	return true;
}

/**
 * Block save / preview / show changes buttons until wysiwyg is fully loaded
 *
 * @author Maciej Brencz <macbre at wikia-inc.com>
 */
function Wysiwyg_BlockSaveButton($editPage, &$checkboxes) {

	// add disabled='disabled' attribute
	$buttons = array('save', 'preview', 'diff');
	foreach($buttons as $button) {
		$checkboxes[$button] = substr($checkboxes[$button], 0, -3) . ' disabled="disabled" />';
	}

	return true;
}

/**
 * Parse given wikitext to HTML
 *
 * Workaround for disabled MW API on staff and contractor
 *
 * @author Maciej Brencz <macbre at wikia-inc.com>
 */
$wgAjaxExportList[] = 'WysiwygParseWikitext';
function WysiwygParseWikitext($wikitext) {
	global $IP, $wgRequest, $wgTitle, $wgWysiwygParserEnabled;

	// enable wysiwyg parser when requested
	if ($wgRequest->getVal('wysiwyg')) {
		require_once("$IP/extensions/wikia/Wysiwyg/WysiwygParser.php");
		$wgWysiwygParserEnabled = true;
		$parser = new WysiwygParser();
	}
	else {
		$parser = new Parser();
	}

	$options = new ParserOptions();

	$html = $parser->parse($wikitext, $wgTitle, $options)->getText();

	$wgWysiwygParserEnabled = false;

	return new AjaxResponse($html);
}

/**
 * Return messages for FCK
 *
 * FCK stores its messages in static files. Using AJAX request we can make FCK MW-i18n compatible.
 *
 * @author Maciej Brencz <macbre at wikia-inc.com>
 */
$wgAjaxExportList[] = 'WysiwygGetFCKi18n';
function WysiwygGetFCKi18n() {
	global $wgExtensionMessagesFiles, $wgLang;

	// load messages (they all have Wysiwyg prefix)
	wfLoadExtensionMessages('FCK');

	// load messages file to get list of messages we should return
	$messages = array();
	require( $wgExtensionMessagesFiles['FCK'] );

	$list = array_keys($messages['en']);

	$messages = array();
	$messages['Dir'] = ($wgLang->isRTL() ? 'rtl' : 'ltr');

	foreach($list as $msg) {
		$key = substr($msg, 7);
		$messages[$key] = wfMsg($msg);
	}

	$js = 'var FCKLang = ' . Wikia::json_encode($messages) . ';';

	$ret = new AjaxResponse($js);
	$ret->setContentType('application/x-javascript');
	$ret->setCacheDuration(86400 * 365 * 10); // 10 years

	return $ret;
}
