<?php

class CuratedTourController extends WikiaController {

	public function saveCuratedTourData() {
		$data = array(
			array(
				'PageName' => 'HomePage',
				'Selector' => '#img',
				'Notes' => 'Test'
			)
		);
		$this->getCuratedTourPage()->doEdit( json_encode( $data ), NS_MEDIAWIKI );
	}

	public function getCuratedTourData() {
		$this->response->setFormat('json');
		$text = json_decode( $this->getCuratedTourPage()->getText(), true );
		$this->response->setVal( 'data', $text );
	}

	private function getCuratedTourPage() {
		$title = \Title::newFromText( wfMessage( 'curated-tour-title' )->escaped(), NS_MEDIAWIKI );
		return new WikiPage( $title );
	}
}
