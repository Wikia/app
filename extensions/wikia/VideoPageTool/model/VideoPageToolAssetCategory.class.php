<?php

/**
 * VideoPageToolAssetCategory Class
 */
class VideoPageToolAssetCategory extends VideoPageToolAsset {

	protected $title;
	protected $displayTitle;

	// required data field -- array( FormFieldName => varName )
	protected static $dataFields = array(
		'categoryKey'  => 'title',
		'displayTitle' => 'displayTitle',
	);

	/**
	 * Get asset data (used in template)
	 * @return array
	 *
	 * The associative array data returned has the keys:
	 *     categoryName => Human readable title, e.g. "Soul Bubbles Nintendo DS"
	 *     categoryKey  => DBKey of the title, e.g. "Soul_Bubbles_Nintendo_DS"
	 *     displayTitle => Preferred title entered via Admin tool, e.g. "Soul Bubbles on Nintendo DS"
	 *     updatedBy    => Name of the user who updated this asset last
	 *     updatedAt    => Date this asset was last updated, e.g. "17:04, September 13, 2013"
	 */
	public function getAssetData() {
		$title = Title::newFromText( $this->title, NS_CATEGORY );
		if ( empty( $title ) ) {
			return self::getDefaultAssetData();
		}

		$data = array(
			'categoryName' => $title->getText(),
			'categoryKey'  => $title->getDBKey(),
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
			'categoryName' => wfMessage( 'videopagetool-category-name' )->plain(),
			'categoryKey'  => '',
			'displayTitle' => wfMessage( 'videopagetool-category-display-title' )->plain(),
		);
		$defaultData = array_merge( $data, parent::getDefaultAssetData() );

		return $defaultData;
	}

}
