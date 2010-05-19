<?php

// this is to be able to pull related websites feed
ini_set("user_agent",  "");
require_once( "$IP/extensions/wikia/newsite/NeueWebsiteJob.php" );


function neue_website( $nws ) {
	global $wgUser, $wgOut;

	// $output = "Schnapp. ++$nws++\n\n";
	$output = "";

	if( stristr($nws, "fuerbesucher.net" ) ||
		stristr($nws, "blogspot.com" ) ||
		stristr($nws, "4visitors.net" ) )
	{
		$nws = htmlspecialchars($nws);
		$output = wfMsg( 'newsite-error-invalid', $nws );
		return $output;
	}

	$newdom = validate_domain( $nws );
	if( !$newdom ) {
		$nws = htmlspecialchars($nws);
		$output = wfMsg( 'newsite-error-invalid', $nws );
		return $output;
	}

	$newhost = get_host($newdom);
	if( !$newhost ) {
		$output = wfMsg( 'newsite-error-notfound', $newdom );
		return $output;
	}

	$newpage = $newdom;
	$newpage{0} = strtoupper($newpage{0});

	$title = Title::newFromUrl($newpage);
	if( !is_object( $title ) ) {
		$output = wfMsg( 'newsite-error-invalid', $newdom );
		return;
	}

	if( $title->exists( ) ) {
		$output = wfMsg( 'newsite-error-exists', $title->getText(), $title->getFullUrl() );
		return $output;
	}

	/**
	 * get related sites as job
	 */
	if( !wfReadOnly() ) {
		$job = new NeueWebsiteJob( $title, array( "domain" => $newhost, "key" => $newdom ) );
		$job->insert();
	}

	/**
	 * make_related($dbw, $newhost, $newdom);
	 */

	$dbw = wfGetDB( DB_MASTER );
	if( !get_content( $newhost ) ) {
		$output = wfMsg( 'newsite-error-nocontact', $newhost );
		return $output;
	}

	$wikitext = get_wikitext($dbw, $newhost, $newdom);
	if( !$wikitext ) {
		$output = wfMsg( 'newsite-error-nowikitext', $newhost );
		return $output;
	}

	# FIXME: is this needed? messes with skin, among other things
	# if(!is_object($wgUser) || User::isIP($wgUser->getName()))
	#   $wgUser = User::newFromName('Anonym');

	$article = new Article( $title );
	$article->doEdit( WSINFO_PLACEHOLDER . "\n" . $wikitext, wfMsg( 'newsite-edit-comment' ) );

	$armor = substr(md5($newdom), 0,16) . 'WsWImG=' . $newdom . "=no=Ws3ik1Ju5ch=" . substr(md5($newdom), 16);
	$crypt = strtr(trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, 'WsImgS33CCrret', $armor, MCRYPT_MODE_ECB,
		mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)))), '+/', '-!');

	$url = fopen("http://thumbs.websitewiki.de/$crypt", "r");
	fclose($url);

	// redirect on success!
	$wgOut->redirect( $title->getFullURL() );
}


function validate_domain($dom)
{
  global $exDomainList;

  $d = strtolower(ltrim(trim($dom)));

  $d = eregi_replace("^http://", "", $d);
  $d = eregi_replace("^(www\.)+", "", $d);

  if($p = strpos($d, ' '))
    $d = substr($d, 0, $p);
  if($p = strpos($d, '/'))
    $d = substr($d, 0, $p);

  if(ereg("[^-0-9.a-z]", $d))
    return '';
  if(ereg("^[-.]", $d))
    return '';
  if(ereg("\.\.", $d))
    return '';

#  if(!ereg($exDomainList, $d))
#    return '';

  return $d;
}

function get_host($dom) {
	$dnsrec = @dns_get_record("www.$dom", DNS_A);
	if( isset( $dnsrec[0] ) && array_key_exists( 'ip', $dnsrec[0] ) ) {
		return "www.$dom";
	}

	$dnsrec = @dns_get_record($dom, DNS_A);
	if( isset( $dnsrec[0] ) && array_key_exists( 'ip', $dnsrec[0] ) ) {
		return $dom;
	}

	return '';
}


function Substrings($text, $openingMarker, $closingMarker)
{
  $openingMarkerLength = strlen($openingMarker);
  $closingMarkerLength = strlen($closingMarker);

  $result = array();
  $position = 0;
  while (($position = strpos($text, $openingMarker, $position)) !== false) {
    $position += $openingMarkerLength;
    if (($closingMarkerPosition = strpos($text, $closingMarker, $position)) !== false) {
      $result[] = substr($text, $position, $closingMarkerPosition - $position);
      $position = $closingMarkerPosition + $closingMarkerLength;
    }
  }
  return $result;
}


