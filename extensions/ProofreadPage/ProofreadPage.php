<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "ProofreadPage extension\n" );
}

$dir = dirname(__FILE__) . '/';

$wgExtensionMessagesFiles['ProofreadPage'] = dirname(__FILE__) . '/ProofreadPage.i18n.php';

$wgHooks['BeforePageDisplay'][] = 'pr_beforePageDisplay';
$wgHooks['GetLinkColours'][] = 'pr_getLinkColours';
$wgHooks['ImageOpenShowImageInlineBefore'][] = 'pr_imageMessage';
$wgHooks['ArticleSaveComplete'][] = 'pr_articleSave';
$wgHooks['EditFormPreloadText'][] = 'pr_preloadText';

# Allows for extracting text from djvu files. To enable, set to 'djvutxt' or similar
$wgDjvutxt = null;


$wgExtensionCredits['other'][] = array(
	'name'           => 'ProofreadPage',
	'author'         => 'ThomasV',
	'svn-date' => '$LastChangedDate: 2009-03-22 20:57:40 +0100 (ndz, 22 mar 2009) $',
	'svn-revision' => '$LastChangedRevision: 48686 $',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Proofread_Page',
	'description'    => 'Allow easy comparison of text to the original scan',
	'descriptionmsg' => 'proofreadpage_desc',
);


$wgExtensionFunctions[] = "pr_main";
function pr_main() {
	global $wgParser;
	$wgParser->setHook( "pagelist", "pr_renderPageList" );
	$wgParser->setHook( "indexref", "pr_renderIndexTag" );
}




# Bump the version number every time you change proofread.js
$wgProofreadPageVersion = 18;

/**
 * 
 * Query the database to find if the current page is referred in an Index page. 
 * 
 */
function pr_load_index($title){

	$page_namespace = preg_quote( wfMsgForContent( 'proofreadpage_namespace' ), '/' );
	$index_namespace = preg_quote( wfMsgForContent( 'proofreadpage_index_namespace' ), '/' );

	$title->pr_index_title=NULL;

	$dbr = wfGetDB( DB_SLAVE );
	$result = $dbr->select(
			array( 'page', 'pagelinks' ),
			array( 'page_namespace', 'page_title' ),
			array(
				'pl_namespace' => $title->getNamespace(),
				'pl_title' => $title->getDBkey(),
				'pl_from=page_id'
			),
			__METHOD__);

	while( $x = $dbr->fetchObject( $result ) ) {
		$ref_title = Title::makeTitle( $x->page_namespace, $x->page_title );
		if( preg_match( "/^$index_namespace:(.*)$/", $ref_title->getPrefixedText() ) ) {
			$title->pr_index_title = $ref_title->getPrefixedText();
			break;
		}
	}
	$dbr->freeResult( $result ) ;

	if($title->pr_index_title) return;

	/*check if we are a page of a multipage file*/

	if ( preg_match( "/^$page_namespace:(.*?)(\/([0-9]*)|)$/", $title->getPrefixedText(), $m ) ) {
		$imageTitle = Title::makeTitleSafe( NS_IMAGE, $m[1] );
	}
	if ( !$imageTitle ) return;

	$image = wfFindFile( $imageTitle );

	//if it is multipage, we use the page order of the file
	if( $image->exists() && $image->isMultiPage() ) {

		$pagenr = 1;
		$parts = explode( '/', $title->getText() );
		if( count( $parts ) > 1 ) {
			$pagenr = intval( array_pop( $parts ) );
		}
		$count = $image->pageCount();
		if( $pagenr < 1 || $pagenr > $count || $count == 1 )
			return $err;
		$name = $image->getTitle()->getText();
		$index_name = "$index_namespace:$name";
		$prev_name = "$page_namespace:$name/" . ( $pagenr - 1 );
		$next_name = "$page_namespace:$name/" . ( $pagenr + 1 );
		$prev_url = ( $pagenr == 1 ) ? '' : Title::newFromText( $prev_name )->getFullURL();
		$next_url = ( $pagenr == $count ) ? '' : Title::newFromText( $next_name )->getFullURL();

		//todo : we should read pagenum from the index if it is provided
		$title->pr_page_num = "$pagenr";

		if( !$title->pr_index_title ) { 
			//there is no index, or the page is not listed in the index : use canonical index
			$title->pr_index_title = $index_name;
		}
	} 


}



/**
 * 
 * return the URLs of the index, previous and next pages.
 * 
 */


