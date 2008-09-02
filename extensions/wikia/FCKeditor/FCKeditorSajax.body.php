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
	global $wgExtensionFunctions, $wgTitle, $wgContLang ;

	$options = new FCKeditorParserOptions();
	$options->setTidy(true);
	$parser = new FCKeditorParser();

	if (in_array("wfCite", $wgExtensionFunctions)) {
		$parser->setHook('ref', array($parser, 'ref'));
		$parser->setHook('references', array($parser, 'references'));
	}
	$parser->setOutputType(OT_HTML);
	$lang_img = $wgContLang->getFormattedNsText( NS_IMAGE );

	// this could go either through WMU or FCK image dialog
	if (false === strpos($term, "[[")) {
		$term = "[[" . $lang_img . ":".$term."]]" ;
		$tag = $term ;
	} else {
		$tags_text = substr ($term, strpos ($term, ":") + 1) ;
		preg_match ("/^[^\|]+/", $tags_text, $tags) ;
		$tag = $tags [0] ;		
	}	

	$originalLink = $parser->parse($term, $wgTitle, $options)->getText() ;
	if (false == strpos($originalLink, "src=\"")) {
		return "";
	}

	$srcPart = substr($originalLink, strpos($originalLink, "src=")+ 5);
	$url = strtok($srcPart, '"');

	return  $url . "<FCK_SajaxResponse_splitter_tag/>" . $tag ;
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

	// fix the namespace... 
	$ns_seed = split (':', $term2) ;

	if(count($ns_seed) > 1) {
		$ns_name = $ns_seed [0];
		$term2 = $ns_seed [1];
		if(isset($ns_name)) {
			$ns = Namespace::getCanonicalIndex(strtolower($ns_name));
			$ns_name = $wgContLang->getFormattedNsText( $ns );
		}

	} else {
		$title_name = $term2 ;
	}

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
		
		if (isset ($ns_name)) {
			$ret .= $ns_name . ":" . str_replace ('_', ' ', $row->page_title) ."\n";
		} else {
			$ret .=  str_replace ('_', ' ', $row->page_title) ."\n";
		}
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
	$old_parser = new Parser() ;
        $old_parser->setOutputType(OT_HTML);
	
	$parsed_text = $parser->parse($wiki, $wgTitle, $options)->getText() ;
	$parsed_templates = $old_parser->parse ($parser->fck_parsed_templates, $wgTitle, $options)->getText() ;

	$result_text = $parsed_text . "<FCK_SajaxResponse_splitter_tag/>" . $parsed_templates ;

	return $result_text ;
}
