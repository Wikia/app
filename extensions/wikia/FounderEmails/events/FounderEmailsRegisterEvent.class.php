<?php

class FounderEmailsRegisterEvent extends FounderEmailsEvent {
	public function __construct( Array $data = array() ) {
		parent::__construct( 'register' );
		$this->setData( $data );
	}

	public function enabled( User $admin, $wikiId = null ) {
		$wikiId = empty( $wikiId ) ? F::app()->wg->CityId : $wikiId;

		if ( self::isAnswersWiki( $wikiId ) ) {
			return false;
		}

		// disable if all Wikia email disabled
		if ( $admin->getBoolOption( 'unsubscribed' ) ) {
			return false;
		}

		// If digest mode is enabled, do not create user registration event notifications
		if ( $admin->getOption( "founderemails-complete-digest-$wikiId" ) ) {
			return false;
		}
		if ( $admin->getOption( "founderemails-joins-$wikiId" ) ) {
			return true;
		}
		return false;
	}

	public function process( Array $events ) {
		global $wgEnableAnswers, $wgCityId;

		if ( count( $events ) == 0 ) {
			return false;
		}

		// get just one event when we have more... for now, just randomly
		$eventData = $events[rand( 0, count( $events ) -1 )];

		$founderEmailObj = FounderEmails::getInstance();
		$wikiService = ( new WikiService );
		$user_ids = $wikiService->getWikiAdminIds();
		$foundingWiki = WikiFactory::getWikiById( $wgCityId );

		$emailParams = array(
			'$EDITORNAME' => $eventData['data']['userName'],
			'$EDITORPAGEURL' => $eventData['data']['userPageUrl'],
			'$EDITORTALKPAGEURL' => $eventData['data']['userTalkPageUrl'],
			'$WIKINAME' => $foundingWiki->city_title,
			'$WIKIURL' => $foundingWiki->city_url,
		);
		$wikiType = !empty( $wgEnableAnswers ) ? '-answers' : '';

		foreach ( $user_ids as $user_id ) {
			$user = User::newFromId( $user_id );

			// skip if not enable
			if ( !$this->enabled( $user, $wgCityId ) ) {
				continue;
			}
			self::addParamsUser( $wgCityId, $user->getName(), $emailParams );

			$langCode = $user->getOption( 'language' );
			$mailSubject = strtr( wfMsgExt( 'founderemails' . $wikiType . '-email-user-registered-subject', array( 'content' ) ), $emailParams );
			$mailBody = strtr( wfMsgExt( 'founderemails' . $wikiType . '-email-user-registered-body', array( 'content' ) ), $emailParams );

			if ( empty( $wgEnableAnswers ) ) { // FounderEmailv2.1
				$links = array(
					'$EDITORNAME' => $emailParams['$EDITORPAGEURL'],
					'$WIKINAME' => $emailParams['$WIKIURL'],
				);
				$mailBodyHTML = F::app()->renderView( 'FounderEmails', 'GeneralUpdate', array_merge( $emailParams, array( 'language' => 'en', 'type' => 'user-registered' ) ) );
				$mailBodyHTML = strtr( $mailBodyHTML, FounderEmails::addLink( $emailParams, $links ) );
			} else {
				$mailBodyHTML = $this->getLocalizedMsg( 'founderemails' . $wikiType . '-email-user-registered-body-HTML', $emailParams );
			}

			$mailCategory = FounderEmailsEvent::CATEGORY_REGISTERED . ( !empty( $langCode ) && $langCode == 'en' ? 'EN' : 'INT' );

			$founderEmailObj->notifyFounder( $user, $this, $mailSubject, $mailBody, $mailBodyHTML, $wgCityId, $mailCategory );
		}

		return true;
	}

	public static function register( $user ) {
		wfProfileIn( __METHOD__ );

		$eventData = array(
			'userName' => $user->getName(),
			'userPageUrl' => $user->getUserPage()->getFullUrl(),
			'userTalkPageUrl' => $user->getTalkPage()->getFullUrl(),
		);

		FounderEmails::getInstance()->registerEvent( new FounderEmailsRegisterEvent( $eventData ) );

		wfProfileOut( __METHOD__ );
		return true;
	}
}
