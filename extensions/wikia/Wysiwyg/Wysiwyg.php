<?php
$wgExtensionCredits['other'][] = array(
	'name' => 'Wikia Rich Text Editor (Wysiwyg)',
	'description' => 'FCKeditor integration for MediaWiki',
	'url' => 'http://www.wikia.com/wiki/c:help:Help:New_editor',
	'version' => 0.13,
	'author' => array('Inez Korczyński', 'Maciej Brencz', 'Maciej Błaszkowski (Marooned)', 'Łukasz \'TOR\' Garczewski')
);

$dir = dirname(__FILE__).'/';
$wgExtensionMessagesFiles['Wysiwyg'] = $dir.'Wysiwyg.i18n.php';
$wgAjaxExportList[] = 'Wysywig_Ajax';
$wgAjaxExportList[] = 'WysiwygToolbarRemoveTooltip';
$wgEnableMWSuggest = true;

$wgHooks['AlternateEdit'][] = 'Wysiwyg_AlternateEdit';
$wgHooks['EditPage::showEditForm:initial'][] = 'Wysiwyg_Initial';
$wgHooks['UserToggles'][] = 'Wysiwyg_Toggle';
$wgHooks['UserGetOption'][] = 'Wysiwyg_UserGetOption';
$wgHooks['getEditingPreferencesTab'][] = 'Wysiwyg_UserPreferences';
$wgHooks['MagicWordwgVariableIDs'][] = 'Wysiwyg_RegisterMagicWordID';
$wgHooks['LanguageGetMagic'][] = 'Wysiwyg_GetMagicWord';
$wgHooks['InternalParseBeforeLinks'][] = 'Wysiwyg_RemoveMagicWord';
$wgHooks['LinkEnd'][] = 'Wysiwyg_LinkEnd';

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

// add "Disable Wysiwyg" as the first option in editing tab of user preferences
function Wysiwyg_UserPreferences($preferencesForm, $toggles) {
	array_unshift($toggles, 'disablewysiwyg');

	// add JS to hide certain switches when wysiwyg is enabled
	global $wgOut, $wgJsMimeType, $wgExtensionsPath, $wgStyleVersion;
	$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"$wgExtensionsPath/wikia/Wysiwyg/wysiwyg_preferences.js?$wgStyleVersion\"></script>" );

	return true;
}

// add user toggles
function Wysiwyg_Toggle($toggles) {
	$toggles[] = 'disablewysiwyg';
	return true;
}

// modify values returned by User::getOption() when wysiwyg is enabled
function Wysiwyg_UserGetOption($options, $name, $value) {

	wfProfileIn(__METHOD__);

	// don't continue if user turns off wysiwyg (disablewysiwyg = true)
	if (!empty($options['disablewysiwyg'])) {
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
		$edgeCasesText = Wysiwyg_CheckEdgeCases($input);
		if ($edgeCasesText != '') {
			header('X-edgecases: 1');
			return $edgeCasesText;
		} else {
			$separator = Parser::getRandomString();
			header('X-sep: ' . $separator);
			return new AjaxResponse(join(Wysiwyg_WikiTextToHtml($input, $pageName, true), "--{$separator}--"));
		}

	}
	return false;
}

