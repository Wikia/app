<?php

/**
 * Static class for hooks handled by the Contest extension.
 *
 * @since 0.1
 *
 * @file Contest.hooks.php
 * @ingroup Contest
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class ContestHooks {

	/**
	 * Schema update to set up the needed database tables.
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/LoadExtensionSchemaUpdates
	 *
	 * @since 0.1
	 *
	 * @param DatabaseUpdater $updater
	 *
	 * @return true
	 */
	public static function onSchemaUpdate( DatabaseUpdater $updater ) {
		$updater->addExtensionUpdate( array(
			'addTable',
			'contests',
			dirname( __FILE__ ) . '/Contest.sql',
			true
		) );

		$updater->addExtensionUpdate( array(
			'addField',
			'contests',
			'contest_signup_email',
			dirname( __FILE__ ) . '/sql/AddContestEmailFields.sql',
			true
		) );
		
		$updater->addExtensionUpdate( array(
			'applyPatch',
			dirname( __FILE__ ) . '/sql/UpdateContestantRatingField.sql',
			true
		) );

		return true;
	}

	/**
	 * Hook to add PHPUnit test cases.
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/UnitTestsList
	 *
	 * @since 0.1
	 *
	 * @param array $files
	 *
	 * @return true
	 */
	public static function registerUnitTests( array &$files ) {
		$testDir = dirname( __FILE__ ) . '/test/';

		$files[] = $testDir . 'ContestValidationTests.php';

		return true;
	}

	/**
	 * Called when changing user email address.
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/UserSetEmail
	 *
	 * Checks if there are any active contests in which the user is participating,
	 * and if so, updates the email there as well.
	 *
	 * @since 0.1
	 *
	 * @param User $user
	 * @param string $email
	 *
	 * @return true
	 */
	public static function onUserSetEmail( User $user, &$email ) {
		$dbr = wfGetDB( DB_SLAVE );

		$contestants = $dbr->select(
			array( 'contest_contestants', 'contests' ),
			array( 'contestant_id' ),
			array( 'contest_status' => Contest::STATUS_ACTIVE, 'contestant_user_id' => $user->getId() ),
			__METHOD__,
			array(),
			array( 'contests' => array( 'INNER JOIN', array( 'contest_id=contestant_contest_id' ) ) )
		);

		$contestantIds = array();

		foreach ( $contestants as $contestant ) {
			$contestantIds[] = $contestant->contestant_id;
		}

		if ( count( $contestantIds ) > 0 ) {
			ContestContestant::s()->update(
				array( 'email' => $email ),
				array( 'id' => $contestantIds )
			);
		}

		return true;
	}

	/**
	 * Called after the personal URLs have been set up, before they are shown.
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/PersonalUrls
	 *
	 * @since 0.1
	 *
	 * @param array $personal_urls
	 * @param Title $title
	 *
	 * @return true
	 */
	public static function onPersonalUrls( array &$personal_urls, Title &$title ) {
		if ( ContestSettings::get( 'enableTopLink' ) ) {
			global $wgUser;

			// Find the watchlist item and replace it by the my contests link and itself.
			if ( $wgUser->isLoggedIn() && $wgUser->getOption( 'contest_showtoplink' ) ) {
				$url = SpecialPage::getTitleFor( 'MyContests' )->getLinkUrl();
				$myContests = array(
					'text' => wfMsg( 'contest-toplink' ),
					'href' => $url,
					'active' => ( $url == $title->getLinkUrl() )
				);

				$insertUrls = array( 'mycontests' => $myContests );
		
				$personal_urls = wfArrayInsertAfter( $personal_urls, $insertUrls, 'preferences' );
			}
		}

		return true;
	}

	/**
	 * Adds the preferences of Contest to the list of available ones.
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/GetPreferences
	 *
	 * @since 0.1
	 *
	 * @param User $user
	 * @param array $preferences
	 *
	 * @return true
	 */
	public static function onGetPreferences( User $user, array &$preferences ) {
		if ( ContestSettings::get( 'enableTopLink' ) ) {
			$preferences['contest_showtoplink'] = array(
				'type' => 'toggle',
				'label-message' => 'contest-prefs-showtoplink',
				'section' => 'contest',
			);
		}

		return true;
	}

	/**
	 * Used when generating internal and interwiki links in Linker::link(),
	 * just before the function returns a value.
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/LinkEnd
	 *
	 * @since 0.1
	 *
	 * @param $skin
	 * @param Title $target
	 * @param array $options
	 * @param string $text
	 * @param array $attribs
	 * @param $ret
	 *
	 * @return true
	 */
	public static function onLinkEnd( $skin, Title $target, array $options, &$text, array &$attribs, &$ret ) {
		if ( $GLOBALS['wgContestEmailParse'] ) {
			$attribs['href'] = $target->getFullURL();
		}

		return true;
	}

}