function pr_navigation( $image ) {
	global $wgTitle;
	$page_namespace = preg_quote( wfMsgForContent( 'proofreadpage_namespace' ), '/' );
	$index_namespace = preg_quote( wfMsgForContent( 'proofreadpage_index_namespace' ), '/' );
	$err = array( '', '', '', '', array() );


	//if multipage, we use the page order, but we should read pagenum from the index
	if( $image->exists() && $image->isMultiPage() ) {

		$pagenr = 1;
		$parts = explode( '/', $wgTitle->getText() );
		if( count( $parts ) > 1 ) {
			$pagenr = intval( array_pop( $parts ) );
		}
		$count = $image->pageCount();
		if( $pagenr < 1 || $pagenr > $count || $count == 1 )
			return $err;
		$name = $image->getTitle()->getText();
		$index_name = "$index_namespace:$name";
		$prev_name = "$page_namespace:$name/" . ( $pagenr - 1 );
		$next_name = "$page_namespace:$name/" . ( $pagenr + 1 );
		$prev_url = ( $pagenr == 1 ) ? '' : Title::newFromText( $prev_name )->getFullURL();
		$next_url = ( $pagenr == $count ) ? '' : Title::newFromText( $next_name )->getFullURL();
		$page_num = $pagenr;

		if( !$index_title ) { 
			//there is no index, or the page is not listed in the index : use canonical index
			$index_title = Title::newFromText( $index_name );
		}
	} 
	else {
		$page_num = '';
		$prev_url = '';
		$next_url = '';
	}


	if( !$index_title ) return $err;
	if( !$index_title->exists()) return $err;

	//if the index page exists, read metadata

	list( $prev_title, $next_title, $attributes ) = pr_parse_index($index_title,$wgTitle);

	$index_url = $index_title->getFullURL();
	if($prev_title) $prev_url = $prev_title->getFullURL();
	if($next_title) $next_url = $next_title->getFullURL();

	return array( $index_url, $prev_url, $next_url, $attributes );

}


/*
  read metadata from the index page
  read also pagenum if page_title is provided (not for djvu with pagelist)
*/

function pr_parse_index($index_title, $page_title){

	$page_namespace = preg_quote( wfMsgForContent( 'proofreadpage_namespace' ), '/' );
	$index_namespace = preg_quote( wfMsgForContent( 'proofreadpage_index_namespace' ), '/' );

	if( !$index_title ) return ;
	if( !$index_title->exists() ) return;

	$rev = Revision::newFromTitle( $index_title );
	$text =	$rev->getText();

	$attributes = array();

	if($page_title){

		//default pagenum was set during load()
		if($page_title->pr_page_num) $attributes["pagenum"] = $page_title->pr_page_num;

		$tag_pattern = "/\[\[($page_namespace:.*?)(\|(.*?)|)\]\]/i";
		preg_match_all( $tag_pattern, $text, $links, PREG_PATTERN_ORDER );

		for( $i=0; $i<count( $links[1] ); $i++) { 
			$a_title = Title::newFromText( $links[1][$i] );
			if(!$a_title) continue; 
			if( $a_title->getPrefixedText() == $page_title->getPrefixedText() ) {
				$attributes["pagenum"] = $links[3][$i];
				break;
			}
		}
		if( ($i>0) && ($i<count($links[1])) ){
			$prev_title = Title::newFromText( $links[1][$i-1] );
		}
		if( ($i>=0) && ($i+1<count($links[1])) ){
			$next_title = Title::newFromText( $links[1][$i+1] );
		}
	}

	$var_names = explode(" ", wfMsgForContent('proofreadpage_js_attributes') );
	for($i=0; $i< count($var_names);$i++){
		$tag_pattern = "/\n\|".$var_names[$i]."=(.*?)\n/i";
		//$var = 'proofreadPage'.$var_names[$i];
		$var = strtolower($var_names[$i]);
		if( preg_match( $tag_pattern, $text, $matches ) ) $attributes[$var] = $matches[1]; 
		else $attributes[$var] = '';
	}
	

	return array( $prev_title, $next_title, $attributes );

}


/**
 * 
 * Append javascript variables and code to the page.
 * 
 */

