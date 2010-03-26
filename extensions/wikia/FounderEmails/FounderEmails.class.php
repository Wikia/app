<?php

class FounderEmails {

	static private $instance = null;
	private $mLastEvetType = null;

	private function __construct() { }
	private function __clone() { }

	/**
	 * @return FounderEmails
	 */
	static public function getInstance() {
		if(self::$instance == null) {
			self::$instance = new FounderEmails;
		}
		return self::$instance;
	}

	/**
	 * get wiki founder
	 * @return User
	 */
	public function getWikiFounder( $wikiId = 0 ) {
		global $wgCityId, $wgFounderEmailsDebugUserId;

		$wikiId = !empty($wikiId) ? $wikiId : $wgCityId;

		if( empty($wgFounderEmailsDebugUserId) ) {
			$wikiFounder = User::newFromId( WikiFactory::getWikiById( $wikiId )->city_founding_user );
		}
		else {
			$wikiFounder = User::newFromId( $wgFounderEmailsDebugUserId );
		}

		return $wikiFounder;
	}

	/**
	 * send notification email to wiki founder
	 */
	public function notifyFounder($mailSubject, $mailBody, $mailBodyHTML, $wikiId = 0) {
		return $this->getWikiFounder( $wikiId )->sendMail( $mailSubject, $mailBody, null, null, 'FounderEmails', $mailBodyHTML );
	}

	/**
	 * register new event on wiki
	 * @param FounderEmailsEvent $event
	 * @param bool $doProcess perform event processing when done
	 */
	public function registerEvent(FounderEmailsEvent $event, $doProcess = true) {
		global $wgCityId;
		wfProfileIn( __METHOD__ );

		// Backward compatibility for opposite option ([..]disabled) prior to rt#44284 - SWC
		if( !$this->getWikiFounder()->getOption('founderemailsdisabled', false)
			&& $this->getWikiFounder()->getOption('founderemailsenabled', true)) {
			$event->create();
			if( $doProcess ) {
				$this->processEvents( $event->getType(), true, $wgCityId );
			}
			$this->mLastEvetType = $event->getType();
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * process all registered events of given type when aplicable
	 * @param string $eventType event type
	 * @param bool $useMasterDb master db flag
	 */
	public function processEvents( $eventType, $useMasterDb = false, $wikiId = null ) {
		global $wgWikicitiesReadOnly, $wgExternalSharedDB;

		wfProfileIn( __METHOD__ );
		$dbs = wfGetDB( ( $useMasterDb ? DB_MASTER : DB_SLAVE ), array(), $wgExternalSharedDB );
		$whereClause = array( 'feev_type' => $eventType );
		if( $wikiId != null ) {
			$whereClause['feev_wiki_id'] = $wikiId;
		}
		$res = $dbs->select( 'founder_emails_event', array( '*' ), $whereClause, __METHOD__, array( 'ORDER BY' => 'feev_timestamp' ) );

		$aEventsData = array();
		while($row = $dbs->fetchObject($res)) {
			$aEventsData[] = array( 'id' => $row->feev_id, 'wikiId' => $row->feev_wiki_id, 'timestamp' => $row->feev_timestamp, 'data' => unserialize($row->feev_data) );
		}

		if( count($aEventsData) ) {
			$oEvent = FounderEmailsEvent::newFromType( $eventType );
			$result = $oEvent->process( $aEventsData );

			if( $result && !$wgWikicitiesReadOnly && ( $wikiId != null ) ) {
				// remove processed events per wiki
				$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
				foreach($aEventsData as $event) {
					$dbw->delete( 'founder_emails_event', array( 'feev_id' => $event['id'] ) );
				}
			}
		}

		wfProfileOut( __METHOD__ );
	}

	public function getLastEventType() {
		return $this->mLastEvetType;
	}

	public static function userTogglesHook( $toggles, $defaults = false ) {
		if( is_array($defaults) ) {
			$defaults[] = 'founderemailsenabled';
		}
		else {
			$toggles[] = 'founderemailsenabled';
		}
		return true;
	}

	public static function userProfilePreferencesHook( $prefsForm, $toggleHtml ) {
		global $wgUser;

		if( FounderEmails::getInstance()->getWikiFounder()->getId() == $wgUser->getId() ) {
			$prefsForm->mUsedToggles['founderemailsenabled'] = true;
			$toggleHtml .= $prefsForm->getToggle('founderemailsenabled') . "<br />";
		}

		return true;
	}

}
