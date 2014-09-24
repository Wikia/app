<?php

class MediaGalleryModel extends WikiaObject {
	/**
	 * @var array Basic data for MediaGalleries
	 */
	private $galleryData = [];

	/**
	 * @var int Total items in galleries
	 */
	private $itemCount = 0;

	function __construct( array $items ) {
		parent::__construct();
		$this->setGalleryData( $items );
	}

	/**
	 * Set basic data for galleries based on info passed in from WikiaPhotoGallery
	 * @param array $items Raw gallery data
	 */
	public function setGalleryData( $items ) {
		$this->itemCount = count( $items );
		$dimensionIndex = 0;

		foreach ( $items as $item ) {
			$data = $this->getMediaData( $item, $dimensionIndex );

			if ( !empty( $data ) ) {
				$this->galleryData[] = $data;
			}
			++$dimensionIndex;
		}

		// it shouldn't have changed but just in case it did
		$this->itemCount = count( $this->galleryData );
	}

	/**
	 * Get data for each gallery item
	 * @param array $item Data about the media item
	 * @param int $index Where the item shows up in the gallery
	 * @return array|null
	 */
	public function getMediaData( array $item, $index ) {
		$file = wfFindFile( $item['title'] );

		// we've already checked at this point but leaving this here just in case
		if ( !$file instanceof File ) {
			return null;
		}

		$dimension = MediaGalleryHelper::getImageWidth( $this->itemCount, $index );
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
	 * Get total number of items in gallery
	 * @return int
	 */
	public function getMediaCount() {
		return $this->itemCount;
	}

	/**
	 * Retrieve gallery data
	 * @return array
	 */
	public function getGalleryData() {
		return $this->galleryData;
	}
}