function pr_beforePageDisplay( &$out ) {
	global $wgTitle, $wgJsMimeType, $wgScriptPath,  $wgRequest, $wgProofreadPageVersion;

	wfLoadExtensionMessages( 'ProofreadPage' );
	$action = $wgRequest->getVal('action');
	$isEdit = ( $action == 'submit' || $action == 'edit' ) ? 1 : 0;
	if ( !isset( $wgTitle ) || ( !$out->isArticle() && !$isEdit ) || isset( $out->proofreadPageDone ) ) {
		return true;
	}
	$out->proofreadPageDone = true;

	$page_namespace = preg_quote( wfMsgForContent( 'proofreadpage_namespace' ), '/' );
	if ( preg_match( "/^$page_namespace:(.*?)(\/([0-9]*)|)$/", $wgTitle->getPrefixedText(), $m ) ) {
		if( !isset($wgTitle->pr_index_title) ) pr_load_index($wgTitle);
		pr_preparePage( $out, $m, $isEdit );
		return true;
	}

	$index_namespace = preg_quote( wfMsgForContent( 'proofreadpage_index_namespace' ), '/' );
	if ( $isEdit && (preg_match( "/^$index_namespace:(.*?)(\/([0-9]*)|)$/", $wgTitle->getPrefixedText(), $m ) ) ) {
		pr_prepareIndex( $out );
		return true;
	}

	return true;
}


function pr_prepareIndex( $out ) {
	global $wgTitle, $wgJsMimeType, $wgScriptPath,  $wgRequest, $wgProofreadPageVersion;
	$jsFile = htmlspecialchars( "$wgScriptPath/extensions/ProofreadPage/proofread_index.js?$wgProofreadPageVersion" );

	$out->addScript( <<<EOT
<script type="$wgJsMimeType" src="$jsFile"></script>

EOT
	);
	$out->addScript( "<script type=\"{$wgJsMimeType}\"> 
var prp_index_attributes = \"" . Xml::escapeJsString(wfMsgForContent('proofreadpage_index_attributes')) . "\";
</script>\n"
	);

}






function pr_preparePage( $out, $m, $isEdit ) {
	global $wgTitle, $wgJsMimeType, $wgScriptPath,  $wgRequest, $wgProofreadPageVersion;

	$imageTitle = Title::makeTitleSafe( NS_IMAGE, $m[1] );
	if ( !$imageTitle ) {
		return true;
	}

	$image = wfFindFile( $imageTitle );
	if ( $image->exists() ) {
		$width = $image->getWidth();
		$height = $image->getHeight();
		if($m[2]) { 
			$viewName = $image->thumbName( array( 'width' => $width, 'page' => $m[3] ) );
			$viewURL = $image->getThumbUrl( $viewName );

			$thumbName = $image->thumbName( array( 'width' => '##WIDTH##', 'page' => $m[3] ) );
			$thumbURL = $image->getThumbUrl( $thumbName );
		}
		else {
			$viewURL = $image->getViewURL();
			$thumbName = $image->thumbName( array( 'width' => '##WIDTH##' ) );
			$thumbURL = $image->getThumbUrl( $thumbName );
		}
		$thumbURL = str_replace( '%23', '#', $thumbURL );
	} 
	else {	
		$width = 0;
		$height = 0;
		$viewURL = '';
		$thumbURL = '';
	}

	list( $index_url, $prev_url, $next_url, $attributes ) = pr_navigation( $image );

	$jsFile = htmlspecialchars( "$wgScriptPath/extensions/ProofreadPage/proofread.js?$wgProofreadPageVersion" );
	$jsVars = array(
		'proofreadPageWidth' => intval( $width ),
		'proofreadPageHeight' => intval( $height ),
		'proofreadPageViewURL' => $viewURL,
		'proofreadPageThumbURL' => $thumbURL,
		'proofreadPageIsEdit' => intval( $isEdit ),
		'proofreadPageIndexURL' => $index_url,
		'proofreadPagePrevURL' => $prev_url,
		'proofreadPageNextURL' => $next_url,
	) + $attributes;
	$varScript = Skin::makeVariablesScript( $jsVars );

	$out->addScript( <<<EOT
$varScript
<script type="$wgJsMimeType" src="$jsFile"></script>

EOT
	);

        # Add messages from i18n
        $out->addScript( "<script type=\"{$wgJsMimeType}\"> 
var proofreadPageMessageIndex = \"" . Xml::escapeJsString(wfMsg('proofreadpage_index')) . "\";
var proofreadPageMessageNextPage = \"" . Xml::escapeJsString(wfMsg('proofreadpage_nextpage')) . "\";
var proofreadPageMessagePrevPage = \"" . Xml::escapeJsString(wfMsg('proofreadpage_prevpage')) . "\";
var proofreadPageMessageImage = \"" . Xml::escapeJsString(wfMsg('proofreadpage_image')) . "\";
var proofreadPageMessageHeader = \"" . Xml::escapeJsString(wfMsg('proofreadpage_header')) . "\";
var proofreadPageMessagePageBody = \"" . Xml::escapeJsString(wfMsg('proofreadpage_body')) . "\";
var proofreadPageMessageFooter = \"" . Xml::escapeJsString(wfMsg('proofreadpage_footer')) . "\";
var proofreadPageMessageToggleHeaders = \"" . Xml::escapeJsString(wfMsg('proofreadpage_toggleheaders')) . "\";
var proofreadPageMessageStatus = \"" . Xml::escapeJsString(wfMsg('proofreadpage_page_status')) . "\";
var proofreadPageMessageQuality1 = \"" . Xml::escapeJsString(wfMsgForContent('proofreadpage_quality1_category')) . "\";
var proofreadPageMessageQuality2 = \"" . Xml::escapeJsString(wfMsgForContent('proofreadpage_quality2_category')) . "\";
var proofreadPageMessageQuality3 = \"" . Xml::escapeJsString(wfMsgForContent('proofreadpage_quality3_category')) . "\";
var proofreadPageMessageQuality4 = \"" . Xml::escapeJsString(wfMsgForContent('proofreadpage_quality4_category')) . "\";
</script>\n" 
        );
	return true;
}


