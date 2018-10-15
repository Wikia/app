<?php

namespace Wikia\PortableInfobox\Helpers;


class PortableInfoboxImagesHelper {
	const MAX_DESKTOP_THUMBNAIL_HEIGHT = 500;

	/**
	 * extends image data
	 *
	 * @param array $data image data
	 * @param int $thumbnailFileWidth preferred thumbnail file width
	 * @param int $thumbnailImgTagWidth preferred thumbnail img tag width
	 * @return array|bool false on failure
	 */
	public function extendImageData( $data, $thumbnailFileWidth, $thumbnailImgTagWidth = null ) {
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
		// we need to have different thumbnail file dimensions to support (not to have pixelated images) wider infoboxes than default width
		$fileDimensions = $this->getThumbnailSizes( $thumbnailFileWidth, self::MAX_DESKTOP_THUMBNAIL_HEIGHT,
			$originalWidth, $file->getHeight() );
		$imgTagDimensions =
			empty( $thumbnailImgTagWidth )
				? $fileDimensions
				: $this->getThumbnailSizes( $thumbnailImgTagWidth,
				self::MAX_DESKTOP_THUMBNAIL_HEIGHT, $originalWidth, $file->getHeight() );

		// if custom and big enough, scale thumbnail size
		$ratio =
			!empty( $wgPortableInfoboxCustomImageWidth ) &&
			$originalWidth > $wgPortableInfoboxCustomImageWidth
				? $wgPortableInfoboxCustomImageWidth / $fileDimensions['width'] : 1;
		// get thumbnail
		$thumbnail = $file->transform( [
			'width' => round( $fileDimensions['width'] * $ratio ),
			'height' => round( $fileDimensions['height'] * $ratio ),
		] );
		$thumbnail2x = $file->transform( [
			'width' => round( $fileDimensions['width'] * $ratio * 2 ),
			'height' => round( $fileDimensions['height'] * $ratio * 2 ),
		] );
		if ( !$thumbnail || $thumbnail->isError() || !$thumbnail2x || $thumbnail2x->isError() ) {
			return false;
		}

		return array_merge( $data, [
			'height' => intval( $imgTagDimensions['height'] ),
			'width' => intval( $imgTagDimensions['width'] ),
			'thumbnail' => $thumbnail->getUrl(),
			'thumbnail2x' => $thumbnail2x->getUrl(),
			'key' => urlencode( $data['key'] ?? '' ),
			'media-type' => isset( $data['isVideo'] ) && $data['isVideo'] ? 'video' : 'image',
		] );
	}

	public function extendMobileImageData( $data, int $width, int $height ) {
		// title param is provided through reference in WikiaFileHelper::getFileFromTitle
		$title = $data['name'];
		$file = \WikiaFileHelper::getFileFromTitle( $title );

		if (
			!$file || !$file->exists() ||
			!in_array( $file->getMediaType(), [ MEDIATYPE_BITMAP, MEDIATYPE_DRAWING, MEDIATYPE_VIDEO ] )
		) {
			return false;
		}

		$thumbnail = $file->getUrlGenerator()
			->zoomCrop()
			->width($width)
			->height($height)
			->url();

		$thumbnail2x = $file->getUrlGenerator()
			->zoomCrop()
			->width($width * 2)
			->height($height * 2)
			->url();

		$mediaObject = [];
		\Hooks::run( 'PortableInfoboxRenderServiceHelper::extendImageData', [ $file->getTitle(), $data, &$mediaObject ] );

		return array_merge( $data, [
			'height' => $width,
			'width' => $height,
			'thumbnail' => $thumbnail,
			'thumbnail2x' => $thumbnail2x,
			'fileName' => $mediaObject['fileName'] ?? '',
			'dataAttrs' => json_encode( \ArticleAsJson::getDataAttrsForImage( $mediaObject ) ),
		] );
	}

	public function extendMobileImageDataScaleToWidth( $data, int $width ) {
		// title param is provided through reference in WikiaFileHelper::getFileFromTitle
		$title = $data['name'];
		$file = \WikiaFileHelper::getFileFromTitle( $title );

		if (
			!$file || !$file->exists() ||
			!in_array( $file->getMediaType(), [ MEDIATYPE_BITMAP, MEDIATYPE_DRAWING, MEDIATYPE_VIDEO ] )
		) {
			return false;
		}

		$mediaObj = [];
		\Hooks::run( 'PortableInfoboxRenderServiceHelper::extendImageData', [ $file->getTitle(), $data, &$mediaObj ] );

		$thumbnail = $file->getUrlGenerator()
			->scaleToWidth($width)
			->url();

		$thumbnail2x = $file->getUrlGenerator()
			->scaleToWidth($width * 2)
			->url();

		return array_merge( $data, [
			'height' => $mediaObj['height'],
			'width' => $mediaObj['width'],
			'thumbnail' => $thumbnail,
			'thumbnail2x' => $thumbnail2x,
			'fileName' => $mediaObj['fileName'] ?? '',
			'dataAttrs' => json_encode( \ArticleAsJson::getDataAttrsForImage( $mediaObj ) ),
		] );
	}

	/**
	 * @param array $images
	 * @return array
	 */
	public function extendImageCollectionData( $images ) {
		$images = array_map(
			function ( $image, $index ) {
				$image['dataRef'] = $index;

				return $image;
			},
			$images,
			array_keys($images)
		);

		$images[0]['isFirst'] = true;
		return [
			'images' => $images,
		];
	}

	/**
	 * @param array $images
	 * @return array
	 */
	public function extendMobileImageCollectionData( $images ) {
		$dataAttrs = array_map(
			function ( $image ) {
				return json_decode( $image['dataAttrs'] );
			},
			$images
		);

		$images = array_map(
			function ( $image, $index ) {
				$image['dataRef'] = $index;

				return $image;
			},
			$images,
			array_keys($images)
		);

		return [
			'images' => $images,
			'dataAttrs' => json_encode( $dataAttrs ),
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

	/**
	 * return real width of the image.
	 * @param \Title $title
	 * @return int number
	 */
	public function getFileWidth( $title ) {
		$file = \WikiaFileHelper::getFileFromTitle( $title );

		if ( $file ) {
			return $file->getWidth();
		}
		return 0;
	}
}
