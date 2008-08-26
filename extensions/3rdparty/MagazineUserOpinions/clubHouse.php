<?php


$wgExtensionFunctions[] = "wfClubHouse";


function wfClubHouse() {
        global $wgParser, $wgOut;
        $wgParser->setHook( "clubhouse", "renderclubHouse" );
}
function renderclubHouse( $input ) {
	$parser = new Parser();
	$CtgTitle = Title::newFromText( $parser->transformMsg(trim($input), null) );	
	$User = $CtgTitle->getDbKey();
	
	$output = "";
	$output .= '<a href=#pageToolsTop></a><table cellpadding=0 cellspacing=0 border=0><tr>';
	$output .= '<td  id=commentsBtn class="toptabsOn" onMouseDown=javascript:$("commentsBtn").className="toptabsOn";$("emailBtn").className="toptabs";$("relatedBtn").className="toptabs";getContent("extensions/ListPagesAction.php","shw=7&ctg=OPINIONS_BY_USER_' . $User . '&ord=NEW&lv=0&shwctg=1&det=1&pub=0","pageToolsContent")>&nbsp;Recent&nbsp;Opinions&nbsp;</td>';
	$output .= '<td width=5 class="topright">&nbsp;</td>';
	$output .= '<td  id=emailBtn class="toptabs" onMouseDown=javascript:$("emailBtn").className="toptabsOn";$("commentsBtn").className="toptabs";$("relatedBtn").className="toptabs";getContent("extensions/ListPagesAction.php","shw=7&ctg=OPINIONS_BY_USER_' . $User . '&ord=VOTES&lv=0&shwctg=1&det=1&pub=0","pageToolsContent")>Most&nbsp;Voted&nbsp;On</td>';
	$output .= '<td width=5 class="topright">&nbsp;</td>';
	$output .= '<td id=relatedBtn class="toptabs" onMouseDown=$("relatedBtn").className="toptabsOn";$("commentsBtn").className="toptabs";$("emailBtn").className="toptabs";javascript:getContent("extensions/ListPagesAction.php","shw=7&ctg=OPINIONS_BY_USER_' . $User . '&ord=COMMENTS&lv=0&shwctg=1&det=1&pub=0","pageToolsContent")>&nbsp;Most&nbsp;Commented&nbsp;On&nbsp;</td></td>';
	$output .= '<td width=30 class="topright">&nbsp;</td>';
	$output .= '</tr></table><BR><div id=pageToolsContent>';
	return $output;
}


?>