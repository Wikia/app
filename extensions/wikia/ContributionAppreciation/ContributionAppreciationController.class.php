<?php

class ContributionAppreciationController extends WikiaController {
	const CONTRIBUTION_APPRECIATION_EMAIL_CONTROLLER = Email\Controller\ContributionAppreciationMessageController::class;

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
