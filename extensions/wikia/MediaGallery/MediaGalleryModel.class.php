<?php

use Wikia\Logger\WikiaLogger;

class MediaGalleryModel extends WikiaObject {
	/**
	 * Hard upper limit for the number of images per gallery
	 * @see VID-2071
	 */
	const IMAGE_COUNT_LIMIT = 3000;

	/**
	 * @var array Basic data for MediaGalleries
	 */
	private $galleryData = [];

	/**
	 * @var Parser
	 */
	private $parser;

	/**
	 * @var int Total items in galleries
	 */
	private $itemCount = 0;

	function __construct( array $items, \Parser $parser ) {
		parent::__construct();
		$this->parser = $parser;
		$this->setGalleryData( $items );
	}

	/**
	 * Set basic data for galleries based on info passed in from WikiaPhotoGallery
	 * Data exceeding the hard limit gets dropped.
	 *
	 * @param array $items Raw gallery data
	 */
	protected function setGalleryData( array $items ) {
		// Drop data exceeding the hard limit
		if ( count( $items ) > self::IMAGE_COUNT_LIMIT ) {
			$items = array_slice( $items, 0, self::IMAGE_COUNT_LIMIT, true );
		}

		$this->itemCount = count( $items );
		$dimensionIndex = 0;

		foreach ( $items as $item ) {
			$data = $this->getMediaData( $item, $dimensionIndex );

			if ( !empty( $data ) ) {
				$this->galleryData[] = $data;
			}
			++$dimensionIndex;
		}
	}

	/**
	 * Get data for each gallery item
	 * @param array $item Data about the media item
	 * @param int $index Where the item shows up in the gallery
	 * @return array|null
	 */
	protected function getMediaData( array $item, $index ) {
		$file = wfFindFile( $item['title'] );

		if ( !$file instanceof File ) {
			WikiaLogger::instance()->error(
				'File with title: ' . $item['title'] . 'doesn\'t exist',
				[ 'class' => __CLASS__ ]
			);
			return null;
		}

		$dimension = MediaGalleryHelper::getImageWidth( $this->itemCount, $index );
		$thumbUrl = WikiaFileHelper::getSquaredThumbnailUrl( $file, $dimension );

		$dimensions = [
			'width' => $dimension,
			'height' => $dimension,
		];
		$thumb = $file->transform( $dimensions );

		if ( !$thumb instanceof ThumbnailImage ) {
			WikiaLogger::instance()->error(
				'ThumbnailImage from title: ' . $item['title'] . ' couldn\'t be created.',
				[ 'thumbClass' => get_class( $thumb ) ]
			);
			return null;
		}

		$thumb->setUrl( $thumbUrl );

		$thumbnail = $this->app->renderView(
			'ThumbnailController',
			'gallery',
			[ 'thumb' => $thumb ]
		);

		$caption = '';
		if ( !empty( $item['caption'] ) ) {
			// parse any wikitext in caption. Logic borrowed from WikiaMobileMediaService::renderMediaGroup.
			$parser = $this->getParser();
			$caption = $parser->internalParse( $item['caption'] );
			$parser->replaceLinkHolders( $caption );
			$caption = $parser->killMarkers( $caption );
		}

		$title = $file->getTitle();

		return [
			'thumbUrl' => $thumbUrl,
			'thumbHtml' => $thumbnail,
			'caption' => $caption,
			'linkHref' => $file->getTitle()->getLinkURL(),
			'title' => $title->getText(),
			'dbKey' => $title->getDBKey(),
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

	/**
	 * Get the parser object
	 * @return \Parser
	 */
	protected function getParser() {
		return $this->parser;
	}
}

