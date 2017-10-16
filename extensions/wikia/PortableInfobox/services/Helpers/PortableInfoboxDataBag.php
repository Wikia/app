<?php

namespace Wikia\PortableInfobox\Helpers;

/**
 * Class PortableInfoboxDataBag
 * @package Wikia\PortableInfobox\Helpers
 */
class PortableInfoboxDataBag {
	private static $instance = null;
	private $galleries = [ ];
	private $firstInfoboxAlredyRendered = false;

	private function __construct() {
	}

	/**
	 * @return null|PortableInfoboxDataBag
	 */
	public static function getInstance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function setGallery( $marker, $content ) {
		$this->galleries[$marker] = $content;
	}

	/**
	 * Retrieve source content of a gallery identified by Parser marker id
	 */
	public function getGallery( $marker ) {
		if ( isset( $this->galleries[$marker] ) ) {
			return $this->galleries[$marker];
		}

		return null;
	}

	/**
	 * @return boolean
	 */
	public function isFirstInfoboxAlredyRendered() {
		return $this->firstInfoboxAlredyRendered;
	}

	/**
	 * @param boolean $firstInfoboxAlredyRendered
	 */
	public function setFirstInfoboxAlredyRendered( $firstInfoboxAlredyRendered ) {
		$this->firstInfoboxAlredyRendered = $firstInfoboxAlredyRendered;
	}
}
