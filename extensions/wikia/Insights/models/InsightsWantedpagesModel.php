<?php

class InsightsWantedpagesModel extends InsightsQuerypageModel {
	public $type = 'Wantedpages';

	public function getDataProvider() {
		return new WantedPagesPage();
	}

	public function prepareData( $res ) {
		$data = [];
		$dbr = wfGetDB( DB_SLAVE );
		while ( $row = $dbr->fetchObject( $res ) ) {
			$article = [];
			$title = Title::newFromText( $row->title );
			$article['link'] = Linker::link( $title );
			$data[] = $article;
		}
		return $data;
	}

	public function isItemFixed( Article $article ) {
		if( $article->getID() !== 0 ) {
			return $this->removeFixedItem( $this->type, $article->getTitle() );
		}
		return false;
	}
}
