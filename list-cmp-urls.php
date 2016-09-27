<?php

require_once( __DIR__ . '/includes/WebStart.php' );

class CuratedMainPages {
	private $categories = [];

	private static function tableFromResult( ResultWrapper $res ) {

		$articles = array();
		while ( $row = $res->fetchObject( $res ) ) {
			$articles[intval( $row->page_id )] = array(
				'page_id' => $row->page_id
			);
		}

		return $articles;
	}

	public function execute() {
		global $wgCityId;

		$cds = new CommunityDataService( $wgCityId );

		if ( count( @$cds->getCuratedContentData() ) ) {
			$sections = @$cds->getNonFeaturedSections();
			echo rawurldecode( Title::newMainPage()->getFullURL() ) . PHP_EOL;
			foreach ( $sections as $section ) {
				$this->parseSectionItem( $section );
			}
		}
	}

	private function parseSectionItem( $item ) {
		global $wgServer;

		if ( !isset( $item['type'] ) ) {
			if ( !empty( $item['label'] ) ) {
				echo $wgServer . '/main/section/' . str_replace( ' ', '_', $item['label'] ) . PHP_EOL;
			}
			foreach ( $item['items'] as $subItem ) {
				$this->parseSectionItem( $subItem );
			}
			return;
		}
		if ( $item['type'] == 'category' ) {
			$this->parseCategoryItem( $item['title'] );
		}
	}

	private function parseCategoryItem( $catText ) {
		global $wgServer;
		$catText = str_replace( ' ', '_', $catText );
		if ( isset( $this->categories[$catText] ) ) {
			return;
		}
		$this->categories[$catText] = true;

		$sectionTitle = explode( ':', $catText, 2 )[1];

		echo $wgServer . '/main/category/' . $sectionTitle . PHP_EOL;

		$title = Title::newFromDBkey( $catText );
		foreach ( $this->getAlphabetical( $title->getDBkey(), NS_CATEGORY ) as $subCat ) {
			$subTitle = Title::newFromID( $subCat['page_id'] );
			$this->parseCategoryItem( $subTitle->getPrefixedText() );
		}
	}

	private function getAlphabetical( $sCategoryDBKey, $mNamespace ) {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array( 'page', 'categorylinks' ),
			array( 'page_id', 'page_title' ),
			array(
				'cl_to' => $sCategoryDBKey,
				'page_namespace ' . 'IN(' . $mNamespace . ')'
			),
			__METHOD__,
			array( 'ORDER BY' => 'page_title' ),
			array( 'categorylinks' => array( 'INNER JOIN', 'cl_from = page_id' ) )
		);

		return self::tableFromResult( $res );
	}
}

(new CuratedMainPages())->execute();
