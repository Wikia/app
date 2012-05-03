<?php

/**
 * Lightbox controller
 * @author Hyun
 * @author Liz
 */
class LightboxController extends WikiaController {

	public function __construct() {
	}
	
	public function lightboxModalContent() {
		// send request to getImageDetail()
		$this->currentImageDetail = array();
	}
	
	/**
	 * @brief - returns details about images
	 * @requestParam title
	 * @responseParam imageUrl
	 * @responseParam width
	 * @repsonseParam height
	 */
	public function getImageDetail() {
		$this->height = '1000';
		$this->width = '100';
	}
	
	public function getVideoDetail() {
	}
	
	public function getMediaThumbs() {
	}
	
}