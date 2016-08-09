<?php

class ContributionAppreciationController extends WikiaController {
	const CONTRIBUTION_APPRECIATION_EMAIL_CONTROLLER = Email\Controller\ContributionAppreciationMessageController::class;
	const EMAIL_CATEGORY = 'ContributionAppreciationMessage';

	public function appreciate() {
		global $wgUser;

		if ( $this->request->isValidWriteRequest( $wgUser ) ) {
			//TODO: do something with apprecation
			$this->sendMail( Revision::newFromId( $this->request->getInt( 'revision' ) ) );
		}
	}

	public static function onDiffHeader( DifferenceEngine $diffPage, $oldRev, Revision $newRev ) {
		global $wgUser;

		if ( $wgUser->isLoggedIn() ) {
			Wikia::addAssetsToOutput( 'contribution_appreciation_js' );
			$diffPage->getOutput()->addHTML( self::getAppreciationLink( $newRev->getId() ) );
		}

		return true;
	}

	public static function onPageHistoryLineEnding( HistoryPager $pager, $row, &$s, $classes ) {
		global $wgUser;

		if ( $wgUser->isLoggedIn() ) {
			$s .= self::getAppreciationLink( $row->rev_id );
		}

		return true;
	}

	public static function onPageHistoryBeforeList() {
		global $wgUser;

		if ( $wgUser->isLoggedIn() ) {
			Wikia::addAssetsToOutput( 'contribution_appreciation_js' );
		}

		return true;
	}

	public static function onSendGridPostbackLogEvents( $events ) {
		foreach ( $events as $event ) {
			if ( $event[ 'event' ] == 'click' && strpos( $event[ 'category' ], self::EMAIL_CATEGORY ) !== false ) {
				if ( preg_match( '/diff=([0-9]*)/', $event[ 'url' ], $matches ) ) {
					self::sendDataToDW( 'button_clicked', $event[ 'wikia-email-city-id' ], $matches[ 1 ] );
					// for now appreciation functionality is enabled only in English
				} elseif ( strpos( $event[ 'url' ], 'Special:Community' ) !== false ) {
					self::sendDataToDW( 'diff_link_clicked', $event[ 'wikia-email-city-id' ] );
				}
			}
		}

		return true;
	}

	/**
	 * Basing on params, create url to send tracking data to DW and send it.
	 *
	 * @param string $action - how user interacted with email
	 * @param int $wikiId - id of wiki user made contribution on
	 * @param int $revisionId
	 */
	private static function sendDataToDW( $action, $wikiId, $revisionId = -1 ) {

		// TODO: to be changed to: 'appreciation_email'
		$url = 'https://beacon.wikia-services.com/__track/special/testappreciation_email' .
			'?wiki_id=' . $wikiId .
			'&email_action=' . $action;

		if ( $revisionId > 0 ) {
			$dbname = \WikiFactory::IDtoDB( $wikiId );
			$db = wfGetDB( DB_SLAVE, [ ], $dbname );
			$revision = Revision::loadFromId( $db, $revisionId );

			if ( $revision ) {
				$url .=
					'&page_id=' . $revision->getTitle()->getArticleID() .
					'&user_id=' . $revision->getUser();
			}
		}

		Http::get( $url );
	}

	private static function getAppreciationLink( $revision ) {
		return Html::element( 'button',
			[
				'class' => 'appreciation-button',
				'href' => '#',
				'data-revision' => $revision
			],
			wfMessage( 'appreciation-text' )->escaped() );
	}

	public function sendMail( \Revision $revision ) {
		global $wgSitename;

		if ( !$revision ) {
			return;
		}
		$editedPageTitle = $revision->getTitle();

		$params = [
			'buttonLink' =>  SpecialPage::getTitleFor( 'Community' )->getFullURL(),
			'targetUser' => $revision->getUserText(),
			'editedPageTitleText' => $editedPageTitle->getText(),
			'editedWikiName' => $wgSitename,
			'revisionUrl' => $editedPageTitle->getFullURL( [
				'diff' => $revision->getId()
			] )
		];

		F::app()->sendRequest( self::CONTRIBUTION_APPRECIATION_EMAIL_CONTROLLER, 'handle', $params );
	}
}
