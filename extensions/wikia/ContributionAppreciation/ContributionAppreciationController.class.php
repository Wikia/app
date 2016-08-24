<?php

class ContributionAppreciationController extends WikiaController {
	const SUPPORTED_LANGUAGES = [ 'en' ];

	public function appreciate() {
		global $wgUser, $wgCityId;

		$id = 0;
		$this->request->assertValidWriteRequest( $wgUser );
		$revisionId = $this->request->getInt( 'revision' );
		$revision = Revision::newFromId( $revisionId );

		if ( $revision && !$wgUser->isBlocked() ) {
			$id = ( new RevisionUpvotesService() )->addUpvote(
				$wgCityId,
				$revision->getPage(),
				$revisionId,
				$revision->getUser(),
				$wgUser->getId()
			);

			// send email that user received appreciation.
			// Currently disabled because of: https://wikia-inc.atlassian.net/browse/WW-172
			// $this->sendMail( $revisionId );

			\Wikia\Logger\WikiaLogger::instance()->info('ContributionAppreciationMessage email send', [
				'revision_id' => $revisionId,
				'appreciation_receiver' => $revision->getRawUser()
			]);
		}

		$this->response->setValues( [
			'id' => $id,
			'appreciated' => !empty( $id )
		] );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	public function getAppreciations() {
		global $wgUser;

		$upvotes = ( new RevisionUpvotesService() )->getUserNewUpvotes( $wgUser->getId() );

		if ( !empty( $upvotes ) ) {
			$appreciations = $this->prepareAppreciations( $upvotes );

			if ( !empty( $appreciations ) ) {
				$numberOfAppreciations = count( $appreciations );
				$this->appreciations = $appreciations;
				$this->numberOfHiddenAppreciations = $numberOfAppreciations > 2 ? $numberOfAppreciations - 2 : 0;
			}
		}
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
		if ( static::shouldDisplayAppreciation() && $wgUser->getId() !== $newRev->getUser() ) {
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
		if ( static::shouldDisplayAppreciation() && $wgUser->getId() !== intval( $row->rev_user ) ) {
			$tools[] = F::app()->renderView( 'ContributionAppreciation', 'historyModule', [ 'revision' => $row->rev_id ] );
		}

		return true;
	}

	public static function onPageHistoryBeforeList() {
		if ( static::shouldDisplayAppreciation() ) {
			Wikia::addAssetsToOutput( 'contribution_appreciation_js' );
			Wikia::addAssetsToOutput( 'contribution_appreciation_scss' );
		}

		return true;
	}

	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		if ( static::shouldDisplayAppreciation() ) {
			Wikia::addAssetsToOutput( 'contribution_appreciation_user_js' );
			Wikia::addAssetsToOutput( 'contribution_appreciation_user_scss' );
		}

		return true;
	}

	private static function shouldDisplayAppreciation() {
		global $wgUser, $wgLang, $wgEnableCommunityPageExt;

		// we want to run it only for a subset of users: logged in, not blocked,
		// using languages supported in experiment
		return $wgUser->isLoggedIn() &&
			!$wgUser->isBlocked() &&
			static::isSuportedAppreciationLang( $wgLang->getCode() ) &&
			!empty( $wgEnableCommunityPageExt );
	}

	private static function isSuportedAppreciationLang( $lang ) {
		return in_array( $lang, static::SUPPORTED_LANGUAGES );
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
			$diffAuthor = \User::newFromId( $revision->getUser() );

			// we want to send appreciation email for en users only
			if ( $diffAuthor && static::isSuportedAppreciationLang( $diffAuthor->getGlobalPreference( 'language' ) ) ) {
				$editedPageTitle = $revision->getTitle();
				$params = [
					'buttonLink' => SpecialPage::getTitleFor( 'Community' )->getFullURL(),
					'targetUser' => $diffAuthor->getName(),
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
}
