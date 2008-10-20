<?php
if(!defined('MEDIAWIKI')) {
	exit(1);
}

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['WysiwygInterface'] = $dir . 'WysiwygInterface_body.php';
$wgExtensionMessagesFiles['WysiwygInterface'] = $dir . 'WysiwygInterface.i18n.php';
$wgSpecialPages['WysiwygInterface'] = 'WysiwygInterface';

/*
 * AJAX support for html->wiki and wiki->html parser functionality
 */
$wgAjaxExportList[] = 'wfDirectParserAjax';
$wgAjaxExportList[] = 'wfReverseParserAjax';

function wfDirectParserAjax($wikitext, $appendData = false) {

	$options = new ParserOptions();
	$title = new Title();

	require(dirname(__FILE__).'/WysiwygInterface_body.php');

	$parser = new WysiwygParser();
	$parser->setOutputType(OT_HTML);
	global $wgWysiwygParserEnabled;
	$wgWysiwygParserEnabled = true;
	$out = $parser->parse($wikitext, $title, $options)->getText();
	$wgWysiwygParserEnabled = false;

	if ( $appendData != false) {
		global $wgWysiwygMetaData;
		$jsonData = json_encode($wgWysiwygMetaData);

		$out .= 'FCKdata:::separator' . $jsonData;
	}

        $response = new AjaxResponse( $out );
        $response->setContentType('text/plain; charset=utf-8');

        return $response;
}


function wfReverseParserAjax($html, $data = array()) {

        if (!empty($data)) {
                $wgWysiwygMetaData = json_decode($data);
        }
        else {
                $wgWysiwygMetaData = array();
        }

	$html = urldecode($html);

        // call ReverseParser to parse HTML back to wikimarkup
        require(dirname(__FILE__).'/ReverseParser.php');
        $reverseParser = new ReverseParser();

        $result = $reverseParser->parse($html, $wgWysiwygMetaData);

        $response = new AjaxResponse( $result );
        $response->setContentType('text/plain; charset=utf-8');

        return $response;
}

$wgAjaxExportList[] = 'wfWikisyntaxToHtml';
function wfWikisyntaxToHtml($wikitext) {
	require(dirname(__FILE__).'/WysiwygInterface_body.php');
	$options = new ParserOptions();
	$title = new Title();

	$parser = new WysiwygParser();
	$parser->setOutputType(OT_HTML);
	global $wgWysiwygParserEnabled, $wgWysiwygMetaData;
	$wgWysiwygParserEnabled = true;
	return $parser->parse($wikitext, $title, $options)->getText() . '--||--' . Wikia::json_encode($wgWysiwygMetaData, true);
}

$wgAjaxExportList[] = 'wfHtmlToWikisyntax';
function wfHtmlToWikisyntax($html, $wysiwygData) {
	$wysiwygData = Wikia::json_decode($wysiwygData);
	// call ReverseParser to parse HTML back to wikimarkup
	require(dirname(__FILE__).'/ReverseParser.php');
	$reverseParser = new ReverseParser();
	$result = $reverseParser->parse($html, $wysiwygData);
	return $result;
}
