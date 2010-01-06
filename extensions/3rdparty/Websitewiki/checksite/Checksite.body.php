<?php

class Checksite extends SpecialPage
{
  function Checksite() 
  {
    SpecialPage::SpecialPage("Checksite");
  }

  function execute($par) 
  {
    global $wgRequest, $wgOut;

    $param = $wgRequest->getText('param');
    $parcheck = $wgRequest->getText('parcheck');

    $post = "<p />
      <form action=\"/Spezial:Checksite\" method=\"get\">
      <ul>
      <li>Mit dieser Spezialseite kann der Screenshot aktualisiert werden. Die Screenshots werden in der Reihenfolge der Anforderung aktualisiert - bei vielen Screenshots kann das etwas dauern. Mehrfache Anforderung beschleunigt den Vorgang nicht.</li>
      <li>Ausserdem wird anhand von robots.txt überprüft, ob der Inhaber einer Website diese für ungeeignet
      hält, im WebsiteWiki diskutiert zu werden.</li>
      </ul>
      <b>Website überprüfen: </b>
      <input type=\"text\" name=\"parcheck\" value=\"$param\" size=\"40\" maxlength=\"80\" />
      <input type=\"submit\" value=\" überprüfen \" /> 
      </form><p />";

    $this->setHeaders();

    # Get request data from, e.g.


//    $output = "Schnapp. ++$param++ ++$parcheck++\n\n";
//    $post .= $output;

    # Do stuff

    if(!isset($parcheck) || strlen($parcheck) < 5)
    {
      $wgOut->addHTML("$post");
      return;
    }

    $newdom = check_validate_domain($parcheck);
    if(!$newdom)
    {
      $parcheck = htmlspecialchars($parcheck);
      $wgOut->addHTML("$parcheck kann nicht überprüft werden.");
      return;
    }

    $newpage = $newdom;
    $newpage{0} = strtoupper($newpage{0});
    // $output .= "newpage: =$newpage= newdom: =$newdom= newhost =$newhost=\n";

    $title = Title::newFromUrl($newpage);
    if(!is_object($title)) 
    {
      $wgOut->addHTML("$newpage kann nicht als Wikipage gefunden werden.");
      return;
    }

    if(!$title->exists())
    {
      $wgOut->addHTML("Die Website <a href=\"/$newpage\">$newpage</a> existiert nicht im WebsiteWiki.");
      return;
    }

    if(nxdomain($newdom))
    {
      $output = "$newpage ist nicht im DNS vorhanden (NXDOMAIN), die Seite wird gelöscht.";
      $article = new Article( $title );
      $article->updateArticle( "#REDIRECT [[Gelöscht]]", 'Redirect: Gelöscht', false, false );
      return;
    }

    $newhost = check_get_host($newdom);
    if(!$newhost)
    {
      $wgOut->addHTML("Die Website $newdom wurde nicht gefunden.");
      return;
    }

    if($rob = fopen("http://$newhost/robots.txt", "r"))
    {
      $txt = fread($rob, 4096);

      while(!feof($rob))
      {
        $txt .= fread($rob, 4096);
	if(strlen($txt) > 20000)
	  break;
      }

      fclose($rob);

//echo "newhost $newhost $rob $txt\n";

      if(eregi("User-agent:[ \t\n]*WebsiteWiki[ \t\r\n]*Disallow:[ \t\r\n]*/", $txt))
      {
	global $wgUser;

        $output = "http://$newhost/robots.txt empfiehlt, $newpage nicht im Websitewiki aufzuführen.";

	$orgUser = $wgUser;
	$wgUser = User::newFromName("Sysop");
	
	$article = new Article( $title );
	$restrict = Array("edit" => "sysop", "move" => "sysop");
	$article->updateRestrictions($restrict, $output);
	$article->updateArticle( "#REDIRECT [[Ungeeignet]]", 'Redirect: Ungeeignet', false, false );

	$wgUser = $orgUser;
	return;
      }
    }

    if(stristr($newhost, "duckshop.de"))
    {
      $wgOut->addHTML("Der Screenshot kann nicht aktualisiert werden.");
      return;
    }

  
    $output = "Der Screenshot von $newpage wird aktualisiert.";

/****** LOCAL
    $oldimg = "/var/www/htdocs.www.websitewiki.de/websites/${newdom[0]}/${newdom[1]}/$newdom.jpg";
    $newimg = "/var/www/htdocs.www.websitewiki.de/websites/${newdom[0]}/${newdom[1]}/$newdom.bak" . time();

//        $output = "new $newimg old $oldimg";

    if(file_exists($oldimg))
      rename($oldimg, $newimg);
    
    $todo = fopen("/var/www/mkwebsites/todo", "a");
    if($todo)
    {
      fputs($todo, "$newdom\n");
      fclose($todo);
    }
******/

    $url = fopen("http://thumbs.websitewiki.de/newthumb.php?name=$newdom", "r");
    fclose($url);

    # Output
    $wgOut->addHTML( $output);
  }

  function loadMessages() 
  {
	  static $messagesLoaded = false;
	  global $wgMessageCache;
	  if ( $messagesLoaded ) return;
	  $messagesLoaded = true;

	  require( dirname( __FILE__ ) . '/Checksite.i18n.php' );
	  foreach ( $allMessages as $lang => $langMessages ) {
		  $wgMessageCache->addMessages( $langMessages, $lang );
	  }
  }
}

function check_validate_domain($dom) 
{
  global $exDomainList;

  $d = strtolower(ltrim(trim($dom)));

  $d = ereg_replace("^http://", "", $d);
  $d = ereg_replace("^www\.", "", $d);

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

  if(!ereg($exDomainList, $d))
    return '';

  return $d;
}

function check_get_host($dom) 
{
  $dnsrec = dns_get_record("www.$dom", DNS_A);
//   print_r($dnsrec);
  if(isset($dnsrec[0]) && array_key_exists('ip', $dnsrec[0]))
    return "www.$dom";

  $dnsrec = dns_get_record($dom, DNS_A);
  if(isset($dnsrec[0]) && array_key_exists('ip', $dnsrec[0]))
    return $dom;

  return '';
}

function nxdomain($dom) 
{
  // popen("dig +noall +comment $dom");
  return false;
}


?>
