<?php
$wgExtensionCredits['other'][] = array(
	'name' => 'Wysiwyg',
	'description' => 'FCKeditor integration for MediaWiki',
	'version' => 0.02,
	'author' => array('Inez Korczyński', 'Maciej Brencz', 'Maciej Błaszkowski (Marooned)', 'Łukasz \'TOR\' Garczewski')
);

$dir = dirname(__FILE__).'/';
$wgExtensionMessagesFiles['Wysiwyg'] = $dir.'Wysiwyg.i18n.php';
$wgAjaxExportList[] = 'Wysywig_Ajax';

$wgHooks['AlternateEdit'][] = 'Wysiwyg_AlternateEdit';
$wgHooks['EditPage::showEditForm:initial'][] = 'Wysiwyg_Initial';
$wgHooks['UserToggles'][] = 'Wysiwyg_Toggle';
$wgHooks['getEditingPreferencesTab'][] = 'Wysiwyg_Toggle';
$wgHooks['MagicWordwgVariableIDs'][] = 'Wysiwyg_RegisterMagicWordID';
$wgHooks['LanguageGetMagic'][] = 'Wysiwyg_GetMagicWord';
$wgHooks['ParserAfterStrip'][] = 'Wysiwyg_AfterStrip';

function Wysiwyg_RegisterMagicWordID(&$magicWords) {
	$magicWords[] = 'MAG_NOWYSIWYG';
	return true;
}

function Wysiwyg_GetMagicWord(&$magicWords, $langCode) {
	$magicWords['MAG_NOWYSIWYG'] = array(0, '__NOWYSIWYG__');
	return true;
}

function Wysiwyg_AfterStrip(&$parser, &$text, &$strip_state) {
	MagicWord::get('MAG_NOWYSIWYG')->matchAndRemove($text);
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
	global $wgUser, $wgOut, $IP, $wgExtensionsPath, $wgStyleVersion, $wgHooks, $wgWysiwygEdgeCasesFound;

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

	// initialize FCK in source mode for articles in which edge case occured
	$wgWysiwygEdgeCasesFound = Wysiwyg_CheckEdgeCases($form->textbox1) != '' ? 1 : 0;

	//if ($edgeCasesFound) return true;

	$script = <<<EOT
<script type="text/javascript" src="$wgExtensionsPath/wikia/Wysiwyg/fckeditor/fckeditor.js?$wgStyleVersion"></script>
<script type="text/javascript">
//document.domain = 'wikia.com';
function FCKeditor_OnComplete(editorInstance) {
	editorInstance.LinkedField.form.onsubmit = function() {
		if(editorInstance.EditMode == FCK_EDITMODE_SOURCE) {
			YAHOO.util.Dom.get('wysiwygData').value = '';
		} else {
			YAHOO.util.Dom.get('wysiwygData').value = YAHOO.Tools.JSONEncode(editorInstance.wysiwygData);
		}
	}
}

function initEditor() {
	if($('wmuLink')) $('wmuLink').parentNode.style.display = 'none';
	var edgeCasesFound = $wgWysiwygEdgeCasesFound;
	var oFCKeditor = new FCKeditor("wpTextbox1");
	oFCKeditor.wgStyleVersion = wgStyleVersion;
	oFCKeditor.BasePath = "$wgExtensionsPath/wikia/Wysiwyg/fckeditor/";
	oFCKeditor.Config["CustomConfigurationsPath"] = "$wgExtensionsPath/wikia/Wysiwyg/wysiwyg_config.js";
	oFCKeditor.ready = true;
	oFCKeditor.Height = '450px';
	oFCKeditor.Width = document.all ? '99%' : '100%'; // IE fix
	oFCKeditor.ReplaceTextarea();

	if (edgeCasesFound) {
		// fallback to source mode
		var iFrame = document.getElementById('wpTextbox1___Frame');
		iFrame.style.visibility = 'hidden';

		var intervalId = setInterval(function() {
			// wait for FCKeditorAPI to be fully loaded
			if (typeof FCKeditorAPI != 'undefined') {
				var FCK = FCKeditorAPI.GetInstance('wpTextbox1');
				// wait for FCK to be fully loaded
				if (FCK.Status == FCK_STATUS_COMPLETE) {
					clearInterval(intervalId);
					FCK.originalSwitchEditMode.apply(FCK, []);
					FCK.WysiwygSwitchToolbars(true);
					FCK.SetData( document.getElementById('wpTextbox1').value );
					iFrame.style.visibility = 'visible';
				}
			}
		}, 250);
	}

	// macbre: tracking
	if (typeof YAHOO != 'undefined') {
		YAHOO.util.Event.addListener(['wpSave', 'wpPreview', 'wpDiff'], 'click', function(e) {
			var elem = YAHOO.util.Event.getTarget(e);

			var buttonId = elem.id.substring(2).toLowerCase();
			var editorSourceMode = window.FCKwpTextbox1.FCK.EditMode;

			YAHOO.Wikia.Tracker.trackByStr(e, 'wysiwyg/' + buttonId + '/' + (editorSourceMode ? 'wikitextmode' : 'visualmode'));
		});
		if (edgeCasesFound) {
			YAHOO.Wikia.Tracker.trackByStr(null, 'wysiwyg/edgecase');
		}
	}
}
addOnloadHook(initEditor);
</script>
<style type="text/css">/*<![CDATA[*/
.mw-editTools,
#editform #toolbar {
	position: relative;
	top: 25px;
	visibility: hidden;
}
#wpTextbox1 {
	visibility: hidden;
}
#editform {
	background: transparent url('$wgExtensionsPath/wikia/Wysiwyg/fckeditor/editor/skins/default/images/progress_transparent.gif') no-repeat 50% 35%;
}
/*]]>*/</style>
EOT;
	$wgOut->addScript($script);
	$wgHooks['EditPage::showEditForm:initial2'][] = 'Wysiwyg_Initial2';
	$wgHooks['EditForm:BeforeDisplayingTextbox'][] = 'Wysiwyg_BeforeDisplayingTextbox';
	return true;
}

