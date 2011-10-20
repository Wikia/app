<?php
/**
 * @author Sean Colombo
 * @date 20111001
 *
 * Special page to wrap API Gate
 * @TODO: Better description
 *
 * @ingroup SpecialPage
 */

/**
 * @ingroup SpecialPage
 */
class SpecialApiGate extends SpecialPage {
	private $SUBPAGE_NONE = ""; // basically, the main dashboard
	private $SUBPAGE_CHECK_KEY = "checkKey";
	private $SUBPAGE_REGISTER = "register";
	private $SUBPAGE_ALL_KEYS = "allKeys";
	private $SUBPAGE_USER_KEYS = "userKeys";
	private $SUBPAGE_KEY = "key";
	const API_WIKI_CITYID = "97439";

	public function __construct() {
		parent::__construct( 'ApiGate' );
	}

	/**
	 * @param $subpage Mixed: string if any subpage provided, else null
	 */
	public function execute( $subpage ) {
		global $wgOut, $wgRequest, $IP, $wgUser, $API_GATE_DIR;
		wfProfileIn( __METHOD__ );


		$wgOut->setPagetitle( wfMsg('apigate') );
		
		// Box the main content of the text into a left-column so that a custom menu can be put on the right (below).
		$wgOut->addWikiText( "<mainpage-leftcolumn-start />");

// TODO: Make sure that all subpages (EXCEPT checkKey!) redirect to Api wiki if they're on another wiki (needed for that right-rail template to work & still be community editable - including the images on it).
// TODO: Make sure that all subpages (EXCEPT checkKey!) redirect to Api wiki if they're on another wiki (needed for that right-rail template to work & still be community editable - including the images on it).

		$mainSectionHtml = "";
		$apiKey = $wgRequest->getVal( 'apiKey' );
		switch($subpage){
			case $this->SUBPAGE_CHECK_KEY:

				// TODO: LATER Fill this out so that we can do per-method permissions (there can probably be a static helper-function in ApiGate to assist).
				$requestData = array(); 

				// Will output headers and a descriptive body-message.
				ApiGate::isRequestAllowed_endpoint( $apiKey, $requestData );

				// This sub-age is just for returning headers (http status-codes), etc.
				exit;

				break;
			case $this->SUBPAGE_REGISTER:
				// Users must be logged in to get an API key
				if( !$wgUser->isLoggedIn() ){
					$wgOut->setPageTitle( wfMsg( 'apigate-nologin' ) );
					$wgOut->setHTMLTitle( wfMsg( 'errorpagetitle' ) );
					$wgOut->setRobotPolicy( 'noindex,nofollow' );
					$wgOut->setArticleRelated( false );
					$wgOut->enableClientCache( false );

					$mainSectionHtml .= wfMsg('apigate-nologintext') . "<br/><br/><button type='button' data-id='login' class='ajaxLogin'>" . wfMsg('apigate-login-button') . "</button>";
				} else {
					$mainSectionHtml .= $this->subpage_register();
				}

				break;
			case $this->SUBPAGE_ALL_KEYS:
				$mainSectionHtml .= $this->subpage_allKeys();
				break;
			case $this->SUBPAGE_USER_KEYS:
				$mainSectionHtml .= $this->subpage_userKeys();
				break;
			case $this->SUBPAGE_KEY:
				// Module for key info (it's a form)
				$mainSectionHtml .= $this->subpage_keyInfo();

				// Module for stats (we don't have stats yet so this should just say that for now)
				$mainSectionHtml .= $this->subpage_keyStats();

				break;
			case $this->SUBPAGE_NONE:
			default:
				$mainSectionHtml .= $this->subpage_landingPage();
				break;
		}
		$wgOut->addHTML( "<div id='specialApiGateMainSection'><div class='module'>
			<div style='margin:auto;width:400px;background-color:white'>
				\n$mainSectionHtml\n
			</div>
		</div></div>" );

		// End the main column and add the right-rail.
		$wgOut->addWikiText("<mainpage-endcolumn />
							<mainpage-rightcolumn-start />
							{{MenuRail}}
							<mainpage-endcolumn />");

		wfProfileOut( __METHOD__ );
	} // end execute()

	/**
	 * State-dependent dashboard for when you hit Special:ApiGate with no subpage specified.
	 *
	 * This performs its function by returning HTML.
	 *
	 * @param data - optional associative array where keys are variable names (and values are the values for that variable) to be exported to templates.
	 * @return 
	 */
	public function subpage_landingPage( $data = array() ){
		wfProfileIn( __METHOD__ );
		$html = "";

		// TODO: FIXME: Could this be extracted to all be inside of one template in API Gate (index.php template).  We're not doing any funky logic here.
		// TODO: FIXME: Could this be extracted to all be inside of one template in API Gate (index.php template).  We're not doing any funky logic here.

		// Show intro-blurb.
		$html .= ApiGate_Dispatcher::renderTemplate( "intro" );

		// If the user has at least one API key, show the userKeys subpage.
		$userId = ApiGate_Config::getUserId();
		$keys = ApiGate::getKeysByUserId( $userId );
		if( count($keys) > 0 ){
			$html .= $this->subpage_userKeys( $userId, $keys );
		} else {
			// If the user doesn't have any keys yet, show the registration form front-and-center.
// TODO: TEST THAT THE FORM-PROCESSING WORKS EVEN WHEN NOT ON THE /register SUBPAGE.
			$html .= $this->subpage_register();
		}
		
		wfProfileOut( __METHOD__ );
		return $html;
	} // end subpage_landingPage()

	public function subpage_register(){
		global $wgUser, $wgOut, $API_GATE_DIR;
		wfProfileIn( __METHOD__ );
		$html = "";

		// Users must be logged in to get an API key
		if( !$wgUser->isLoggedIn() ){
			$html .= wfMsg('apigate-nologintext') . "<br/><br/><button type='button' data-id='login' class='ajaxLogin'>" . wfMsg('apigate-login-button') . "</button>";
		} else {
			$data = array('firstName' => '', 'lastName' => '', 'email_1' => '', 'email_2' => '', 'errorString' => '');

			// If the user's real name is in their profile, split it up and use it to initialize the form.
			$name = $wgUser->getName();
			$index = strpos($name, " ");
			if($index === false){
				$data['firstName'] = $name;
				$data['lastName'] = "";
			} else {
				$data['firstName'] = substr($name, 0, $index);
				$data['lastName'] = substr($name, $index+1);
			}

			// If the user has an email address set, use it to pre-populate the form.
			$data['email_1'] = $wgUser->getEmail();
			$data['email_2'] = $data['email_1'];

			include "$API_GATE_DIR/ApiGate_Register.class.php";
			$registered = ApiGate_Register::processPost( $data );
			if( $registered ) { // TODO: Not portable. This works well here, but more work would need to be done for API Gate to have a good default behvaior.
				// Display a success message containing the new key.
				$msg = wfMsgExt( 'apigate-register-success', array('parse'), array( $data['apiKey'] ) );
				$msg .= "<br/><br/>" . wfMsgExt( 'apigate-register-success-return', array('parse'), array() );
				$html .=  ApiGate_Dispatcher::renderTemplate( "success", array('message' => $msg) );

				// TODO: I'm not sure I like this.  It makes the URL different from what's shown.  Perhaps get rid of it?
				// $html .= $this->subpage_landingPage( $data );

			} else {
				$html .=  ApiGate_Dispatcher::renderTemplate( "register", $data );
			}
		}

		wfProfileOut( __METHOD__ );
		return $html;
	}

	public function subpage_allKeys(){
	
		// TODO: IMPLEMENT
		// TODO: IMPLEMENT

	
	} // end subpage_allKeys()
	
	/**
	 * Shows a small module of the API keys for the user provided.  If no user is provided, uses the currently logged in user.
	 *
	 * Allows explicitly specifying the keys (for performance reasons, if you've already looked them up).
	 *
	 * @param userId - mixed - (optional) userId of the user whose keys should be shown. If null or not provided, then it will use
	 *                 the currently logged in user.
	 * @param keys - array - (optional) array of keys for the user.  If provided, this will be assumed to be the correct list of keys
	 *               so they will not be looked up from the database using the userId provided (or the default user as described in userId's
	 *               param documentation above.
	 */
	public function subpage_userKeys( $userId=null, $keys=null ){
		wfProfileIn( __METHOD__ );

		if($userId == null){
			$userId = ApiGate_Config::getUserId();
		}
		if($keys == null){
			$keys = ApiGate::getKeysByUserId( $userId );
		}

// TODO: SWITCH TO USING ApiGate template.
		ob_start();
		if(count($keys) > 0){
			print "<ul>";
			foreach($keys as $apiKey){
				print "<li>$apiKey</li>\n";
			}
			print "</ul>\n";
		} else {
// TODO: message & link to register
print "No API keys for current user yet."; // TODO: CHANGE TO i18n MESSAGE w/link!
// TODO: message & link to register
		}
		
		$html = ob_get_clean();

		wfProfileOut( __METHOD__ );
		return $html;
	} // end subpage_userKeys()

	public function subpage_keyInfo( $apiKey ){

		// TODO: IMPLEMENT
		// TODO: IMPLEMENT

	} // end subpage_keyInfo()

	public function subpage_keyStats( $apiKey ){

		// TODO: IMPLEMENT
		// TODO: IMPLEMENT

	} // end subpage_keyStats()

	/**
	 * @brief Hook to add API Gate to user links.
	 */
	public static function onPersonalUrls(&$personalUrls, &$title) {
		wfProfileIn( __METHOD__ );
		
		if( SpecialApiGate::shouldShowUserLink() ) {
			$personalUrls['apiGate']['href'] = SpecialPage::getTitleFor("ApiGate")->getFullURL();
			$personalUrls['apiGate']['text'] = wfMsg( 'apigate-userlink' );
		}

		wfProfileOut( __METHOD__ );
		return true;
	} // end onPersonalUrls()
	
	/**
	 * Hook for adding API Gate user link (which was added to personalUrls by onPersonalUrls()) to the Oasis user-links dropdown.
	 */
	public static function onAccountNavigationModuleAfterDropdownItems(&$dropdownItems, $personalUrls){
		wfProfileIn( __METHOD__ );

		if( SpecialApiGate::shouldShowUserLink() ) {
			$dropdownItems[] = 'apiGate';
		}

		wfProfileOut( __METHOD__ );
		return true; // a hook function's way of saying it's okay to continue
	} // end onAccountNavigationModuleAfterDropdownItems()

	/**
	 * The user link only makes sense for users with an API key (with one exception: we'll make it show up for ALL users while they're on the Wikia API wiki).
	 *
	 * @return bool - true if the currently logged in user should see the link to API Gate in their user-links on this page.
	 */
	public static function shouldShowUserLink(){
		global $wgCityId, $wgUser;
		wfProfileIn( __METHOD__ );
		
		$showLink = false;
		if($wgCityId == self::API_WIKI_CITYID){
			$showLink = true;
		} else {
			$apiKeys = ApiGate::getKeysByUserId( $wgUser->getId() );
			if( count( $apiKeys ) > 0 ){
				$showLink = true;
			}
		}

		wfProfileOut( __METHOD__ );
		return $showLink;
	} // end shouldShowUserLink()

} // end class SpecialApiGate
