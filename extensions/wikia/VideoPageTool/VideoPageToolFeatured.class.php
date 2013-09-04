<?php

/**
 * VideoPageToolFeatured Class
 */
class VideoPageToolFeatured extends VideoPageTool {

	protected static $REQUIRED_ROWS = 5;
	protected static $SECTION_ID = 1;

	public function getDefaultData() {
		$default = array(
			'videoTitle' => '',
			'videoKey' => '',
			'videoThumb' => '',
			'displayTitle' => wfMessage( 'videopagetool-video-title-default-text' )->text(),
			'description' => '',
			'displayTitleClass' => 'alternative',
		);

		$data = array();
		for ( $i = 0; $i < self::$REQUIRED_ROWS; $i++ ) {
			$data[] = $default;
		}

		return $data;
	}

	public function getAssetData( $data ) {
		$helper = new VideoPageToolHelper();
		$assetData = $helper->getVideoData( $data['title'], $data['displayTitle'], $data['description'] );
		if ( empty( $assetData ) ) {
			return $this->getDefaultData();
		}

		$assetData['displayTitleClass'] = '';

		return $assetData;
	}

	/**
	 * Validate form
	 * @param array $formValues
	 * @return boolean
	 */
	public function validateForm( $formValues ) {
		return true;
	}

	public function formatFormData( $formValues ) {
		for ( $i = 0; $i < self::$REQUIRED_ROWS; $i++ ) {
			$data[$i] = array(
			 'title' => $formValues['video_key'][$i],
			 'displayTitle' => $formValues['display_title'][$i],
			 'description' => $formValues['description'][$i],
			);
		}

		return $data;
	}

}
