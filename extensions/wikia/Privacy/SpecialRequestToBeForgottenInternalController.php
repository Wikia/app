<?php

class SpecialRequestToBeForgottenInternalController extends WikiaSpecialPageController {
	public function __construct() {
		parent::__construct( 'RequestToBeForgottenInternal', 'requesttobeforgotten', false );
	}

	public function index() {
		$this->specialPage->checkPermissions();

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
			$dataRemover = new UserDataRemover();
			$dataRemover->startRemovalProcess( $userId );
			$this->setVal( 'message', 'Request to forget ' . $userName . ' with id=' . $userId . ' sent' );
		}
	}
}
