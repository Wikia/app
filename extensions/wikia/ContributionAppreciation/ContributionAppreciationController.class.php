<?php

class ContributionAppreciationController extends WikiaController {

	public function appreciate() {
		global $wgUser;

		if ( $this->request->isValidWriteRequest( $wgUser ) ) {
			//TODO: do something with apprecation
		}
	}

	public function diffModule() {
		$this->response->setValues( array_map( [ 'Sanitizer', 'encodeAttribute' ], $this->request->getParams() ) );
	}

	public function historyModule() {
		$this->response->setValues( array_map( [ 'Sanitizer', 'encodeAttribute' ], $this->request->getParams() ) );
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
}
