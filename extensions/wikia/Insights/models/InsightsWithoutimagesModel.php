<?php

class InsightsWithoutimagesModel extends InsightsQuerypageModel {
	public $type = 'Withoutimages';

	public function getDataProvider() {
		return new WithoutimagesPage();
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

	public function isItemFixed( Article $article ) {
		$dbr = wfGetDB( DB_MASTER );
		$row = $dbr->selectRow( 'imagelinks', '*' , [ 'il_from' => $article->getID() ] );
		if ( $row ) {
			return $this->removeFixedItem( $this->type, $article->getTitle() );
		}
		return false;
	}
}
