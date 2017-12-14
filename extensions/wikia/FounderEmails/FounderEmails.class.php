<?php

use Wikia\DependencyInjection\Injector;
use Wikia\Service\User\Preferences\PreferenceService;

class FounderEmails {
	static private $instance = null;
	private $mLastEventType = null;

	private function __construct() {}
	private function __clone() {}

	/**
	 * @return FounderEmails
	 */
	static public function getInstance() {
		if ( self::$instance == null ) {
			self::$instance = new FounderEmails;
		}
		return self::$instance;
	}

	/**
	 * Get the wiki founder user object for a given wiki ID
	 *
	 * @param int $wikiId
	 *
	 * @return User
	 */
	public function getWikiFounder( $wikiId = 0 ) {
		global $wgCityId, $wgFounderEmailsDebugUserId;

		$wikiId = !empty( $wikiId ) ? $wikiId : $wgCityId;

		if ( empty( $wgFounderEmailsDebugUserId ) ) {
			$wikiFounder = User::newFromId( WikiFactory::getWikiById( $wikiId )->city_founding_user );
		} else {
			$wikiFounder = User::newFromId( $wgFounderEmailsDebugUserId );
		}

		return $wikiFounder;
	}

	/**
	 * Get list of wikis with a particular local preference setting
	 * Since the expected default is 0, we need to look for users with up_property value set to 1
	 *
	 * @param string $preferenceName Which preference setting to search for, MUST be either:
	 *                               founderemails-complete-digest OR founderemails-views-digest
	 *
	 * @return array
	 */

	public function getWikisWithFounderPreference( $preferenceName ) {
		/** @var PreferenceService $preferenceService */
		$preferenceService = Injector::getInjector()->get( PreferenceService::class );
		return $preferenceService->findWikisWithLocalPreferenceValue( $preferenceName, "1" );
	}

	/**
	 * register new event on wiki
	 * @param FounderEmailsEvent $event
	 * @param bool $doProcess perform event processing when done
	 */
	public function registerEvent( FounderEmailsEvent $event, $doProcess = true ) {
		global $wgCityId;
		// Each event has a different named option now
		if ( $event->enabled_wiki( $wgCityId ) ) {
			$event->create();
			if ( $doProcess ) {
				$this->processEvents( $event->getType(), true, $wgCityId );
			}
			$this->mLastEventType = $event->getType();
		}

	}

	/**
	 * process all registered events of given type
	 *
	 * @param string $eventType event type
	 * @param bool $useMasterDb master db flag
	 * @param int $wikiId
	 *
	 * @throws DBUnexpectedError
	 */
	public function processEvents( $eventType, $useMasterDb = false, $wikiId = null ) {
		global $wgWikicitiesReadOnly, $wgExternalSharedDB;

		$aEventsData = [];

		// Digest event types do not have records in the event table so just process them.
		if ( $eventType == 'viewsDigest' || $eventType == "completeDigest" ) {
			if ( $wikiId != null ) {
				$aEventsData[] = $wikiId;
			}

			$oEvent = FounderEmailsEvent::newFromType( $eventType );
			$oEvent->process( $aEventsData );
		} else {
			$dbs = wfGetDB( ( $useMasterDb ? DB_MASTER : DB_SLAVE ), array(), $wgExternalSharedDB );
			$whereClause = array( 'feev_type' => $eventType );
			if ( $wikiId != null ) {
				$whereClause['feev_wiki_id'] = $wikiId;
			}
			$res = $dbs->select( 'founder_emails_event', array( '*' ), $whereClause, __METHOD__, array( 'ORDER BY' => 'feev_timestamp' ) );

			while ( $row = $dbs->fetchObject( $res ) ) {
				$aEventsData[] = array( 'id' => $row->feev_id, 'wikiId' => $row->feev_wiki_id, 'timestamp' => $row->feev_timestamp, 'data' => unserialize( $row->feev_data ) );
			}
			if ( count( $aEventsData ) ) {
				$oEvent = FounderEmailsEvent::newFromType( $eventType );
				$result = $oEvent->process( $aEventsData );
				if ( $result && !$wgWikicitiesReadOnly && ( $wikiId != null ) ) {
					// remove processed events for this wiki
					$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
					foreach ( $aEventsData as $event ) {
						$dbw->delete( 'founder_emails_event', array( 'feev_id' => $event['id'] ), __METHOD__ );
					}
				}
			}
		}
	}

	public function getLastEventType() {
		return $this->mLastEventType;
	}