/**
 *  Return the quality colour codes to pages linked from an index page
 *  Update page counts in pr_index table
 */
function pr_getLinkColours( $page_ids, &$colours ) {
	global $wgTitle;

	if ( !isset( $wgTitle ) ) {
		return true;
	}
	wfLoadExtensionMessages( 'ProofreadPage' );

	// abort if we are not an index page
	$index_namespace = preg_quote( wfMsgForContent( 'proofreadpage_index_namespace' ), '/' );
	if ( !preg_match( "/^$index_namespace:(.*?)$/", $wgTitle->getPrefixedText() ) ) {
		return true;
	}

	//counters
	$n = $n1 = $n2 = $n3 = $n4 = 0;

	$dbr = wfGetDB( DB_SLAVE );
	$catlinks = $dbr->tableName( 'categorylinks' );
	foreach ( $page_ids as $id => $pdbk ) {

		// consider only link in page namespace
		$page_namespace = preg_quote( wfMsgForContent( 'proofreadpage_namespace' ), '/' );
		if ( preg_match( "/^$page_namespace:(.*?)$/", $pdbk ) ) {

			$colours[$pdbk] = 'quality1';
			$n++;

			if ( !isset( $query ) ) {
				$query =  "SELECT cl_from, cl_to FROM $catlinks WHERE cl_from IN(";
			} else {
				$query .= ', ';
			}
			$query .= $id;
		}
	}

	if ( isset( $query ) ) {
		$query .= ')';
		$res = $dbr->query( $query, __METHOD__ );

		while ( $x = $dbr->fetchObject($res) ) {

			$pdbk = $page_ids[$x->cl_from];
			
			switch($x->cl_to){
			case str_replace( ' ' , '_' , wfMsgForContent('proofreadpage_quality1_category')): 
				$colours[$pdbk] = 'quality1';
				$n1++;
				break;
			case str_replace( ' ' , '_' , wfMsgForContent('proofreadpage_quality2_category')): 
				$colours[$pdbk] = 'quality2';
				$n2++;
				break;
			case str_replace( ' ' , '_' , wfMsgForContent('proofreadpage_quality3_category')): 
				$colours[$pdbk] = 'quality3';
				$n3++;
				break;
			case str_replace( ' ' , '_' , wfMsgForContent('proofreadpage_quality4_category')): 
				$colours[$pdbk] = 'quality4';
				$n4++;
				break;
			}
		}
	}

	return true;
}

function pr_imageMessage(  &$imgpage , &$wgOut ) {

	global $wgUser;
	$sk = $wgUser->getSkin();

	$image = $imgpage->img;
	if ( !$image->isMultipage() ) {
		return true;
	}

	wfLoadExtensionMessages( 'ProofreadPage' );
	$index_namespace = preg_quote( wfMsgForContent( 'proofreadpage_index_namespace' ), '/' );
	$name = $image->getTitle()->getText();

	$link = $sk->makeKnownLink( "$index_namespace:$name", wfMsg('proofreadpage_image_message') );
	$wgOut->addHTML( "{$link}" );

	return true;
}



