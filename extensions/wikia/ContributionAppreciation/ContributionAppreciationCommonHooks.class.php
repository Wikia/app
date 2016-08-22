<?php

class ContributionAppreciationCommonHooks {
	const TRACKING_URL = 'https://beacon.wikia-services.com/__track/special/appreciation_email';
	const EMAIL_CATEGORY = 'ContributionAppreciationMessage';

	public static function onSendGridPostbackLogEvents( $events ) {
		foreach ( $events as $event ) {
			if ( static::isAppreciationEmailEvent( $event ) ) {
				if ( preg_match( '/diff=([0-9]*)/', $event[ 'url' ], $diff ) ) {
					static::sendDataToDW( 'button_clicked', $event[ 'wikia-email-city-id' ], $diff[ 1 ] );
				} elseif ( preg_match( '/rev_id=([0-9]*)/', $event[ 'url' ], $revId ) ) {
					static::sendDataToDW( 'diff_link_clicked', $event[ 'wikia-email-city-id' ], $revId[ 1 ] );
				}
			}
		}

		return true;
	}

	/**
	 * Check if event is from sendgrid hook is an appreciation email and has set
	 * all needed fields.
	 *
	 * @param $event from sendgrid hook
	 * @return bool
	 */
	private static function isAppreciationEmailEvent( $event ) {
		return isset( $event[ 'event' ] ) &&
		isset( $event[ 'category' ] ) &&
		isset( $event[ 'url' ] ) &&
		isset( $event[ 'wikia-email-city-id' ] ) &&
		$event[ 'event' ] == 'click' &&
		strpos( $event[ 'category' ], static::EMAIL_CATEGORY ) !== false;
	}

	/**
	 * Basing on params, create url to send tracking data to DW and send it.
	 * If code will appear to be used not only in experiment, move it to
	 * place independent of this extension: https://wikia-inc.atlassian.net/browse/WW-178
	 *
	 * @param string $action - how user interacted with email
	 * @param int $wikiId - id of wiki user made contribution on
	 * @param int $revisionId
	 */
	private static function sendDataToDW( $action, $wikiId, $revisionId ) {
		$dbname = \WikiFactory::IDtoDB( $wikiId );
		$db = wfGetDB( DB_SLAVE, [ ], $dbname );
		$revision = Revision::loadFromId( $db, $revisionId );

		if ( $revision ) {
			$url = static::TRACKING_URL .
				'?wiki_id=' . $wikiId .
				'&email_action=' . $action .
				'&page_id=' . $revision->getTitle()->getArticleID() .
				'&rev_id=' . $revision->getId() .
				'&user_id=' . $revision->getUser();

			Http::get( $url );
		}
	}
}
