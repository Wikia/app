<?php

function wfSajaxGetMathUrl( $term )
{
	$originalLink = MathRenderer::renderMath( $term );

	if (false == strpos($originalLink, "src=\"")) {
		return "";
	}

	$srcPart = substr($originalLink, strpos($originalLink, "src=")+ 5);
	$url = strtok($srcPart, '"');

	return $url;
}

function wfSajaxGetImageUrl( $term )
{
	global $wgExtensionFunctions, $wgTitle;

	$options = new FCKeditorParserOptions();
	$options->setTidy(true);
	$parser = new FCKeditorParser();

	if (in_array("wfCite", $wgExtensionFunctions)) {
		$parser->setHook('ref', array($parser, 'ref'));
		$parser->setHook('references', array($parser, 'references'));
	}
	$parser->setOutputType(OT_HTML);
	$originalLink = $parser->parse("[[Image:".$term."]]", $wgTitle, $options)->getText();
	if (false == strpos($originalLink, "src=\"")) {
		return "";
	}

	$srcPart = substr($originalLink, strpos($originalLink, "src=")+ 5);
	$url = strtok($srcPart, '"');

	return $url;
}

function wfSajaxSearchSpecialTagFCKeditor($empty)
{
	global $wgParser;

	$ret = "nowiki\nincludeonly\nonlyinclude\nnoinclude\ngallery\n";
	foreach ($wgParser->getTags() as $h) {
		if (!in_array($h, array("pre", "math", "ref", "references"))) {
			$ret .= $h ."\n";
		}
	}
	return $ret;
}

function wfSajaxSearchImageFCKeditor( $term )
{
	global $wgContLang, $wgOut;
	$limit = 10;

	$term = $wgContLang->checkTitleEncoding( $wgContLang->recodeInput( js_unescape( $term ) ) );
	$term1 = str_replace( ' ', '_', $wgContLang->ucfirst( $term ) );
	$term2 = str_replace( ' ', '_', $wgContLang->lc( $term ) );
	$term3 = str_replace( ' ', '_', $wgContLang->uc( $term ) );
	$term = $term1;

	if ( strlen( str_replace( '_', '', $term ) )<3 )
	return "";

	$db =& wfGetDB( DB_SLAVE );
	$res = $db->select( 'page', 'page_title',
	array(  'page_namespace' => NS_IMAGE,
	"LOWER(page_title) LIKE '%". $db->strencode( $term2 ) ."%'" ),
	"wfSajaxSearch",
	array( 'LIMIT' => $limit+1 )
	);

	$ret = "";
	$i=0;
	while ( ( $row = $db->fetchObject( $res ) ) && ( ++$i <= $limit ) ) {
		$ret .= $row->page_title ."\n";
	}

	$term = htmlspecialchars( $term );

	return $ret;
}

function wfSajaxSearchArticleFCKeditor( $term )
{
	global $wgContLang, $wgOut;
	$limit = 10;
	$ns = NS_MAIN;

	$term = $wgContLang->checkTitleEncoding( $wgContLang->recodeInput( js_unescape( $term ) ) );

	if (strpos($term, "Category:") === 0) {
		$ns = NS_CATEGORY;
		$term = substr($term, 9);
		$prefix = "Category:";
	}
	else if (strpos($term, ":Category:") === 0) {
		$ns = NS_CATEGORY;
		$term = substr($term, 10);
		$prefix = ":Category:";
	}

	$term1 = str_replace( ' ', '_', $wgContLang->ucfirst( $term ) );
	$term2 = str_replace( ' ', '_', $wgContLang->lc( $term ) );
	$term3 = str_replace( ' ', '_', $wgContLang->uc( $term ) );
	$term = $term1;

	if ( strlen( str_replace( '_', '', $term ) )<3 ) {
		return "";
	}

	$db =& wfGetDB( DB_SLAVE );
	$res = $db->select( 'page', 'page_title',
	array(  'page_namespace' => $ns,
	"LOWER(page_title) LIKE '%". $db->strencode( $term2 ) ."%'" ),
	"wfSajaxSearch",
	array( 'LIMIT' => $limit+1 )
	);

	$ret = "";
	$i=0;
	while ( ( $row = $db->fetchObject( $res ) ) && ( ++$i <= $limit ) ) {
		if (isset($prefix) && !is_null($prefix)) {
			$ret .= $prefix;
		}
		$ret .= $row->page_title ."\n";
	}

	$term = htmlspecialchars( $term );

	return $ret;
}

function wfSajaxSearchTemplateFCKeditor($empty)
{
	global $wgContLang, $wgOut;
	$ns = NS_TEMPLATE;

	$db =& wfGetDB( DB_SLAVE );
	$res = $db->select( 'page', 'page_title',
	array(  'page_namespace' => $ns),
	"wfSajaxSearch"
	);

	$ret = "";
	while ( $row = $db->fetchObject( $res ) ) {
		$ret .= $row->page_title ."\n";
	}

	return $ret;
}

function wfSajaxWikiToHTML( $wiki )
{
	global $wgTitle;

	$options = new FCKeditorParserOptions();
	$options->setTidy(true);
	$parser = new FCKeditorParser();
	$parser->setOutputType(OT_HTML);

	return $parser->parse($wiki, $wgTitle, $options)->getText();
}
