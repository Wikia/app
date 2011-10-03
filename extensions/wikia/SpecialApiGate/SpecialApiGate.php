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
	private $AUTH_SUBPAGE = "checkKey";

	public function __construct() {
		parent::__construct( 'ApiGate' );
	}

	/**
	 * @param $subpage Mixed: string if any subpage provided, else null
	 */
	public function execute( $subpage ) {
		global $wgOut, $wgRequest;
		wfProfileIn( __METHOD__ );

		wfLoadExtensionMessages( 'ApiGate' );
		$wgOut->setPagetitle( wfMsg('apigate') );

		//print "SUBPAGE: $subpage<br/>\n";
		$apiKey = $wgRequest->getVal( 'apiKey' );
		if ( $subpage == $this->AUTH_SUBPAGE ) {
			
			// TEST VALUES FOR GETTING THE DIFFERENT CACHING RETURN VALUES
			switch( $apiKey ){
			case '509':
				header("Status: 509 Bandwidth Limit Exceeded");

				print "This API key has been disabled because the request-rate was too high. Please contact support for more information or to re-enable.";

				break;
			case '200':
			default:
				header("Status: 200 OK");
				print "Cool";
				break;
			}

			// This sub-age is just for returning error-codes.
			exit;
		}

		wfProfileOut( __METHOD__ );
	} // end execute()

} // end class SpecialApiGate
