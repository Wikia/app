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

if ( !defined( 'MEDIAWIKI' ) ) die();

$API_GATE_DIR = "$IP/lib/ApiGate";

$wgSpecialPages[ "ApiGate" ] = "SpecialApiGate";
$wgExtensionMessagesFiles['ApiGate'] = dirname( __FILE__ ) . '/SpecialApiGate.i18n.php';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'ApiGate',
	'url' => 'http://lyrics.wikia.com/User:Sean_Colombo',
	'author' => '[http://www.seancolombo.com Sean Colombo]',
	'descriptionmsg' => 'apigate-desc',
	'version' => '1.0',
);

$wgHooks['PersonalUrls'][] = "SpecialApiGate::onPersonalUrls";
$wgHooks['AccountNavigationModuleAfterDropdownItems'][] = "SpecialApiGate::onAccountNavigationModuleAfterDropdownItems";


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

	public function __construct() {
		parent::__construct( 'ApiGate' );
	}

	/**
	 * @param $subpage Mixed: string if any subpage provided, else null
	 */
	public function execute( $subpage ) {
		global $wgOut, $wgRequest, $IP, $wgUser, $API_GATE_DIR;
		wfProfileIn( __METHOD__ );

		include "$IP/lib/ApiGate/ApiGate.php";

		$wgOut->setPagetitle( wfMsg('apigate') );
		
		// Box the main content of the text into a left-column so that a custom menu can be put on the right (below).
		$wgOut->addWikiText( "<mainpage-leftcolumn-start />");

// TODO: Make sure that all subpages (EXCEPT checkKey!) redirect to Api wiki if they're on another wiki (needed for that right-rail template to work & still community editable - including the images on it).
// TODO: Make sure that all subpages (EXCEPT checkKey!) redirect to Api wiki if they're on another wiki (needed for that right-rail template to work & still community editable - including the images on it).

		$mainSectionHtml = "";
		$apiKey = $wgRequest->getVal( 'apiKey' );
		switch($subpage){
			case $this->SUBPAGE_CHECK_KEY:

				// TODO: Fill this out so that we can do per-method permissions.
				$requestData = array(); 
				// TODO: Fill this out so that we can do per-method permissions.

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
						$mainSectionHtml .=  ApiGate_Dispatcher::renderTemplate( array('message' => $msg), "success" );

						// TODO: I'm not sure I like this.  It makes the URL different from what's shown.  Perhaps get rid of it?
						// $mainSectionHtml .= $this->subpage_landingPage( $data );

					} else {
						$mainSectionHtml .=  ApiGate_Dispatcher::renderTemplate( $data, "register" );
					}
				}

				break;
			case $this->SUBPAGE_ALL_KEYS:

				// TODO: IMPLEMENT
				// TODO: IMPLEMENT

				break;
			case $this->SUBPAGE_USER_KEYS:

				// TODO: IMPLEMENT
				// TODO: IMPLEMENT

				break;
			case $this->SUBPAGE_KEY:

				// TODO: IMPLEMENT
				// TODO: IMPLEMENT

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
		global $wgOut;
		wfProfileIn( __METHOD__ );

		$wgOut->addHTML( "This is where the landing-page will go. It will be state-dependent on the user, their keys, etc.\n" ); // TODO: REMOVE

		wfProfileOut( __METHOD__ );
	} // end subpage_landingPage()

	/**
	 * @brief Hook to add API Gate to user links.
	 */
	public static function onPersonalUrls(&$personalUrls, &$title) {
		wfProfileIn( __METHOD__ );
		
		$personalUrls['apiGate']['href'] = "";
		$personalUrls['apiGate']['text'] = "API Control Panel";
		
		wfProfileOut( __METHOD__ );
		return true;
	} // end onPersonalUrls()
	
	/**
	 * Hook for adding API Gate user link (which was added to personalUrls by onPersonalUrls()) to the Oasis user-links dropdown.
	 */
	public static function onAccountNavigationModuleAfterDropdownItems(&$dropdownItems, $personalUrls){
		wfProfileIn( __METHOD__ );
		
		$dropdownItems[] = 'apiGate';
	
		wfProfileOut( __METHOD__ );
		return true; // a hook function's way of saying it's okay to continue
	} // end onAccountNavigationModuleAfterDropdownItems()

} // end class SpecialApiGate
