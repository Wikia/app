<?php

class FounderEmailsRegisterEvent extends FounderEmailsEvent {

	const EMAIL_CONTROLLER = 'Email\Controller\FounderNewMemberController';

	private $newUserName;

	public function __construct( $newUserName ) {
		parent::__construct( 'register' );
		$this->newUserName = $newUserName;
	}

	public function enabled( $wikiId, User $user ) {
		// Define this cause we have to, we don't actually need it.
	}

	public function process( Array $events ) {

		if ( !$this->isThresholdMet( count( $events ) ) ) {
			return false;
		}

		$foundingWiki = WikiFactory::getWikiById( F::app()->wg->CityId );
		$emailParams = [
			'wikiName' => $foundingWiki->city_url,
			'currentUser' => $this->newUserName
		];

		foreach ( ( new WikiService )->getWikiAdminIds() as $adminId ) {

			// don't send if we're on an answersWiki
			if ( self::isAnswersWiki() ) {
				continue;
			}

			$admin = User::newFromId( $adminId );
			$emailParams['targetUser'] = $admin->getName();
			F::app()->sendRequest( self::EMAIL_CONTROLLER, 'handle', $emailParams );
		}

		return true;
	}

	public static function register( User $user ) {
		FounderEmails::getInstance()->registerEvent( new FounderEmailsRegisterEvent( $user->getName() ) );
		return true;
	}
}
