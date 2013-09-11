<?php

/**
 * VideoPageToolAssetFeatured Class
 */
class VideoPageToolAssetFeatured extends VideoPageToolAsset {

	protected $title;
	protected $displayTitle;
	protected $description;

	public static $REQUIRED_ROWS = 5;

	// required data field -- array( FormFieldName => varName )
	protected static $dataFields = array(
		'videoKey'     => 'title',
		'displayTitle' => 'displayTitle',
		'description'   => 'description',
	);

	/**
	 * get asset data (used in template)
	 * @return array $assetData
	 */
	public function getAssetData() {
		$helper = new VideoPageToolHelper();
		$data = $helper->getVideoData( $this->title, $this->displayTitle, $this->description );
		if ( empty( $data ) ) {
			return self::getDefaultAssetData();
		}

		$data['displayTitleClass'] = '';

		$assetData = array_merge( $data, parent::getAssetData() );

		return $assetData;
	}

	/**
	 * get default asset data (used in template)
	 * @return array $assetData
	 */
	public static function getDefaultAssetData() {
		$data = array(
			'videoTitle' => '',
			'videoKey' => '',
			'videoThumb' => '',
			'displayTitle' => wfMessage( 'videopagetool-video-title-default-text' )->text(),
			'description' => '',
			'displayTitleClass' => 'alternative',
		);
		$defaultData = array_merge( $data, parent::getDefaultAssetData() );

		return $defaultData;
	}

}
