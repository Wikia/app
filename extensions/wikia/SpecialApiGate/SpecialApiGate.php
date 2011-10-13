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

$wgSpecialPages[ "ApiGate" ] = "SpecialApiGate";
$wgExtensionMessagesFiles['ApiGate'] = dirname( __FILE__ ) . '/SpecialApiGate.i18n.php';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'ApiGate',
	'url' => 'http://lyrics.wikia.com/User:Sean_Colombo',
	'author' => '[http://www.seancolombo.com Sean Colombo]',
	'descriptionmsg' => 'apigate-desc',
	'version' => '1.0',
);


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
		global $wgOut, $wgRequest, $IP, $wgUser;
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
					$data = array('firstName' => '', 'lastName' => '', 'email_1' => '', 'email_2' => '');

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

					$mainSectionHtml = ApiGate_Dispatcher::renderTemplate( $data, "register" );
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

				// TODO: Landing page
				$wgOut->addHTML( "This is where the landing-page will go. It will be state-dependent on the user, their keys, etc.\n" ); // TODO: REMOVE
				// TODO: Landing page

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

} // end class SpecialApiGate
