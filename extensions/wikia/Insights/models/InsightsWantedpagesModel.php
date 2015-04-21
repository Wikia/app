<?php

class InsightsWantedpagesModel extends InsightsQuerypageModel {
	const INSIGHT_ID = 'wantedpages';

	public function getDataProvider() {
		return new WantedPagesPage();
	}

	public function prepareData( $res ) {
		$data = [];
		$dbr = wfGetDB( DB_SLAVE );
		while ( $row = $dbr->fetchObject( $res ) ) {
			$article = [];
			$params = $this->getUrlParams();

			$title = Title::newFromText( $row->title );
			$article['link'] = Linker::link( $title, null, [], $params );
			$data[] = $article;
		}
		return $data;
	}

	public function getUrlParams() {
		return $this->getInsightParam();
	}

	public function getInsightId() {
		return self::INSIGHT_ID;
	}
}
