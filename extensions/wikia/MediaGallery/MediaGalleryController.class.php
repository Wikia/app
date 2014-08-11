<?php

class MediaGalleryController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const MAX_ITEMS = 8;

	public function gallery() {
		$items = $this->getVal( 'items' );
		$media = [];

		$itemCount = count( $items );
		$mediaGalleryHelper = new MediaGalleryHelper();
		$dimensionMultiples = $mediaGalleryHelper->getDimensionMultiples( $itemCount );

		$dimensionIndex = 0;
		foreach ( $items as $item ) {
			$file = wfFindFile( $item['title'] );

			if ( !$file instanceof File ) {
				continue; // todo: possible add error state
			}

			$dimension = MediaGalleryHelper::DIMENSION_UNIT * $dimensionMultiples[$dimensionIndex];
			$dimensions = [
				'width' => $dimension,
				'height' => $dimension,
			];
			$thumb = $file->transform( $dimensions );
			$thumbUrl = wfReplaceImageServer(
				WikiaFileHelper::getSquaredThumbnailUrl( $file, $dimension ),
				$file->getTimestamp()
			);

			$params = [
				'thumb' => $thumb,
				'options' => [
					'custom-img-src' => $thumbUrl,
					'file-link' => $file->getUrl(),
				    'fluid' => true,
				]
			];
			$markup = $this->app->renderView(
				'ThumbnailController',
				'image',
				$params
			);
			$media[] = $markup;
			++$dimensionIndex;
		}

		$count = count( $media );
		$showMore = false;
		$showLess = false;
		if ( $count > self::MAX_ITEMS ) {
			$count = 'many';
			$showMore = wfMessage( 'mediagallery-show-more' );
			$showLess = wfMessage( 'mediagallery-show-less' );
		}

		$this->media = $media;
		$this->count = $count;
		$this->showMore = $showMore;
		$this->showLess = $showLess;
	}

}