function Wysiwyg_Initial($form) {
	global $wgUser, $wgOut, $wgRequest, $IP, $wgExtensionsPath, $wgStyleVersion, $wgHooks, $wgWysiwygEdgeCasesFound, $wgWysiwygFallbackToSourceMode, $wgJsMimeType, $wgWysiwygEdit, $wgWysiwygUseNewToolbar;

	wfProfileIn(__METHOD__);

	// check user preferences option
	if($wgUser->getOption('disablewysiwyg') == true) {
		wfProfileOut(__METHOD__);
		return true;
	}

	// do not initialize for articles in namespaces different then main, image or user
	if(!in_array($form->mTitle->mNamespace, array(NS_MAIN, NS_IMAGE, NS_USER, NS_CATEGORY, NS_VIDEO))) {
		wfProfileOut(__METHOD__);
		return true;
	}

	// RT #10170: do not initialize for user JS/CSS subpages
	if ($form->mTitle->isCssJsSubpage()) {
		wfProfileOut(__METHOD__);
		return true;
	}

	// macbre: enable only on monaco skin
	if(get_class($wgUser->getSkin()) != 'SkinMonaco') {
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

	// detect edgecases
	$wgWysiwygEdgeCasesFound = (Wysiwyg_CheckEdgeCases($form->textbox1) != '');

	// initialize FCK in source mode for articles in which edge case occured / user adds fckmode=source to edit page URL / user requested diff/preview when in source mode
	$wgWysiwygFallbackToSourceMode = $wgWysiwygEdgeCasesFound ||
		($wgRequest->getVal('fckmode', 'wysiwyg') == 'source') ||
		($wgRequest->getVal('action') == 'submit' && $wgRequest->getVal('wysiwygTemporarySaveType') == '1');


	$magicWords = MagicWord::$mVariableIDs;
	sort($magicWords);

	// JS
	$wgOut->addInlineScript(
		'var fallbackToSourceMode = ' . ($wgWysiwygFallbackToSourceMode ? 'true' : 'false') . ";\n" .
		'var templateList = ' . WysiwygGetTemplateList() . ";\n" .
		'var templateHotList = ' . WysiwygGetTemplateHotList() . ";\n" .
		'var magicWordList = ' . Wikia::json_encode($magicWords, true) . ";"
	);

	// CSS
 	$wgOut->addLink(array(
		'rel' => 'stylesheet',
		'href' => "$wgExtensionsPath/wikia/Wysiwyg/wysiwyg.css?$wgStyleVersion",
		'type' => 'text/css'
	));

	// add support for new toolbar
	if (!empty($wgWysiwygUseNewToolbar)) {
		// toolbar data
		// TODO: get it from MW article
		// TODO: i18n
		$toolbarData = array(
			array(
				'name'  => 'Text Appearance',
				'items' => array('H2', 'H3', 'Bold', 'Italic', 'Underline', 'StrikeThrough', 'Normal', 'Pre', 'Outdent', 'Indent')
			),
			array(
				'name'  => 'Lists and Links',
				'items' => array('UnorderedList', 'OrderedList', 'Link', 'Unlink')
			),
			array(
				'name'  => 'Insert',
				'items' => array('AddImage', 'AddVideo', 'Table', 'Tildes')
			),
			array(
				'name'  => 'Wiki Templates',
				'items' => array('InsertTemplate')
			),
			array(
				'name'  => 'Controls',
				'items' => array('Undo', 'Redo', 'Widescreen', 'Source')
			),
		);

		// generate buckets and items data
		$toolbarBuckets = array();
		$toolbarItems = array();

		foreach($toolbarData as $bucket) {
			$toolbarBuckets[] = $bucket['name'];

			$toolbarItems[] = '-';
			$toolbarItems = array_merge($toolbarItems, $bucket['items']);
		}

		// tooltip
		$toolbarTooltip = WysiwygToolbarAddTooltip();

		$wgOut->addInlineScript(
			"var wysiwygUseNewToolbar = true;\n" .
			"var wysiwygToolbarBuckets = " . Wikia::json_encode($toolbarBuckets) . ";\n" .
			"var wysiwygToolbarItems = " . Wikia::json_encode($toolbarItems) . ";" .
			( !empty($toolbarTooltip) ? "\nvar wysiwygToolbarTooltip = " . Xml::encodeJsVar($toolbarTooltip) . ";" : '')
		);
	}

	$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"$wgExtensionsPath/wikia/Wysiwyg/fckeditor/fckeditor.js?$wgStyleVersion\"></script>" );
	$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"$wgExtensionsPath/wikia/Wysiwyg/wysiwyg.js?$wgStyleVersion\"></script>" );

	$wgHooks['EditPage::showEditForm:initial2'][] = 'Wysiwyg_Initial2';
	$wgHooks['EditForm:BeforeDisplayingTextbox'][] = 'Wysiwyg_BeforeDisplayingTextbox';
	$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'Wysiwyg_SetDomain';
	$wgHooks['EditPageBeforeEditButtons'][] = 'Wysiwyg_BlockSaveButton';

	wfProfileOut(__METHOD__);
	return true;
}

