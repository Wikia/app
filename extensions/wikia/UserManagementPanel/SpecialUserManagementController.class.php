<?php

class SpecialUserManagementController extends WikiaSpecialPageController {

        public function __construct() {
                parent::__construct('UserManagement', '', false);
        }

	function index() {
		$par = $this->getPar();

		$this->mUser = User::newFromName( $par );

		$this->editCount = $this->mUser->getEditCount();
		$this->wikisEdited = 'blah';

		$this->firstEdit = $this->wg->Lang->date( $this->mUser->getFirstEditTimestamp() );
		$this->lastEdit = $this->wg->Lang->date( $this->mUser->getTouched() );

		$this->email = $this->mUser->getEmail();
		$this->emailConfirmationDate = $this->wg->Lang->date( $this->mUser->getEmailAuthenticationTimestamp() );
		$this->emailSubscriptionStatus = (bool) $this->mUser->getOption( 'subscribed', 1 );
		$this->emailLastDelivery = $this->wg->Lang->date( $this->getLastEmailDelivery() );
		$this->emailChangeUrl = GlobalTitle::newFromText( 'EditAccount', NS_SPECIAL, 177 )->getFullUrl() . '/' . $par;
	}


	private function getLastEmailDelivery() {
		if ( $this->wg->DevelEnvironment ) {
			return $this->mUser->getTouched();
		}

		$dbr = wfGetDB( DB_SLAVE, array(), $this->wg->DBStats );

		$date = $dbr->selectField(
			'mail',
			'transmitted',
			array( 'dst' => $this->mUser->getEmail(),
				'is_spam' => 0,
				'is_error' => 0,
				'is_bounce' => 0,
			),
			array(
				'ORDER BY' => 'transmitted desc'
			)
		);

		return $date;
	}
}
