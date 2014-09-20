<?php

/**
 * VideoPageToolAssetCategory Class
 */
class VideoPageToolAssetCategory extends VideoPageToolAsset {
	const SECTION = 'category';

	protected $categoryName;
	protected $displayTitle;

	protected $defaultThumbOptions = [
		'hidePlayButton' => true,
		'noLazyLoad'     => true,
	];

	// required data field -- array( FormFieldName => varName )
	protected static $dataFields = array(
		'categoryName' => 'categoryName',
		'displayTitle' => 'displayTitle',
	);

	/**
	 * Get the Category Name of the asset
	 * @return string
	 */
	public function getCategoryName() {
		return $this->categoryName;
	}

	/**
	 * Get asset data (used in template)
	 * @param array $thumbOptions
	 * @return array
	 *
	 * The associative array data returned has the keys:
	 *     categoryName => Human readable title, e.g. "Soul Bubbles Nintendo DS"
	 *     displayTitle => Preferred title entered via Admin tool, e.g. "Soul Bubbles on Nintendo DS"
	 *     thumbnails   => An array of video thumbnail data of the format:
	 *          [ title => $title,
	 *            thumb => $thumb,
	 *            url   => $url,
	 *          ]
	 *     updatedBy    => Name of the user who updated this asset last
	 *     updatedAt    => Date this asset was last updated, e.g. "17:04, September 13, 2013"
	 */
	public function getAssetData( $thumbOptions = array() ) {
		$title = Title::newFromText( $this->categoryName, NS_CATEGORY );
		if ( empty( $title ) ) {
			return self::getDefaultAssetData();
		}

		// Allow defaults to be overridden by options passed into us
		$thumbOptions = array_merge( $this->defaultThumbOptions, $thumbOptions );

		$helper = new VideoPageToolHelper();
		$data = array(
			'categoryName' => $title->getText(),
			'displayTitle' => $this->displayTitle,
			'thumbnails'   => $helper->getVideosByCategory( $title, $thumbOptions ),
			'total'        => $helper->getVideosByCategoryCount( $title ),
			'url'          => $title->escapeLocalURL(),
			'seeMoreLabel' => wfMessage( 'videopagetool-see-more-label' )->plain(),
		);

		$assetData = array_merge( $data, parent::getAssetData( $thumbOptions ) );

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

	/**
	 * Format form data
	 * @param integer $requiredRows
	 * @param array $formValues
	 * @param string $errMsg
	 * @return array $data
	 */
	public static function formatFormData( $requiredRows, $formValues, &$errMsg ) {
		// set displayTitle = categoryName if displayTitle is empty
		foreach ( $formValues['displayTitle'] as $order => &$value ) {
			if ( empty( $value ) ) {
				$value = $formValues['categoryName'][$order];
			}
		}

		// Remove rows where categoryName is empty
		$resetRows = false;
		$rows = count( $formValues['categoryName'] );
		$helper = new VideoPageToolHelper();
		for ( $i = $rows - 1; $i >= $helper->getRequiredRowsMin( 'category' ); $i-- ) {
			if ( !empty( $formValues['categoryName'][$i] ) ) {
				break;
			}

			foreach ( STATIC::$dataFields as $formFieldName => $varName ) {
				unset( $formValues[$formFieldName][$i] );
			}

			$resetRows = true;
		}

		// update required rows
		if ( $resetRows ) {
			$requiredRows = $helper->getRequiredRows( 'category', $formValues );
		}

		return parent::formatFormData( $requiredRows, $formValues, $errMsg );
	}

}
