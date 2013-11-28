<?php
require_once( dirname(__FILE__) . '/../../Maintenance.php' );

class FixWikiMainImage extends Maintenance {

	public function __construct() {
		parent::__construct();
	}

	public function execute() {
		$wikis = $this->getWikisToFix();

		$corporateModel = new WikiaCorporateModel();
		foreach ($wikis as $wiki) {
			$wikiLocalImage = $this->getCVImage($wiki['city_id']);
			if (!empty($wikiLocalImage)) {
				$dbname = WikiFactory::IDtoDB($wiki['city_id']);
				$corpWikiImageName = $this->getCorpWikiImageName($wikiLocalImage->image_name, $dbname);
				$corpWikiId = $corporateModel->getCorporateWikiIdByLang($wiki['city_lang_code']);
				$fileTitle = GlobalTitle::newFromText($corpWikiImageName, NS_FILE, $corpWikiId);
				var_dump($fileTitle->getFullURL(), $fileTitle->exists());
			}
		}
	}

	protected function getWikisToFix() {
		global $wgExternalSharedDB;
		$out = [];

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$result = $dbr->select(
			array( CityVisualization::CITY_VISUALIZATION_TABLE_NAME ),
			array( '*' ),
			array( 'city_main_image' => null ),
			__METHOD__
		);

		while( $cvData = $dbr->fetchRow( $result ) ) {
			$out[] = $cvData;
		}
		return $out;
	}

	protected function getCVImage($wikiId) {
		global $wgExternalSharedDB;
		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$result = $dbr->selectRow(
			array( CityVisualization::CITY_VISUALIZATION_IMAGES_TABLE_NAME ),
			array( '*' ),
			array(
				'city_id' => $wikiId,
				'image_index' => 0
			),
			__METHOD__
		);
		return $result;
	}

	protected function getCorpWikiImageName($destinationName, $wikiDBname) {
		$destinationFileNameArr = explode('.', $destinationName);
		$destinationFileExt = array_pop($destinationFileNameArr);

		array_splice($destinationFileNameArr, 1, 0, array(',', $wikiDBname));

		return implode('', $destinationFileNameArr).'.'.$destinationFileExt;
	}
}

$maintClass = "FixWikiMainImage";
require_once( DO_MAINTENANCE );
