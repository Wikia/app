<?php
require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class FixWikiMainImage extends Maintenance {

	public function __construct() {
		parent::__construct();
	}

	public function execute() {
		$wikis = $this->getWikisToFix();

		$corporateModel = new WikiaCorporateModel();
		foreach ( $wikis as $wiki ) {
			$wikiLocalImage = $this->getCVImage( $wiki['city_id'] );
			if ( ! empty( $wikiLocalImage ) ) {
				try {
					$corpWikiId = $corporateModel->getCorporateWikiIdByLang( $wiki['city_lang_code'] );
				}
				catch ( Exception $e ) {
					var_dump( $wiki['city_id'], $wiki['city_lang_code'] );
				}

				$t = GlobalTitle::newFromText( 'Wikia-Visualization-Main.png', NS_FILE, $wiki['city_id'] );

				$task = new PromoteImageReviewTask();

				var_dump( $t->getArticleID(), $wiki['city_main_image'], $corpWikiId, $wiki['city_id'] );

				$res = $task->uploadSingleImage( $t->getArticleID(), 'Wikia-Visualization-Main.png', $corpWikiId, $wiki['city_id'] );
				if ( $res['status'] == 0 && ! empty( $res['name'] ) ) {
					var_dump( $res );
					$this->updateVisualizationMainImageName( $wiki['city_id'], $res['name'] );
				}

			}
		}
	}

	protected function getWikisToFix() {
		global $wgExternalSharedDB;
		$out = [ ];

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$result = $dbr->select( array( CityVisualization::CITY_VISUALIZATION_TABLE_NAME ), array( '*' ), array( 'city_main_image' => null, 'city_lang_code' => F::app()->wg->ContLang->getCode() ), __METHOD__ );

		while ( $cvData = $dbr->fetchRow( $result ) ) {
			$out[] = $cvData;
		}

		return $out;
	}

	protected function getCVImage( $wikiId ) {
		global $wgExternalSharedDB;
		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$result = $dbr->selectRow( array( CityVisualization::CITY_VISUALIZATION_IMAGES_TABLE_NAME ), array( '*' ), array( 'city_id' => $wikiId, 'image_index' => 0, 'image_review_status' => ImageReviewStatuses::STATE_APPROVED ), __METHOD__ );

		return $result;
	}

	protected function updateVisualizationMainImageName( $wikiId, $imageName ) {
		global $wgExternalSharedDB;
		$db = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
		var_dump( $wikiId, $imageName );
		$db->update( CityVisualization::CITY_VISUALIZATION_TABLE_NAME, [ 'city_main_image' => $imageName ], [ 'city_id' => $wikiId, 'city_lang_code' => F::app()->wg->ContLang->getCode() ], __METHOD__ );
		$db->commit();
	}

	protected function getCorpWikiImageName( $destinationName, $wikiDBname ) {
		$destinationFileNameArr = explode( '.', $destinationName );
		$destinationFileExt = array_pop( $destinationFileNameArr );

		array_splice( $destinationFileNameArr, 1, 0, array( ',', $wikiDBname ) );

		return implode( '', $destinationFileNameArr ) . '.' . $destinationFileExt;
	}
}

$maintClass = "FixWikiMainImage";
require_once( DO_MAINTENANCE );
