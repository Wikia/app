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
		global $wgOut, $wgRequest, $IP;
		wfProfileIn( __METHOD__ );

		include "$IP/lib/ApiGate/ApiGate.php";

		$wgOut->setPagetitle( wfMsg('apigate') );

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

				// TODO: IMPLEMENT

				print "Registration page here";

				// TODO: IMPLEMENT

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
				print "This is where the landing-page will go. It will be state-dependent on the user, their keys, etc.\n"; // TODO: REMOVE
				// TODO: Landing page

				break;
		}

		wfProfileOut( __METHOD__ );
	} // end execute()

} // end class SpecialApiGate
