<?php

class MediaGalleryController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const MAX_ITEMS = 8;
	const DIMENSION_UNIT = 60;
	const DEFAULT_DIMENSION_MULTIPLE = 3;

	private $dimensionMultiples = [
		1 => [5],
		2 => [5, 5],
		3 => [4, 4, 4],
		4 => [3, 3, 3, 3],
		5 => [6, 3, 3, 3, 3],
		6 => [4, 4, 4, 4, 4, 4],
		7 => [4, 4, 4, 3, 3, 3, 3],
		8 => [3, 3, 3, 3, 3, 3, 3, 3],
	];

	public function gallery() {
		$items = $this->getVal( 'items' );
		$media = [];

		$itemCount = count( $items );
		$dimensionMultiples = $this->getDimensionMultiples( $itemCount );

		$dimensionIndex = 0;
		foreach ( $items as $item ) {
			$file = wfFindFile( $item['title'] );

			if ( !$file instanceof File ) {
				continue; // todo: possible add error state
			}

			$dimension = self::DIMENSION_UNIT * $dimensionMultiples[$dimensionIndex];
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

	/**
	 * Get the dimensions of items in order
	 *
	 * @param int $itemCount
	 * @return array
	 * @throws Exception
	 */
	protected function getDimensionMultiples( $itemCount ) {
		if ( !isset( $this->dimensionMultiples[$itemCount] ) ) {
			throw new Exception( sprintf( "%s", __METHOD__ ) );
		}
		return $this->dimensionMultiples[$itemCount];
	}
}