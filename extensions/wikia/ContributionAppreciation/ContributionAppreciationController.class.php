<?php

class ContributionAppreciationController extends WikiaController {
	const EMAIL_CATEGORY = 'ContributionAppreciationMessage';

	public function appreciate() {
		global $wgUser;

		$this->request->assertValidWriteRequest( $wgUser );
		$this->sendMail( $this->request->getInt( 'revision' ) );
	}

	public function diffModule() {
		$this->response->setValues( $this->request->getParams() );
	}

	public function historyModule() {
		$this->response->setValues( $this->request->getParams() );
	}

	public static function onAfterDiffRevisionHeader( DifferenceEngine $diffPage, Revision $newRev, OutputPage $out ) {
		if ( self::shouldDisplayAppreciation() ) {
			Wikia::addAssetsToOutput( 'contribution_appreciation_js' );
			Wikia::addAssetsToOutput( 'contribution_appreciation_scss' );
			$out->addHTML( F::app()->renderView(
				'ContributionAppreciation',
				'diffModule',
				[ 'revision' => $newRev->getId(), 'username' => $newRev->getUserText() ]
			) );
		}

		return true;
	}

	public static function onPageHistoryToolsList( HistoryPager $pager, $row, &$tools ) {
		if ( self::shouldDisplayAppreciation() ) {
			$tools[] = F::app()->renderView( 'ContributionAppreciation', 'historyModule', [ 'revision' => $row->rev_id ] );
		}

		return true;
	}

	public static function onPageHistoryBeforeList() {
		if ( self::shouldDisplayAppreciation() ) {
			Wikia::addAssetsToOutput( 'contribution_appreciation_js' );
			Wikia::addAssetsToOutput( 'contribution_appreciation_scss' );
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

	private static function shouldDisplayAppreciation() {
		global $wgUser, $wgLang;

		// we want to run it only for english users
		return $wgUser->isLoggedIn() && $wgLang->getCode() === 'en';
	}

	private function sendMail( $revisionId ) {
		global $wgSitename;

		$revision = Revision::newFromId( $revisionId );

		if ( $revision ) {
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

			$this->app->sendRequest( 'Email\Controller\ContributionAppreciationMessageController', 'handle', $params );
		}
	}
}
