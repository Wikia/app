<?php

class ContributionAppreciationController extends WikiaController {
	const EMAIL_CATEGORY = 'ContributionAppreciationMessage';
	const TRACKING_URL = 'https://beacon.wikia-services.com/__track/special/appreciation_email';

	public function appreciate() {
		global $wgUser, $wgCityId;

		$this->request->assertValidWriteRequest( $wgUser );
		$revisionId = $this->request->getInt( 'revision' );
		$revision = Revision::newFromId( $revisionId );

		if ( $revision ) {
			( new RevisionUpvotesService() )->addUpvote(
				$wgCityId,
				$revision->getPage(),
				$revisionId,
				$revision->getUser(),
				$wgUser->getId()
			);

			$this->sendMail( $revisionId );
		}
	}

	public function getAppreciations() {
		global $wgUser;

		$html = '';
		$upvotesService = new RevisionUpvotesService();
		$upvotes = $upvotesService->getUserNewUpvotes( $wgUser->getId() );

		if ( !empty( $upvotes ) ) {
			$appreciations = $this->prepareAppreciations( $upvotes );

			if ( !empty( $appreciations ) ) {
				$html = $this->app->renderView( 'ContributionAppreciation', 'appreciations', [
					'appreciations' => $appreciations
				] );
			}
		}

		$this->response->setBody( $html );
	}

	public function appreciations() {
		$appreciations = $this->getVal( 'appreciations' );
		$numberOfAppreciations = count( $appreciations );
		$this->numberOfHiddenAppreciations = $numberOfAppreciations > 2 ? $numberOfAppreciations - 2 : 0;
		$this->appreciations = $appreciations;
	}

	public function diffModule() {
		$this->response->setValues( $this->request->getParams() );
	}

	public function historyModule() {
		$this->response->setValues( $this->request->getParams() );
	}

	public static function onAfterDiffRevisionHeader( DifferenceEngine $diffPage, Revision $newRev, OutputPage $out ) {
		global $wgUser;

		// no appreciation for yourself
		if ( self::shouldDisplayAppreciation() && $wgUser->getId() !== $newRev->getUser() ) {
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
		global $wgUser;

		// no appreciation for yourself
		if ( self::shouldDisplayAppreciation() && $wgUser->getId() !== intval( $row->rev_user ) ) {
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
			if ( self::isAppreciationEmailEvent( $event ) ) {
				if ( preg_match( '/diff=([0-9]*)/', $event[ 'url' ], $diff ) ) {
					self::sendDataToDW( 'button_clicked', $event[ 'wikia-email-city-id' ], $diff[ 1 ] );
				} elseif ( preg_match( '/rev_id=([0-9]*)/', $event[ 'url' ], $revId ) ) {
					self::sendDataToDW( 'diff_link_clicked', $event[ 'wikia-email-city-id' ], $revId[ 1 ] );
				}
			}
		}
	}

	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		if ( self::shouldDisplayAppreciation() ) {
			Wikia::addAssetsToOutput( 'contribution_appreciation_user_js' );
			Wikia::addAssetsToOutput( 'contribution_appreciation_user_scss' );
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
			strpos( $event[ 'category' ], self::EMAIL_CATEGORY ) !== false;
	}

	/**
	 * Basing on params, create url to send tracking data to DW and send it.
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
			$url = self::TRACKING_URL .
				'?wiki_id=' . $wikiId .
				'&email_action=' . $action .
				'&page_id=' . $revision->getTitle()->getArticleID() .
				'&rev_id=' . $revision->getId() .
				'&user_id=' . $revision->getUser();

			Http::get( $url );
		}
	}

	private static function shouldDisplayAppreciation() {
		global $wgUser, $wgLang, $wgEnableCommunityPageExt;

		// we want to run it only for english users
		return $wgUser->isLoggedIn() && $wgLang->getCode() === 'en' && !empty( $wgEnableCommunityPageExt );
	}

	private function prepareAppreciations( $upvotes ) {
		$appreciations = [ ];

		foreach ( $upvotes as $upvote ) {
			$wikiId = $upvote[ 'revision' ][ 'wikiId' ];
			$title = GlobalTitle::newFromId( $upvote[ 'revision' ][ 'pageId' ], $wikiId );

			if ( $title && $title->exists() ) {
				$diffLink = $this->getDiffLink( $title, $upvote[ 'revision' ][ 'revisionId' ] );
				$userLinks = $this->getUserLinks( $upvote[ 'upvotes' ], $wikiId );

				if ( !empty( $userLinks ) ) {
					$appreciations[] = [
						'userLinks' => $userLinks,
						'diffLink' => $diffLink
					];
				}
			}
		}

		return $appreciations;
	}

	private function getDiffLink( Title $title, $revisionId ) {
		return Html::element( 'a', [
			'href' => $title->getFullURL( [ 'diff' => $revisionId, 'oldid' => 'prev' ] ),
			'data-tracking' => 'notification-diff-link',
			'target' => '_blank',
			'class' => 'article-title'
		], $title->getText());
	}

	private function getUserLinks( $upvotes, $wikiId ) {
		$userLinks = [ ];
		foreach ( $upvotes as $upvote ) {
			$userLinks[] = $this->getUserLink( $upvote[ 'from_user' ], $wikiId );
		}

		return $userLinks;
	}

	private function getUserLink( $userId, $wikiId ) {
		$user = User::newFromId( $userId );
		$title = GlobalTitle::newFromText( $user->getName(), NS_USER, $wikiId );

		return Html::element( 'a', [
			'href' => $title->getFullURL(),
			'data-tracking' => 'notification-userpage-link',
			'target' => '_blank',
			'class' => 'username'
		], $user->getName() );
	}

	private function sendMail( $revisionId ) {
		global $wgSitename;

		$revision = Revision::newFromId( $revisionId );

		if ( $revision ) {
			$editedPageTitle = $revision->getTitle();
			$params = [
				'buttonLink' => SpecialPage::getTitleFor( 'Community' )->getFullURL( [
					'rev_id' => $revision->getId()
				] ),
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
