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

		// Just to see what they're sending us.
		ob_start();
		global $_POST;
		print_r($_POST);
		$data = ob_get_clean();
		wfErrorLog("SendGridPostback: " . $data, "/var/log/php");

		$wgOut->addHtml("Post-data logged to error log");
	}

} // end class SendGridPostback
