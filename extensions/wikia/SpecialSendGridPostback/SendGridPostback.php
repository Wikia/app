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
class SendGridPostback extends UnlistedSpecialPage {

	public static $POSTBACK_LOG_TABLE_NAME = "postbackLog";

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
		global $wgOut, $_POST, $wgRequest, $IP;

		wfProfileIn(__METHOD__);

		require "$IP/lib/Mail.php";
		require "$IP/lib/Mail/wikiadb.php";

		$this->outputHeader();
		$this->setHeaders();

		$emailId = $wgRequest->getVal('wikia-email-id');
		$emailAddr = $wgRequest->getVal('email');
		$cityId = $wgRequest->getVal('wikia-email-city-id'); // cityId of the wiki which sent the email
		$senderDbName = $wgRequest->getVal('wikia-db');
		
		// Verify the token so that we know this POST probably came from SendGrid.
		$postedToken = $wgRequest->getVal('wikia-token');
		$generatedToken = wfGetEmailPostbackToken($emailId, $emailAddr);
		if($postedToken == $generatedToken){
			// We don't take any actions yet, so log all token-validated postbacks to the database.
			$this->logPostbackForLater();

			// Take action on the eventType.
			$eventType = $wgRequest->getVal('event');
			switch ($eventType) {
			case 'click':
				$this->handleClick($emailId, $emailAddr);
				break;
			case 'open':
				$this->handleOpen($emailId, $emailAddr);
				break;
			case 'unsubscribe':
				$this->handleUnsubscribe($emailId, $emailAddr);
				break;
			case 'bounce':
				$this->handleBounce($emailId, $emailAddr, $wgRequest->getVal('status'), $wgRequest->getVal('reason'));
				break;
			case 'spamreport':
				$this->handleSpam($emailId, $emailAddr);
				break;
			default:
				Wikia::log(__METHOD__, false, "Unrecognized type: <postback>" . print_r($_POST, true) . "</postback>\n", true);
			}

			$wgOut->addHtml("Postback processed.");
		} else {
			// Log the token-validation problem.
			Wikia::log(__METHOD__, false, "INVALID TOKEN DURING THIS POSTBACK: <postback>" . print_r($_POST, true) . "</postback>\n", true);
			$wgOut->addHtml("Postback token did not match expected value.  Ignoring.");
		}

		wfProfileOut(__METHOD__);
	}
	
	private function handleClick ($id, $email, $url) {
		Wikia::log(__METHOD__, false, "<postback>" . $email . "</postback>\n", true);
		
		$dbw = wfGetDb(DB_MASTER, array(), Mail_wikiadb::$MAIL_DB_NAME);
		$dbw->update(
			Mail_wikiadb::$MAIL_TABLE_NAME,
			array( /* SET */'clicked' => date('Y-m-d H:i:s') ),
			array( /* WHERE */'id' => $id ),
			""
		);
	}
	
	private function handleOpen ($id, $email) {
		Wikia::log(__METHOD__, false, "<postback>" . $email . "</postback>\n", true);

		$dbw = wfGetDb(DB_MASTER, array(), Mail_wikiadb::$MAIL_DB_NAME);
		$dbw->update(
			Mail_wikiadb::$MAIL_TABLE_NAME,
			array( /* SET */'opened' => date('Y-m-d H:i:s') ),
			array( /* WHERE */'id' => $id ),
			""
		);
	}
	
	private function handleUnsubscribe ($id, $email) {
		Wikia::log(__METHOD__, false, "<postback>" . $email . "</postback>\n", true);
	}
	
	private function handleBounce ($id, $email, $status, $reason) {
		Wikia::log(__METHOD__, false, "<postback>$email, $status, $reason</postback>\n", true);

		// Update the mail table to include details about the bounce		
		$dbw = wfGetDb(DB_MASTER, array(), Mail_wikiadb::$MAIL_DB_NAME);
		$dbw->update(
			Mail_wikiadb::$MAIL_TABLE_NAME,
			array( /* SET */'is_bounce'    => 1,
							'error_status' => $status,
							'error_msg'    => $reason ),
			array( /* WHERE */'id' => $id ),
			""
		);
		
		// Invalidate the users email to force them to reverify it
		$dbr = wfGetDb(DB_SLAVE);
		$res = $dbr->select( 'user',
							 array( 'id' ),
							 array( 'user_email' => $email ),
							 __METHOD__
						   );
		while ($row = $dbr->fetchObject($res)) {
			$user = User::newFromId($row->id);
			if (!$user) next;
			
			$user->invalidateEmail();
			$user->saveSettings();
		}
	}
	
	private function handleSpam ($id, $email) {
		Wikia::log(__METHOD__, false, "<postback>" . $email . "</postback>\n", true);
		
		$dbw = wfGetDb(DB_MASTER, array(), Mail_wikiadb::$MAIL_DB_NAME);
		$dbw->update(
			Mail_wikiadb::$MAIL_TABLE_NAME,
			array( /* SET */'is_spam'  => 1 ),
			array( /* WHERE */'id' => $id ),
			""
		);
	}
	
	/**
	 * We're not sure how we want to handle the postbacks in all cases, so for now just log them to the db and come back for them later.
	 *
	 * NOTE: This does not check (or store) the token, so check the token before calling this function.
	 */
	private function logPostbackForLater(){
		global $wgRequest;
		wfProfileIn(__METHOD__);
		
		$eventType = $wgRequest->getVal('event');
		$emailId = $wgRequest->getVal('wikia-email-id');
		$emailAddr = $wgRequest->getVal('email');
		$cityId = $wgRequest->getVal('wikia-email-city-id'); // cityId of the wiki which sent the email
		$senderDbName = $wgRequest->getVal('wikia-db');
		$url = $wgRequest->getVal('url', '');
		$status = $wgRequest->getVal('status', '');
		$reason = $wgRequest->getVal('reason', '');
	
		$dbw = wfGetDb(DB_MASTER, array(), Mail_wikiadb::$MAIL_DB_NAME);
		$dbw->insert(
			self::$POSTBACK_LOG_TABLE_NAME,
			array(
				"mail_id" => $emailId,
				"emailAddr" => $emailAddr,
				"cityId" => $cityId,
				"eventType" => $eventType,
				"senderDbName" => $senderDbName,
				"url" => $url,
				"status" => $status,
				"reason" => $reason
			)
		);

		wfProfileOut(__METHOD__);
	} // end logPostbackForLater()

} // end class SendGridPostback
