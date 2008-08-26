<?php


$wgExtensionFunctions[] = "wfpageTools";


function wfpageTools() {
        global $wgParser, $wgOut;
		$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/pageTools.js\"></script>\n");
        $wgParser->setHook( "pagetools", "renderpageTools" );
}
function renderpageTools( $input ) {
	global $wgUser, $wgTitle, $wgOut, $IP;
	require_once ("$IP/extensions/ListPages/ListPagesClass.php");
	$parser = new Parser();
	$list = new ListPages();
	$list->setBool("ShowCtg","yes");
	
	$relatedctgArray = explode( "," , strip_tags(  $list->getCategoryLinks($wgTitle->mArticleID,7)  )  );
	foreach($relatedctgArray as $ctg ){
		if($ctg!=""){
			$ctg = trim(strtoupper($ctg));
			if( $ctg != "NEWS" && $ctg != "OPINIONS"){
				if($ctgstr!="")$ctgstr.= ",";
				$CtgTitle = Title::newFromText( $parser->transformMsg(trim($ctg), $wgOut->parserOptions()) );
				$ctgstr .= $CtgTitle->getDbKey();
			}
		}
	}
	
	$output = "";
	$output .= '<a href="#pageToolsTop"></a><table cellpadding="0" cellspacing="0" border="0"><tr>';
	$output .= '<td width="100" id="commentsBtn" class="toptabsOn" onmousedown=\'javascript:$("commentsBtn").className="toptabsOn";$("historyBtn").className="toptabs";$("emailBtn").className="toptabs";$("relatedBtn").className="toptabs";getContent("index.php?title=Special:CommentAction&Action=2","pid=' . $wgTitle->mArticleID . '&shwform=1&ord=0","pageToolsContent")\'>Comments</td>';
	$output .= '<td width="5" class="topright">&nbsp;</td>';
	$output .= '<td width="100" id="emailBtn" class="toptabs" onmousedown=\'javascript:$("emailBtn").className="toptabsOn";$("historyBtn").className="toptabs";$("commentsBtn").className="toptabs";$("relatedBtn").className="toptabs";getContent("index.php?title=Special:EmailThis&pageid=' . $wgTitle->mArticleID . '","","pageToolsContent")\'>Email This</td>';
	$output .= '<td width="5" class="topright">&nbsp;</td>';
	$output .= '<td width="100" id="relatedBtn" class="toptabs" onmousedown=\'$("relatedBtn").className="toptabsOn";$("historyBtn").className="toptabs";$("commentsBtn").className="toptabs";$("emailBtn").className="toptabs";javascript:getContent("index.php?title=Special:ListPagesAction","shw=15&ctg=' . $ctgstr . '&ord=PUBLISHEDDATE&lv=1&shwctg=1&det=0&pub=1","pageToolsContent")\'>Related Articles</td>';
	$output .= '<td width="5" class="topright">&nbsp;</td>';
	$output .= '<td width="100" id="historyBtn" class="toptabs" onmousedown=\'$("historyBtn").className="toptabsOn";$("relatedBtn").className="toptabs";$("commentsBtn").className="toptabs";$("emailBtn").className="toptabs";javascript:getContent("index.php?title=Special:PageHistoryAJAX&pid=' . $wgTitle->mArticleID . '","","pageToolsContent")\'>Page History</td><td width="300" class="topright">&nbsp;</td>';
	$output .= '</tr></table><br/><div id="pageToolsContent">';
	return $output;
}


?>