<?php
/**
 * Provides a special function to use the DPL extension
 *
 * @author Algorithmix (Gero Scholz) http://semeb.com/dpldemo

 * Thanks go to  Austin Che <http://openwetware.org/wiki/User:Austin>
 * for his special page which offers generich wiki text parsing
 *
 * @version 1.1.1
 * @version 1.1.4
 *          first GUI design, still very rudimentary
 *
 * @version 1.1.7
 *          changed label for "createreport"
 * @version 1.1.9
 *          added && for newline separation
 */

class DynamicPageListSP extends SpecialPage
{
        function DynamicPageListSP() {
                SpecialPage::SpecialPage("DynamicPageListSP");
                self::loadMessages();
        }

        
		function execute($par) {
		    global $wgOut, $wgRequest, $wgRawHtml, $wgUser;
		    $oldRawHtml = $wgRawHtml;
		    $wgRawHtml = false;         // disable raw html if it's enabled as this could be XSS security risk
		 
		    $mytitle = Title::makeTitle(NS_SPECIAL, "DynamicPageListSP");
            $this->setHeaders();
			//$wgOut->setPageTitle("Special Page: Dynamic Page List");
		 
			$wikitext .=      $wgRequest->getText('wikitext1') ? $wgRequest->getText('wikitext1') : str_replace( "&&", "\n", $par );
		    $wikitext .= "\n".$wgRequest->getText('wikitext2');
		    $wikitext .= "\n".$wgRequest->getText('wikitext3');
		    $wikitext .= "\n".$wgRequest->getText('wikitext4');
		    $wikitext .= "\n".$wgRequest->getText('wikitext5');
		    $wikitext .= "\n".$wgRequest->getText('wikitext6');
		    $wikitext .= "\n".$wgRequest->getText('wikitext7');
		    $cmds = split("\n",$wikitext);
		    $wikitext='';
		    foreach ($cmds as $cmd) {
			    if ($cmd=="") continue;
			    if (preg_match('/=\?/',$cmd)) continue;
			    if (preg_match('/^debug/',$cmd)) 	$wikitext=   $cmd."\n".$wikitext;
			    else 							    $wikitext .= $cmd."\n";
		    } 
	        $action = $mytitle->escapeLocalUrl();
		    if ($wikitext) {
			    $wgOut->addHtml("<table><tr><td>\n");
		        $wgOut->addHTML("<form method='post' action=\"{$action}\">" . 
		                        "<textarea rows=8 name=wikitext1>$wikitext</textarea>" .
		                        "<input type='submit' value='" . wfMsg('dpl2_createreport')."' >" );
				$wgOut->addHtml("&nbsp; &nbsp; <a href=../index.php/Special:DynamicPageListSP>reset</a>" .
		                        "</form>\n");
			    $wgOut->addHtml("</td></tr><tr><td>\n");
		        $wgOut->addHtml($wgOut->parse("<dpl>".$wikitext."\n</dpl>"));
			    $wgOut->addHtml("</td></tr></table>\n");
	            $skin = $wgUser->getSkin();
                // $wgOut->setPageTitle('Dynamic Page Lister');
		    }
		    else {
			    $wikitext1=	   "category   =? cat1|cat2|*cat3|+cat4|.."
			               	."\nnamespace  =? (empty)|Help|Template|Category|.."
			               	."\nlinksto    =? page"
			               	."\ntitlematch =? sqlpattern"
			               	."\nuses       =? page"
			               	."\nredirects  =? true"
			               	."\nminoredits =? exclude"
			               	."\ncategoriesminmax =? min,max"
			               	."\nlinksfrom        =? page"
			               	."\nopenreferences   =? true|[false]"
						    ."\nnotcategory      =? cat1|cat2|.."
			               	."\nnotnamespace     =? (empty)|Help|Template|Category|.."
			               	."\nnotlinksto       =? page"
			               	."\nnottitlematch    =? sqlpattern"
			               	."\nnotuses          =? page"
			               	;
			    $wikitext2=	   "createdby          =? username"
			               	."\nmodifiedby         =? username"
			               	."\nlastmodifiedby     =? username"
			    			."\nfirstrevisionsince =? yyyy/mm/dd"
			               	."\nallrevisionssince  =? yyyy/mm/dd"
			               	."\nlastrevisionbefore =? yyyy/mm/dd"
			               	."\nallrevisionsbefore =? yyyy/mm/dd"
			               	."\nnotcreatedby       =? user"
			               	."\nnotmodifiedby      =? username"
			               	."\nnotlastmodifiedby  =? username"
			    		   	;
			    $wikitext3=    "mode               =? userformat|categories|.."
			    			."\ninclude            =? #chap1,{templ2}ext,section,*"
							."\nlistseparators     =? ,¶* [[%PAGE%¦%TITLE%]],"
							."\nlistseparators     =? {¦class=sortable¶!page¶!chap1¶!chap2¶¦-,¶¦[[%PAGE%¦%TITLE%]],¶¦-,¶¦}"
							."\nsecseparators      =? ¶¦"
							."\nmultisecseparators =? ¶----"
			               	."\nincludematch       =? /parm\s*=\s*value/"
			               	."\nincludemaxlength   =? number"
			               	."\ndominantsection    =? number (refers to 'include=')"
			               	;
			    $wikitext4=	   "shownamespace        =? false"
							."\naddcategories        =? true"
			               	."\naddpagecounter       =? true"
			               	."\naddpagesize          =? true"
			               	."\naddeditdate          =? true"
			               	."\naddfirstcategorydate =? true"
			               	."\naddpagetoucheddate   =? true"
			               	."\nadduser              =? true"
			    			;
			    $wikitext5=    "headingmode     =? H3"
			               	."\nheadingcount    =? true"
			               	."\nhitemattr       =?"
			               	."\nhlistattr       =?"
			               	."\nordermethod     =?"
			               	."\ninlinetext      =?"
							."\nlistattr        =?"
			               	."\nitemattr        =?"
			    			;
			    $wikitext6=	   "count           =? number"
			               	."\noffset          =? number"
			               	."\nrandomcount     =? number"
			               	."\ntitle           =? page"
			               	."\nescapelinks     =? false"
			               	."\nuserdateformat  =? Y M d (D) h:i"
			               	."\ndebug           =? 3"
			    			;
			    $wikitext7=    "resultsheader   =? text"
			               	."\nnoresultsheader =? text"
			    			."\ncolumns         =? number"
			               	."\norder           =? descending"
			               	."\nreplaceintitle  =? /regex/,replacement"
			               	."\ntitlemaxlength  =? number"
		               		."\nrows            =? number"
			               	."\nrowsize         =? number"
			               	."\nrowcolformat    =? cellspacing=20"
			    			;
			               
		        $wgOut->addHTML("<form method='post' action=\"{$action}\">" .
		        				"<table><tr>".
		        				"<td><textarea rows='5' name=\"wikitext1\">$wikitext1</textarea></td>" .
		        				"<td><textarea rows='5' name=\"wikitext2\">$wikitext2</textarea></td>" .
		        				"</tr><tr>".
		        				"<td colspan=2><textarea rows='7' name=\"wikitext3\">$wikitext3</textarea></td>" .
		        				"</tr><tr>".
		                        "<td><textarea rows='5' name=\"wikitext4\">$wikitext4</textarea></td>" .
		                        "<td><textarea rows='5' name=\"wikitext5\">$wikitext5</textarea></td>" .
		        				"</tr><tr>".
		                        "<td><textarea rows='5' name=\"wikitext6\">$wikitext6</textarea></td>" .
		                        "<td><textarea rows='5' name=\"wikitext7\">$wikitext7</textarea></td>" .
		        				"</tr></table>".
		                        "<input type='submit' value='" . wfMsg('dpl2_createreport') . "' />".
		                        " &nbsp; To select a parameter <b>remove the '?'</b> and fill in <b>your arguments</b>!".
		                        " See also the <b><a href='http://semeb.com/dpldemo/index.php/Manual#Parameters' target=dplman>manual</a></b>.</form>\n");
		    }
		 
		    $wgRawHtml = $oldRawHtml;
		}


        function loadMessages() {
                static $messagesLoaded = false;
                global $wgMessageCache;
                if ( $messagesLoaded ) return;
                $messagesLoaded = true;

                require( dirname( __FILE__ ) . '/DynamicPageListSP.i18n.php' );
                foreach ( $allMessages as $lang => $langMessages ) {
                        $wgMessageCache->addMessages( $langMessages, $lang );
                }
        }
}
?>