<?php

class ContributionAppreciationController extends WikiaController {
	const CONTRIBUTION_APPRECIATION_EMAIL_CONTROLLER = Email\Controller\ContributionAppreciationMessageController::class;

	public function appreciate() {
		global $wgUser;

		if ( $this->request->wasPosted() && $wgUser->matchEditToken( $this->getVal( 'token' ) ) ) {
			//TODO: do something with apprecation
			$this->response->setFormat( WikiaResponse::FORMAT_JSON );
			$this->setVal( 'user', $wgUser->getName() );
			$this->setVal( 'for', Revision::newFromId( $this->request->getInt( 'revision' ) )->getUserText() );

			$this->sendMail( Revision::newFromId( $this->request->getInt( 'revision' ) ) );
		}
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

	private static function getAppreciationLink( $revision ) {
		return Html::element( 'a',
			[
				'class' => 'like',
				'href' => '#',
				'data-revision' => $revision
			],
			wfMessage( 'appreciation-text' )->escaped() );
	}

	public function sendMail( \Revision $revision ) {
	//public function sendMail() {
		global $wgUser, $wgSitename;

		//$revision = Revision::newFromId( 1569246 );

		if ( !$revision ) {
			return;
		}
		$editedPageTitle = $revision->getTitle();

		$params = [
			'buttonLink' =>  SpecialPage::getTitleFor( 'Community' )->getFullURL(),
			//'targetUser' => $wgUser, //testing
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
