<?php

include_once('extensions/twitter.php');

class NeueWebsite extends SpecialPage
{
  function NeueWebsite() 
  {
    SpecialPage::SpecialPage("NeueWebsite");
  }

  function execute($par) 
  {
#    include('/var/www/db/wsinfo.inc'); // get the db connection info

    global $wgRequest, $wgOut, $wgUser;

    sleep(5); // throttle

    $newPageRunning = true;

    $sk = $wgUser->getSkin();

    $post = "<p />
      <form action=\"" . Title::newFromText('Special:NeueWebsite')->getFullUrl() . "\" method=\"get\">
      <b>Neue Website: </b>
      <input type=\"text\" name=\"param\" size=\"40\" maxlength=\"80\" />
      <input type=\"submit\" value=\" anlegen \" /> 
      </form><p />";

    $this->setHeaders();

    # Get request data from, e.g.
    $param = $wgRequest->getText('param');

    # Do stuff

    if(!isset($param) || strlen($param) < 5)
    {
      $wgOut->addHTML("$post");
      return;
    }

    // $output = "Schnapp. ++$param++ ++$par++\n\n";
    $output = neue_website($param);

    if(strpos($output, "wurde angelegt."))
    {
#      $newpage = validate_domain($param);
#      $newpage{0} = strtoupper($newpage{0});
#      $tw = new Twitter('WebsiteWiki', 'Waehhpps1tt');
#      $twstatus = "Neue Website $newpage eingetragen - http://websitewiki.de/$newpage";
#      if(strlen($twstatus <= 140))
#        $tw->updateStatus($twstatus);
    }

    # Output
    $wgOut->addHTML( $output . $post );
  }

  function loadMessages() 
  {
	  static $messagesLoaded = false;
	  global $wgMessageCache;
	  if ( $messagesLoaded ) return;
	  $messagesLoaded = true;

	  require( dirname( __FILE__ ) . '/NeueWebsite.i18n.php' );
	  foreach ( $allMessages as $lang => $langMessages ) {
		  $wgMessageCache->addMessages( $langMessages, $lang );
	  }
  }
}

?>