function make_related($dbw, $dom, $domdom)
{
  global $exDomainList;
  $gourl = "http://www.google.de/ie?safe=off&q=related%3A$dom&hl=de&start=0&num=30&sa=N";

//    echo $gourl;

  $gofp = @fopen($gourl, "r");
  $go = @fread($gofp, 10240);
  $go = $go.fread($gofp, 10240);
  $go = $go.fread($gofp, 10240);
  $go = $go.fread($gofp, 10240);
  $go = $go.fread($gofp, 10240);
  fclose($gofp);

  if(!strstr($go, "keine mit Ihrer Suchanfrage"))
  {
//     echo "FOUND $dom ... $go\n";

    $matches = array();
    $newmatches = array();
    $matches = Substrings($go, 'http://', '/');

//      var_dump($matches);

    foreach($matches as $match)
    {
      $n = strtolower($match);
      if(!strncmp($n, "www.", 4))
      {
	$n = substr($n, 4);
        if(ereg($exDomainList, $n) && stripos($n, "google") === false)
	  $newmatches[] = $n;
      }
    }

    $umatches = array_unique($newmatches);

    foreach($umatches as $match) {
	// echo "match: $dom $match ---";
	wfWaitForSlaves( 5 );
	$qr = $dbw->query("insert into related set name1='$domdom', name2='$match'");
	// hope it works
    }
  }
  // else
  //   echo "NIX FOUND $dom\n";
}

function get_content($host)
{
  system(escapeshellcmd("/var/www/mkwebsites/bin/mkhtml $host"), $ret);
  if($ret == 0)
    return true;
  else
    return false;
}

