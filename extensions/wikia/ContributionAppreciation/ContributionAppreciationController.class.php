<?php

class ContributionAppreciationController extends WikiaController {
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
					'appreciations' => $appreciations,
					'userName' => $wgUser
				] );
			}
		}

		$this->response->setBody( $html );
	}

	public function appreciations() {
		$this->userName = $this->getVal( 'userName' );
		$this->appreciations = $this->getVal( 'appreciations' );
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


	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		if ( self::shouldDisplayAppreciation() ) {
			Wikia::addAssetsToOutput( 'contribution_appreciation_user_js' );
		}

		return true;
	}

	private static function shouldDisplayAppreciation() {
		global $wgUser, $wgLang;

		// we want to run it only for english users
		return $wgUser->isLoggedIn() && $wgLang->getCode() === 'en';
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
			'target' => '_blank'
		], wfMessage( 'appreciation-user-contribution' )->escaped() );
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
			'target' => '_blank'
		], $user->getName() );
	}

	private function sendMail( $revisionId ) {
		global $wgSitename;

		$revision = Revision::newFromId( $revisionId );

		if ( $revision ) {
			$editedPageTitle = $revision->getTitle();
			$params = [
				'buttonLink' => SpecialPage::getTitleFor( 'Community' )->getFullURL(),
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