//credit : http://www.mediawiki.org/wiki/Extension:RomanNumbers
function toRoman($num) {
if ($num < 0 || $num > 9999) return -1;
 
	$romanOnes = array(1=> "I",2=>"II",3=>"III",4=>"IV", 5=>"V", 6=>"VI", 7=>"VII", 8=>"VIII", 9=>"IX"   );
	$romanTens = array(1=> "X", 2=>"XX", 3=>"XXX", 4=>"XL", 5=>"L", 6=>"LX", 7=>"LXX",8=>"LXXX", 9=>"XC");
	$romanHund = array(1=> "C", 2=>"CC", 3=>"CCC", 4=>"CD", 5=>"D", 6=>"DC", 7=>"DCC",8=>"DCCC", 9=>"CM");
	$romanThou = array(1=> "M", 2=>"MM", 3=>"MMM", 4=>"MMMM", 5=>"MMMMM", 6=>"MMMMMM",7=>"MMMMMMM", 8=>"MMMMMMMM", 9=>"MMMMMMMMM");
 
	$ones = $num % 10;
	$tens = ($num - $ones) % 100;
	$hund = ($num - $tens - $ones) % 1000;
	$thou = ($num - $hund - $tens - $ones) % 10000;
 
	$tens = $tens / 10;
	$hund = $hund / 100;
	$thou = $thou / 1000;
	
	if ($thou) $romanNum .= $romanThou[$thou];
	if ($hund) $romanNum .= $romanHund[$hund];
	if ($tens) $romanNum .= $romanTens[$tens];
	if ($ones) $romanNum .= $romanOnes[$ones];
 
	return $romanNum; 
}



function pr_renderIndexTag( $input, $args ) {
	global $wgParser, $wgTitle;

	if( !isset($wgTitle->pr_index_title) ) pr_load_index($wgTitle);

	$index_namespace = preg_quote( wfMsgForContent( 'proofreadpage_index_namespace' ), '/' );

	$name = $args['src'];
	if( $name ) 
		$index_title = Title::newFromText( "$index_namespace:$name" );
	else 
		$index_title = Title::newFromText( $wgTitle->pr_index_title );

	if( ! $index_title || ! $index_title->exists() ) return "error: no such index: $index_namespace:$name"; 

	if($wgTitle->pr_index_title) $page_index = $wgTitle; else $page_index=NULL;

	//here we must parse the index everytime we render the tag: 
	//it would be better to store the attributes in a table
	//especially in the case of a 'special' page
	list( $prev_title, $next_title, $attributes ) = pr_parse_index( $index_title, $page_index );

	//first parse
	$input = $wgParser->recursiveTagParse($input);

	foreach($attributes as $key=>$val){
		$input = str_replace( "{{{{$key}}}}", $val, $input );
	}


	$out = $wgParser->recursiveTagParse($input);

	return $out;

}


