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
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'Wysiwyg_SetDomain';
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

	// detec edgecases
	$wgWysiwygEdgeCasesFound = (Wysiwyg_CheckEdgeCases($form->textbox1) != '');

	// initialize FCK in source mode for articles in which edge case occured / user adds fckmode=source to edit page URL / user requested diff/preview when in source mode
	$wgWysiwygFallbackToSourceMode = $wgWysiwygEdgeCasesFound ||
		($wgRequest->getVal('fckmode', 'wysiwyg') == 'source') ||
		($wgRequest->getVal('action') == 'submit' && $wgRequest->getVal('wysiwygTemporarySaveType') == '1');

	// JS
	$wgOut->addInlineScript('var fallbackToSourceMode = '.($wgWysiwygFallbackToSourceMode ? 'true' : 'false'));


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
	global $wgRequest;
	if(isset($wgRequest->data['wpTextbox1'])) {
		if(isset($wgRequest->data['wysiwygData'])) {
			if($wgRequest->data['wysiwygData'] != '') {
				$wgRequest->data['wpTextbox1'] = Wysiwyg_HtmlToWikiText($wgRequest->data['wpTextbox1'], $wgRequest->data['wysiwygData'], true);
			}
		}
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
			//'__NOWYSIWYG__' => 'wysiwyg-edgecase-nowysiwyg', // new magic word to disable FCK for current article
		),
		'regexp' => array(
//			'/\[\[[^|]+\|.*?(?:(?:' . wfUrlProtocols() . ')|{{).*?]]/' => 'wysiwyg-edgecase-complex-description', // external url or template found in the description of a link
			//'/{{[^}]*(?<=\[)[^}]*}}/' => 'wysiwyg-edgecase-template-with-link', // template with link as a parameter
//			'/\[\[(?:image|media)[^]|]+\|[^]]+(?:\[\[|(?:' . wfUrlProtocols() . '))(?:[^]]+])?[^]]+]]/si' => 'wysiwyg-edgecase-image-with-link', // template with link as a parameter
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

	$options = new ParserOptions();
	$wysiwygParser = new WysiwygParser();
	$wysiwygParser->setOutputType(OT_HTML);

	$wgWysiwygParserTildeEnabled = true;
	$wikitext = $wysiwygParser->preSaveTransform($wikitext, $title, $wgUser, $options);
	$wgWysiwygParserTildeEnabled = false;

	$wgWysiwygParserEnabled = true;
	$html = $wysiwygParser->parse($wikitext, $title, $options)->getText();
	$wgWysiwygParserEnabled = false;

	// replace placeholders with HTML
	if (!empty($wgWysiwygMarkers)) {
		$html = strtr($html, $wgWysiwygMarkers);
	}

	// replace whitespaces after opening (<li>) and before closing tags (</p>, </h2>, </li>, </dt>, </dd>)
	$replacements = array(
		"\n</p>"  => '</p>',
		' </h'    => '</h',
		'<li> '   => '<li>',
		"\n</li>" => '</li>',
		"\n</dt>" => '</dt>',
		"\n</dd>" => '</dd>',
		"</dl>\n" => '</dl>',
		"</ol>\n" => '</ol>',
		"</ul>\n" => '</ul>',
		"\n</td>" => '</td>',
		"\n<input" => '<input',
	);
	$html = strtr($html, $replacements);

	// replace placeholders with HTML
	if (!empty($wgWysiwygMarkers)) {
		$html = strtr($html, $wgWysiwygMarkers);
	}

	// extract refid's of templates from template markers
	// preg_match_all('/\x7f-wtb-(\d+)-\x7f.*?\x7f-wte-\1-\x7f/si', $html, $matches);
	preg_match_all('/\x7f-wtb-(\d+)-\x7f/', $html, $matches);

	if(count($matches[1]) > 0) {
		$templateCallsToParse = array();
		foreach($matches[1] as $val) {
			$templateCallsToParse[] = $wgWysiwygMetaData[$val]['originalCall'];
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
	require_once(dirname(__FILE__).'/ReverseParser.php');
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

	$wgWysiwygMetaData[$refId] = $data;

	return "\x7f-wtb-{$refId}-\x7f{$output}\x7f-wte-{$refId}-\x7f";
}

/**
 * Adding reference ID with metadata to global $wgWysiwygMetaData and surround passed element with extra code
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function Wysiwyg_SetRefId($type, $params, $addMarker = true, $returnId = false) {
	global $wgWysiwygMetaData, $wgWysiwygParser, $wgWysiwygMarkers;

	if(!empty($params['original'])) {
		$params['original'] = preg_replace('/\x7f-start-\d+-stop/', '', $params['original']);
	}

	$refId = count($wgWysiwygMetaData);
	$data = array('type' => $type);
	$result = '';

	$regexPreProcessor = array(
		'search' => array(
			'%<template><title>[^<]*</title><originalCall><!\[CDATA\[(.*?)]]></originalCall></template>%si',
			'%<ext><name>([^>]+)</name><attr></attr><inner>([^>]+)</inner><close>[^>]+</close></ext>%si'),
		'replace' => array(
			'\1',
			'<\1>\2</\1>')
	);

	switch ($type) {
		case 'external link':
			$data['href'] = $params['link'];
//			$data['description'] = $params['wasblank'] ? '' : $params['text'];
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
//			$data['description'] = preg_replace('%\x7f-wtb-(\d+)-\x7f.*?\x7f-wte-\1-\x7f%sie', '$wgWysiwygMetaData[\\1]["originalCall"];', $data['description']);
			if ($params['original'] != '') {
				$data['original'] = htmlspecialchars_decode(preg_replace($regexPreProcessor['search'], $regexPreProcessor['replace'], $params['original']));
			}
			break;

		case 'internal link: media':
		case 'category':
			$data['href'] = ($params['noforce'] ? '' : ':') . $params['link'];
//			$data['description'] = $params['wasblank'] ? '' : $params['text'];
			if ($params['original'] != '') {
				$data['original'] = htmlspecialchars_decode(preg_replace($regexPreProcessor['search'], $regexPreProcessor['replace'], $params['original']));
			}
			$result = '[[' . $data['href'] . ($params['wasblank'] ? '' : '|' . $params['text']) . ']]';
			break;

		case 'image':
			$data['href'] = ($params['noforce'] ? '' : ':') . $params['link'];
//			$data['description'] = $params['wasblank'] ? '' : $params['text'];
//			$data['description'] = preg_replace('%\x7f-wtb-(\d+)-\x7f.*?\x7f-wte-\1-\x7f%sie', '$wgWysiwygMetaData[\\1]["originalCall"];', $data['description']);
			if ($params['original'] != '') {
				$data['original'] = htmlspecialchars_decode(preg_replace($regexPreProcessor['search'], $regexPreProcessor['replace'], $params['original']));
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
