<?php

function kwlink($kw)
{
  $kwu = $kw;
  $kwu{0} = strtoupper($kwu{0});
  return "<a href=\"/Spezial:Keyword/" . htmlspecialchars($kw) . "\">$kwu</a>";
}

class Keyword extends SpecialPage
{
  function Keyword() 
  {
    SpecialPage::SpecialPage("Keyword");
  }

  function execute($par) 
  {
    global $wgRequest, $wgOut;
//    sleep(1);  // throttle ...


    $post = "<p />
      <form action=\"/Spezial:Keyword\" method=\"get\">
      <b>Keyword: </b>
      <input type=\"text\" name=\"kw\" size=\"40\" maxlength=\"80\" />
      <input type=\"submit\" value=\" suchen \" /> 
      </form><p />
      <b>Liste der <a href=\"/Spezial:Keyword?target=common\">h&auml;ufigsten Keywords</a></b><p />";

    $output= "";
    $this->setHeaders();
    $wgOut->setRobotPolicy('index,follow');

    // Google
      $google =  <<<EOG
<table border="1" cellspacing="0" cellpadding="4" style="float:right; margin:0 0 .5em 1em;
     width:260px; background:#fff; border-collapse:collapse; border:1px solid #999;
     font-size:smaller; line-height:1.5; " summary="Anzeigen">
<tr><td align="center" height="250" style="background:#ffffff;">
<script type="text/javascript"><!--
google_ad_client = "pub-6826490085913423";
google_ad_width = 250;
google_ad_height = 250;
google_ad_format = "250x250_as";
google_ad_type = "text";
google_ad_channel = "0080536474";
google_color_border = "F0F0F0";
google_color_bg = "F0F0F0";
google_color_link = "002BB8";
google_color_text = "000000";
google_color_url = "3366BB";
//-->
</script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</td></tr></table>
EOG;

    # Get request data from, e.g.
    $kwp = $wgRequest->getText('kw');
    $tar = $wgRequest->getText('target');
    $doall = $wgRequest->getText('all');
    $kwt = substr(strstr($wgRequest->getVal('title'), "/"), 1);
    $kw = $kwp ? $kwp : $kwt;

    # Do stuff

    $dbr =& wfGetDB( DB_MASTER );

    if($tar == "common")
    {
      $wgOut->setPagetitle( "Häufigste Keywords" );
      $wgOut->addHTML("H&auml;ufigste Keywords:<p><ol>\n");

      $res = $dbr->doQuery("select kw_word, kw_count from kw_keywords order by kw_count desc limit 100");
      while($res && $row = mysql_fetch_row($res))
      {
	$kword = $row[0];
	$kcount = $row[1];
        $output .= "<li>" . kwlink($kword) . " ($kcount)</li>\n";
      }
      $output .= "</ol>\n";
      $wgOut->addHTML( $google.$output );

      return;
    }

    if(!isset($kw) || strlen($kw) < 2)
    {
      $wgOut->addHTML("$post");
      return;
    }

    $keyword = strtolower(trim(str_replace("_", " ", $kw)));
    $gnkeyword = $keyword;
    $keyword{0} = strtoupper($keyword{0});

    $wgOut->setPagetitle( "Keyword $keyword" );

    $kw = $dbr->strencode(strtolower(trim(str_replace("_", " ", $kw))));

    $res = $dbr->doQuery("select count(*) from kw_keywords");
    if($res && $row = mysql_fetch_row($res))
      $diffkeys = $row[0];
    else
    {
      $wgOut->addHTML("Fehler bei der Keywordausz&auml;hlung.");
      return;
    }

    $res = $dbr->doQuery("select kw_count from kw_keywords order by kw_count desc limit 1");
    if($res && $row = mysql_fetch_row($res))
      $maxkeycount = $row[0];
    else
    {
      $wgOut->addHTML("Fehler bei der Keywordausz&auml;hlung.");
      return;
    }

    $res = $dbr->doQuery("select kw_count, kw_id from kw_keywords where kw_word='$kw'");
    if($res && $row = mysql_fetch_row($res))
    {
      $thiskeycount = $row[0];
      $thiskeyid = $row[1];
    }
    else
    {
      $wgOut->addHTML("Das Keyword <i>$keyword</i> wird von keiner Seite im WebsiteWiki verwendet.");
      return;
    }

    $thisrelcomm = round(($thiskeycount / $maxkeycount * 100), 2);

    $output .= "<ul>\n";
    $output .= "<li>Das Keyword <i>$keyword</i> wird $thiskeycount mal auf Websites im WebsiteWiki verwendet.</li>\n";
    $output .= "<li>Suchen von <i><a href=\"http://www.gnomit.com/search/$gnkeyword\">$keyword</a></i> bei <a href=\"http://www.gnomit.com/\">Gnomit</a>.</li>\n";
    $output .= "<li>Seine relative <a href=\"/Spezial:Keyword?target=common\">H&auml;ufigkeit</a> betr&auml;gt $thisrelcomm %.</li>\n";

    $output .= "<li>Verwandte Keywords:</li>\n<li><ul>\n";

    $res = $dbr->doQuery("select kw_page,kw_ptype from kw_page where kw_key = $thiskeyid limit 50;");  // 50 was 100
    $similpages = array();
    $porncount = 0;
    while($res && $row = mysql_fetch_row($res))
    {
      $similpages[] = $row[0];
      $porncount += $row[1];
    }
    // $output .= "<li>npc = $porncount</li>\n";

    $similstring = '(';
    foreach( $similpages as $spage) 
      $similstring .= $spage . ",";

    $similstring .= '0)';
    
    $res = $dbr->doQuery("select kw_word from kw_keywords,kw_page where kw_page in $similstring  and kw_key=kw_id group by kw_key order by count(kw_key) desc limit 15 offset 1");
    while($res && $row = mysql_fetch_row($res))
    {
      $sameword = $row[0];
      $output .= "<li>" . kwlink($sameword) . "</li>\n";
    }
    $output .= "</ul></li>\n";

    if(!$doall && $thiskeycount > 25)
    {
      srand($thiskeyid);
      $off = rand(0, $thiskeycount - 25);
      $ua = "u.a.";
      $alleanz = " [<a href=\"?all=1\">alle anzeigen</a>]";
      $limi = "limit 25 offset $off";
//      sleep(2);  // throttle more ...
    }
    else
    {
      $ua = "";
      $off = 0;
      $alleanz = "";
      $limi = "";
    }

    // randomized, slow $res = $dbr->doQuery("select page_title from kw_page,page where kw_key=$thiskeyid and page_id=kw_page order by rand($thiskeyid) limit 25");

    $res = $dbr->doQuery("select page_title from kw_page,page where kw_key=$thiskeyid and page_id=kw_page $limi");
    $output .= "<li><i>$keyword</i> wird $ua auf folgenden Websites verwendet:$alleanz</li>\n<li><ul>\n";
    while($res && $row = mysql_fetch_row($res))
    {
      $pgtitle = $row[0];
      $output .= "<li><a href=\"/" . htmlspecialchars($pgtitle) . "\">$pgtitle</a></li>\n";
    }
    $output .= "</ul></li>\n";
    $output .= "</ul>\n";

//     $output .= "KW: $kw num $diffkeys this $thiskeycount id $thiskeyid max $maxkeycount\n";

    if($porncount == 0)
      $wgOut->addHTML( $google.$output );
    else
      $wgOut->addHTML( $output );
  }

  function loadMessages() 
  {
	  static $messagesLoaded = false;
	  global $wgMessageCache;
	  if ( $messagesLoaded ) return;
	  $messagesLoaded = true;

	  require( dirname( __FILE__ ) . '/Keyword.i18n.php' );
	  foreach ( $kwallMessages as $lang => $langMessages ) {
		  $wgMessageCache->addMessages( $langMessages, $lang );
	  }
  }
}
?>