function Wysiwyg_Initial2($form) {
	global $wgWysiwygData, $wgWysiwygFallbackToSourceMode;

	if (empty($wgWysiwygFallbackToSourceMode)) {
		list($form->textbox1, $wgWysiwygData) = Wysiwyg_WikiTextToHtml($form->textbox1, false, true);
	}
	else {
		$wgWysiwygData = '';
	}

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
			'<!--' => 'wysiwyg-edgecase-comment', // HTML comments
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

	// macbre: existance of __NOWYSIWYG__
	wfDebug("Wysiwyg: checking for __NOWYSIWYG__\n");

	$mw = MagicWord::get('MAG_NOWYSIWYG');
	if ($mw->match($text)) {
		$matches = array();
		$countNoWysiwygAll = preg_match_all($mw->getRegex(), $text, $matches);
		$countNoWysiwygInNoWiki = preg_match_all('/\<nowiki\>__NOWYSIWYG__\<\/nowiki\>/si', $text, $matches);

		wfDebug("Wysiwyg: __NOWYSIWYG__ (count: {$countNoWysiwygAll} / in <nowiki>: {$countNoWysiwygInNoWiki})\n");

		if ($countNoWysiwygAll > $countNoWysiwygInNoWiki) {
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

function Wysiwyg_WikiTextToHtml($wikitext, $pageName = false, $encode = false) {
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
		$templateParser->setOutputType(OT_HTML);
		$templateCallsParsed = explode("\x7f-sep-\x7f", $templateParser->parse(implode("\x7f-sep-\x7f", $templateCallsToParse), $title, $options, false)->getText());

		$templateCallsParsed =  array_combine($matches[1], $templateCallsParsed);

		// save name of HTML tag wrapping template output
		foreach($templateCallsParsed as $refid => $parsed) {
			$parsed = trim($parsed);

			if (strlen($parsed) > 0 && $parsed{0} != '<') {
				$wrapper = false;
			}
			else {
				// HTML cleanup
				if ( substr($parsed, 0, 4) == '</p>' ) {
					$parsed = trim( substr($parsed, 4) );
				}

				if ( substr($parsed, -3) == '<p>' ) {
					$parsed = trim( substr($parsed, 0, -3) );
				}

				// get first HTML tag
				$wrapper = substr($parsed, 1, strpos($parsed, '>') - 1);

				// try to get only the name (get rid of attributes)
				if (strpos($wrapper, ' ') !== false) {
					$wrapper = substr($wrapper, 0, strpos($wrapper, ' '));
				}

				// save cleaned HTML for preview in wysiwyg mode
				$templateCallsParsed[$refid] = $parsed;
			}
			$wgWysiwygMetaData[$refid]['wrapper'] = $wrapper;
		}

		$html = preg_replace('/\x7f-wtb-(\d+)-\x7f.*?\x7f-wte-\1-\x7f/sie', "'<input type=\"button\" refid=\"\\1\" _fck_type=\"template\" value=\"'.\$wgWysiwygMetaData[\\1]['name'].'\" class=\"wysiwygDisabled wysiwygTemplate\" /><input value=\"'.htmlspecialchars(stripslashes(\$templateCallsParsed[\\1])).'\" style=\"display:none\" />'", $html);
	}

	// fix for multiline pre
	$html = preg_replace('#<pre>.*?</pre>#sie', 'str_replace("\\n", "<!--EOLPRE-->\\n", "\0")', $html);

	// fix for IE
	$html = str_replace("\n", "<!--EOL1-->\n", $html);

	$html = preg_replace_callback("/<li>(\s*)/", create_function('$matches','return "<li space_after=\"".$matches[1]."\">";'), $html);
	$html = preg_replace_callback("/<h([1-6][^>]*)>(\s*)/", create_function('$matches','return "<h".$matches[1]." space_after=\"".$matches[2]."\">";'), $html);

	// replace placeholders with <input> grey boxes
	if (!empty($wgWysiwygMarkers)) {
		$html = strtr($html, $wgWysiwygMarkers);
	}

	wfDebug("Wysiwyg_WikiTextToHtml html: {$html}\n");

	return array($html, $encode ? Wikia::json_encode($wgWysiwygMetaData, true) : $wgWysiwygMetaData);
}

function Wysiwyg_HtmlToWikiText($html, $wysiwygData, $decode = false) {

	// fix for IE
	$html = str_replace("<!--EOL1-->\n", "", $html);
	$html = str_replace("<!--EOL1--> ", " ", $html);
	$html = str_replace("<!--EOL1-->", " ", $html);

	// fix for multiline pre
	$html = str_replace("<!--EOLPRE-->", "\n", $html);

	$html = preg_replace_callback("/<li space_after=\"(\s*)\">/", create_function('$matches','return "<li>".$matches[1];'), $html);

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
			'%<ext><name>([^>]+)</name><attr></attr><inner>([^>]+)</inner><close>[^>]+</close></ext>%si'),
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
			}
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
	}

	if($addMarker) {
		$params['text'] .= "\x1$refId\x1";
	}
	if($result != '') {
		$result = str_replace(' wasHtml="1"', '', $result);
		if (isset($data['description'])) {
			$data['description'] =  str_replace(' wasHtml="1"', '', $data['description']);
		}
		$result = htmlspecialchars($result);

		$result = "<input type=\"button\" refid=\"{$refId}\" _fck_type=\"{$type}\" value=\"{$result}\" title=\"{$result}\" class=\"{$className}\" />";

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

	echo $html;
	exit();
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
	echo  Wikia::json_encode(!empty($params) ? $params : null, true);
	exit();
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

	// for anon users we have JS logic
	if ($wgUser->isAnon()) {
		return true;
	}

	// for logged in users get comma separated list of city ids
	$cities = explode(',', $wgUser->getOption('wysiwyg-cities-edits', ''));

	wfDebug('wysiwyg-cities-edits: ' . print_r($cities, true) . "\n");

	// check for current city id
	return !in_array($wgCityId, $cities);
}

