<?php

class ContributionAppreciationController extends WikiaController {

	public function appreciate() {
		$user = $this->wg->User;

		$this->request->isValidWriteRequest( $user );

		$revisionId = $this->request->getInt( 'revision' );
		$revision = Revision::newFromId( $revisionId );
		if ( $revision instanceof Revision ) {
			( new RevisionUpvotesService() )->addUpvote(
				$this->wg->CityId,
				$revision->getPage(),
				$revisionId,
				$revision->getUser(),
				$user->getId()
			);
		}
	}

	public function getAppreciations() {
		$html = '';
		$user = $this->wg->User;
		$upvotesService = new RevisionUpvotesService();
		$upvotes = $upvotesService->getUserNewUpvotes( $user->getId() );

		if ( !empty( $upvotes ) ) {
			$appreciations = $this->prepareAppreciations( $upvotes );

			$html = $this->app->renderView( 'ContributionAppreciation', 'appreciations', [
				'appreciations' => $appreciations,
				'userName' => $user
			] );
		}

		$this->setVal( 'html', $html );
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
		if ( self::shouldDisplayApprectiation() ) {
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
		if ( self::shouldDisplayApprectiation() ) {
			$tools[] = F::app()->renderView( 'ContributionAppreciation', 'historyModule', [ 'revision' => $row->rev_id ] );
		}

		return true;
	}

	public static function onPageHistoryBeforeList() {
		if ( self::shouldDisplayApprectiation() ) {
			Wikia::addAssetsToOutput( 'contribution_appreciation_js' );
			Wikia::addAssetsToOutput( 'contribution_appreciation_scss' );
		}

		return true;
	}

	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		if ( self::shouldDisplayApprectiation() ) {
			Wikia::addAssetsToOutput( 'contribution_appreciation_user_js' );
		}

		return true;
	}

	private static function shouldDisplayApprectiation() {
		global $wgUser, $wgLang;

		return $wgUser->isLoggedIn() && $wgLang->getCode() === 'en';

	}

	private function prepareAppreciations( $upvotes ) {
		$appreciations = [];

		foreach( $upvotes as $upvote ) {
			$wikiId = $upvote['revision']['wikiId'];
			$title = GlobalTitle::newFromId( $upvote['revision']['pageId'], $wikiId );

			if ( !$title instanceof Title ) {
				continue;
			}

			$diffLink = $this->getDiffLink( $title, $upvote['revision']['revisionId'] );
			$userLinks = $this->getUserLinks( $upvote['upvotes'], $wikiId );

			if ( !empty( $userLinks ) ) {
				$appreciations[] = $this->getUserAppreciationMessage( $userLinks, $diffLink );
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
		$userLinks = [];
		foreach ( $upvotes as $upvote ) {
			$userLinks[] = $this->getUserLink( $upvote['from_user'], $wikiId );
		}

		return $userLinks;
	}

	private function getUserLink( $userId, $wikiId ) {
		$user = User::newFromId( $userId );
		$title = GlobalTitle::newFromText( $user->getName(), NS_USER, $wikiId);

		return Html::element( 'a', [
			'href' => $title->getFullURL(),
			'data-tracking' => 'notification-userpage-link',
			'target' => '_blank'
		], $user->getName() );
	}

	private function getUserAppreciationMessage( $userLinks, $diffLink ) {
		return wfMessage( 'appreciation-user', count( $userLinks ) )->rawParams(
			implode( ', ', $userLinks ),
			$diffLink
		)->escaped();
	}
}