// --- mkwiki

  function stringrpos($haystack,$needle,$offset=NULL)
  {
    if (strpos($haystack,$needle,$offset) === FALSE)
      return FALSE;

    return strlen($haystack)
           - strpos( strrev($haystack) , strrev($needle) , $offset)
           - strlen($needle);
  }

  function getservertech($log)
  {
    $ret = array();

    $lastsec = substr($log, stringrpos($log, 'HTTP request sent'));
    $start = stristr($lastsec, 'Server: ');
    $sline = substr($start, 8, strpos($start, "\n") - 8);

    $tok = strtok($sline, " ");

    while ($tok !== false)
    {
       $ret[] = $tok;
       $tok = strtok(" ");
    }

    // echo " lastsec $lastsec";
    // echo $start;

    return $ret;
  }

  function uridomain($uri)
  {
    $ret = "";
    $off = 0;

    if(!strncasecmp($uri, "www.", 4))
      $off = 4;

    // echo "lline $lline off $off\n";

    $send = strpos($uri, "/");
    $cend = strpos($uri, ":");
    $qend = strpos($uri, "?");

    $end = 9999;
    if($send > 0)
      $end = $send;

    if($cend > 0)
      $end = min($end, $cend);

    if($qend > 0)
      $end = min($end, $qend);


    if($end > 0 && $end < 9999)
      $ret = substr($uri, $off, $end - $off);
    else
      $ret = substr($uri, $off);

    if(strlen($ret) < 4)
      return "";

    return $ret;
  }


	/**
	 * check if theres location line in log stream
	 */
	function getredir( $log, $site ) {
		if( $lastloc = substr( $log, stringrpos( $log, ' Location: http://') ) ) {
			$start = stristr( $lastloc, ' Location: http://' );
			$lline = substr( $start, 18, strpos( $start, "\n" ) - 18 );
			$lline = uridomain( $lline );
			if( strtolower( $lline ) !== strtolower( $site ) ) {
				return $lline;
			}
		}
		return "";
	}

  function geterror($log)
  {
    if($lastloc = substr($log, stringrpos($log, ' HTTP/1')))
    {
      if(eregi("HTTP/1.. (4[0-9][0-9] [^\n]*\n)", $lastloc, $errco))
        return $errco[1];
    }

    return "";
  }

  function has_iso_umlauts($str)
  {
    return ereg("[\344\366\374\304\326\334\337]", $str);
  }

  function de_iso($str)
  {
    if(has_iso_umlauts($str))
      return utf8_encode($str);
    else
      return $str;
  }

  function webclean($str, $cset) {
	  $cset = strtoupper( $cset );

	  if ( $cset != "UTF-8" ) {
		  $str = @iconv( $cset, "UTF-8//IGNORE", $str );
	  }

	  $str = eregi_replace("<[^>]*>|[]\001-\037{}\\[]", " ", $str);
	  $str = ereg_replace("[ ]+", " ", $str);
	  $str = html_entity_decode($str, ENT_QUOTES, "utf-8");
	  $str = htmlspecialchars($str, ENT_QUOTES, "utf-8");
	  return $str;
  }

  function wikilink($str, $lower=true)
  {
    $str = trim($str);
    if($lower)
      $str = strtolower($str);
    $str{0} = strtoupper($str{0});
    return "[[$str]]";
  }

  function trimnl($str)
  {
    if(($pos = strpos($str, "\r")) || ($pos = strpos($str, "\n")) )
       return trim(substr($str, 0, $pos));
    else
       return trim($str);
  }

  function gettitle($web)
  {
    if(eregi("<title>([^<]*)</title>", $web, $tit))
      return trimnl($tit[1]);
    else
      return false;
  }

  function getdesc($web)
  {
    if(eregi("<META[^>]*name=\"description\"[^>]*content=\"([^\"]*)\"[^>]*>", $web, $desc) ||
       eregi("<META[^>]*content=\"([^\"]*)\"[^>]*name=\"description\"[^>]*>", $web, $desc))
      return trimnl($desc[1]);
    else
      return false;
  }

  function getkeys($web)
  {
    if(eregi("<META[^>]*name=\"keywords\"[^>]*content=\"([^\"]*)\"[^>]*>", $web, $keys) ||
       eregi("<META[^>]*content=\"([^\"]*)\"[^>]*name=\"keywords\"[^>]*>", $web, $keys))
      return trimnl($keys[1]);
    else
      return false;
  }

  function getgenerator($web)
  {
    if(eregi("<META[^>]*name=\"generator\"[^>]*content=\"([^\">\n]*)\"[^>\n]*>", $web, $gens) ||
       eregi("<META[^>]*content=\"([^\">\n]*)\"[^>\n]*name=\"generator\"[^>]*>", $web, $gens))
      return trimnl(de_iso($gens[1]));
    else
      return false;
  }

  function getcharset($web) {
    if(preg_match("|<META[^>]*http-equiv=['\"]?Content-Type['\"]?[^>]*content=[\"']([^\"']*)[\"'][^>]*>|i", $web, $desc) ||
       preg_match("|<META[^>]*content=[\"']([^\"']*)[\"'][^>]*http-equiv=[\"']?Content-Type[\"']?[^>]*>|i", $web, $desc) ||
       // geez, this is stupid...
       preg_match("|<META[^>]*http-equiv=['\"]?Content-Style-Type['\"]?[^>]*content=[\"']([^\"']*)[\"'][^>]*>|i", $web, $desc)
	) {
      // echo "ctype ===${desc[1]}===\n";
      if(eregi("charset=([a-zA-Z0-9-]+)", $desc[1], $cset))
        return trimnl(strtoupper($cset[1]));
    }
    else
      return "iso-8859-1";
  }

  function getmetaredir($web)
  {
    if(eregi("<META[^>]*http-equiv=\"Refresh\"[^>]*content=\"[^uU]*url=http://([^\"]*)\"[^>]*>", $web, $desc) ||
       eregi("<META[^>]*content=\"[^uU]*url=http://([^\"]*)\"[^>]*http-equiv=\"Refresh\"[^>]*>", $web, $desc))
    {
      return uridomain($desc[1]);
    }
  }

  function stristr_array($str, $arr)
  {
    foreach($arr as $match)
      if(stristr($str, $match))
        return true;

    return false;
  }

  function getrelated($dom, $dbw)
  {
    $rela = array();
    $qr = $dbw->query("select name1, name2 from related where name1='$dom' or name2='$dom'");
    $res = $qr->result;
    if($res)
    {
      while ($row = mysql_fetch_row($res))
      {
	if($row[0] != $dom)
	  $rela[] = $row[0];
	if($row[1] != $dom)
	  $rela[] = $row[1];
      }
    }
    $relu = array_unique($rela);
    asort($relu);

    return $relu;
  }


