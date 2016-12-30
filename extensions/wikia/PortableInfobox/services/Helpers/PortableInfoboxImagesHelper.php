<?php

namespace Wikia\PortableInfobox\Helpers;


class PortableInfoboxImagesHelper {
	const MAX_DESKTOP_THUMBNAIL_HEIGHT = 500;

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
		$title = $data['name'];
		$file = \WikiaFileHelper::getFileFromTitle( $title );

		if (
			!$file || !$file->exists() ||
			!in_array( $file->getMediaType(), [ MEDIATYPE_BITMAP, MEDIATYPE_DRAWING, MEDIATYPE_VIDEO ] )
		) {
			return false;
		}

		// get dimensions
		$originalWidth = $file->getWidth();
		$dimensions = $this->getThumbnailSizes(
			$width, self::MAX_DESKTOP_THUMBNAIL_HEIGHT, $originalWidth, $file->getHeight() );
		// if custom and big enough, scale thumbnail size
		$ratio = !empty( $wgPortableInfoboxCustomImageWidth ) && $originalWidth > $wgPortableInfoboxCustomImageWidth ?
			$wgPortableInfoboxCustomImageWidth / $dimensions['width'] : 1;
		// get thumbnail
		$thumbnail = $file->transform( [
			'width' => round( $dimensions['width'] * $ratio ),
			'height' => round( $dimensions['height'] * $ratio )
		] );
		$thumbnail2x = $file->transform( [
			'width' => round( $dimensions['width'] * $ratio * 2 ),
			'height' => round( $dimensions['height'] * $ratio * 2 )
		] );
		if ( !$thumbnail || $thumbnail->isError() || !$thumbnail2x || $thumbnail2x->isError() ) {
			return false;
		}
		$ref = null;

		wfRunHooks( 'PortableInfoboxRenderServiceHelper::extendImageData', [ $data, &$ref ] );

		return array_merge( $data, [
			'ref' => $ref,
			'height' => $dimensions['height'],
			'width' => $dimensions['width'],
			'thumbnail' => $thumbnail->getUrl(),
			'thumbnail2x' => $thumbnail2x->getUrl(),
			'key' => urlencode( $data['key'] ?? '' ),
			'media-type' => isset( $data['isVideo'] ) && $data['isVideo'] ? 'video' : 'image',
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
		return [
			'images' => $images,
			'firstImage' => $images[0],
			'mercuryComponentAttrs' => json_encode( $mercuryComponentAttrs )
		];
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
}