function Wysiwyg_Initial2($form) {
	global $wgWysiwygData, $wgWysiwygEdgeCasesFound;

	if (empty($wgWysiwygEdgeCasesFound)) {
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
			'__NOWYSIWYG__' => 'wysiwyg-edgecase-nowysiwyg', // new magic word to disable FCK for current article
			'<span refid=' => 'wysiwyg-edgecase-syntax', // span with fck metadata - shouldn't be used by user
		),
		'regexp' => array(
			'/\[\[[^|]+\|.*?(?:(?:' . wfUrlProtocols() . ')|{{).*?]]/' => 'wysiwyg-edgecase-complex-description', // external url or template found in the description of a link
			'/{{[^}]*(?<=\[)[^}]*}}/' => 'wysiwyg-edgecase-template-with-link', // template with link as a parameter
			'/\[\[(?:image|media)[^]|]+\|[^]]+(?:\[\[|(?:' . wfUrlProtocols() . '))(?:[^]]+])?[^]]+]]/si' => 'wysiwyg-edgecase-image-with-link', // template with link as a parameter
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

	// if edge case was found add main information about edge cases, like "Edge cases found:"
	if (count($edgeCasesFound) > 0) {
		$out = wfMsg('wysiwyg-edgecase-info').' '.implode(', ', $edgeCasesFound);
	}
	return $out;
}

function Wysiwyg_WikiTextToHtml($wikitext, $articleId = -1, $encode = false) {
	global $IP, $wgWysiwygMetaData, $wgWysiwygParserEnabled, $wgWysiwygParserTildeEnabled, $wgTitle, $wgUser, $wgWysiwygMarkers;

	require("$IP/extensions/wikia/Wysiwyg/WysiwygParser.php");

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

	wfDebug("Wysiwyg_WikiTextToHtml html: {$html}\n");

	return array($html, $encode ? Wikia::json_encode($wgWysiwygMetaData, true) : $wgWysiwygMetaData);
}

function Wysiwyg_HtmlToWikiText($html, $wysiwygData, $decode = false) {
	require(dirname(__FILE__).'/ReverseParser.php');
	$reverseParser = new ReverseParser();
	return $reverseParser->parse($html, $decode ? Wikia::json_decode($wysiwygData, true) : $wysiwygData);
}

/**
 * Adding reference ID with metadata to global $wgWysiwygMetaData and surround passed element with extra code
 *
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 */
function Wysiwyg_SetRefId($type, $params, $addMarker = true, $returnId = false) {
	global $wgWysiwygMetaData, $wgWysiwygParser, $wgWysiwygMarkers;

	$refId = count($wgWysiwygMetaData);
	$data = array('type' => $type);
	$result = '';

	switch ($type) {
		case 'external link':
			$data['href'] = $params['link'];
			$data['description'] = $params['wasblank'] ? '' : $params['text'];
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
			break;

		case 'internal link: media':
		case 'image':
		case 'category':
			$data['href'] = ($params['noforce'] ? '' : ':') . $params['link'];
			$data['description'] = $params['wasblank'] ? '' : $params['text'];
			$result = "[[" . $data['href'] . ($params['wasblank'] ? '' : "|".$params['text']) . "]]";
			break;

		case 'external link: raw image':
			$data['href'] = $params['text'];
			break;

		case 'external link: raw':
			$data['href'] = $params['link'];
			break;

		case 'nowiki':
			$data['description'] = $params['text'];
			$result = $params['text'];
			break;

		case 'curly brackets':
		case 'gallery':
		case 'hook':
			if (!empty($params['lineStart'])) {	//for curly brackets
				$data['lineStart'] = 1;
			}
			$data['description'] = $params['text'];
			$result = $params['text'];
			break;

		case 'double underscore: toc':
			$data['description'] = $params['text'];
			$result = "<!--MWTOC-->";
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
		$result = "<input type=\"button\" refid=\"{$refId}\" value=\"{$result}\" title=\"{$result}\" class=\"wysiwygDisabled\" />";

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
