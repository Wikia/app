<?php

/**
 * VideoPageToolAssetFeatured Class
 */
class VideoPageToolAssetFeatured extends VideoPageToolAsset {

	protected $title;
	protected $displayTitle;
	protected $description;
	protected $altThumbName;

	// required data field -- array( FormFieldName => varName )
	protected static $dataFields = array(
		'videoKey'     => 'title',
		'displayTitle' => 'displayTitle',
		'description'  => 'description',
		'altThumbName' => 'altThumbName',
	);

	/**
	 * Get asset data (used in template)
	 * @return array An associative array of video metadata for the video named by $this->title
	 *
	 * The associative array data returned has the keys:
	 *     videoTitle      => Human readable title, e.g. "Soul Bubbles Nintendo DS Trailer - Bubbles"
	 *     videoKey        => DBKey of the title, e.g. "Soul_Bubbles_Nintendo_DS_Trailer_-_Bubbles"
	 *     displayTitle    => Preferred title entered via Admin tool, e.g. "Bubbles from "Soul Bubbles" on Nintendo DS"
	 *     videoThumb      => Embed code for the video thumbnail.
	 *     largeThumbUrl   => Large version of the video thumbnail image.  Does not include the embed code.
	 *     altThumbName    => Thumbnail that will replace original thumbnail
	 *     description     => Description of this video given in the Admin tool, e.g. "All about Bubbles!"
	 *     videoTitleClass =>
	 *     altThumbClass   =>
	 *     updatedBy       => User who updated this asset last, e.g. "Garthwebb"
	 *     updatedAt       => Date this asset was last updated, e.g. "17:04, September 13, 2013"
	 */
	public function getAssetData() {
		$helper = new VideoPageToolHelper();
		$data = $helper->getVideoData( $this->title, $this->altThumbName, $this->displayTitle, $this->description );
		if ( empty( $data ) ) {
			return self::getDefaultAssetData();
		}

		// This needs to be set to an empty string when there is a real asset rather than default asset data
		$data['videoTitleClass'] = '';
		$data['altThumbClass'] = '';

		$assetData = array_merge( $data, parent::getAssetData() );

		return $assetData;
	}

	/**
	 * Get default asset data (used in template)
	 * @return array $assetData
	 */
	public static function getDefaultAssetData() {
		$data = array(
			'videoTitle'      => wfMessage( 'videopagetool-video-title-default-text' )->plain(),
			'videoKey'        => '',
			'videoThumb'      => '',
			'largeThumbUrl'   => '',
			'altThumbName'     => wfMessage( 'videopagetool-image-title-default-text' )->plain(),
			'displayTitle'    => '',
			'description'     => '',
			'videoTitleClass' => 'alternative',
			'altThumbClass'   => 'alternative',
		);
		$defaultData = array_merge( $data, parent::getDefaultAssetData() );

		return $defaultData;
	}

}
