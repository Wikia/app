<?php

class UnsubscribePreferences {

	/**
	 * @param User $user
	 * @param Array $defaultPreferences
	 * @return bool
	 */
	public static function onGetPreferences( $user, &$defaultPreferences ) {
		global $wgJsMimeType, $wgExtensionsPath, $wgCityId;
		F::app()->wg->Out->addScript( "<script type=\"{$wgJsMimeType}\" src=\"$wgExtensionsPath/wikia/SpecialUnsubscribe/UnsubscribePreferences.js\"></script>" );

		$unsubscribe = array( 'unsubscribed' => array(
			'type' => 'toggle',
			'section' => 'personal/email',
			'label-message' => 'unsubscribe-preferences-toggle',
			)
		);

		$notice = array( 'no-email-notice-followedpages' => array(
			'type' => 'info',
			'section' => 'watchlist/basic',
			'default' => wfMsg( 'unsubscribe-preferences-notice' ),
			)
	       );

		// move e-mail options higher up
		$emailAddress = array( 'emailaddress' => $defaultPreferences['emailaddress'] );
		unset( $defaultPreferences['emailaddress'] );
		$defaultPreferences = self::insert( $defaultPreferences, 'language', $emailAddress, false );

		// move founder emails higher up
		$founderEmailsFirstKey = "adoptionmails-label-$wgCityId";
		if ( !empty( $defaultPreferences[$founderEmailsFirstKey] ) ) {
			$founderEmails = array( $founderEmailsFirstKey => $defaultPreferences[$founderEmailsFirstKey] );
			unset( $defaultPreferences[$founderEmailsFirstKey] );
			$defaultPreferences = self::insert( $defaultPreferences, 'emailaddress', $founderEmails );
		}

		// add the unsubscribe checkbox
		$defaultPreferences = self::insert( $defaultPreferences, 'emailauthentication', $unsubscribe );

		// add a notice if needed
		if ( $user->getOption( 'unsubscribe' ) ) {
			$defaultPreferences = self::insert( $defaultPreferences, 'watchdefault', $notice, false );
		}


		$defaultPreferences = self::insert( $defaultPreferences, 'language', $emailAddress, false );

		return true;
	}

	/**
	 * inserts an option array before or after the specified key
	 *
	 * @param array $subject preferences array
	 * @param string $key the key relative to which we'll be inserting
	 * @param array $contents the stuff to insert
	 * @param bool $direction insert after key if true, before if false
	 */
	private static function insert( $subject, $key, $content, $direction = true ) {
		$displacedContent = array( $key => $subject[$key] );

		$subjectAfter = array_splice(
			$subject,
			array_search( $key, array_keys( $subject ) )
		);

		if ( $direction ) {
			$missingPiece = array_merge( $displacedContent, $content );
		} else {
			$missingPiece = array_merge( $content, $displacedContent );
		}

		return array_merge( $subject, $missingPiece, $subjectAfter );
	}
}
