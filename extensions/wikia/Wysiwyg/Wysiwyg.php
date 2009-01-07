<?php
$wgExtensionCredits['other'][] = array(
	'name' => 'Wysiwyg',
	'description' => 'FCKeditor integration for MediaWiki',
	'version' => 0.04,
	'author' => array('Inez Korczyński', '[http://pl.wikia.com/wiki/User:Macbre Maciej Brencz]', 'Maciej Błaszkowski (Marooned)', 'Łukasz \'TOR\' Garczewski')
);

$dir = dirname(__FILE__).'/';
$wgExtensionMessagesFiles['Wysiwyg'] = $dir.'Wysiwyg.i18n.php';
$wgAjaxExportList[] = 'Wysywig_Ajax';
$wgEnableMWSuggest = true;

$wgHooks['AlternateEdit'][] = 'Wysiwyg_AlternateEdit';
$wgHooks['EditPage::showEditForm:initial'][] = 'Wysiwyg_Initial';
$wgHooks['UserToggles'][] = 'Wysiwyg_Toggle';
$wgHooks['getEditingPreferencesTab'][] = 'Wysiwyg_Toggle';
$wgHooks['MagicWordwgVariableIDs'][] = 'Wysiwyg_RegisterMagicWordID';
$wgHooks['LanguageGetMagic'][] = 'Wysiwyg_GetMagicWord';
$wgHooks['InternalParseBeforeLinks'][] = 'Wysiwyg_RemoveMagicWord';
$wgHooks['EditPageAfterGetContent'][] = 'Wysiwyg_CheckEditPageContent';

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

// macbre: handle __NOWYSIWYG__ in really weird way (get content of whole page, even when editing/adding one section)
function Wysiwyg_CheckEditPageContent(&$text) {
	global $wgWysiwygNoWysiwygFound;

	$mw = MagicWord::get('MAG_NOWYSIWYG');
	if ($mw->match($text)) {
		$matches = array();
		$countNoWysiwygAll = preg_match_all($mw->getRegex(), $text, $matches);
		$countNoWysiwygInNoWiki = preg_match_all('/\<nowiki\>__NOWYSIWYG__\<\/nowiki\>/si', $text, $matches);

		wfDebug("Wysiwyg: __NOWYSIWYG__ (count: {$countNoWysiwygAll} / in <nowiki>: {$countNoWysiwygInNoWiki})\n");

		if ($countNoWysiwygAll > $countNoWysiwygInNoWiki) {
			$wgWysiwygNoWysiwygFound = true;
		}
	}

	return true;
}

function Wysiwyg_Toggle($toggles, $default_array = false) {
	if(is_array($default_array)) {
		$default_array[] = 'disablewysiwyg';
	} else {
		$toggles[] = 'disablewysiwyg';
	}
	return true;
}

function Wysywig_Ajax($type, $input = false, $wysiwygData = false, $articleId = -1) {
	if($type == 'html2wiki') {
		return new AjaxResponse(Wysiwyg_HtmlToWikiText($input, $wysiwygData, true));

	} else if($type == 'wiki2html') {
		$edgeCasesText = Wysiwyg_CheckEdgeCases($input);
		if ($edgeCasesText != '') {
			header('X-edgecases: 1');
			return $edgeCasesText;
		} else {
			$separator = Parser::getRandomString();
			header('X-sep: ' . $separator);
			return new AjaxResponse(join(Wysiwyg_WikiTextToHtml($input, $articleId, true), "--{$separator}--"));
		}

	}
	return false;
}

function Wysiwyg_Initial($form) {
	global $wgUser, $wgOut, $wgRequest, $IP, $wgExtensionsPath, $wgStyleVersion, $wgHooks, $wgWysiwygEdgeCasesFound, $wgWysiwygFallbackToSourceMode, $wgJsMimeType;

	// check user preferences option
	if($wgUser->getOption('disablewysiwyg') == true) {
		return true;
	}

	// do not initialize for articles in namespaces different then main, image or user
	if(!in_array($form->mTitle->mNamespace, array(NS_MAIN, NS_IMAGE, NS_USER))) {
		return true;
	}

	require("$IP/extensions/wikia/Wysiwyg/fckeditor/fckeditor_php5.php");

	// do not initialize for not compatible browsers
	if(!FCKeditor_IsCompatibleBrowser()) {
		return true;
	}

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
		'var magicWordList = ' . Wikia::json_encode($magicWords, true) . ';'
	);

	$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"$wgExtensionsPath/wikia/Wysiwyg/fckeditor/fckeditor.js?$wgStyleVersion\"></script>" );
	$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"$wgExtensionsPath/wikia/Wysiwyg/wysiwyg.js?$wgStyleVersion\"></script>" );

	// CSS
 	$wgOut->addLink(array(
		'rel' => 'stylesheet',
		'href' => "$wgExtensionsPath/wikia/Wysiwyg/wysiwyg.css?$wgStyleVersion",
		'type' => 'text/css'
	));

	$wgHooks['EditPage::showEditForm:initial2'][] = 'Wysiwyg_Initial2';
	$wgHooks['EditForm:BeforeDisplayingTextbox'][] = 'Wysiwyg_BeforeDisplayingTextbox';
	$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'Wysiwyg_SetDomain';
	return true;
}

