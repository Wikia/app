<?php

namespace Wikia\PortableInfobox\Helpers;

use Wikia\Logger\WikiaLogger;

class PortableInfoboxRenderServiceHelper {
	const LOGGER_LABEL = 'portable-infobox-render-not-supported-type';
	const DEFAULT_DESKTOP_THUMBNAIL_WIDTH = 270;
	const EUROPA_THUMBNAIL_WIDTH = 300;
	const MOBILE_THUMBNAIL_WIDTH = 360;
	const MINIMAL_HERO_IMG_WIDTH = 300;
	const MAX_DESKTOP_THUMBNAIL_HEIGHT = 500;
	const EUROPA_THEME_NAME = 'pi-theme-europa';

	/**
	 * creates special data structure for horizontal group from group data
	 *
	 * @param array $groupData
	 * @return array
	 */
	public function createHorizontalGroupData( $groupData ) {
		$horizontalGroupData = [
			'labels' => [ ],
			'values' => [ ],
			'renderLabels' => false
		];

		foreach ( $groupData as $item ) {
			$data = $item[ 'data' ];

			if ( $item[ 'type' ] === 'data' ) {
				array_push( $horizontalGroupData[ 'labels' ], $data[ 'label' ] );
				array_push( $horizontalGroupData[ 'values' ], $data[ 'value' ] );

				if ( !empty( $data[ 'label' ] ) ) {
					$horizontalGroupData[ 'renderLabels' ] = true;
				}
			} elseif ( $item[ 'type' ] === 'header' ) {
				$horizontalGroupData[ 'header' ] = $data[ 'value' ];
			}
		}

		return $horizontalGroupData;
	}

	/**
	 * extends image data
	 *
	 * @param array $data image data
	 * @param int $width preferred thumbnail width
	 * @return array|bool false on failure
	 */
	public function extendImageData( $data, $width ) {
		global $wgPortableInfoboxCustomImageWidth;

		// title param is provided through reference in WikiaFileHelper::getFileFromTitle
		$title = $data[ 'name' ];
		$file = \WikiaFileHelper::getFileFromTitle( $title );
		if ( !$file || !$file->exists() ) {
			return false;
		}
		// get dimensions
		$originalWidth = $file->getWidth();
		$dimensions = $this->getThumbnailSizes(
			$width, self::MAX_DESKTOP_THUMBNAIL_HEIGHT, $originalWidth, $file->getHeight() );
		// if custom and big enough, scale thumbnail size
		$ratio = !empty( $wgPortableInfoboxCustomImageWidth ) && $originalWidth > $wgPortableInfoboxCustomImageWidth ?
			$wgPortableInfoboxCustomImageWidth / $dimensions[ 'width' ] : 1;
		// get thumbnail
		$thumbnail = $file->transform( [
			'width' => round( $dimensions[ 'width' ] * $ratio ),
			'height' => round( $dimensions[ 'height' ] * $ratio )
		] );
		if ( !$thumbnail || $thumbnail->isError() ) {
			return false;
		}
		$ref = null;

		wfRunHooks( 'PortableInfoboxRenderServiceHelper::extendImageData', [ $data, &$ref ] );

		return array_merge( $data, [
			'ref' => $ref,
			'height' => $dimensions[ 'height' ],
			'width' => $dimensions[ 'width' ],
			'thumbnail' => $thumbnail->getUrl(),
			'key' => urlencode( $data[ 'key' ] ),
			'media-type' => $data[ 'isVideo' ] ? 'video' : 'image',
			'mercuryComponentAttrs' => json_encode( [
				'itemContext' => 'portable-infobox',
				'ref' => $ref
			] )
		] );
	}

	/**
	 * @param array $images
	 * @return array
	 */
	public function extendImageCollectionData( $images ) {
		$mercuryComponentAttrs = [
			'refs' => array_map( function ( $image ) {
				return $image['ref'];
			}, $images )
		];
		$images[0]['isFirst'] = true;
		$data = [
			'images' => $images,
			'firstImage' => $images[0],
			'mercuryComponentAttrs' => json_encode( $mercuryComponentAttrs )
		];
		
		return $data;
	}

	/**
	 * checks if infobox data item is valid hero component data.
	 * If image is smaller than MINIMAL_HERO_IMG_WIDTH const, doesn't render the hero module.
	 *
	 * @param array $item - infobox data item
	 * @param array $heroData - hero component data
	 *
	 * @return bool
	 */
	public function isValidHeroDataItem( $item, $heroData ) {
		$type = $item[ 'type' ];

		if ( $type === 'title' && !array_key_exists( 'title', $heroData ) ) {
			return true;
		}

		if ( $type === 'image' && !array_key_exists( 'image', $heroData ) && count( $item[ 'data' ] ) === 1 ) {
			$imageWidth = $this->getFileWidth( $item[ 'data' ][ 0 ][ 'name' ] );

			if ( $imageWidth >= self::MINIMAL_HERO_IMG_WIDTH ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * required for testing mobile template rendering
	 * @return bool
	 */
	public function isMobile() {
		return \F::app()->checkSkin( 'wikiamobile' );
	}

	/**
	 * @return bool
	 */
	public function isMercury() {
		global $wgArticleAsJson;
		
		return !empty( $wgArticleAsJson );
	}

	/**
	 * check if item type is supported and logs unsupported types
	 *
	 * @param string $type - template type
	 * @param array $templates - array of supported templates
	 *
	 * @return bool
	 */
	public function isTypeSupportedInTemplates( $type, $templates ) {
		$isValid = true;

		if ( !isset( $templates[ $type ] ) ) {
			WikiaLogger::instance()->info( self::LOGGER_LABEL, [
				'type' => $type
			] );

			$isValid = false;
		}

		return $isValid;
	}

	/**
	 * Checks if europa theme is enabled and used
	 * @return bool
	 */
	public function isEuropaTheme() {
		global $wgEnablePortableInfoboxEuropaTheme;

		return !empty( $wgEnablePortableInfoboxEuropaTheme );
	}

	/**
	 * Calculates image dimensions based on preferred width and max acceptable height
	 *
	 * @param int $preferredWidth
	 * @param int $maxHeight
	 * @param int $originalWidth
	 * @param int $originalHeight
	 * @return array [ 'width' => int, 'height' => int ]
	 */
	public function getThumbnailSizes( $preferredWidth, $maxHeight, $originalWidth, $originalHeight ) {
		if ( ( $originalHeight / $originalWidth ) > ( $maxHeight / $preferredWidth ) ) {
			$height = min( $maxHeight, $originalHeight );
			$width = min( $preferredWidth, $height * $originalWidth / $originalHeight );
		} else {
			$width = min( $preferredWidth, $originalWidth );
			$height = min( $maxHeight, $width * $originalHeight / $originalWidth );
		}

		return [ 'height' => round( $height ), 'width' => round( $width ) ];
	}

	/**
	 * return real width of the image.
	 * @param \Title $title
	 * @return int number
	 */
	private function getFileWidth( $title ) {
		$file = \WikiaFileHelper::getFileFromTitle( $title );

		if ( $file ) {
			return $file->getWidth();
		}
	}
}
