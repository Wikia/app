<?php
/**
 * EditPageTracking extension
 * Allows tracking when users first click on "edit page"
 */

$wgExtensionCredits['other'][] = array(
	'author' => array( 'Andrew Garrett' ),
	'descriptionmsg' => 'editpagetracking-desc',
	'name' => 'EditPageTracking',
	'url' => 'https://www.mediawiki.org/wiki/Extension:EditPageTracking',
	'version' => '0.1',
	'path' => __FILE__,
);

$wgExtensionMessagesFiles['EditPageTracking'] = dirname(__FILE__).'/EditPageTracking.i18n.php';

$wgHooks['LoadExtensionSchemaUpdates'][] = 'EditPageTracking::doSchemaUpdates';
$wgHooks['EditPage::showEditForm:initial'][] = 'EditPageTracking::onEditForm';

/** Configuration **/

/** The registration cutoff for recording this data **/
$wgEditPageTrackingRegistrationCutoff = null;

abstract class EditPageTracking {

	/**
	 * Applies EditPageTracking schema updates.
	 *
	 * @param $updater DatabaseUpdater
	 */
	public static function doSchemaUpdates( $updater = null ) {
		$updater->addExtensionUpdate( array( 'addTable', 'edit_page_tracking',
			dirname(__FILE__).'/edit_page_tracking.sql', true ) );

		return true;
	}

	/**
	 * Monitors edit page usage
	 */
	public static function onEditForm( EditPage $editPage ) {
		global $wgUser, $wgEditPageTrackingRegistrationCutoff, $wgMemc;

		// Anonymous users
		if ( $wgUser->isAnon() ) {
			return true;
		}

		if ( $wgEditPageTrackingRegistrationCutoff &&
			$wgUser->getRegistration() < $wgEditPageTrackingRegistrationCutoff )
		{
			// User registered before the cutoff
			return true;
		}

		if ( EditPageTracking::getFirstEditPage( $wgUser ) ) {
			// Already stored.
			return true;
		}

		// Record it
		$dbw = wfGetDB( DB_MASTER );

		$title = $editPage->getArticle()->getTitle();
		$timestamp = wfTimestampNow();

		$row = array(
			'ept_user' => $wgUser->getId(),
			'ept_namespace' => $title->getNamespace(),
			'ept_title' => $title->getDBkey(),
			'ept_timestamp' => $dbw->timestamp( $timestamp ),
		);

		$dbw->insert( 'edit_page_tracking', $row, __METHOD__ );

		$wgUser->mFirstEditPage = $timestamp;

		$cacheKey = wfMemcKey( 'first-edit-page', $wgUser->getId() );
		$wgMemc->set($cacheKey, $timestamp, 86400);

		return true;
	}

	/**
	 * Gets the first time a user opened an edit page
	 * @param $user User The User to check.
	 * @return The timestamp of the first time the user opened an edit page.
	 * false for an anonymous user, null for a user who has never opened an edit page.
	 */
	public static function getFirstEditPage( $user ) {
		global $wgMemc;

		if ( isset($user->mFirstEditPage) ) {
			return $user->mFirstEditPage;
		}

		if ( $user->isAnon() ) {
			return false;
		}

		$cacheKey = wfMemcKey( 'first-edit-page', $user->getId() );
		$cacheVal = $wgMemc->get($cacheKey);

		if ( $cacheVal !== false ) {
			$user->mFirstEditPage = $cacheVal;
			return $cacheVal;
		}

		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select( 'edit_page_tracking', 'ept_timestamp',
			array( 'ept_user' => $user->getID() ),
			__METHOD__, array( 'ORDER BY' => 'ept_timestamp asc' ) );

		if ( $dbr->numRows($res) == 0 ) {
			$user->mFirstEditPage = null;
			$wgMemc->set( $cacheKey, null, 86400 );
			return null;
		}

		$row = $dbr->fetchObject( $res );

		$user->mFirstEditPage = wfTimestamp( TS_MW, $row->ept_timestamp );
		$wgMemc->set($cacheKey, $user->mFirstEditPage, 86400);

		return $user->mFirstEditPage;
	}

}