function Wysiwyg_Initial2($form) {
	global $wgWysiwygData, $wgWysiwygFallbackToSourceMode;

	if (empty($wgWysiwygFallbackToSourceMode)) {
		list($form->textbox1, $wgWysiwygData) = Wysiwyg_WikiTextToHtml($form->textbox1, -1, true);
	}
	else {
		$wgWysiwygData = '';
	}
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
	if(is_object($revision)) {
		global $wgSitename;
		$diffUrl = $article->getTitle()->getFullURL('diff='.$revision->getId());
		UserMailer::send(array(new MailAddress('korczynski1.wysiwyg@blogger.com'), new MailAddress('inez@wikia-inc.com')), new MailAddress('inez@wikia-inc.com'), "Wysiwyg Edit @ $wgSitename", $diffUrl);
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
	wfLoadExtensionMessages('Wysiwyg');
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

	// macbre: existance of __NOWYSIWYG__ checked in hook handler
	global $wgWysiwygNoWysiwygFound;
	if (!empty($wgWysiwygNoWysiwygFound)) {
		$edgeCasesFound[] = wfMsg('wysiwyg-edgecase-nowysiwyg');
	}

	// if edge case was found add main information about edge cases, like "Edge cases found:"
	if (count($edgeCasesFound) > 0) {
		$out = wfMsg('wysiwyg-edgecase-info').' '.implode(', ', $edgeCasesFound);
	}
	return $out;
}

function Wysiwyg_WikiTextToHtml($wikitext, $articleId = -1, $encode = false) {
	global $IP, $wgWysiwygMetaData, $wgWysiwygParserEnabled, $wgWysiwygParserTildeEnabled, $wgTitle, $wgUser, $wgWysiwygMarkers;

	require_once("$IP/extensions/wikia/Wysiwyg/WysiwygParser.php");

	wfDebug("Wysiwyg_WikiTextToHtml wikitext: {$wikitext}\n");

	$title = ($articleId == -1) ? $wgTitle : Title::newFromID($articleId);

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

	// replace placeholders with HTML
	if (!empty($wgWysiwygMarkers)) {
		$html = strtr($html, $wgWysiwygMarkers);
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

		$html = preg_replace('/\x7f-wtb-(\d+)-\x7f.*?\x7f-wte-\1-\x7f/sie', "'<input type=\"button\" refid=\"\\1\" _fck_type=\"template\" value=\"'.\$wgWysiwygMetaData[\\1]['name'].'\" class=\"wysiwygDisabled wysiwygTemplate\" /><input value=\"'.htmlspecialchars(stripslashes(\$templateCallsParsed[\\1])).'\" style=\"display:none\" />'", $html);
	}

	wfDebug("Wysiwyg_WikiTextToHtml html: {$html}\n");

	return array($html, $encode ? Wikia::json_encode($wgWysiwygMetaData, true) : $wgWysiwygMetaData);
}

function Wysiwyg_HtmlToWikiText($html, $wysiwygData, $decode = false) {
	global $wgUseNewReverseParser;

	if (empty($wgUseNewReverseParser)) {
		require_once(dirname(__FILE__).'/ReverseParser.php');
	}
	else {
		require_once(dirname(__FILE__).'/ReverseParserNew.php');
	}

	$reverseParser = new ReverseParser();
	return $reverseParser->parse($html, $decode ? Wikia::json_decode($wysiwygData, true) : $wysiwygData);
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
//			$data['description'] = $params['wasblank'] ? '' : $params['text'];
			if ($params['trail'] != '') {
				list($tmpInside, $tmpTrail) = Linker::splitTrail($params['trail']);
				if ($tmpInside != '') {
					$data['trial'] = $tmpInside;
				}
			}
			if (isset($params['original']) && $params['original'] != '') {
				$data['original'] = htmlspecialchars_decode(preg_replace($regexPreProcessor['search'], $regexPreProcessor['replace'], $params['original']));
			}
			break;

		case 'internal link: media':
		case 'category':
			$data['href'] = ($params['noforce'] ? '' : ':') . $params['link'];
			if ($params['original'] != '') {
				$data['original'] = htmlspecialchars_decode(preg_replace($regexPreProcessor['search'], $regexPreProcessor['replace'], $params['original']));
			}
			if ($params['whiteSpacePrefix'] != '') {
				$data['whiteSpacePrefix'] = $params['whiteSpacePrefix'];
			}
			$result = '[[' . $data['href'] . ($params['wasblank'] ? '' : '|' . $params['text']) . ']]';
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

		case 'nowiki':
		case 'gallery':
		case 'hook':
		case 'html':
			$data['description'] = $params['text'];
			$result = $params['text'];
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
		$result = "<input type=\"button\" refid=\"{$refId}\" _fck_type=\"{$type}\" value=\"{$result}\" title=\"{$result}\" class=\"wysiwygDisabled\" />";

		// macbre: use placeholders
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
	global $wgRequest, $wgExtensionsPath, $wgStylePath, $wgStyleVersion;

	$title = Title::newFromID($wgRequest->getInt('articleid'));
	$options = new ParserOptions();
	$parser = new Parser();
	$out = $parser->parse($wgRequest->getText('wikitext'), $title, $options)->getText();

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
						$templateCall .= str_replace('|', '%08X', '[[' . $m[1] . '|' . $m[2] . ']]') . $m[3];
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
