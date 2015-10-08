<?php

/**
 * Class InsightsWantedpagesModel
 * A class specific to a subpage with a list of pages
 * that do not exist and have been referred to.
 */
class InsightsWantedpagesModel extends InsightsQueryPageModel {
	const INSIGHT_TYPE = 'wantedpages';

	public function getDataProvider() {
		return new WantedPagesPage();
	}

	public function arePageViewsRequired() {
		return false;
	}

	public function prepareData( $res ) {
		$data = [];
		$dbr = wfGetDB( DB_SLAVE );
		while ( $row = $dbr->fetchObject( $res ) ) {
			if ( $row->title ) {
				$article = [];
				$params = $this->getUrlParams();

				$title = Title::newFromText( $row->title, $row->namespace );
				if ( $title === null ) {
					$this->error( 'WantedPagesModel received reference to non existent page' );
					continue;
				}

				$article['link'] = InsightsHelper::getTitleLink( $title, $params );
				$article['metadata']['wantedBy'] = [
					'message' => $this->wlhLinkMessage(),
					'value' => (int)$row->value,
					'url' => $this->getWlhUrl( $title ),
				];

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
	 * @param Title $title
	 * @return bool
	 */
	public function isItemFixed( Title $title ) {
		if( $title->getArticleID() !== 0 ) {
			return $this->removeFixedItem( ucfirst( self::INSIGHT_TYPE ), $title );
		}
		return false;
	}
}
