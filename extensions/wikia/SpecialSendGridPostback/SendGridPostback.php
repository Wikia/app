<?php
/**
 * A SpecialPage which SendGrid will post data to when an email is opened, clicked, bounced back, unsubscribed, marked as spam, etc..
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

		// TODO: REMOVE THIS SECTION
		// Just to see what they're sending us.
		ob_start();
		global $_POST;
		print_r($_POST);
		$data = ob_get_clean();
		
		// Writes to syslog1:/var/log/httpd - just buying time until we implement the rest.
		Wikia::log(__METHOD__, false, "<postback>" . $data . "</postback>\n", true);
		
		// TODO: VERIFY THE TOKEN
		// TODO: VERIFY THE TOKEN
		
		// TODO: Update the wikia_mailer database with the info from the post
		// TODO: Update the wikia_mailer database with the info from the post
		
		// TODO: Set "user preference" that says they were blocked (make sure to add code to clear this out any time a user verifies).
		// TODO: Set "user preference" that says they were blocked (make sure to add code to clear this out any time a user verifies).

		$wgOut->addHtml("Post-data logged to error log");
	}

} // end class SendGridPostback
