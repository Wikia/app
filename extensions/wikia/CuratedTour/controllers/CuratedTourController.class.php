<?php

class CuratedTourController extends WikiaController {

	public function getCuratedTourData() {
		$this->response->setFormat('json');
		$text = json_decode( $this->getCuratedTourPage()->getText(), true );
		$this->response->setVal( 'data', $text );
	}

	public function setCuratedTourData() {
		if ( $this->request->wasPosted() && $this->wg->User->matchEditToken( $this->getVal( 'editToken' ) ) ) {
			$data = $this->getVal( 'currentTourData' );

			try {
				$this->getCuratedTourPage()->doEdit( json_encode( $data ), NS_MEDIAWIKI );
				$this->response->setVal( 'status', true );
			} catch ( Exception $e ) {
				$this->response->setVal( 'status', false );
			}
		}
		else {
			$this->response->setVal( 'status', false );
		}
	}

	private function getCuratedTourPage() {
		$title = \Title::newFromText( wfMessage( 'curated-tour-page-title' )->escaped(), NS_MEDIAWIKI );
		return new WikiPage( $title );
	}
}
