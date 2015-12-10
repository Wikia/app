<?php

/**
 * Class InsightsWantedpagesModel
 * A class specific to a subpage with a list of pages
 * that do not exist and have been referred to.
 */
class InsightsWantedpagesModel extends InsightsQueryPageModel {
	const INSIGHT_TYPE = 'wantedpages';
	private static $insightConfig = [
		'pageviews' => false,
		'whatlinksheremessage' => 'insights-wanted-by'
	];

	public function __construct() {
		$this->config = new InsightsConfig( self::INSIGHT_TYPE, self::$insightConfig );
	}

	public function getDataProvider() {
		return new WantedPagesPage();
	}

	public function prepareData( $res ) {
		$data = [];
		$itemData = new InsightsItemData();

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

				$article['link'] = $itemData->getTitleLink( $title, $params );
				$article['metadata']['wantedBy'] = [
					'message' => $this->getConfig()->getWhatLinksHereMessage(),
					'value' => (int)$row->value,
					'url' => $itemData->getWlhUrl( $title ),
				];

				$data[] = $article;
			}
		}
		return $data;
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
