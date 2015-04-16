<?php

class InsightsUncategorizedModel extends InsightsSubpageModel {
	public $settings = [
		'template' => 'subpageList',
	];

	public function getDataProvider() {
		return new UncategorizedPagesPage();
	}

	public function prepareData( $res ) {
		$data = [];
		$dbr = wfGetDB( DB_SLAVE );
		while ( $row = $dbr->fetchRow( $res ) ) {
			if ( $row['title'] ) {
				$article = [];

				$title = Title::newFromText( $row['title'] );

				$article['title'] = $title->getText();
				$article['link'] = $title->getFullURL();

				$lastRev = $title->getLatestRevID();
				$rev = Revision::newFromId( $lastRev );

				if ( $rev ) {
					$article['revision'] = $this->prepareRevisionData( $rev );
					$data[ $title->getArticleID() ] = $article;
				}
			}
		}
		return $data;
	}
}