	public static function onGetPreferences( $user, &$defaultPreferences ) {
		global $wgUser, $wgCityId, $wgSitename, $wgEnableUserPreferencesV2Ext;

		$wikiService = ( new WikiService );
		if ( !FounderEmailsEvent::isAnswersWiki() && in_array( $wgUser->getId(), $wikiService->getWikiAdminIds() ) ) {

			if ( empty( $wgEnableUserPreferencesV2Ext ) ) {
				$section = 'personal/wikiemail';
				$prefVersion = '';
			} else {
				$section = 'emailv2/wikiemail';
				$prefVersion = '-v2';
			}

			// If we are in digest mode, grey out the individual email options
			$disableEmailPrefs = $wgUser->getLocalPreference( 'founderemails-complete-digest', $wgCityId );

			$defaultPreferences["adoptionmails-label-$wgCityId"] = array(
				'type' => 'info',
				'label' => '',
				'help' => wfMsg( 'wikiadoption-pref-label', $wgSitename ),
				'section' => $section,
			);
			$defaultPreferences["founderemails-joins-$wgCityId"] = array(
				'type' => 'toggle',
				'label-message' => array( 'founderemails-pref-joins' . $prefVersion, $wgSitename ),
				'section' => $section,
				'disabled' => $disableEmailPrefs,
			);
			$defaultPreferences["founderemails-edits-$wgCityId"] = array(
				'type' => 'toggle',
				'label-message' => array( 'founderemails-pref-edits' . $prefVersion, $wgSitename ),
				'section' => $section,
				'disabled' => $disableEmailPrefs,
			);
			$defaultPreferences["founderemails-views-digest-$wgCityId"] = array(
				'type' => 'toggle',
				'label-message' => array( 'founderemails-pref-views-digest' . $prefVersion, $wgSitename ),
				'section' => $section,
				'disabled' => $disableEmailPrefs,
			);
			$defaultPreferences["founderemails-complete-digest-$wgCityId"] = array(
				'type' => 'toggle',
				'label-message' => array( 'founderemails-pref-complete-digest' . $prefVersion, $wgSitename ),
				'section' => $section,
			);
		}

		return true;
	}

	/**
	 * Hook - clear cache for list of admin_ids
	 * @param object $user
	 * @param array $addgroup
	 * @param array $removegroup
	 * @return true
	 */
	public static function onUserRightsChange( $user, $addgroup, $removegroup ) {
		global $wgCityId, $wgMemc;

		if ( !empty( $wgCityId ) ) {
			if ( ( $addgroup && ( in_array( 'sysop', $addgroup ) || in_array( 'bureaucrat', $addgroup ) ) )
				|| ( $removegroup && ( in_array( 'sysop', $removegroup ) || in_array( 'bureaucrat', $removegroup ) ) ) ) {
				$wikiService = ( new WikiService ); /* @var $wikiService WikiService */
				$memKey  = $wikiService->getMemKeyAdminIds( $wgCityId );
				$wgMemc->delete( $memKey );
				$memKey  = $wikiService->getMemKeyAdminIds( $wgCityId, true );
				$wgMemc->delete( $memKey );
				$wikiService->getWikiAdminIds( $wgCityId, true );
			}
		}

		return true;
	}

	/* stats methods */

	public function getPageViews ( $cityID ) {
		$today = date( 'Y-m-d', strtotime( '-1 day' ) );

		$pageViews = DataMartService::getPageviewsDaily( $today, null, $cityID );

		$views = isset( $pageViews[$today] ) ? $pageViews[$today] : 0 ;

		return $views;
	}

	public function getDailyEdits ( $cityID, /*Y-m-d*/ $day = null ) {
		global $wgDWStatsDB;

		$today = ( empty( $day ) ) ? date( 'Y-m-d', strtotime( '-1 day' ) ) : $day;

		$db = wfGetDB( DB_SLAVE, array(), $wgDWStatsDB );

		$oRow = $db->selectRow(
			array( 'rollup_wiki_user_events' ),
			array( 'sum(creates + edits) as cnt' ),
			array( "time_id = '$today 00:00:00'", 'wiki_id' => $cityID, 'period_id' => DataMartService::PERIOD_ID_DAILY ),
			__METHOD__
		);

		$edits = isset( $oRow->cnt ) ? $oRow->cnt : 0;

		return $edits;
	}

	/**
	 * add link (<a> tag) to the param
	 *
	 * @param array $params
	 * @param array $links
	 * @param string $color
	 *
	 * @return array
	 */
	public static function addLink( $params, $links, $color = '#2C85D5' ) {
		if ( is_array( $params ) && is_array( $links ) ) {
			foreach ( $links as $key => $value ) {
				if ( array_key_exists( $key, $params ) )
					$params[$key] = '<a href="' . $value . '" style="color:' . $color . ';">' . $params[$key] . '</a>';
			}
		}
		return $params;
	}
}
