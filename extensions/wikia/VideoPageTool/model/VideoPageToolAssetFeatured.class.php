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
		'video_key'     => 'title',
		'display_title' => 'displayTitle',
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

	/**
	 * Validate form
	 * @param array $formValues
	 * @return boolean
	 */
	public static function validateForm( $formValues ) {
		return true;
	}

	/**
	 * Format form data
	 * @param array $formValues
	 * @return array
	 */
	public static function formatFormData( $formValues ) {
		for ( $i = 0; $i < self::$REQUIRED_ROWS; $i++ ) {
			foreach ( self::$dataFields as $formFieldName => $varName ) {
				$order = $i + 1;	// because input data start from 0
				$data[$order][$varName] = $formValues[$formFieldName][$i];
			}
		}

		return $data;
	}

}
