<?php

class MediaGalleryController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const MAX_ITEMS = 8;
	const MAX_EXPANDED_ITEMS = 100;

	/**
	 * @var MediaGalleryModel
	 */
	public $model;

	/**
	 * Entry point into MediaGalleries. Data must be sent from WikiaPhotoGallery
	 * Note: A nice improvement would be to implement better way of getting data from anywhere as opposed to only at
	 * time of article parse.
	 */
	public function gallery() {
		$items = $this->getVal( 'items' );
		$this->model = new MediaGalleryModel( $items );

		$galleryParams = $this->getVal( 'gallery_params', [] ); // gallery tag parameters
		$visibleCount = empty( $galleryParams['expand'] ) ? self::MAX_ITEMS : self::MAX_EXPANDED_ITEMS;

		$data = $this->model->getGalleryData();

		// noscript tag does not need more than 100 images
		$this->media = array_slice( $data, 0, self::MAX_EXPANDED_ITEMS );
		$this->json = json_encode( $data );
		$this->count = $this->model->getMediaCount();
		$this->visibleCount = $visibleCount;
		$this->expanded = empty( $galleryParams['expand'] ) ? 0 : self::MAX_EXPANDED_ITEMS;
		$this->addImageButton = wfMessage('mediagallery-add-image-button')->plain();
	}
}
