<?php
class LiveDelegationHandler extends SpecialPage {
	
	function LiveDelegationHandler(){
		UnlistedSpecialPage::UnlistedSpecialPage("LiveDelegationHandler");
	}
	
	function execute(){
		
		global $IP, $wgOut, $wgLiveAPIApplicationKey;
		
		$wgOut->setArticleBodyOnly(true);
		
		require_once( "$IP/extensions/wikia/WikiContacts/live_lib/windowslivelogin.php" );
		$COOKIE = "delauthtoken";
		$COOKIETTL = time() + (10 * 365 * 24 * 60 * 60);
		
		// Initialize the WindowsLiveLogin module.
		$wll = WindowsLiveLogin::initFromXml($wgLiveAPIApplicationKey);
		$wll->setDebug(false);
		
		// Extract the 'action' parameter, if any, from the request.
		$action = @$_REQUEST['action'];
		
		if ($action == 'delauth') {
		  $consent = $wll->processConsent($_REQUEST);
		
		  if ($consent) {
	            $rawtoken = $consent->getToken();
		    setcookie($COOKIE,  $rawtoken, $COOKIETTL, "/");
		  }
		  else {
		    setcookie($COOKIE);
		  }
		}
		
		//Get the consent URL for the specified offers.
		$consenturl = $wll->getConsentUrl("Contacts.View");
		
		// If the raw consent token has been cached in a site cookie, attempt to
		// process it and extract the consent token.
		$message_html = "<p>Please <a href=\"$consenturl\">click here</a> to grant consent 
				 for this application to access your Windows Live data.</p>";
		
		
	
		if ($rawtoken) {
		    $token = $wll->processConsentToken($rawtoken);
		}
		 
		if ($token && !$token->isValid()) {
		    $token = null;
		}
		
		if ($token) {
		    // Convert Unix epoch time stamp to user-friendly format.
		    $expiry = $token->getExpiry();
		    $expiry = date(DATE_RFC2822, $expiry);
		  
		    global $wgProfileJSONPath;
		    
		    // Prepare the message to display the consent token contents.
		    $message_html = "<script>
		    window.location='{$wgProfileJSONPath}/JSON/msform.html'
		    </script>";
		 
		}
		
		$wgOut->addHTML( $message_html );

	}
}


?>