/**
 * Store list of cities id where we shouldn't show first time edit popup anymore
 */
function WysiwygFirstEditMessageSave() {
	global $wgUser, $wgCityId;

	// ignore if user is anon
	if ($wgUser->isAnon()) {
		return;
	}

	// get comma separated list of city ids
	$cities = explode(',', $wgUser->getOption('wysiwyg-cities-edits', ''));

	// add current city id
	if (!in_array($wgCityId, $cities)) {
		$cities[] = $wgCityId;

		// store up to 50 city ids
		$cities = array_slice($cities, -50);
	}

	$value = trim(implode(',', $cities), ',');

	wfDebug("wysiwyg-cities-edits: {$value}\n");

	// store new value in user settings
	$wgUser->setOption('wysiwyg-cities-edits', $value);
	$wgUser->saveSettings();

	// commit
	$dbw = wfGetDB( DB_MASTER );
	$dbw->commit();

	return new AjaxResponse('ok');
}
$wgAjaxExportList[] = 'WysiwygFirstEditMessageSave';

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
		$body = wfMsgExt('wysiwyg-first-edit-message', 'parse') . '<input type="checkbox" id="wysiwyg-first-edit-dont-show-me" />'.
			'<label for="wysiwyg-first-edit-dont-show-me">' . wfMsg('wysiwyg-first-edit-dont-show-me') . '</label>';

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

	return $html;
}
