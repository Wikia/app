<?php

class InsightsWantedpagesModel extends InsightsSubpageModel {
	public $settings = [
		'template' => 'subpageList',
	];

	public function getDataProvider() {
		return new WantedPagesPage();
	}

	public function prepareData( $res ) {
		$data = [];
		$dbr = wfGetDB( DB_SLAVE );
		while ( $row = $dbr->fetchObject( $res ) ) {
			$article = [];
			$title = Title::newFromText( $row->title );

			$article['title'] = $title->getText();
			$article['link'] = $title->getFullURL();
			$data[] = $article;
		}
		return $data;
	}
}
