<?php

namespace Wikia\PortableInfobox\Helpers;

use \Wikia\Logger\WikiaLogger;

class PortableInfoboxRenderServiceHelper {
	const LOGGER_LABEL = 'portable-infobox-render-not-supported-type';
	//todo: https://wikia-inc.atlassian.net/browse/DAT-3075
	//todo: figure out what to do when user changes default infobox width via custom theming
	// changed value from 270 to 300 to support default theme europa width
	const DESKTOP_THUMBNAIL_WIDTH = 270;
	const EUROPA_THUMBNAIL_WIDTH = 300;
	const MOBILE_THUMBNAIL_WIDTH = 360;
	const MINIMAL_HERO_IMG_WIDTH = 300;
	const MAX_DESKTOP_THUMBNAIL_HEIGHT = 500;
	const EUROPA_THEME = 'europa';

	/**
	 * creates special data structure for horizontal group from group data
	 *
	 * @param array $groupData
	 * @return array
	 */
	public function createHorizontalGroupData( $groupData ) {
		$horizontalGroupData = [
			'labels' => [],
			'values' => [],
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
			} else if ( $item[ 'type' ] === 'header' ) {
				$horizontalGroupData[ 'header' ] = $data[ 'value' ];
			}
		}

		return $horizontalGroupData;
	}

	/**
	 * extends image data
	 *
	 * @param array $data
	 * @param string $theme
	 *
	 * @return bool|array
	 */
	public function extendImageData( $data, $theme ) {
		$thumbnail = $this->getThumbnail( $data[ 'name' ], $theme );
		$ref = null;

		if ( !$thumbnail ) {
			return false;
		}

		wfRunHooks( 'PortableInfoboxRenderServiceHelper::extendImageData', [ $data, &$ref ] );
		$dimensions = self::getImageSizesToDisplay( $thumbnail, $theme );

		$data[ 'ref' ] = $ref;
		$data[ 'height' ] = $dimensions[ 'height' ];
		$data[ 'width' ] = $dimensions[ 'width' ];
		$data[ 'thumbnail' ] = $thumbnail->getUrl();
		$data[ 'key' ] = urlencode( $data[ 'key' ] );
		$data[ 'media-type' ] = $data[ 'isVideo' ] ? 'video' : 'image';

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
	public function isWikiaMobile() {
		return \F::app()->checkSkin( 'wikiamobile' );
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
	 * return real width of the image.
	 * @param Title $title
	 * @return int number
	 */
	private function getFileWidth( $title ) {
		$file = \WikiaFileHelper::getFileFromTitle( $title );

		if ( $file ) {
			return $file->getWidth();
		}
	}

	/**
	 * @desc create a thumb of the image from file title.
	 * @param Title $title
	 * @param string $theme
	 * @return bool|MediaTransformOutput
	 */
	private function getThumbnail( $title, $theme ) {
		$file = \WikiaFileHelper::getFileFromTitle( $title );

		if ( $file ) {
			$size = $this->getImageSizesForThumbnailer( $file, $theme );
			$thumb = $file->transform( $size );

			if ( !is_null( $thumb ) && !$thumb->isError() ) {
				return $thumb;
			}
		}

		return false;
	}

	/**
	 * @desc get image size to be passed to a thumbnailer.
	 *
	 * Return size according to the width and height limitations:
	 * Height on desktop cannot be bigger than 500px
	 * Width have to be adjusted to const for mobile or desktop infobox
	 * if $wgPortableInfoboxCustomImageWidth is set, do not change max height
	 * and set width to $wgPortableInfoboxCustomImageWidth.
	 * @param $image
	 * @param string $theme
	 * @return array width and height
	 */
	public function getImageSizesForThumbnailer( $image, $theme ) {
		global $wgPortableInfoboxCustomImageWidth;

		$desktopThumbnailWidth = $theme === self::EUROPA_THEME ? self::EUROPA_THUMBNAIL_WIDTH :
			self::DESKTOP_THUMBNAIL_WIDTH;

		if ( $this->isWikiaMobile() ) {
			$width = self::MOBILE_THUMBNAIL_WIDTH;
			$height = null;
		} else if ( empty( $wgPortableInfoboxCustomImageWidth ) ) {
			$height = min( self::MAX_DESKTOP_THUMBNAIL_HEIGHT, $image->getHeight() );
			$width = $desktopThumbnailWidth;
		} else {
			$height = $image->getHeight();
			$width = $wgPortableInfoboxCustomImageWidth;
		}

		return [ 'height' => $height, 'width' => $width ];
	}

	/**
	 * @desc if it's not a request from mobile skin and wgPortableInfoboxCustomImageWidth
	 * is set, the $thumbnail->getWidth() can return some big value - we need
	 * to adjust it to DESKTOP_THUMBNAIL_WIDTH to look good in the infobox.
	 * Also, the $height have to be adjusted here to make image look good in infobox.
	 * @param $thumbnail \MediaTransformOutput
	 * @param string $theme
	 * @return array width and height which will be displayed i.e. in the width
	 * and height properties of the img tag
	 */
	public function getImageSizesToDisplay( $thumbnail, $theme ) {
		global $wgPortableInfoboxCustomImageWidth;

		$desktopThumbnailWidth = $theme === self::EUROPA_THEME ? self::EUROPA_THUMBNAIL_WIDTH : self::DESKTOP_THUMBNAIL_WIDTH;

		if ( !$this->isWikiaMobile() && !empty( $wgPortableInfoboxCustomImageWidth ) ) {
			if ( $this->isThumbAboveMaxAspectRatio( $thumbnail ) ) {
				$height = min( self::MAX_DESKTOP_THUMBNAIL_HEIGHT, $thumbnail->getHeight() );
				$width = min( $desktopThumbnailWidth, $height * $thumbnail->getWidth() /
						$thumbnail->getHeight() );
			} else {
				$width = min( $desktopThumbnailWidth, $thumbnail->getWidth() );
				$height = min( self::MAX_DESKTOP_THUMBNAIL_HEIGHT, $width * $thumbnail->getHeight() /
						$thumbnail->getWidth() );
			}
		} else {
			$width = $thumbnail->getWidth();
			$height = $thumbnail->getHeight();
		}

		return [ 'height' => round( $height ), 'width' => round( $width ) ];
	}

	/**
	 * @desc checks if thumbnail aspect ratio is bigger than max aspect ratio (tall and thin images)
	 * @param $thumbnail \MediaTransformOutput
	 * @return bool
	 */
	private function isThumbAboveMaxAspectRatio( $thumbnail ) {
		return $thumbnail->getHeight() / $thumbnail->getWidth() > self::MAX_DESKTOP_THUMBNAIL_HEIGHT /
			self::DESKTOP_THUMBNAIL_WIDTH;
	}
}