function pr_renderPageList( $input, $args ) {

	global $wgUser, $wgTitle;

	wfLoadExtensionMessages( 'ProofreadPage' );
	$index_namespace = preg_quote( wfMsgForContent( 'proofreadpage_index_namespace' ), '/' );
	if ( !preg_match( "/^$index_namespace:(.*?)(\/([0-9]*)|)$/", $wgTitle->getPrefixedText(), $m ) ) {
		return true;
	}

	$imageTitle = Title::makeTitleSafe( NS_IMAGE, $m[1] );
	if ( !$imageTitle ) {
		return true;
	}
	$image = wfFindFile( $imageTitle );
	$return="";

	if ( $image->isMultipage() ) {

		$name = $imageTitle->getDBkey();
		$count = $image->pageCount();
		$dbr = wfGetDB( DB_SLAVE );
		$pagetable = $dbr->tableName( 'page' );

		$page_namespace = preg_quote( wfMsgForContent( 'proofreadpage_namespace' ), '/' );
		$page_ns_index = MWNamespace::getCanonicalIndex( strtolower( $page_namespace ) );
		if( $page_ns_index == NULL ) {
			$page_ns_index = NS_MAIN;
		}

		for( $i=0; $i<$count ; $i++) { 

			if ( !isset( $query ) ) {
				$query =  "SELECT page_id, page_title, page_namespace";
				$query .= " FROM $pagetable WHERE (page_namespace=$page_ns_index AND page_title IN(";
			} else {
				$query .= ', ';
			}
			$link_name = "$name" . '/'. ($i+1) ;	
			$query .= $dbr->addQuotes( $link_name );
		}
		$query .= '))';
		$res = $dbr->query( $query, __METHOD__ );

		$colours = array();
		$linkcolour_ids = array();
		while ( $s = $dbr->fetchObject($res) ) {
			$title = Title::makeTitle( $s->page_namespace, $s->page_title );
			$pdbk = $title->getPrefixedDBkey();
			$colours[$pdbk] = 'known';
			$linkcolour_ids[$s->page_id] = $pdbk;
		}
		pr_getLinkColours( $linkcolour_ids, $colours );

		$sk = $wgUser->getSkin();

		$offset = 0;
		$mode = 'normal';
		for( $i=1; $i<$count+1 ; $i++) { 

			$pdbk = "$page_namespace:$name" . '/'. $i ;
			//default
			$single=false;
			$mode = 'normal';
			$links = true;

			foreach ( $args as $num => $param ) {

			  if( ( preg_match( "/^([0-9]*)to([0-9]*)$/", $num, $m ) && ( $i>=$m[1] && $i<=$m[2] ) ) 
			      || ( is_numeric($num) && ($i == $num) ) ) {
					$params = explode(";",$param);
					foreach ( $params as $iparam ) {
						switch($iparam){
						case 'roman': 
							$mode = 'roman';
							break;
						case 'highroman': 
							$mode = 'highroman';
							break;
						case 'empty': 
							$links = false;
							break;
						default:
							if(is_numeric($iparam)) 
								$offset = $i - $iparam[0]; 
							else
								$single = $iparam[0];

						}
					}
				}
			}

			if( $single ) { 
				$view = $single; 
				$offset=$offset+1;
			}
			else {
				$view = ($i - $offset);
				if($mode == 'highroman') $view = '&nbsp;'.toRoman($view);
				elseif($mode == 'roman') $view = '&nbsp;'.strtolower(toRoman($view));
				elseif($mode == 'normal') $view = ''.$view;
				elseif($mode == 'empty') $view = ''.$view;
				else $view = $mode.$view;
			}

			$n = strlen($count) - strlen($view);
			if( $n && ($mode == 'normal' || $mode == 'empty') ){
				$txt = '<span style="visibility:hidden;">';
				for( $j=0; $j<$n; $j++) $txt = $txt.'0';
				$view = $txt.'</span>'.$view;
			}
			$title = Title::newFromText( $pdbk );

			if($links==false) $return.= $view." ";
			else{
				if ( !isset( $colours[$pdbk] ) ) {
					$link = $sk->makeBrokenLinkObj( $title, $view );
				} 
				else {
					$link = $sk->makeColouredLinkObj( $title, $colours[$pdbk], $view );
				}
				$return .= "{$link} ";
			}
		}
	}
	return $return;
}


/* update coloured links in index pages */
function pr_articleSave( $article ) {

	wfLoadExtensionMessages( 'ProofreadPage' );
	$page_namespace = preg_quote( wfMsgForContent( 'proofreadpage_namespace' ), '/' );
	$index_namespace = preg_quote( wfMsgForContent( 'proofreadpage_namespace' ), '/' );

	$title = $article->mTitle;

	if( preg_match( "/^$page_namespace:(.*)$/", $title->getPrefixedText() ) ) {

		if( !isset($title->pr_index_title) ) pr_load_index($title);
		if( $title->pr_index_title) {
			$index_title = Title::makeTitleSafe( $index_namespace, $title->pr_index_title );
			$index_title->invalidateCache();
		}
	}

	return true;

}



function pr_preloadText( $textbox1, $mTitle ) {
	global $wgDjvutxt;

	$page_namespace = preg_quote( wfMsgForContent( 'proofreadpage_namespace' ), '/' );

	if ( $wgDjvutxt && preg_match( "/^$page_namespace:(.*?)\/([0-9]*)$/", $mTitle->getPrefixedText(), $m ) ) {

		$imageTitle = Title::makeTitleSafe( NS_IMAGE, $m[1] );
		if ( !$imageTitle ) {
			return true;
		}

		$image = wfFindFile( $imageTitle );
		if ( $image->exists() && $image->getMimeType() == 'image/vnd.djvu' ) {
			$srcPath = $image->getPath();
			$cmd = "( " .wfEscapeShellArg( $wgDjvutxt );
			$cmd .= " --page {$m[2]} ". wfEscapeShellArg( $srcPath )." )";
			wfProfileIn( 'ProofreadPage' );
			wfDebug( __METHOD__.": $cmd\n" );
			$out = wfShellExec( $cmd, $retval );
			wfProfileOut( 'ProofreadPage' );

			if($retval==0) $textbox1 = $out;
		}
	}
	return true;
}
