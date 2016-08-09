<?php

class ContributionAppreciationController extends WikiaController {
	public function appreciate() {
		global $wgUser;

		if ( $this->request->isValidWriteRequest( $wgUser ) ) {
			$this->sendMail( $this->request->getInt( 'revision' ) );
		}
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

	private static function shouldDisplayApprectiation() {
		global $wgUser, $wgLang;

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
