<?php

/**
 * VideoPageToolAssetCategory Class
 */
class VideoPageToolAssetCategory extends VideoPageToolAsset {

	protected $categoryName;
	protected $displayTitle;

	// required data field -- array( FormFieldName => varName )
	protected static $dataFields = array(
		'categoryName'  => 'categoryName',
		'displayTitle' => 'displayTitle',
	);

	/**
	 * Get asset data (used in template)
	 * @return array
	 *
	 * The associative array data returned has the keys:
	 *     categoryName => Human readable title, e.g. "Soul Bubbles Nintendo DS"
	 *     displayTitle => Preferred title entered via Admin tool, e.g. "Soul Bubbles on Nintendo DS"
	 *     updatedBy    => Name of the user who updated this asset last
	 *     updatedAt    => Date this asset was last updated, e.g. "17:04, September 13, 2013"
	 */
	public function getAssetData() {
		$title = Title::newFromText( $this->categoryName, NS_CATEGORY );
		if ( empty( $title ) ) {
			return self::getDefaultAssetData();
		}

		$data = array(
			'categoryName' => $title->getText(),
			'displayTitle' => $this->displayTitle,
		);

		$assetData = array_merge( $data, parent::getAssetData() );

		return $assetData;
	}

	/**
	 * Get default asset data (used in template)
	 * @return array $assetData
	 */
	public static function getDefaultAssetData() {
		$data = array(
			'categoryName' => '',
			'displayTitle' => '',
		);
		$defaultData = array_merge( $data, parent::getDefaultAssetData() );

		return $defaultData;
	}

}
