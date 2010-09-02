<?php
/**
 * A SpecialPage which SendGrid will post data to when an email is opened, clicked, bounced back, unsubscribed, marked as spam, etc..
 *
 * The documentation for SendGrid's postbacks can be found here:
 * http://wiki.sendgrid.com/doku.php?id=event_api
 *
 * @author Sean Colombo
 */

$wgSpecialPages['SendGridPostback'] = 'SendGridPostback';
/*$wgExtensionCredits['specialpage'][] = array(
	'name' => 'SendGridPostback',
	'url' => 'http://lyrics.wikia.com/User:Sean_Colombo', // FIXME: please point to a location where to get more information on this extension (presumably mediawiki.org/wiki/Extension/BatchUserRights
	'author' => '[http://www.seancolombo.com Sean Colombo]',
	'descriptionmsg' => 'sendgridpostback-desc',
	'version' => '1.0',
);*/

/**
 * @ingroup SpecialPage
 */
class SendGridPostback extends SpecialPage {

	public function __construct() {
		parent::__construct( 'SendGridPostback' );
	}

	public function isRestricted() {
		return false;
	}

	/**
	 * @param $par Mixed: string if any subpage provided, else null
	 */
	function execute( $par ) {
		global $wgOut;
		$this->outputHeader();
		$this->setHeaders();

		// Store the raw data of the postback.
		ob_start();
		global $_POST;
		print_r($_POST);
		$postString = ob_get_clean();

		// Writes to syslog1:/var/log/httpd - just buying time until we implement the rest.
		//Wikia::log(__METHOD__, false, "<postback>" . $postString . "</postback>\n", true);
		
		global $wgRequest;
		$emailId = $wgRequest->getVal('wikia-email-id');
		$emailAddr = $wgRequest->getVal('email');
		$cityId = $wgRequest->getVal('wikia-email-city-id'); // cityId of the wiki which sent the email
		$senderDbName = $wgRequest->getVal('wikia-db');
		
		// Verify the token so that we know this POST probably came from SendGrid.
		$postedToken = $wgRequets->getVal('wikia-token');
		$generatedToken = wfGetEmailPostbackToken($emailId, $emailAddr);
		if($postedToken == $generatedToken){
			// Take action on the eventType.
			$eventType = $wgRequest->getVal('event');
			switch($eventType){
			case 'click':
				// NOTE: ALSO COMES WITH 'url' OF THE LINK THAT WAS CLICKED ON.
				Wikia::log(__METHOD__, false, "<postback>" . $postString . "</postback>\n", true);
				break;
			case 'open':
				Wikia::log(__METHOD__, false, "<postback>" . $postString . "</postback>\n", true);
				break;
			case 'unsubscribe':
				Wikia::log(__METHOD__, false, "<postback>" . $postString . "</postback>\n", true);
				break;
			case 'bounce':
				// NOTE: ALSO COMES WITH 'status' AND 'reason' FOR THE BOUNCE.
				
				// TODO: REMOVE THIS ONCE WE ACTUALLY PROCESS THE DATA.
				Wikia::log(__METHOD__, false, "<postback>" . $postString . "</postback>\n", true);

				// TODO: Update the wikia_mailer database with the info from the post
				// TODO: Update the wikia_mailer database with the info from the post
				
				// TODO: Get all users which use the email address provided.
				// TODO: Get all users which use the email address provided.
				
				// TODO: Set "user preference" that says they were blocked (make sure to add code to clear this out any time a user verifies) for each user found.
				// TODO: Set "user preference" that says they were blocked (make sure to add code to clear this out any time a user verifies) for each user found.
			
				break;
			case 'spamreport':
				Wikia::log(__METHOD__, false, "<postback>" . $postString . "</postback>\n", true);
				break;
			default:
				Wikia::log(__METHOD__, false, "Unrecognized type: <postback>" . $postString . "</postback>\n", true);
			}

			$wgOut->addHtml("Postback processed.");
		} else {
			// Log the token-validation problem.
			Wikia::log(__METHOD__, false, "INVALID TOKEN DURING THIS POSTBACK: <postback>" . $postString . "</postback>\n", true);
			$wgOut->addHtml("Postback token did not match expected value.  Ignoring.");
		}
	}

} // end class SendGridPostback
