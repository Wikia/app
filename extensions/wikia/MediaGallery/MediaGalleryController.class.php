<?php

class MediaGalleryController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const MAX_ITEMS = 8;
	const MAX_EXPANDED_ITEMS = 100;

	public function gallery() {
		$items = $this->getVal( 'items' );
		$galleryParams = $this->getVal( 'gallery_params', [] ); // gallery tag parameters
		$visibleCount = empty( $galleryParams['expand'] ) ? self::MAX_ITEMS : self::MAX_EXPANDED_ITEMS;

		$media = [];

		$itemCount = count( $items );

		$dimensionIndex = 0;
		foreach ( $items as $item ) {
			$file = wfFindFile( $item['title'] );
			$classes = [];

			if ( !$file instanceof File ) {
				continue; // todo: possible add error state
			}

			$dimension = MediaGalleryHelper::getImageWidth( $itemCount, $dimensionIndex );
			$dimensions = [
				'width' => $dimension,
				'height' => $dimension,
			];
			$thumb = $file->transform( $dimensions );
			$thumbUrl = wfReplaceImageServer(
				WikiaFileHelper::getSquaredThumbnailUrl( $file, $dimension ),
				$file->getTimestamp()
			);
			$thumb->setUrl( $thumbUrl );

			$markup = $this->app->renderView(
				'ThumbnailController',
				'gallery',
				[ 'thumb' => $thumb ]
			);

			// Hide overflow items
			if ( $dimensionIndex >= $visibleCount ) {
				$classes[] = "hidden";
				$classes[] = "fade";
			}

			$media[] = [
				'thumbnail' => $markup,
				'classes' => join( " ", $classes ),
				'caption' => $item['caption'],
			];
			++$dimensionIndex;
		}

		$this->media = $media;
		$this->count = count( $media );
		$this->visibleCount = $visibleCount;
		$this->addImageButton = wfMessage('mediagallery-add-image-button')->plain();
	}

}