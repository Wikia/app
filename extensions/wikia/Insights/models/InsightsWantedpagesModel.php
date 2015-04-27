<?php

/**
 * Class InsightsWantedpagesModel
 * A class specific to a subpage with a list of pages
 * that do not exist and have been referred to.
 */
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

	/**
	 * Checks if a given article has been fixed by a user
	 * inside a productivity loop.
	 * @param Article $article
	 * @return bool
	 */
	public function isItemFixed( Article $article ) {
		if( $article->getID() !== 0 ) {
			return $this->removeFixedItem( ucfirst( self::INSIGHT_TYPE ), $article->getTitle() );
		}
		return false;
	}

	/**
	 * Prepares a link to a Special:WhatLinksHere page
	 * for the article
	 * @param Title $title The target article's title object
	 * @param $result A number of referring links
	 * @return string A URL to the WLH page
	 * @throws MWException
	 */
	private function makeWlhLink( Title $title, $result ) {
		$wlh = SpecialPage::getTitleFor( 'Whatlinkshere', $title->getPrefixedText() );
		$label = wfMessage( 'insights-wanted-by' )->numParams( $result->value )->escaped();
		return Linker::link( $wlh, $label );
	}
}
