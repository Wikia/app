<?php

class MediaGalleryModel extends WikiaObject {
	/**
	 * @var array Raw data sent by WikiaPhotoGallery
	 */
	public $items = [];

	/**
	 * @var array Basic data for MediaGalleries
	 */
	public $galleryData = [];

	function __construct( array $items ) {
		parent::__construct();
		$this->items = $items;
		$this->setGalleryData();
	}

	/**
	 * Set basic data for galleries based on info passed in from WikiaPhotoGallery
	 */
	public function setGalleryData() {
		$media = [];
		$itemCount = count( $this->items );
		$dimensionIndex = 0;

		foreach ( $this->items as $item ) {
			$data = $this->getMediaData( $item, $itemCount, $dimensionIndex );

			if ( !empty( $data ) ) {
				$media[] = $data;
			}

			++$dimensionIndex;
		}

		$this->galleryData = $media;
	}

	/**
	 * Get data for each gallery item
	 * @param array $item
	 * @param $count
	 * @param $index
	 * @return array|null
	 */
	public function getMediaData( array $item, $count, $index ) {
		$file = wfFindFile( $item['title'] );

		if ( !$file instanceof File ) {
			return null; // todo: possibly add error state
		}

		$dimension = MediaGalleryHelper::getImageWidth( $count, $index );
		$thumbUrl = WikiaFileHelper::getSquaredThumbnailUrl( $file, $dimension );

		$dimensions = [
			'width' => $dimension,
			'height' => $dimension,
		];
		$thumb = $file->transform( $dimensions );
		$thumb->setUrl( $thumbUrl );

		$thumbnail = $this->app->renderView(
			'ThumbnailController',
			'gallery',
			[ 'thumb' => $thumb ]
		);

		$caption = '';
		if ( !empty( $item['caption'] ) ) {
			// parse any wikitext in caption. Logic borrowed from WikiaMobileMediaService::renderMediaGroup.
			$parser = $this->wg->Parser;
			$caption = $parser->internalParse( $item['caption'] );
			$parser->replaceLinkHolders( $caption );
			$caption = $parser->killMarkers( $caption );
		}

		return [
			'thumbUrl' => $thumbUrl,
			'thumbHtml' => $thumbnail,
			'caption' => $caption,
			'linkHref' => $file->getTitle()->getLinkURL(),
		];
	}

	/**
	 * Get count of actual gallery items (i.e. file exists)
	 * @return int
	 */
	public function getMediaCount() {
		$data = $this->galleryData;
		return count( $data );
	}

	public function getGalleryData() {
		return $this->galleryData;
	}
}

