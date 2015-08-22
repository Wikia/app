<?php

class FounderEmailsRegisterEvent extends FounderEmailsEvent {

	const EMAIL_CONTROLLER = 'Email\Controller\FounderNewMember';

	public function __construct( Array $eventData = [] ) {
		parent::__construct( 'register' );
		$this->setData( $eventData );
	}

	public function enabled( User $admin, $wikiId = null ) {
		// don't send if we're on an answersWiki
		if ( self::isAnswersWiki() ) {
			return false;
		}

		return true;
	}

	public function process( Array $events ) {
		if ( count( $events ) == 0 ) {
			return false;
		}

		// This event is triggered when a new user registers, so we
		// know there's only one event in the events array
		$eventData = $events[0]['data'];
		$emailParams = [
			'currentUser' => $eventData['newUserName'],
		];

		foreach ( ( new WikiService )->getWikiAdminIds() as $adminId ) {
			$admin = User::newFromId( $adminId );
			$emailParams['targetUser'] = $admin->getName();

			F::app()->sendRequest( self::EMAIL_CONTROLLER, 'handle', $emailParams );
		}

		return true;
	}

	public static function register( User $user ) {
		$eventData = [
			'newUserName' => $user->getName()
		];
		FounderEmails::getInstance()->registerEvent( new FounderEmailsRegisterEvent( $eventData ) );
		return true;
	}
}
