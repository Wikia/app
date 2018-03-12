<?php

require __DIR__ . '/../../../maintenance/Maintenance.php';

/**
 * Maintenance script to send email confirmation reminder to users.
 * Conditions:
 * - user email not authenticated
 * - users signed up 7 days ago
 *
 * @author Hyun
 * @author Saipetch
 * @author Kamil Koterba
 */

class SendConfirmationReminder extends Maintenance {

	public function execute() {
		foreach ( $this->getRecipients() as $user ) {
			// send reminder email if it has not been sent yet
			if ( !$user->getGlobalFlag( "cr_mailed", 0 ) ) {
				$user->setGlobalFlag( "cr_mailed", "1" );
				$user->sendConfirmationMail( false, 'ConfirmationReminderMail' );
			}
		}
	}

	/**
	 * Get IDs of users to send reminder
	 * Conditions
	 * - user email not authenticated
	 * - users signed up 7 days ago
	 *
	 * @return User[]
	 */
	private function getRecipients() {
		global $wgExternalSharedDB;

		$dbr = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
		$res = $dbr->select(
			[ '`user`' ],
			[ 'user_id' , 'user_name', 'user_email' ],
			[
				"user_email != ''",
			 	'user_email_authenticated' => NULL,
			 	'date(user_registration) = curdate() - interval 7 day',
			],
			__METHOD__
		);

		$recipients = [];

		foreach ( $res as $row ) {
			$recipients[] = User::newFromRow( $row );
		}

		return $recipients;
	}
}

$maintClass = SendConfirmationReminder::class;
require RUN_MAINTENANCE_IF_MAIN;
