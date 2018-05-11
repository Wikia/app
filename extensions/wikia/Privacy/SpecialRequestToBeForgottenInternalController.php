<?php

class SpecialRequestToBeForgottenInternalController extends WikiaSpecialPageController {
	public function __construct() {
		parent::__construct( 'RequestToBeForgottenInternal', 'requesttobeforgotten', false );
		$this->specialPage->checkPermissions();
	}

	public function index() {
		$reqUser = RequestContext::getMain()->getUser();

		if ( $this->getRequest()->wasPosted() && $reqUser->matchEditToken( $this->getVal( 'editToken' ) ) ) {
			$userName = $this->getVal( 'username', '' );
			$this->forgetUser( $userName );
		}

		$this->setVal( 'editToken', $reqUser->getEditToken() );
	}

	private function forgetUser( string $userName ) {
		$user = User::newFromName( $userName );

		if ( !( $user instanceof User ) || $user->isAnon() ) {
			$this->setVal( 'message', 'Invalid username' );
		} else {
			$userId = $user->getId();
			$this->setVal( 'message', 'Request to forget ' . $userName . ' with id=' . $userId . ' sent' );
			F::app()->sendRequest(
				'RemoveUserDataController',
				'removeUserData',
				[ 'userId' => $userId ]
			);
		}
	}
}