<?php

class InsightsUncategorizedModel extends InsightsQuerypageModel {
	public $settings = [
		'template' => 'subpageList',
	];

	public function getDataProvider() {
		return new UncategorizedPagesPage();
	}

	public function prepareData( $res ) {
		$data = [];
		$dbr = wfGetDB( DB_SLAVE );
		while ( $row = $dbr->fetchObject( $res ) ) {
			if ( $row->title ) {
				$article = [];

				$title = Title::newFromText( $row->title );
				$article['link'] = Linker::link( $title );

				$lastRev = $title->getLatestRevID();
				$rev = Revision::newFromId( $lastRev );

				if ( $rev ) {
					$article['revision'] = $this->prepareRevisionData( $rev );
				}
				$data[] = $article;
			}
		}
		return $data;
	}
}
