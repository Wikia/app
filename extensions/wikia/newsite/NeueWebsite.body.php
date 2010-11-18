<?php

class NeueWebsite extends SpecialPage
{
  function NeueWebsite() 
  {
    SpecialPage::SpecialPage("NewWebsite");
  }

  function execute($par) 
  {
    global $wgRequest, $wgOut, $wgUser;

	if ( wfReadOnly() ) {
		$wgOut->readOnlyPage();
		return;
	}

	if ( $wgUser->isBlocked() ) {
		$wgOut->blockedPage( false );
		return;
	}

	wfLoadExtensionMessages( 'Newsite' );

    $newPageRunning = true;

    $post = "<p />
      <form action=\"" . Title::newFromText( $this->getLocalname(), NS_SPECIAL )->getFullUrl() . "\" method=\"get\">
      <b>" . wfMsg( 'newsite-form-label' ) . "</b>
      <input type=\"text\" name=\"param\" size=\"40\" maxlength=\"80\" />
      <input type=\"submit\" value=\"" . wfMsg( 'newsite-form-submit' ) . "\" /> 
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

	# FIXME: Twitter extension dependancy
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

}
