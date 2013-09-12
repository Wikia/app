<?php

/**
 * VideoPageToolAssetFeatured Class
 */
class VideoPageToolAssetFeatured extends VideoPageToolAsset {

	protected $title;
	protected $displayTitle;
	protected $description;

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

		$data['videoTitleClass'] = '';

		$assetData = array_merge( $data, parent::getAssetData() );

		return $assetData;
	}

	/**
	 * get default asset data (used in template)
	 * @return array $assetData
	 */
	public static function getDefaultAssetData() {
		$data = array(
			'videoTitle' => wfMessage( 'videopagetool-video-title-default-text' )->text(),
			'videoKey' => '',
			'videoThumb' => '',
			'displayTitle' => '',
			'description' => '',
			'videoTitleClass' => 'alternative',
		);
		$defaultData = array_merge( $data, parent::getDefaultAssetData() );

		return $defaultData;
	}

}
