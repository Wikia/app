<?php

class ContributionAppreciationController extends WikiaController {

	public function appreciate() {
		global $wgUser;

		if ( $this->request->wasPosted() && $wgUser->matchEditToken( $this->getVal( 'token' ) ) ) {
			//TODO: do something with apprecation
			$this->response->setFormat( WikiaResponse::FORMAT_JSON );
			$this->setVal( 'user', $wgUser->getName() );
			$this->setVal( 'for', Revision::newFromId( $this->request->getInt( 'revision' ) )->getUserText() );
		}
	}

	public function getAppreciations() {
		global $wgUser;

		$html = '';
		$upvotesService = new RevisionUpvotesService();
		$upvotes = $upvotesService->getUserNewUpvotes( $wgUser->getId() );

		if ( !empty( $upvotes ) ) {
			$appreciations = $this->prepareAppreciations( $upvotes );

			$html = $this->app->renderView( 'ContributionAppreciation', 'appreciations', [
				'appreciations' => $appreciations,
				'userName' => $wgUser->getName()
			] );
		}

		$this->setVal( 'html', $html );
	}

	public function appreciations() {
		$this->userName = $this->getVal( 'userName' );
		$this->appreciations = $this->getVal( 'appreciations' );
	}

	private function prepareAppreciations( $upvotes ) {
		$appreciatons = [];

		foreach( $upvotes as $upvote ) {
			$title = GlobalTitle::newFromId( $upvote['revision']['pageId'], $upvote['revision']['wikiId'] );

			if ( !$title instanceof Title ) {
				continue;
			}

			$diffLink = $this->getDiffLink( $title, $upvote['revision']['revisionId'] );

			$userLinks = [];
			foreach ( $upvote['upvotes'] as $userUpvote ) {
				$userLinks[] = $this->getUserLink( $userUpvote['from_user'] );
			}

			if ( !empty( $userLinks ) ) {
				$appreciatons[] = wfMessage( 'appreciation-user', count( $userLinks ) )->rawParams(
					implode( ', ', $userLinks ),
					$diffLink
				)->escaped();
			}
		}

		return $appreciatons;
	}

	private function getDiffLink( Title $title, $revisionId ) {
		return Html::element( 'a', [
			'href' => $title->getFullURL( [ 'diff' => $revisionId, 'oldid' => 'prev' ] )
		], wfMessage( 'appreciation-user-contribution' )->escaped() );
	}

	private function getUserLink( $userId ) {
		$user = User::newFromId( $userId );

		return Html::element( 'a', [
			'href' => $user->getUserPage()->getFullURL()
		], $user->getName() );
	}

	public static function onDiffHeader( DifferenceEngine $diffPage, $oldRev, Revision $newRev ) {
		Wikia::addAssetsToOutput( 'contribution_appreciation_js' );
		$diffPage->getOutput()->addHTML( self::getAppreciationLink( $newRev->getId() ) );

		return true;
	}

	public static function onPageHistoryLineEnding( HistoryPager $pager, $row, &$s, $classes ) {
		$s .= self::getAppreciationLink( $row->rev_id );

		return true;
	}

	public static function onPageHistoryBeforeList() {
		Wikia::addAssetsToOutput( 'contribution_appreciation_js' );

		return true;
	}

	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		if ( $out->getUser()->isLoggedIn() ) {
			Wikia::addAssetsToOutput( 'contribution_appreciation_user_js' );
		}

		return true;
	}

	private static function getAppreciationLink( $revision ) {
		return Html::element( 'a',
			[
				'class' => 'like',
				'href' => '#',
				'data-revision' => $revision
			],
			wfMessage( 'appreciation-text' )->escaped() );
	}
}
