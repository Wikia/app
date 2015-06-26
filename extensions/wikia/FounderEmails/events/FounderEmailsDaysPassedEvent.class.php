<?php

class FounderEmailsDaysPassedEvent extends FounderEmailsEvent {
	public function __construct( Array $data = array() ) {
		parent::__construct( 'daysPassed' );
		$this->setData( $data );
	}

	public function enabled ( $wgCityId, User $user ) {
		// This type of email cannot be disabled or avoided without unsubscribing from all email
		return true;
	}

	public function process( Array $events ) {
		global $wgExternalSharedDB, $wgTitle;

		$wgTitle = Title::newMainPage();
		foreach ( $events as $event ) {
			$wikiId = $event['wikiId'];
			$eventData = $event['data'];
			$activateTime = $eventData['activateTime'];

			if ( $this->isInvalidWiki( $wikiId ) ) {
				continue;
			}

			if ( $this->isTooEarlyToSendEmail( $activateTime ) ) {
				continue;
			}

			$adminIds = ( new WikiService )->getWikiAdminIds( $wikiId );
			foreach ( $adminIds as $adminId ) {
				$user = User::newFromId( $adminId );
			}

			$dbw = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );
			$dbw->delete( 'founder_emails_event', array( 'feev_id' => $event['id'] ) );
		}

		// always return false to prevent deleting from FounderEmails::processEvent
		return false;
	}

	private function isInvalidWiki( $wikiId ) {
		return $wikiId == 0; // should "never" happen BugId:12717
	}

	private function isTooEarlyToSendEmail( $activateTime ) {
		return time() < $activateTime;
	}

	public static function register( $wikiParams, $debugMode = false ) {
		global $wgFounderEmailsExtensionConfig, $wgCityId;

		$founderEmailObj = FounderEmails::getInstance();

		$wikiFounder = $founderEmailObj->getWikiFounder();
		$wikiFounder->setOption( "founderemails-joins-$wgCityId", true );
		$wikiFounder->setOption( "founderemails-edits-$wgCityId", true );

		$wikiFounder->saveSettings();

		foreach ( $wgFounderEmailsExtensionConfig['events']['daysPassed']['days'] as $daysToActivate ) {

			// Send the 0 day email, queue the rest
			$doProcess = $daysToActivate == 0 ? true : false;
			$eventData = array(
				'activateDays' => $daysToActivate,
				'activateTime' => time() + ( 86400 * $daysToActivate ),
				'wikiName' => $wikiParams['title'],
				'wikiUrl' => $wikiParams['url'],
			);

			$founderEmailObj->registerEvent( new FounderEmailsDaysPassedEvent( $eventData ), $doProcess );
		}

		return true;
	}
}
