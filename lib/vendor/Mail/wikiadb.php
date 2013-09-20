<?php
/**
 * Store email in the database where it can be picked out by a job-runner and
 * send to an external email provider (such as SendGrid).
 *
 * @seealso /maintenance/wikia/sql/wikiamailer.sql for database schema
 * @author Sean Colombo
 */

class Mail_wikiadb extends Mail {

	public static $MAIL_TABLE_NAME = "wikia_mailer.mail";

	function Mail_wikiadb($params) {
	}

	function send($recipients, $headers, $body){
		$this->_sanitizeHeaders($headers);
		list($from, $textHeaders) = $this->prepareHeaders($headers);
		$priority = 0;
		if (isset($headers['X-Priority'])) {
			$priority = $headers['X-Priority'];
		}
		
		if (isset($headers['X-Msg-Category'])) {
			$category = $headers['X-Msg-Category'];
		}
		
		global $wgCityId, $wgExternalDatawareDB;
		$wgCityId = ($wgCityId == null?0:$wgCityId); // fake city-id for contractor/staff.
		// FB:4431 Write mail to archive database now
		$dbw = wfGetDb(DB_MASTER, array(), $wgExternalDatawareDB);
		$dbw->begin(__METHOD__);
		foreach ($recipients as $recipient) {

			// TODO: SHOULD WE FILTER BASED ON BLOCKS / SPAMS HERE?  FOR NOW WE WILL LET SENDGRID HANDLE THAT.
			$dbw->insert(
				self::$MAIL_TABLE_NAME,
				array(
					'src'     => $from,
					'subj'    => $headers['Subject'],
					'dst'     => $recipient,
					'hdr'     => $textHeaders,
					'msg'     => $body,
					'city_id' => $wgCityId,
					'priority' => $priority,
					'category' => $category,
				),
				__METHOD__
			);
			
			// Add postback token so that we can verify that any postback actually comes from SendGrid.
			$emailId = $dbw->insertId();
			$postbackToken = wfGetEmailPostbackToken($emailId, $recipient);
			$textHeaders .= $this->sep . "X-CallbackToken: ".$postbackToken;
			$dbw->update(
				self::$MAIL_TABLE_NAME,
				array( /* SET */'hdr' => $textHeaders ),
				array( /* WHERE */'id' => $emailId ),
				__METHOD__
			);
			wfDebugLog( "enotif", __METHOD__ . ": email added to database with data: $recipient $from {$headers['Subject']}", true );
		}
		$dbw->commit(__METHOD__);

	}
}
