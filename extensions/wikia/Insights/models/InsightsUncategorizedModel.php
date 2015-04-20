<?php

class InsightsUncategorizedModel extends InsightsQuerypageModel {

	public $type = 'Uncategorizedpages';

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

	public function isItemFixed( WikiPage $wikiPage ) {
		$title = Title::newFromID( $wikiPage->getId() );
		$categories = $title->getParentCategories( true );
		if ( !empty( $categories ) ) {
			return $this->removeFixedItem( $this->type, $title );
		}
		return false;
	}
}
