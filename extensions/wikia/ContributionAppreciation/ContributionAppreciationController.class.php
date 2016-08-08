<?php

class ContributionAppreciationController extends WikiaController {

	public function appreciate() {
		global $wgUser;

		if ( $this->request->isValidWriteRequest( $wgUser ) ) {
			//TODO: do something with apprecation
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

		if ( $wgUser->isLoggedIn() ) {
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

		if ( $wgUser->isLoggedIn() ) {
			$tools[] = F::app()->renderView( 'ContributionAppreciation', 'historyModule', [ 'revision' => $row->rev_id ] );
		}

		return true;
	}

	public static function onPageHistoryBeforeList() {
		global $wgUser;

		if ( $wgUser->isLoggedIn() ) {
			Wikia::addAssetsToOutput( 'contribution_appreciation_js' );
			Wikia::addAssetsToOutput( 'contribution_appreciation_scss' );
		}

		return true;
	}
}
