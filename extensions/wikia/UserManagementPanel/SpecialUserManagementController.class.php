<?php

class SpecialUserManagementController extends WikiaSpecialPageController {

        public function __construct() {
                parent::__construct('UserManagement', 'usermanagement', false);
        }

	function index() {

		if ( !$this->wg->User->isAllowed( 'usermanagement' ) ) {
			$this->skipRendering();
			throw new PermissionsError( 'usermanagement' );
		}

		$this->setHeaders();

		$par = $this->getPar();

		$this->mUser = User::newFromName( $par );

		$this->editCount = $this->mUser->getEditCount();
		$this->wikisEdited = '(coming soon)';

		$this->firstEdit = $this->wg->Lang->date( $this->mUser->getFirstEditTimestamp() );
		$this->lastEdit = $this->wg->Lang->date( $this->mUser->getTouched() );

		$this->email = $this->mUser->getEmail();
		$this->emailConfirmationDate = $this->wg->Lang->date( $this->mUser->getEmailAuthenticationTimestamp() );
		$this->emailSubscriptionStatus = !$this->mUser->getOption( 'unsubscribed', 0 );

		// email delivery info
		$emailErrors = array();
		$lastEmailData = $this->getLastEmailDelivery();
		if ( empty( $lastEmailData ) ) {
			$this->emailLastDelivery = 'none';
		} else {
			$this->emailLastDelivery = $this->wg->Lang->date( wfTimestamp( TS_MW, $lastEmailData['transmitted'] ) );
/*
			if ( $lastEmailData['is_bounce'] ) {
				$this->emailError[] = "bounced";
			}

			if ( $lastEmailData['is_error'] ) {
				$this->emailErrors[] = "error (" . $lastEmailData['error_status'] . "): " . $lastEmailData['error_msg'];
			}

			if ( $lastEmailData['is_spam'] ) {
				$this->emailErrors[] = "marked as spam";
			}
*/

			if ( empty( $emailErrors ) ) {
				$this->emailLastDeliveryStatus = ''; // Wikia::successmsg( 'OK' );
			} else {
				$this->emailLastDeliveryStatus = Wikia::errormsg( implode( ', ', $emailErrors ) );
			}

		}

		$this->emailChangeUrl = GlobalTitle::newFromText( 'EditAccount', NS_SPECIAL, 177 )->getFullUrl() . '/' . $par;
		$this->emailChangeSubscriptionUrl = $this->emailChangeUrl;
         }



	private function getLastEmailDelivery() {
		global $wgWikiaMailerDB;
		$dbr = wfGetDB( DB_SLAVE, array(), $wgWikiaMailerDB );

		$res = $dbr->select(
			'wikia_mailer.mail_send',
			array(
				'transmitted',
				'is_bounce',
				'is_error',
				'is_spam',
				'error_status',
				'error_msg',
			 ),
			array( 'dst' => $this->mUser->getEmail() ),
			__METHOD__,
			array(
				'ORDER BY' => 'transmitted desc',
				'LIMIT' => 1,
			)
		);

		return $dbr->fetchRow( $res );
	}
}