function get_wikitext($dbw, $site, $domsite)
{

  $baustellen_texte = Array(
    "Neue Internetpr",
    "hier entsteht",
    "gerade freigeschaltet",
    "soeben freigeschaltet",
    "domain holding page",
    "hier entsteh",
    "under construction",
  );

  $parking_texte = Array(
    "ageweco.de",
    "alias.teldo3.com",
    "cool-domain.de",
    "domaindevil.de",
    "domainkompetenz.de",
    "easydoor.de",
    "financeinvest.com",
    "finden.net",
    "information.de",
    "kreditescout.de",
    "ndparking.de",
    "ndparking.com",
    "netzerfolg.de",
    "onlineservice.de",
    "park.ireit.com",
    "promotion.partnercash.de",
    "sedo.com",
    "sedo.de",
    "sedoparking.com",
    "sedoparking.de",
  );

  $empty_redir = Array(
    "leere.seite",
    "localhost",
  );

  $erotik_texte = Array(
    "porn",
    "sex",
    "xxx",
    "lesb",
    "gay",
    "schwul",
    "teen",
    "lolita",
    "eroti",
    "adult",
    "voyeur",
    "hardcore",
    "pussy",
    "titt",
    "tits",
    "nude",
    "nackt",
    "versau",
    "fick",
    "fuck",
    "tabulos",
    "swinger",
    "votze",
  );

  $htcontent = "";
  $locontent = "";
  $hfp = false;
  $lfp = false;

  $title = "";
  $parking = false;
  $empty = false;
  $weberror = "";
  $baustelle = false;
  $verkauf = false;
  $erotik = false;
  $empty = false;
  $redir = "";
  $servertech = "";
  $system = "";
  $server = "";
  $title = "";
  $description = "";
  $keywords = "";
  $generator = "";
  $metaredir = "";
  $framesets = false;
  $iframes = false;
  $scripts = false;
  $charset = "iso-8859-1";
  $related = Array();
  $output = "";
  $newpage = $domsite;
  $newpage{0} = strtoupper($newpage{0});

  $hfile="/var/www/mkwebsites/html/$site";

  if(file_exists("$hfile.html"))
    $hfp = fopen("$hfile.html", "r");
  if(file_exists("$hfile.log"))
    $lfp = fopen("$hfile.log", "r");

  // echo "hfp $hfp lfp $lfp";

  if($hfp && $lfp)
  {
    // get it

    if(filesize("$hfile.html"))
      $htcontent = fread($hfp, filesize("$hfile.html"));
    else
      $empty = true;
    $locontent = fread($lfp, filesize("$hfile.log"));

    fclose($hfp);
    fclose($lfp);

    // servertech

    $servertech = getservertech($locontent);

    $weberror = trim(geterror($locontent));

    if($servertech)
    {
      if(isset($servertech[1]) && ereg("\(([^)/]*)[/)]", $servertech[1], $osses))
	$system = $osses[1];

      if(stristr($servertech[0], "apache"))
      {
	$server = "Apache";
      }
      else
      {
	if($pos = strpos($servertech[0], '/'))
	{
	  $server = substr($servertech[0], 0, $pos);
	}
	else
	  $server = $servertech[0];
	// echo "raw ${servertech[0]} -> $server\n";
      }

      if(!$system && stristr($server, "Microsoft"))
	$system = "Windows";
    }


    if($htcontent)
    {
      $title = gettitle($htcontent);
      $description = getdesc($htcontent);
      $keywords = getkeys($htcontent);
      $generator = getgenerator($htcontent);
      $charset = getcharset($htcontent);
      $metaredir = getmetaredir($htcontent);

      $baustelle = stristr_array($title . $description, $baustellen_texte);
      $verkauf = stristr($title, "zu verkaufen");
    }

    $redir = getredir( $locontent, $site );
    if(!$redir)
      $redir = $metaredir;

    if(!strcasecmp($redir, $site))
      $redir = "";

    if($redir)
      $parking = stristr_array($redir, $parking_texte);

    if(!$empty && $redir)
      $empty = stristr_array($redir, $empty_redir);

    // echo "$site allredir $redir parking=$parking empty=$empty\n";

    $erotik = stristr_array($title . $description . $site . $redir, $erotik_texte);

    if(stristr($htcontent, "<frameset"))
      $framesets = true;

    if(stristr($htcontent, "<iframe"))
      $iframes = true;

    if(stristr($htcontent, "<script"))
      $scripts = true;


    // OUTPUT
    $wtitle = webclean($title, $charset);

    if($title && !empty( $wtitle )) {
      if(strstr($wtitle, "ist zu verkaufen"))
	$wtitle = ereg_replace("ist zu verkaufen",
	    "[http://www.sedo.de/checkdomainoffer.php4?partnerid=13318&amp;domain=$site ist zu verkaufen]", $wtitle);
      $output .= "'''" . $wtitle . "'''\n\n";
    }

    $wdescription = webclean($description, $charset);
    if( !empty( $wdescription ) && strcmp($description, $title) )
      $output .= wfMsgForContent( 'newsite-output-description' ) . "\n" . $wdescription . "\n\n";

    if($weberror || $baustelle || $empty || $redir || $parking || $verkauf)
    {
      $output .= wfMsgForContent( 'newsite-output-status' ) . "\n";
      if($weberror)
	$output .= wfMsgForContent( 'newsite-output-status-error', wikilink($weberror) ) . "\n";
      if($baustelle)
	$output .= wfMsgForContent( 'newsite-output-status-under-construction' ) . "\n";
      if($verkauf)
	$output .= wfMsgForContent( 'newsite-output-status-forsale' ) . "\n";
      if($empty)
	$output .= wfMsgForContent( 'newsite-output-status-empty' ) . "\n";
      if($redir)
	$output .= wfMsgForContent( 'newsite-output-status-redir', wikilink($redir) ) . "\n";
      if($parking)
	$output .= wfMsgForContent( 'newsite-output-status-parked' ) . "\n";
    }

    $output .= wfMsgForContent( 'newsite-output-technology' ) . "\n";
    $output .= wfMsgForContent( 'newsite-output-technology-content' ) . "\n";
    if($framesets)
      $output .= wfMsgForContent( 'newsite-output-technology-content-framesets' ) . "\n";
    if($iframes)
      $output .= wfMsgForContent( 'newsite-output-technology-content-iframes' ) . "\n";
    if($scripts)
      $output .= wfMsgForContent( 'newsite-output-technology-content-scripts' ) . "\n";
    $output .=  wfMsgForContent( 'newsite-output-technology-content-charset', wikilink($charset) ) . "\n";
    if($generator)
    {
#	FIXME: German only hack
#     $generator = eregi_replace("f[^r]*r windows", "for windows", $generator);
      $output .= wfMsgForContent( 'newsite-output-technology-content-generator', wikilink($generator) ) . "\n";
    }

    if(count($servertech) > 2 || $system || $server)
    {
      $output .= wfMsgForContent( 'newsite-output-technology-server' ) . "\n";
      if($server)
	$output .= wfMsgForContent( 'newsite-output-technology-server-webserver', wikilink($server, false) ) . "\n";
      if($system)
	$output .= wfMsgForContent( 'newsite-output-technology-server-os', wikilink($system) ) . "\n";
      if(count($servertech) > 2)
      {
	$output .= wfMsgForContent( 'newsite-output-technology-server-components' ) . "\n";
	for($i = 2; $i < count($servertech); $i++)
	  if(!strpos($servertech[$i], ')') && strcasecmp($servertech[$i], "with"))
	  {
	    if($pos = strpos($servertech[$i], '/'))
	      $tech = substr($servertech[$i], 0, $pos);
	    else
	      $tech = $servertech[$i];

	    $output .= "**" . wikilink($tech, false) . "\n";
	  }
      }
    }

    if($keywords)
    {
      $kommas = substr_count($keywords, ",");
      $spaces = substr_count($keywords, " ");
      if($kommas < (2 * $spaces))
	$tokki = ", ";
      else
	$tokki = ",";

//	echo "kommas $kommas spaces $spaces\n";

      $wkeywords = webclean($keywords, $charset);
      if ( !empty( $wkeywords ) ) {
	      $output .= wfMsgForContent( 'newsite-output-keywords', $newpage ) . "\n<keywords>";
	      $ktok = strtok($wkeywords, $tokki);

	      while ($ktok !== false) {
		      $output .= trim($ktok);
		      $ktok = strtok($tokki);
		      if($ktok !== false)
			      $output .= ", ";
	      }
	      $output .= "</keywords>\n";
      }
    }

    $output .= Xml::openElement( "nws:related" );
	$output .= Xml::closeElement( "nws:related" );

    # add category
    if($erotik)
      $initialCategory = wfMsgForContent( 'newsite-category-erotic' );
    else
      $initialCategory = wfMsgForContent( 'newsite-category-default' );

    global $wgContLang;

    $output .= '[[' . $wgContLang->getNsText(NS_CATEGORY) . ':' . $initialCategory . ']]';

    return $output;
  }

  return "";
}

// -- end mkwiki
