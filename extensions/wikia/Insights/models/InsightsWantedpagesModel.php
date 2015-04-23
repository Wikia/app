<?php

class InsightsWantedpagesModel extends InsightsQuerypageModel {
	const INSIGHT_TYPE = 'wantedpages';

	public function getDataProvider() {
		return new WantedPagesPage();
	}

	public function prepareData( $res ) {
		$data = [];
		$dbr = wfGetDB( DB_SLAVE );
		while ( $row = $dbr->fetchObject( $res ) ) {
			if ( $row->title ) {
				$article = [];
				$params = $this->getUrlParams();

				$title = Title::newFromText( $row->title );

				$article['link'] = InsightsHelper::getTitleLink( $title, $params );

				$article['metadata']['wantedBy'] = $this->makeWlhLink( $title, $row );

				$data[] = $article;
			}
		}
		return $data;
	}

	public function getInsightType() {
		return self::INSIGHT_TYPE;
	}

	public function isItemFixed( Article $article ) {
		if( $article->getID() !== 0 ) {
			return $this->removeFixedItem( ucfirst( self::INSIGHT_TYPE ), $article->getTitle() );
		}
		return false;
	}

	private function makeWlhLink( $title, $result ) {
		$wlh = SpecialPage::getTitleFor( 'Whatlinkshere', $title->getPrefixedText() );
		$label = wfMessage( 'insights-wanted-by' )->numParams( $result->value )->escaped();
		return Linker::link( $wlh, $label );
	}
}
